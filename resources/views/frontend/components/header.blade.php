<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.png')}}">

    <!-- Vendors Css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/animate/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/remixicon/remixicon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fontawesome-pro/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/aos/aos.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fancybox/fancybox.css')}}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/spacing.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/frontend.css')}}">
</head>

<body>

<div class="header-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-3 col-6">
                <div class="logo-wrap">
                    <a href="{{route('home')}}">
                        <img src="{{asset('logo.png')}}" alt="logo">
                    </a>
                </div>
            </div>
            <div class="col-xl-9 col-6">
                <div class="header-right d-none d-xl-flex">
                    <div class="main-menu">
                        <ul>
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li><a href="{{route('service')}}">Service</a></li>
                            <li><a href="{{route('tracking')}}">Tracking</a></li>
                            <li><a href="{{route('shop')}}">Marketplace</a></li>
                            <li><a href="{{route('partners')}}">Partners</a></li>
                            <li><a href="{{route('about')}}">About</a></li>
                        </ul>
                    </div>
                    <div class="header-account">
                        <div class="current"><i class="ri-account-circle-2-line"></i></div>
                        <div class="sub-menu">
                            @if(auth()->check())
                                <a href="{{route('my-account')}}">My Account</a>
                                <a href="{{route('my-profile')}}">My Profile</a>
                                <a href="{{route('my-orders')}}">My Orders</a>
                                <a href="{{route('my-wishlist')}}">My Wishlist</a>
                                <a href="{{route('dashboard')}}">My Dashboard</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="logout-btn" data-logout-button>Logout</button>
                                </form>
                            @else
                                <a href="{{route('login')}}">login</a>
                                <a href="{{route('register')}}">Register</a>
                            @endif
                        </div>
                    </div>
                    <div class="header-btns">
                        <a href="{{route('contact')}}">Get a Quote</a>
                    </div>
                </div>
                <div class="header-right d-flex d-xl-none">
                    <div class="open-menu">
                        <i class="ri-menu-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas-wrapper">
    <div class="offcanvas-sidebar">
        <div class="offcanvas-menu">
            <ul>
                <li><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('service')}}">Service</a></li>
                <li><a href="{{route('tracking')}}">Tracking</a></li>
                <li><a href="{{route('shop')}}">Marketplace</a></li>
                <li><a href="{{route('partners')}}">Partners</a></li>
                <li><a href="{{route('about')}}">About</a></li>
            </ul>
        </div>
        <div class="offcanvas-btns">
            <a href="{{route('contact')}}" class="quote">Get a Quote</a>
            @if(auth()->check())
                <a href="{{route('my-account')}}">My Account</a>
                <a href="{{route('my-profile')}}">My Profile</a>
                <a href="{{route('my-orders')}}">My Orders</a>
                <a href="{{route('my-wishlist')}}">My Wishlist</a>
                <a href="{{route('dashboard')}}">My Dashboard</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn" data-logout-button>Logout</button>
                </form>
            @else
                <a href="{{route('login')}}" class="login">login</a>
                <a href="{{route('register')}}" class="register">Register</a>
            @endif
        </div>
    </div>
    <div class="offcanvas-close">
        <i class="ri-close-line"></i>
    </div>
    <div class="offcanvas-overlay"></div>
</div>
