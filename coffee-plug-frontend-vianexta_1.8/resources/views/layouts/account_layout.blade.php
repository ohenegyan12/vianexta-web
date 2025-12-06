<!DOCTYPE html>
<html lang="en" class="h-screen" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'ViaNexta')</title>
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @yield('script')
</head>

<body class="relative min-h-full" data-theme="light">
    <section class="py-4 md:py-6 bg-secondary">
        <div class="px-5 mx-auto max-w-screen-2xl ">
            <div class="flex flex-row items-center justify-between ">
                <a href="{{session('auth_user_tokin') ==null ? route('new_home') : (session('auth_user_role') == 'Buyer' ? route('buyerDashboard') :  route('sellersDashboardHome'))}}">
                    <div class="flex flex-row items-center gap-x-2" data-aos="fade-right" data-aos-duration="900">
                        <img src="{{ asset('images/vienexta_white.png') }}" alt="logo" class="h-12 w-auto" style="max-width: 120px;" />
                    </div>
                </a>
                <div class="flex items-center text-white gap-x-4">
                    @php if(session('auth_user_tokin') ==null){ @endphp
                    <a href="{{ route('login_page') }}">
                        <div class="text-lg font-semibold text-white hidden sm:block">Log in</div>
                    </a>
                    @php } else { @endphp
                    @if(session('auth_user_role') == 'Buyer')
                    <a href="{{ route('buyerDashboard') }}">
                        <div class="text-lg font-semibold text-white hidden sm:block">Welcome {{session('auth_user_name')}}</div>
                    </a>
                    @else
                    <a href="{{ route('sellersDashboardHome') }}">
                        <div class="text-lg font-semibold text-white hidden sm:block">Welcome {{session('auth_user_name')}}</div>
                    </a>
                    @endif

                    @php } @endphp

                    <!-- <a href="{{route('buyer_cart')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="hidden w-8 h-8 sm:block">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>

                    </a> -->
                    <div @click.away="open = false" class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparen rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:w-auto md:inline md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">
                            <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800" style="Width:200px;">
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline text-secondary" href="{{route('buyers_landing')}}">Buyer
                                    <hr>
                                </a>
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline text-secondary" href="{{route('sellers_landing')}}">Seller
                                    <hr>
                                </a>
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline text-secondary" href="{{ route('ourTeam') }}">Our Team
                                    <hr>
                                </a>
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline text-secondary" href="{{ route('recommend')}}">Recommend
                                    <hr>
                                </a>
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline text-secondary" href="{{route('help')}}">Help
                                    <hr>
                                </a>
                                @if(session('auth_user_role') == 'Buyer')
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline text-secondary" href="{{route('buyerDashboard')}}">Dashboard
                                    <hr>
                                </a>
                                @endif
                                @if(session('auth_user_role') == 'Supplier')
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline text-secondary" href="{{route('sellersDashboardHome')}}">Dashboard
                                    <hr>
                                </a>
                                @endif
                                <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" > -->
                                <!-- @csrf   -->
                                <a href="{{route('login_page')}}" class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline  btn btn-primary text-white">Log Out</a>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                    <div x-data="{ open: false }">
                        <!-- <button @click=" open = !open ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>

                        </button> -->

                        <!-- @include('includes.flyout_menu') -->

                    </div>

                </div>
            </div>

        </div>
    </section>

    @yield('content')



    @include('includes.alerts.message_alerts')
    @include('includes.footers.footer_alt')
    @include('includes.alerts.alert_scripts')
    @include('partials.scripts.animations ')

    @yield('scripts')
</body>

</html>