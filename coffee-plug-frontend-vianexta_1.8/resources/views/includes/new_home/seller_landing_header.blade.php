
<style>
    .center-link {
         left: 50%;
         transform: translateX(-50%)
      }
       .dropdown-item:hover {
        transform: scale(1.1);
        background-color: #D3D3D3;
    }
    .dropdown-item {
        margin: 5px;
    }
 </style>

<nav id="app_header" class="navbar fixed-top position-relative" style="background:#07382F">
    <div class="container">
        <div class="d-flex w-100 align-items-end">
            <a class="navbar-brand text-white fw-bolder d-flex align-items-center" href="{{session('auth_user_tokin') ==null ? route('new_home') : route('sellersDashboardHome')}}">
                <img class="coffee-logo ms-2" src="{{ asset('images/logo_new_w.svg') }}" width="auto" height="40"
                    alt="Logo">
            </a>
            <ul class="center-link ms-auto d-none d-md-flex align-items-center nav-list position-absolute column-gap-5 mb-0 ps-0">
                <li><a class="nav-link text-white fs-5 fw-bolder" href="{{route('buyers_landing')}}">Buyer</a></li>
                <li><a class="nav-link text-white fs-5 fw-bolder" href="{{route('sellers_landing')}}">Seller</a></li>
            </ul>
            <div class="ms-auto nav-icons d-flex align-items-center column-gap-3">
                <a class="nav-link text-white" href="{{session('auth_user_tokin') ==null ? route('login_page'): (session('auth_user_role') == 'Buyer' ? route('buyerDashboard') : route('sellersDashboardHome')) }}"><i class="fa fa-user-o fa-2x"></i></a>
                @if(session('auth_user_role') == 'Buyer')
                  <a class="nav-link text-white" href="{{route('buyer_cart')}}"><i class="fa fa-shopping-cart fa-2x"></i></a>
                @endif
                <div class="position-relative">
                    <i id="toggle" class="fa fa-bars fa-2x text-white" aria-hidden="true"></i>
                    <div id="drop" class="position-absolute d-none nav-dropdown py-2 px-4 rounded bg-white">
                        <a class="d-md-none dropdown-item text-white" href="{{route('buyers_landing')}}">Buyer</a>
                        <a class="d-md-none dropdown-item text-white" href="{{route('sellers_landing')}}">Seller</a>
                        <a class="dropdown-item" href="{{ route('buyer_market_place') }}">Marketplace</a>
                        <a class="dropdown-item" href="{{ route('work_with_us') }}">Work with us</a>
                        <a class="dropdown-item" href="{{ route('recommend')}}">Recommend</a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="{{route('sellersDashboardHome')}}">Dashboard</a>
                        <a class="dropdown-item" href="{{route('help')}}">Help</a>
                          @csrf  
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
