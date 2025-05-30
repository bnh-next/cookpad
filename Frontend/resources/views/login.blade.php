@extends('layouts.auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4" style="width: 400px; border-radius: 15px;">

        <div class="text-center mb-4">
            <a href="{{ url('/home') }}">
                <img src="{{ asset('assets/image/logo2.png') }}" alt="Logo" style="height: 40px;">
            </a>
        </div>
        <h3 class="text-center mb-4">Đăng nhập Cookpad</h3>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input required type="email" name="email" class="form-control" placeholder="Nhập email...">
            </div>

            <div class="form-group mb-4">
                <label for="password">Mật khẩu</label>
                <input required type="password" name="password" class="form-control" placeholder="Nhập mật khẩu...">
            </div>

            <button type="submit" class="btn-common w-100">Đăng nhập</button>
        </form>

        <div class="text-center mt-3">
            <p class="mb-1">Chưa có tài khoản?</p>
            <a href="{{ route('register') }}" class="btn btn-link">Đăng ký ngay</a>
        </div>
    </div>
</div>
@endsection
