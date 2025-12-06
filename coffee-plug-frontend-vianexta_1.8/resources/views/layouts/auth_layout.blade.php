<!DOCTYPE html>
<html lang="en" class="h-screen" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ViaNexta')</title>
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <!-- select2 css -->
    <link rel="stylesheet" href="{{ asset('abel_assets/css/plugins/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/css/flag-icon.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @stack('css')

    <style>
        .center-link {
            left: 50%;
            transform: translateX(-50%);
            column-gap: 3rem;
        }

        .container {
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 12px;
        }
    </style>

</head>

<!-- <body class="relative min-h-full"> -->

<body class="d-flex flex-column min-vh-100">

    {{-- @include('includes.new_home.seller_landing_header') --}}
    @include('includes.new_home.new_home_header')

    @yield('content')



    @include('includes.alerts.message_alerts')
    <!-- @include('includes.footers.footer_alt') -->
    @include('includes.footers.new_home_footer')
    @yield('scripts')

    <script src="{{ asset('vendor/js/bootstrap.min.js') }}"></script>
    <!-- sweet alert Js -->
    <script src="{{ asset('abel_assets/js/vendor-all.min.js')}}"></script>
    <script src="{{ asset('abel_assets/js/plugins/sweetalert.min.js')}}"></script>

    <!-- AOS initialization removed - library not loaded -->
    <script src="{{ asset('abel_assets/js/vendor-all.min.js')}}"></script>
    <script src="{{ asset('abel_assets/js/plugins/select2.full.min.js')}}"></script>
    <script src="{{ asset('abel_assets/js/pages/form-select-custom.js')}}"></script>
    <!-- <script src="{{ asset('js/aos.js') }}"></script> -->
    @include('includes.alerts.sweet_alert_scripts')

    <script src="{{ asset('js/tabs.js') }}"></script>
</body>

</html>