<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">
</head>

<body>
    <div class="relative h-screen text-white overflow-y-visible py-5 sm:py-10">
        <div class="absolute inset-0">
            <img src="{{ asset('images/hero_md-1.webp') }}" alt="Background Image"
                class="object-cover object-center w-full h-full " />

        </div>

        <div class="relative z-10 flex flex-col justify-between items-center h-full text-center">
            <div>
                <div class="flex items-center justify-center gap-x-4 mb-4">

                    <img src="{{ asset('images/logo_new.png') }}" alt="logo" class="w-14 h-14 sm:w-20 sm:h-20">
                    <h1 class="text-3xl sm:text-5xl text-white font-semibold">CoffeePlug</h1>

                </div>
                <p class="text-lg text-center">Get your coffee from across the world right to your door
                    step.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-y-2 sm:gap-x-4">
                <a href="{{ route('login_page') }}" class="btn btn-secondary w-96">Get
                    Started</a>
                <a href="{{ route('languages') }}" class="btn btn-outline w-96">
                    Create an Account
                </a>
            </div>
        </div>
    </div>

    <!-- Clare Chat Component -->
    <script src="{{ asset('js/clare-component.js') }}"></script>
</body>

</html>
