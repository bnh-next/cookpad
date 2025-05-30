<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/image/kaiadmin/favicon.ico') }}" type="assets/image/x-icon" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main_content.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/search.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/slide.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-common,
        .btn-common:link,
        .btn-common:visited {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            color: #ffffff;             
            background: linear-gradient(135deg, #F09030, #e07b00);   
            border: none;   
            border-radius: 25px;
            text-decoration: none;       
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(240, 144, 48, 0.3);
        }

        .btn-common:hover,
        .btn-common:focus {
            background: linear-gradient(135deg, #e07b00, #d18600);   
            color: #ffffff;              
            text-decoration: none;       
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(240, 144, 48, 0.4);
            outline: none;
        }

        .btn-common:active {
            background: linear-gradient(135deg, #d18600, #c17800);  
            transform: translateY(0);
        }

        .user-dropdown {
            min-width: 240px;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: none;
        }

        .user-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            font-weight: 500;
            font-size: 0.95rem;
            color: #333;
            transition: all 0.3s ease;
        }

        .user-dropdown .dropdown-item:hover {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            transform: translateX(5px);
        }

        .user-dropdown .dropdown-item i {
            width: 20px;
            margin-right: 12px;
            color: #6c757d;
        }

        .user-dropdown .dropdown-divider {
            margin: 0;
            opacity: 0.3;
        }

        /* Modern Sidebar Styles */
        .sidebar {
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            width: 280px;
        }

        .sidebar-logo .logo-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-item {
            margin: 0.25rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .sidebar .nav-item > a {
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar .nav-item > a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateX(5px);
        }

        .sidebar .nav-item.active > a {
            background: linear-gradient(135deg, #F09030, #e07b00);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(240, 144, 48, 0.3);
        }

        .sidebar .nav-item i {
            width: 20px;
            margin-right: 15px;
            font-size: 1.1rem;
        }

        .sidebar-meal-item {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .sidebar-meal-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        /* Top Header - Simplified */
        .top-header {
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .top-nav {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        /* New Search Section */
        .search-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            padding: 3rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .search-container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            padding: 0 2rem;
        }

        .main-logo {
            margin-bottom: 2rem;
        }

        .main-logo img {
            height: 60px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
        }

        .main-search-form {
            display: flex;
            align-items: center;
            background: #ffffff;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            border: 2px solid #f0f0f0;
            transition: all 0.3s ease;
            max-width: 600px;
            margin: 0 auto;
        }

        .main-search-form:focus-within {
            border-color: #F09030;
            box-shadow: 0 8px 30px rgba(240, 144, 48, 0.2);
        }

        .main-search-form input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 18px 25px;
            font-size: 16px;
            outline: none;
            color: #333;
        }

        .main-search-form input::placeholder {
            color: #999;
        }

        .main-search-form button {
            background: linear-gradient(135deg, #F09030, #e07b00);
            border: none;
            padding: 18px 30px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .main-search-form button:hover {
            background: linear-gradient(135deg, #e07b00, #d18600);
            transform: scale(1.05);
        }

        /* User Profile Styling */
        .user-profile-btn {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border: 2px solid #e9ecef;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .user-profile-btn:hover {
            border-color: #F09030;
            box-shadow: 0 6px 20px rgba(240, 144, 48, 0.2);
            transform: translateY(-2px);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .user-name {
            color: #333;
            font-weight: 600;
            margin-right: 8px;
        }

        /* Home Content Container */
        .home-content-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Slider adjustments */
        .slider-container {
            margin-bottom: 3rem;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Content grid improvements */
        .container-item {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .container-item .item {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container-item .item:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .container-item .item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .container-item .item .desc {
            padding: 1rem;
        }

        .container-item .item .description {
            margin: 0;
            font-weight: 600;
            color: #333;
        }

        .container-item .item .description a {
            text-decoration: none;
            color: inherit;
        }

        .container-item .item .description a:hover {
            color: #F09030;
        }

        /* Section headers */
        .header {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #F09030, #e07b00);
            border-radius: 2px;
        }

        /* Main panel adjustments */
        .main-panel {
            margin-left: 280px;
            width: calc(100% - 280px);
        }

        .content-custom {
            padding: 0;
        }

        /* Search suggestions */
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            margin-top: 10px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .suggestion-item {
            padding: 12px 20px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }

        .suggestion-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        /* Pagination improvements */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin: 3rem 0;
        }

        .pagination .page-link {
            color: #F09030;
            border: 1px solid #F09030;
            margin: 0 2px;
            border-radius: 8px;
        }

        .pagination .page-item.active .page-link {
            background-color: #F09030;
            border-color: #F09030;
        }

        .pagination .page-link:hover {
            background-color: #F09030;
            border-color: #F09030;
            color: white;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
                transform: translateX(-100%);
            }
            
            .main-panel {
                margin-left: 0;
                width: 100%;
            }
            
            .top-nav {
                padding: 0 1rem;
            }
            
            .search-container {
                padding: 0 1rem;
            }
            
            .main-logo img {
                height: 45px;
            }
            
            .main-search-form {
                max-width: 100%;
            }
            
            .main-search-form input {
                padding: 15px 20px;
                font-size: 14px;
            }
            
            .main-search-form button {
                padding: 15px 20px;
                font-size: 14px;
            }
            
            .home-content-container {
                padding: 1rem;
            }
            
            .container-item {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="/" class="logo">
                        <img src="{{ asset('assets/image/logo_text_halloween.png') }}"
                            alt="navbar brand"
                            class="navbar-brand"
                            height="20" />
                    </a>
                </div>
            </div>

            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    @php $me = session('user'); @endphp

                    <ul class="nav nav-secondary">
                        {{-- Trang chủ --}}
                        <li class="nav-item active">
                            <a href="{{ url('/home') }}">
                                <i class="fas fa-home"></i>
                                <p class="title">Trang chủ</p>
                            </a>
                        </li>

                        {{-- Premium --}}
                        <li class="nav-item">
                            <a href="#base" data-bs-toggle="collapse">
                                <i class="fa-brands fa-product-hunt"></i>
                                <p class="title">Premium</p>
                            </a>
                        </li>

                        {{-- Kho món ăn của bạn --}}
                        <li class="nav-item">
                            <a href="#sidebarLayouts" data-bs-toggle="collapse" class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fa-solid fa-store"></i>
                                    <span class="title">Kho món ăn của bạn</span>
                                </div>
                                <i class="fas fa-chevron-down text-white small me-2"></i>
                            </a>

                            @if(!Auth::check())
                                <div class="collapse show pt-1" id="sidebarLayouts">
                                    <div class="px-4 pt-2">
                                        <p class="text-white-50 small mb-0">
                                            <small><a href="{{ route('login') }}" class="text-decoration-underline text-white">
                                                Để bắt đầu tạo kho lưu trữ món ngon của riêng bạn, vui lòng đăng ký hoặc đăng nhập.
                                            </a></small>
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="collapse show" id="sidebarLayouts">
                                    <ul class="nav flex-column ps-3">
                                        <li class="nav-item py-2 px-3 rounded sidebar-meal-item">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-file-alt me-3 mt-1 text-light"></i>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold text-white">Tất Cả</span>
                                                    <small class="text-white-50">{{ $counts['all'] ?? 0 }} món</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item py-2 px-3 rounded sidebar-meal-item">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-bookmark me-3 mt-1 text-light"></i>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold text-white">Đã Lưu</span>
                                                    <small class="text-white-50">{{ $counts['saved'] ?? 0 }} món</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item py-2 px-3 rounded sidebar-meal-item">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-check-circle me-3 mt-1 text-light"></i>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold text-white">Đã Nấu</span>
                                                    <small class="text-white-50">{{ $counts['cooked'] ?? 0 }} món</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item py-2 px-3 rounded sidebar-meal-item">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-user me-3 mt-1 text-light"></i>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold text-white">Món Của Tôi</span>
                                                    <small class="text-white-50">{{ $counts['mine'] ?? 0 }} món</small>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <!-- Top Header - Only User Menu -->
            <div class="top-header">
                <div class="top-nav">
                    <!-- User Menu -->
                    <div class="navbar-nav">
                        @php use Illuminate\Support\Facades\Auth; $me = Auth::user(); @endphp

                        @if(!Auth::check())
                            <a href="{{ route('login') }}" class="btn-common">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Đăng nhập
                            </a>
                        @else
                            <div class="dropdown">
                                <button type="button" class="btn user-profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ $me['avatar_url'] ?? asset('assets/img/default-avatar.png') }}" class="user-avatar" alt="Avatar">
                                    <span class="user-name">{{ Auth::user()->name ?? Auth::user()->email }}</span>
                                    <i class="fas fa-chevron-down text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow user-dropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('account') }}">
                                            <i class="fas fa-user-circle"></i>Thông tin cá nhân
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt"></i>Đăng xuất
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Search Section - Only show on home page -->
            @if(request()->is('home') || request()->is('/'))
            <div class="search-section">
                <div class="search-container">
                    <!-- Main Logo -->
                    <div class="main-logo">
                        <a href="/home">
                            <img src="{{ asset('assets/image/logo2.png') }}" alt="Cookpad Logo">
                        </a>
                    </div>

                    <!-- Search Form -->
                    <div class="position-relative">
                        <form action="/search" method="POST" class="main-search-form">
                            @csrf
                            <input
                                type="search"
                                name="search_query"
                                id="mainSearchInput"
                                placeholder="Tìm tên món hay nguyên liệu"
                                autocomplete="off"
                            />
                            <button type="submit">
                                <i class="fas fa-search me-2"></i>
                                Tìm kiếm
                            </button>
                        </form>
                        
                        <!-- Search suggestions -->
                        <div class="search-suggestions" id="mainSearchSuggestions">
                            <!-- JS sẽ append suggestions vào đây -->
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Main Content -->
            <div class="content-custom">
                <div class="home-content-container">
                    @yield('content')
                </div>
                
                <!-- Footer -->
                <div class="row footer-image">
                    <div class="col-md-12">
                        <div class="img">
                            <img src="{{ asset('assets/image/footer-210d183ce6443eb41fa78f10b270fb773bab56416e2680a35328f51e8ddf85d0.png') }}"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var timeout;

            // Xử lý tìm kiếm cho main search
            $('#mainSearchInput').on('keyup', function(e) {
                var query = $(this).val().trim();
                var lastKeyword = query.split(',').pop().trim();

                if (lastKeyword.length > 1) {
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        $.ajax({
                            url: '{{ url("/ingredients") }}',
                            type: 'GET',
                            data: {
                                search_ingredients: lastKeyword
                            },
                            success: function(data) {
                                var suggestions = data.suggestions;
                                var resultHtml = '';

                                if (suggestions && suggestions.length > 0) {
                                    suggestions.forEach(function(item) {
                                        resultHtml += `
                                            <div class="suggestion-item">
                                                ${item}
                                            </div>`;
                                    });
                                } else {
                                    resultHtml = '<div class="suggestion-item">Không có kết quả phù hợp</div>';
                                }

                                $('#mainSearchSuggestions').html(resultHtml).show();
                            },
                            error: function() {
                                $('#mainSearchSuggestions').html(
                                    '<div class="suggestion-item">Lỗi kết nối API</div>'
                                ).show();
                            }
                        });
                    }, 100);
                } else {
                    $('#mainSearchSuggestions').hide();
                }
            });

            // Khi nhấn vào một gợi ý
            $(document).on('click', '.suggestion-item', function() {
                var selectedValue = $(this).text().trim();
                var currentInput = $('#mainSearchInput').val().trim();

                // Lấy danh sách các từ khóa, loại bỏ từ cuối cùng và thay bằng gợi ý
                var keywords = currentInput.split(',');
                keywords[keywords.length - 1] = selectedValue;

                // Cập nhật ô input với các từ khóa đã chỉnh sửa
                $('#mainSearchInput').val(keywords.join(', ').trim() + ', ');

                // Ẩn hộp gợi ý
                $('#mainSearchSuggestions').hide();

                // Đưa con trỏ về cuối ô input
                $('#mainSearchInput').focus();
            });

            // Ẩn suggestions khi click ra ngoài
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-container').length) {
                    $('#mainSearchSuggestions').hide();
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/slide.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

</body>

</html>
