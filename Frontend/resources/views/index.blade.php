<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="{{ asset('assets/image/kaiadmin/favicon.ico') }}" type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: { families: ["Public Sans:300,400,500,600,700"] },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["assets/css/fonts.min.css"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
  </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main_content.css') }}" />

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link rel="stylesheet" href="assets/css/demo.css" />
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="index.html" class="logo">
            <img src="{{ asset('assets/image/logo_text_halloween.png') }}" alt="navbar brand" class="navbar-brand" height="20" />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item active">
              <a data-bs-toggle="collapse" href="" class="collapsed" aria-expanded="false">
                <i class="fas fa-home"></i>
                <p class="title">Trang chủ</p>
                <span class="caret"></span>
              </a>
            </li>
            <li class="nav-section">
              <span class="sidebar-mini-icon">
                <i class="fa fa-ellipsis-h"></i>
              </span>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#base">
                <i class="fa-brands fa-product-hunt"></i>
                <p class="title">Premium</p>
                <span class="caret"></span>
              </a>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#sidebarLayouts">
                <i class="fa-solid fa-store"></i>
                <p class="title">Kho món ăn của bạn</p>
              </a>
            </li>
            <li class="nav-item">
              <p class="title content-sidebar-desc" style="margin-bottom: 0px;">Để bắt đầu tạo kho lưu trữ món ngon của
                riêng bạn, vui lòng
                <a style="padding: 0px !important; text-decoration: underline !important;" href=""
                  class="title">đăng ký hoặc đăng nhập.</a>
                </p>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img src="{{ asset('assets/assets/image/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->

        <!-- End Navbar -->
      </div>
      <!-- ------------------------------------------------MAIN CONTENT------------------------------------------------------------ -->
      <div class="content-custom" style="padding: 0px 120px;">
        <div class="container">
          <div class="main-content">
            <div class="banner-main">
              <div class="img"><a href=""><img src="{{ asset('assets/image/photo.webp') }}" alt=""></a></div>
              <div class="title">
                <h1 class="header">Biến việc nấu ăn hàng ngày trở nên thú vị hơn!</h1>
                <p class="description">Tìm và chia sẻ các công thức tuyệt vời cho việc nấu ăn hàng ngày của bạn</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row mon-ngon-cook">
          <div class="col-md-7 content-industry-left">
            <h1 class="header">Tìm và khám phá món ngon từ cộng đồng Cookpad</h1>
            <p class="description">Thông qua tìm kiếm trên Cookpad, bạn có thể khám phá công thức nấu ăn theo nguyên
              liệu
              hoặc tên món ăn, đảm bảo bạn luôn tìm được món ngon.

              Trải nghiệm tìm kiếm thậm chí còn tốt hơn với ứng dụng di động Cookpad miễn phí!</p>
          </div>
          <div class="col-md-5 content-industry-right">
            <div class="img">
              <img src="{{ asset('assets/image/photo_v3.webp') }}" alt="">
            </div>
          </div>
        </div>
        <div class="row mon-ngon-cook">
          <div class="col-md-5 content-industry-right">
            <div class="img">
              <img src="{{ asset('assets/image/photo_v3 (1).webp') }}" alt="">
            </div>
          </div>
          <div class="col-md-7 content-industry-left">
            <h1 class="header">Lưu công thức</h1>
            <p class="description">Sử dụng biểu tượng đánh dấu, bạn có thể lưu các công thức nấu ăn trong trang bếp của
              mình để dùng sau này.

              Với ứng dụng di động Cookpad miễn phí, bạn có thể lưu và quản lý công thức nấu ăn của mình hiệu quả hơn!
            </p>
          </div>

        </div>
        <div class="row mon-ngon-cook">
          <div class="col-md-5 content-industry-right">
            <div class="img">
              <img src="{{ asset('assets/image/photo_v3 (1) (1).webp') }}" alt="">
            </div>
          </div>
          <div class="col-md-7 content-industry-left">
            <h1 class="header">Chia sẻ cách làm món ngon của bạn</h1>
            <p class="description">Sử dụng biểu tượng đánh dấu, bạn có thể lưu các công thức nấu ăn trong trang bếp của
              mình để dùng sau này. Với ứng dụng di động Cookpad miễn phí, bạn có thể lưu và quản lý công thức nấu ăn
              của mình hiệu quả hơn!
            </p>
          </div>

        </div>
        <div class="row mon-ngon-cook">
          <div class="col-md-12 content-industry-left">
            <h1 class="header">Về Cookpad</h1>
            <p class="description">Sứ mệnh của Cookpad là làm cho việc vào bếp vui hơn mỗi ngày, vì chúng tôi tin rằng
              nấu nướng là chìa khoá cho một cuộc sống hạnh phúc hơn và khoẻ mạnh hơn cho con người, cộng đồng, và hành
              tinh này. Chúng tôi muốn hỗ trợ các đầu bếp gia đình trên toàn thế giới để họ có thể giúp đỡ nhau qua việc
              chia sẻ các món ngon và kinh nghiệm nấu ăn của mình.
            </p>
          </div>

        </div>
        <!-- ------------------------------------------------END MAIN CONTENT------------------------------------------------------------ -->







        <!-- ------------------------------------------------FOOTER---------------------------------------------------------------------- -->
        <div class="row footer-image">
          <div class="col-md-12">
            <div class="img">
              <img src="{{ asset('assets/image/footer-210d183ce6443eb41fa78f10b270fb773bab56416e2680a35328f51e8ddf85d0.png') }}" alt="">
            </div>

          </div>
        </div>
        <!-- ------------------------------------------------END FOOTER--------------------------------------------------------------- -->
      </div>


      <!-- Custom template | don't include it in your project! -->
      <div class="custom-template">
        <div class="title">Settings</div>
        <div class="custom-content">
          <div class="switcher">
            <div class="switch-block">
              <h4>Logo Header</h4>
              <div class="btnSwitch">
                <button type="button" class="selected changeLogoHeaderColor" data-color="dark"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="blue"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="purple"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="light-blue"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="green"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="orange"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="red"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="white"></button>
                <br />
                <button type="button" class="changeLogoHeaderColor" data-color="dark2"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="blue2"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="purple2"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="light-blue2"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="green2"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="orange2"></button>
                <button type="button" class="changeLogoHeaderColor" data-color="red2"></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Navbar Header</h4>
              <div class="btnSwitch">
                <button type="button" class="changeTopBarColor" data-color="dark"></button>
                <button type="button" class="changeTopBarColor" data-color="blue"></button>
                <button type="button" class="changeTopBarColor" data-color="purple"></button>
                <button type="button" class="changeTopBarColor" data-color="light-blue"></button>
                <button type="button" class="changeTopBarColor" data-color="green"></button>
                <button type="button" class="changeTopBarColor" data-color="orange"></button>
                <button type="button" class="changeTopBarColor" data-color="red"></button>
                <button type="button" class="selected changeTopBarColor" data-color="white"></button>
                <br />
                <button type="button" class="changeTopBarColor" data-color="dark2"></button>
                <button type="button" class="changeTopBarColor" data-color="blue2"></button>
                <button type="button" class="changeTopBarColor" data-color="purple2"></button>
                <button type="button" class="changeTopBarColor" data-color="light-blue2"></button>
                <button type="button" class="changeTopBarColor" data-color="green2"></button>
                <button type="button" class="changeTopBarColor" data-color="orange2"></button>
                <button type="button" class="changeTopBarColor" data-color="red2"></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Sidebar</h4>
              <div class="btnSwitch">
                <button type="button" class="changeSideBarColor" data-color="white"></button>
                <button type="button" class="selected changeSideBarColor" data-color="dark"></button>
                <button type="button" class="changeSideBarColor" data-color="dark2"></button>
              </div>
            </div>
          </div>
        </div>
        <div class="custom-toggle">
          <i class="icon-settings"></i>
        </div>
      </div>
      <!-- End Custom template -->
    </div>
        <!-- Core JS Files -->
        <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

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
