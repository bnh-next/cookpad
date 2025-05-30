<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function show()
    {
        return view('account');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validate đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->name = $request->name;

        // Nếu người dùng có nhập mật khẩu mới -> kiểm tra mật khẩu cũ
        if ($request->filled('password')) {
            // Kiểm tra mật khẩu hiện tại
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
            }

            // Validate mật khẩu mới
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
