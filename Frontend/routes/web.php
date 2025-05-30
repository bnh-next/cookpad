<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DishController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;

// Trang chủ
Route::get('/', function () {
    return view('index');
});

Route::get('/home', [DishController::class, 'home']);

// Tìm kiếm
Route::match(['get', 'post'], '/search', [DishController::class, 'search']);
Route::get('/detail/{id}', [DishController::class, 'detail_products'])->name('dish.show');
Route::get('/ingredients', [DishController::class, 'searchIngredients']);

// 👉 Đăng nhập - chỉ cho khách (chưa đăng nhập)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Thông tin tài khoản
Route::get('/account', [AccountController::class, 'show'])->name('account');
Route::put('/account', [AccountController::class, 'update'])->name('account.update');

// 👉 Lưu món và đánh giá món (chỉ khi đã đăng nhập)
Route::middleware(['auth'])->group(function () {
    Route::post('/dishes/{id}/favorite', [DishController::class, 'saveFavorite'])->name('dishes.favorite');
    Route::post('/dishes/{id}/rating', [DishController::class, 'submitRating'])->name('dishes.rating');
});
