    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home_page') }}">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/vienexta_white.png') }}" alt="logo" width="100%" height="40">
                </div>
            </a>

            <strong>Account : {{session('auth_user_type')}}</strong>
        </div>

        <ul class="list-unstyled components">
            <li class="{{in_array(Request::route()->getName(), [
                              'buyerDashboard'
                              ]) ? 'active' : ''}}">
                <a href="{{ route('buyerDashboard') }}">
                    <i class="fa fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="{{in_array(Request::route()->getName(), [
                              'buyerAccountPage'
                              ]) ? 'active' : ''}}">
                <a href="{{ route('buyerAccountPage') }}">
                    <i class="fa fa-briefcase"></i>
                    Account
                </a>
            </li>
            <li class="{{in_array(Request::route()->getName(), [
                                          'buyer_market_place'
                                          ]) ? 'active' : ''}}">
                <a href="{{ route('buyer_market_place') }}">
                    <i class="fa fa-shopping-bag"></i>
                    Marketplace
                </a>
            </li>
            <li class="{{in_array(Request::route()->getName(), [
                                          'buyerOrderHistory'
                                          ]) ? 'active' : ''}}">
                <a href="{{ route('buyerOrderHistory') }}">
                    <i class="fa fa-list"></i>
                    Orders
                </a>
            </li>
            <li class="{{in_array(Request::route()->getName(), [
                                          'buyer_cart'
                                          ]) ? 'active' : ''}}">
                <a href="{{ route('buyer_cart') }}">
                    <i class="fa fa-shopping-cart"></i>
                    Cart
                </a>
            </li>
            <li class="{{in_array(Request::route()->getName(), [
                                          'help'
                                          ]) ? 'active' : ''}}">
                <a href="{{ route('help') }}">
                    <i class="fa fa-info"></i>
                    Help
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                    Logout
                </a>
                <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>

    </nav>