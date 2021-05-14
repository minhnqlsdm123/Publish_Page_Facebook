<!DOCTYPE html>
<html>

<head>
    <title>Thegioididong</title>
    <link rel="icon" sizes="32x32" type="image/png" href="" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/frontend/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/frontend/fonts/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/frontend/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="/frontend/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="/frontend/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/frontend/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/frontend/css/home.css" />
    <link rel="stylesheet" href="/frontend/css/lightslider.css" />
    <link rel="stylesheet" href="/frontend/css/lightgallery.min.css" />
    <link href="/backend/build/css/toastr.min.css" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @if(session('toastr'))
    <script>
        var TYPE_MESSAGE = "{{session('toastr.type')}}";
        var MESSAGE      = "{{session('toastr.message')}}";
    </script>
    @endif
</head>

<body>
    <div id="wrapper">
        <div id="top-header">
            <div class="container clearfix">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="menu fl_left">
                            <li><a href="">Chăm sóc khách hàng</a></li>
                            <li><a href="">Kiểm tra đơn hàng</a></li>
                        </ul>
                        <ul class="menu fl_right">
                            @if(\Auth::guard('account')->check())
                            <li><a href="">Chào: <span>{{ \Auth::guard('account')->user()->name }}</span></a></li>
                            <li><a href="">|</a></li>
                            <li><a href="{{ route('account.get.logout') }}">Đăng xuất</a></li>
                            @else
                            <li><a href="{{ route('account.get.register') }}">Đăng kí</a></li>
                            <li><a href="{{ route('account.get.login') }}">Đăng nhập</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- end top-header -->
        <div id="wp-header">
            <div class="container">
                <div class="logo">
                    <a href="{{ route('frontend.home') }}">
                        <img src="/frontend/image/logo.png" title="" alt="" />
                    </a>
                </div>
                <!-- end logo -->
                <div class="form-search">
                    <form action="" method="Get">
                        <input type="text" name="keyword" value="" />
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <!-- end form-search -->
                <div class="tools">
                    <ul class="menu">
                        <li>
                            <a href="" title="Giỏ hàng">
                                <i class="fa fa-shopping-bag cart"></i>
                                <span class="text">
                                    <span class="">Giỏ hàng (0)</span>
                                </span>
                            </a>
                        </li>
                        <li class="li-icon-nav-menu">
                            <a href="" class="icon-nav-menu">
                                <span class=""><i class="fa fa-bars" aria-hidden="true"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- end tools -->
            </div>
        </div>
        <!-- end wp-header -->
        <div id="main-menu">
            <div class="container">
                <ul>
                    <li><a href="">Laptop</a></li>
                    <li><a href="">Laptop</a></li>
                    <li><a href="">Máy tính bảng</a></li>
                    <li><a href="">Phụ kiện điện thoại</a></li>
                    <li><a href="">Phụ kiện máy tính</a></li>
                    <li><a href="">Máy ảnh số</a></li>
                    <li><a href="">Điện thoại</a></li>
                </ul>
            </div>
        </div>
        <!-- end menu -->