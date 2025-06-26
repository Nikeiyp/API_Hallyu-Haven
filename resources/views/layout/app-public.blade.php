<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" contents ="{{csrf_token() }}">
    <meta name="description" content="{{ config('app.desc') }}">
    <meta name="keywords" content="ecommerce, merch">
    <meta name="author" content="{{ config('app.name') }}">

    <title>@yield('title') | {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{asset('asset/images/favicon.ico')}}">

    <!-- BEGIN: CSS Assets -->
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/vendor/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/vendor/fontawesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/vendor/linearicons.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/vendor/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/vendor/ionicons.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/slick.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/style.css')}}">
    <!-- END: CSS Assets -->
</head>

<body class="box-home">
    <div class="page-box">
        @include('components.header')
        <div id="main-wrapper">
            @yield('content')
        </div>
        @include('components.footer')
    </div>

    <!-- BEGIN: JS Assets -->
    <script src="{{asset('asset/js/vendor/modernizr-2.8.3.min.js')}}"></script>
    <script src="{{asset('asset/js/vendor/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('asset/js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>
    <script src="{{asset('asset/js/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/slick.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/jquery-ui.js')}}"></script>
    <script src="{{asset('asset/js/plugins/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/instafeed.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/images-loaded.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/isotope.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/ajax-mail.js')}}"></script>
    <script src="{{asset('asset/js/plugins/jquery.instagramFeed.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/ion.rangeSlider.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/jquery.zoom.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/plugin.js')}}"></script>
    <!-- NOTE: please remove the comment from below plugins.min.js for better website load performance -->
    <!-- <script src="{{asset('assets/js/plugins/plugins.min.js')}}"></script> -->
    <script src="{{asset('asset/js/main.js')}}"></script>
    <script src="{{asset('asset/js/pages/index-newsletter-popup.js')}}"></script>
    @yield('addition_script')
    <!-- END: JS Assets -->
</body>

</html>
