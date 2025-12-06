<style>
    .center-link {
        left: 50%;
        transform: translateX(-50%);
    }

    .dropdown-item:hover {
        transform: scale(1.1);
        background-color: #D3D3D3;
    }

    .dropdown-item {
        margin: 5px;
    }

    /* Make the navbar opaque */
    #app_header {
        background-color: #F1F1F1;
        /* White with opacity */
        z-index: 1030;
        /* Ensure it stays above other elements */
        /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
        /* Optional shadow for better visibility */
    }
</style>

<link rel="stylesheet" href="{{ asset('css/custom_style.css') }}">
<nav id="app_header" class="navbar fixed-top">
    <div class="container">
        <div class="d-flex w-100 align-items-end position-relative">
            <a class="navbar-brand text-primary fw-bolder d-flex align-items-center" href="{{session('auth_user_tokin') ==null ? route('new_home') : route('buyerDashboard')}}">
                {{-- ViaNexta --}}
                <img class="coffee-logo ms-2" src="{{ asset('images/logo_new.png') }}" height="40"
                    alt="Logo">
            </a>
            <ul class="center-link navv d-none d-md-flex align-items-end nav-list position-absolute column-gap-5 mb-0">
                <li><a class="nav-link text-primary fs-5 fw-bold" href="{{route('buyers_landing')}}">Buyer</a></li>
                <li><a class="nav-link text-primary fs-5 fw-bold" href="{{route('sellers_landing')}}">Seller</a></li>
            </ul>
            <div class="nav-icons d-flex align-items-center column-gap-3 ms-auto">
                <a class="nav-link text-primary" href="{{session('auth_user_tokin') ==null ? route('login_page') : route('buyerDashboard')}}"><i class="fa fa-user-o fa-2x"></i></a>
                @if(session('auth_user_role') == 'Buyer')
                <a class="nav-link text-primary" href="{{route('buyer_cart')}}"><i class="fa fa-shopping-cart fa-2x"></i></a>
                @endif
                <div class="position-relative">
                    <i id="toggle" class="fa fa-bars fa-2x" aria-hidden="true"></i>
                    <div id="drop" class="position-absolute d-none nav-dropdown py-2 px-4 rounded bg-white">
                        <a class="d-md-none dropdown-item text-primary" href="{{route('buyers_landing')}}">Buyer</a>
                        <a class="d-md-none dropdown-item text-primary" href="{{route('sellers_landing')}}">Seller</a>
                        <a class="dropdown-item" href="{{ route('buyer_market_place') }}">Marketplace</a>
                        <a class="dropdown-item" href="{{ route('work_with_us') }}">Work with us</a>
                        <a class="dropdown-item" href="{{ route('join_team') }}">Our team</a>
                        <a class="dropdown-item" href="{{ route('recommend')}}">Recommend</a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="{{route('buyerDashboard')}}">Dashboard</a>
                        <a class="dropdown-item" href="{{route('order_history')}}">Order tracking</a>
                        <a class="dropdown-item" href="{{route('help')}}">Help</a>
                        @if(session('auth_user_tokin') == null)
                        <a href="{{route('login_page')}}" class="dropdown-item">Log in</a>
                        @else
                        <a href="{{ route('login_page') }}" class="dropdown-item">Log out</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<script src="{{ asset('js/nav.js') }}"></script>