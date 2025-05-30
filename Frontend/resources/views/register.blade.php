@extends('layouts.auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow-sm p-4" style="width: 450px; border-radius: 15px;">

        <div class="text-center mb-4">
            <a href="{{ url('/home') }}">
                <img src="{{ asset('assets/image/logo2.png') }}" alt="Logo" style="height: 40px;">
            </a>
        </div>

        <h3 class="text-center mb-3">Đăng ký tài khoản mới</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="full_name">Họ và tên</label>
                <input type="text" name="full_name" class="form-control" placeholder="Nhập họ tên..." required>
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Nhập email..." required>
            </div>

            <div class="form-group mb-4">
                <label for="password">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu..." required>
            </div>

            <button type="submit" class="btn-common w-100">Đăng ký</button>
        </form>

        <div class="text-center mt-3">
            <p>Đã có tài khoản?</p>
            <a href="{{ route('login') }}" class="btn btn-link">Đăng nhập ngay</a>
        </div>
    </div>
</div>
@endsection
