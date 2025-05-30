<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DishController extends Controller
{
    public function home(Request $request)
    {
        $response = Http::get('http://localhost:8000/api/v1/post/dishes', [
            'page' => 0,
            'limit' => 50,
        ]);

        $items = $response->json();

        $perPage = 8;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($items, ($currentPage - 1) * $perPage, $perPage);

        $paginator = new LengthAwarePaginator(
            $currentItems,
            count($items),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('home', ['items' => $paginator]);
    }

    public function search(Request $request)
    {
        $query = $request->input('search_query');
        $ingredients = explode(',', $query);
        $ingredients = array_unique(array_map('trim', $ingredients));

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post('http://localhost:8000/api/v1/post/recommend_dishes_kmeans?k=10', $ingredients);

        if ($response->status() == 200) {
            $dishes = $response->json()['recommended_dishes'] ?? [];
            $dishes = collect($dishes)->unique('id')->values()->all();
        } else {
            dd($response->body());
        }

        $countDish = count($dishes);

        return view('dishes', compact('dishes', 'countDish', 'query', 'ingredients'));
    }

    public function detail_products($id)
    {
        $response = Http::get("http://localhost:8000/api/v1/post/dishes/{$id}");
        $dish = $response->json();

        $ratings = DB::table('ratings')
            ->where('dish_id', $id)
            ->orderByDesc('created_at')
            ->get();

        return view('dish_detail', compact('dish', 'ratings'));
    }

    public function searchIngredients(Request $request)
    {
        $query = $request->input('search_ingredients');

        $ingredients = Http::get("http://localhost:8000/api/v1/post/suggest_ingredients", [
            'query' => $query
        ]);

        $ingredients = $ingredients->json();
        $suggestions = isset($ingredients['suggestions']) ? $ingredients['suggestions'] : [];

        return response()->json(['suggestions' => $suggestions]);
    }

    public function saveFavorite(Request $request, $id)
    {
        $user_id = Auth::id();

        $exists = DB::table('favorites')
            ->where('user_id', $user_id)
            ->where('dish_id', $id)
            ->exists();

        if (!$exists) {
            DB::table('favorites')->insert([
                'user_id' => $user_id,
                'dish_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Đã lưu món ăn vào danh sách yêu thích.');
    }

    public function submitRating(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        DB::table('ratings')->insert([
            'user_id' => Auth::id(),
            'dish_id' => $id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá món ăn.');
    }
}
