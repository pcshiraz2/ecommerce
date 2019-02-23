<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="@lang('platform.direction')">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ config('app.url') }}">

    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="@yield('author')">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    @if (Route::getCurrentRoute()->uri() == '/')
        <title>{{ config('platform.name', 'ShirazPlatform') }}@yield('title')</title>
    @else
        <title>@yield('title'){{ config('platform.name', 'ShirazPlatform') }}</title>
    @endif
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body class="rtl">
<div id="app">
    <header class="{{ config('platform.header-position') }}">
        <nav class="navbar navbar-expand-md {{ config('platform.navbar-type') }}">
            <div class="{{ config('platform.navbar-container') }}">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand mr-auto" href="{{ url('/') }}">
                    <i class="{{ config('platform.main-icon') }}"></i> {{ config('platform.name', 'ShirazPlatform') }}
                </a>

                <div class="d-block d-md-none d-lg-none d-xl-none">
                    <button class="btn btn-info btn-sm">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest

                        @else

                        @endguest
                        <li><a class="nav-link{{ Request::segment(1) == 'product' ? ' active' : '' }}"
                               href="{{ route('shop') }}"><i class="fa fa-shopping-bag"></i> فروشگاه</a></li>
                    </ul>
                    <form class="my-auto mx-auto w-50 d-none d-md-block d-lg-block d-xl-block" method="get" action="{{ route('product.find') }}">
                        <div class="input-group">
                            <input type="text" autocomplete="off" id="search" name="search" class="form-control"
                                   placeholder="جستجو..." aria-label="جستجوی ..." aria-describedby="navbar-search" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button id="search-btn" class="btn btn-warning" type="submit" id="navbar-search"><i
                                            class="fa fa-search" id="search-icon"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if(Cart::count())
                            <li>
                                <a class="nav-link{{ Request::segment(1) == 'cart' ? ' active' : '' }}"
                                   href="{{ route('cart') }}"><i class="fa fa-shopping-basket"></i> سبد خرید<span
                                            class="badge badge-pill badge-info">{{Cart::count()}}</span></a>
                            </li>
                        @endif
                        @guest
                            <li><a class="nav-link{{ Request::segment(1) == 'login' ? ' active' : '' }}"
                                   href="{{ route('login') }}"><i class="fa fa-sign-in"></i>ورود </a></li>
                            @if(config('platform.register-enabled'))
                                <li><a class="nav-link{{ Request::segment(1) == 'register' ? ' active' : '' }}"
                                       href="{{ route('register') }}"><i class="fa fa-user-plus"></i> ثبت نام</a></li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user-circle-o"></i> {{ Auth::user()->nav_name }} <span
                                            class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item{{ Request::segment(1) == 'dashboard' ? ' active' : '' }}"
                                       href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> پیشخوان</a>
                                    @can('admin')
                                        <a class="dropdown-item{{ Request::segment(1) == config('platform.admin-route') ? ' active' : '' }}"
                                           href="{{ route('admin.dashboard') }}"><i class="fa fa-cogs"></i> مدیریت سیستم</a>
                                    @endcan
                                    <a class="dropdown-item{{ Request::segment(1) == 'notification' ? ' active' : '' }}"
                                           href="{{ route('notification') }}"><i class="fa fa-bullhorn"></i> اطلاعیه ها

                                        </a>
                                    <a class="dropdown-item{{ Request::segment(1) == 'profile' ? ' active' : '' }}"
                                       href="{{ route('profile') }}">
                                        <i class="fa fa-user"></i> مشخصات کاربری
                                    </a>
                                    <a class="dropdown-item{{ Request::segment(1) == 'password' ? ' active' : '' }}"
                                       href="{{ route('password') }}">
                                        <i class="fa fa-key"></i> تغییر رمز عبور
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i> خروج
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>

            </div>
        </nav>
    </header>
    <main class="py-4" role="main">
        <div class="{{ config('platform.main-container') }}">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>

    </main>
    <footer class="{{ config('platform.footer-position') }}">
        <nav class="navbar navbar-expand-lg {{ config('platform.navbar-bottom-type') }}">
            <div class="{{ config('platform.navbar-container') }}">

                <ul class="navbar-nav mr-auto">
                    <li><a class="nav-link" href="{{ route('contact-us') }}"><i class="fa fa-envelope"></i> تماس با
                            ما</a></li>
                    <li><a class="nav-link" href="{{ route('about-us') }}"><i class="fa fa-info"></i> درباره ماه</a>
                    </li>
                    <li><a class="nav-link" href="{{ route('tos') }}"><i class="fa fa-balance-scale"></i> قوانین و
                            مقررات</a></li>
                    <li><a class="nav-link" href="{{ route('complaint') }}"><i class="fa fa-user-times"></i> ثبت
                            شکایت</a></li>
                    <li><a class="nav-link" href="{{ route('free-pay') }}"><i class="fa fa-money"></i>
                            پرداخت نقدی</a></li>
                </ul>
                <div class="ml-auto">
                    <div class="clearfix">
                        <img src="https://trustseal.enamad.ir/logo.aspx?id=117474&amp;p=hc4M4EyOgZbGDfWO" alt="" onclick="window.open(&quot;https://trustseal.enamad.ir/Verify.aspx?id=117474&amp;p=hc4M4EyOgZbGDfWO&quot;, &quot;Popup&quot;,&quot;toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30&quot;)" style="cursor:pointer" id="hc4M4EyOgZbGDfWO">
                        <img id = 'jxlzwlaorgvjapfurgvjjxlz' style = 'cursor:pointer' onclick = 'window.open("https://logo.samandehi.ir/Verify.aspx?id=143531&p=rfthaodsxlaodshwxlaorfth", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")' alt = 'logo-samandehi' src = 'https://logo.samandehi.ir/logo.aspx?id=143531&p=nbpdshwlqftiujynqftinbpd' />
                    </div>
                </div>
            </div>
        </nav>
        <div class="{{ config('platform.main-container') }}">
            <div class="row justify-content-center">
                <div class="col-12 text-center my-2">
                    <i class="fa fa-heart" style="color: mediumvioletred"></i> <a href="https://pcshiraz.ir" target="_blank">قدرت گرفته از پی سی شیراز</a>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@include('flash::message')
@yield('js')
</body>
</html>

