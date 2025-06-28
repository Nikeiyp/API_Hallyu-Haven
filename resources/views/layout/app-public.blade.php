<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) ?? 'en' }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ config('app.desc') }}">
    <meta name="keywords" content="ecommerce,merchandise">
    <meta name="author" content="{{ config('app.name') }}">

    <title>@yield('title') | {{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('asset/images/favicon.ico') }}">
    <!-- BEGIN: CSS Assets -->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/vendor/linearicons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/vendor/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/animation.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/slick.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/magnific-popup.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/easyzoom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/plugins/slick-theme.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @yield('addition_css')
    <!-- END: CSS Assets -->
</head>

<body class="box-home">
    <div class="page-box">
        @include('components.header')
        <div id="main-wrapper">
            @yield('content')
            @include('components.footer')
        </div>
    </div>


    <!-- BEGIN: JS Assets -->
    <script src="{{ asset('asset/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <script src="{{ asset('asset/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('asset/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('asset/js/vendor/axios.min.js') }}"></script>
    <script src="{{ asset('asset/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/fullpage.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/slick.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/countdown.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/easyzoom.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/images-loaded.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/isotope.min.js') }}"></script>
    
    <!-- Instagramfeed JS -->
    <!-- <script src="{{ asset('assets/js/plugins/jquery.instagramfeed.min.js')}}"></script> -->
    <script src="{{ asset('asset/js/plugins/ajax.mail.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/wow.min.js')}}"></script>
    <!-- Plugins JS (Please remove the comment from below plugins.min.js for better website load 
    performance and remove plugin js files from above) -->
    <script src="{{ asset('asset/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('asset/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('pages/js/app.js') }}"></script>
    @yield('addition_script')
    <!-- END: JS Assets -->
</body>
</html>