<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        Maintenance - {{ setting('website_name', config('app.name')) }}
    </title>

    <!-- favicon -->
    <link
        rel="shortcut icon"
        type="image/x-icon"
        href="{{ setting('favicon') ? asset(setting('favicon')) : asset('favicon.png') }}"
    >

    <!-- csrf -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Vendors Css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/animate/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/remixicon/remixicon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fontawesome-pro/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/aos/aos.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fancybox/fancybox.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2/sweetalert2.min.css')}}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/spacing.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/frontend.css')}}">
</head>

<body>
    <div class="maintenance-page">

        @if (setting('website_logo'))
            <img
                src="{{ asset(setting('website_logo')) }}"
                alt="{{ setting('website_name', config('app.name')) }}"
            >
        @endif

        <h1>We'll Be Back Soon</h1>

        <p>
            {{ setting(
                'website_tagline',
                'Our website is currently undergoing maintenance.'
            ) }}
        </p>

    </div>



    <!-- Vendors Js -->
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/popper/popper.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('assets/vendor/fancybox/fancybox.umd.js')}}"></script>
    <script src="{{asset('assets/vendor/sweetalert2/sweetalert2@11.js')}}"></script>


    <!-- Main Js -->
    <script src="{{asset('assets/js/frontend.js')}}"></script>

    @include('frontend.components.alerts')

    <!-- Page Specific Js -->
    @stack('scripts')
</body>

</html>

