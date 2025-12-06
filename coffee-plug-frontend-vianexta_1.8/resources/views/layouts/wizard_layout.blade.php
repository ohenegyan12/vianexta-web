<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ViaNexta')</title>
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_style.css') }}">
    <!-- select2 css -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/css/flag-icon.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- fileupload-custom css -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet"> -->
    @stack('css')

</head>

<body class="d-flex flex-column min-vh-100">

    @yield('content')


    @if(!isset($donnot_show_footer) || $donnot_show_footer==null || !$donnot_show_footer)
    @include('includes.footers.new_home_footer')
    @endif

    @include('includes.alerts.message_alerts')

    <script src="{{ asset('js/tabs.js') }}"></script>
    <!-- Add interact.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/interact.js/1.10.17/interact.min.js"></script>
    <script src="{{ asset('vendor/js/bootstrap.min.js') }}"></script>
    <!-- sweet alert Js -->
    <script src="{{ asset('abel_assets/js/vendor-all.min.js')}}"></script>
    <script src="{{ asset('abel_assets/js/plugins/sweetalert.min.js')}}"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    @include('includes.alerts.sweet_alert_scripts')

    @yield('scripts')
</body>

</html>