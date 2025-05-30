<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .btn-common,
        .btn-common:link,
        .btn-common:visited {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        font-weight: 500;
        color: #ffffff;             
        background-color: #F09030;   
        border: 1px solid #F09030;   
        border-radius: 0.5rem;
        text-decoration: none;       
        cursor: pointer;
        transition: background-color .2s, transform .1s;
        }

        .btn-common:hover,
        .btn-common:focus {
        background-color: #e07b00;   
        color: #ffffff;              
        text-decoration: none;       
        transform: translateY(-2px);
        outline: none;
        }

        .btn-common:active {
        background-color: #d18600;  
        transform: translateY(0);
        }
    </style>
    @php
    if (session('user')) {
        header('Location: /home');
        exit;
    }
    @endphp

</head>
<body class="bg-dark text-white d-flex justify-content-center align-items-center" style="min-height: 100vh">
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
