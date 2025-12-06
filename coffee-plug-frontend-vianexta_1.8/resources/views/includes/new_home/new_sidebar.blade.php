    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home_page') }}">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/vienexta_white.png') }}" alt="logo" width="100%" height="40">
                </div>
            </a>

            <strong style="color: #07382F;">Account : {{session('auth_user_type')}}</strong>
        </div>

        <ul class="list-unstyled components">
            <li class="{{in_array(Request::route()->getName(), [
                              'sellersDashboardHome'
                              ]) ? 'active' : ''}}">
                <a href="{{ route('sellersDashboardHome') }}">
                    <i class="fa fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="{{in_array(Request::route()->getName(), [
                              'sellerAccountPage'
                              ]) ? 'active' : ''}}">
                <a href="{{ route('sellerAccountPage') }}">
                    <i class="fa fa-briefcase"></i>
                    Account
                </a>

            </li>
            <li class="{{in_array(Request::route()->getName(), [
                              'sellersProductPage',
                              'sellers_add_product',
                              'editProduct',
                              'viewProduct',
                              ]) ? 'active' : ''}}">
                <a href="{{ route('sellersProductPage') }}">
                    <i class="fa fa-shopping-bag"></i>
                    Products
                </a>
                <!-- <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-copy"></i>
                    Pages
                </a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                        <a href="#">Page 1</a>
                    </li>
                    <li>
                        <a href="#">Page 2</a>
                    </li>
                    <li>
                        <a href="#">Page 3</a>
                    </li>
                </ul> -->
            </li>
            <li class="{{in_array(Request::route()->getName(), [
                              'roasterOrdersListPage',
                              'deliveryQuotes'
                              ]) ? 'active' : ''}}">
                <a href="{{ route('roasterOrdersListPage') }}">
                    <i class="fa fa-first-order"></i>
                    Orders
                </a>
            </li>
            @if(session('auth_user_type') == 'Admin')
            <li class="{{in_array(Request::route()->getName(), [
                              'producersListPage'
                              ]) ? 'active' : ''}}">
                <a href="{{ route('producersListPage') }}">
                    <i class="fa fa-user-circle-o"></i>
                    Producers
                </a>
            </li>
            <li class="{{in_array(Request::route()->getName(), [
                              'roastersListPage',
                              'roasterPendingOrders'
                              ]) ? 'active' : ''}}">
                <a href="{{ route('roastersListPage') }}">
                    <i class="fa fa-free-code-camp"></i>
                    Roasters
                </a>
            </li>

            <li class="{{in_array(Request::route()->getName(), [
                              'retailersListPage'
                              ]) ? 'active' : ''}}">
                <a href="{{ route('retailersListPage') }}">
                    <i class="fa fa-users"></i>
                    Retailers
                </a>
            </li>
            <li class="{{in_array(Request::route()->getName(), [
                              'caffeesListPage',
                              ]) ? 'active' : ''}}">
                <a href="{{ route('caffeesListPage') }}">
                    <i class="fa fa-coffee"></i>
                    Cafe
                </a>
            </li>
            <li class="{{in_array(Request::route()->getName(), [
                              'coffeeSuppliersListPage'
                              ]) ? 'active' : ''}}">
                <a href="{{ route('coffeeSuppliersListPage') }}">
                    <i class="fa fa-truck"></i>
                    Coffee Suppliers
                </a>
            </li>
            @endif

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