<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ViaNexta')</title>
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/keen-slider.min.css" rel="stylesheet"/>
    @yield('header-scripts')

</head>

<body>


    @yield('content')




    @include('includes.alerts.alert_scripts')
    @include('partials.scripts.animations ')
</body>

</html>
