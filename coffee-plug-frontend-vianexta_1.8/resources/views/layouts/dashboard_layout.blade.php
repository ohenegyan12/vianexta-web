<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Analytics Dashboard|ViaNexta</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies,ViaNexta,Coffee .">
    <meta name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard,ViaNexta,Coffee">
    <meta name="author" content="Phoenixcoded">

    <!-- [Favicon] icon -->
    {{-- <link rel="icon" href="{{ asset('dashboard_assets/images/favicon.svg') }}" type="image/x-icon"> --}}
    <!-- [Font] Family -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets/fonts/inter/inter.css') }}" id="main-font-link" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets/fonts/tabler-icons.min.css') }}" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets/fonts/feather.css') }}" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets/fonts/fontawesome.css') }}" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets/fonts/material.css') }}" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('dashboard_assets/css/style-preset.css') }}" />
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-14K1GBX9FG"></script>
    @stack('css')
</head>
<!-- [Head] end -->



<body data-pc-preset="preset-2" data-pc-sidebar-caption="true" data-pc-direction="ltr">

    <section style="background-color:#07382F ">
        <div class="container-xxl p-3 ">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('buyer_market_place') }}">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/vienexta_white.png') }}" alt="logo" width="200" height="40">
                    </div>
                </a>
                <h6 class=" text-white">Welcome {{session('auth_user_name')}}
                    <p>Role: {{session('auth_user_role')}} </p>
                </h6>

            </div>
        </div>
    </section>


    @yield('content')



    @include('includes.alerts.message_alerts')
    <!-- Required Js -->
    <script src="{{ asset('dashboard_assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard_assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('dashboard_assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard_assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('dashboard_assets/js/plugins/feather.min.js') }}"></script>
    <!-- Data Table JS - data_tables.js -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script src="{{ asset('dashboard_assets/js/datatables.js') }}"></script>
    <!-- Chart JS -->

    @yield('scripts')

</body>

</html>