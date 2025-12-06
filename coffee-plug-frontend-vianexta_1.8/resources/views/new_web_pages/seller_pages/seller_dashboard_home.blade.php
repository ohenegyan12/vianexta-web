@extends('layouts.new_home_layout')
@section('title', 'Seller Dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">
<link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">
@endpush

@section('content')
<div class="wrapper">
    @include('includes.new_home.new_sidebar')
    <!-- Page Content  -->
    <div id="content">
        @include('includes.new_home.seller_nav')


        <div class="row gx-2 gx-lg-3 gy-5 gy-lg-0 mt-3 row-gap-3">
            <h3 class="mb-5" style="color: #07382F">{{session('auth_user_type')}}'s Dashboard</h3>
            <div class="col-sm-12 col-md-6">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded">
                    <div class="row g-0">
                        <div class="col-md-4 pt-lg-3 text-center">
                            <img src="{{ asset('images/seller/dash_two.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">Pending Orders</p>
                                <h5 class="card-title">{{isset($dashboard_data->pendingOrders) ? $dashboard_data->pendingOrders: "0"}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded">
                    <div class="row g-0">
                        <div class="col-md-4 pt-lg-3 text-center">
                            <img src="{{ asset('images/seller/dash_one.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">Total Number of Orders</p>
                                <h5 class="card-title">{{isset($dashboard_data->totalOrders) ? $dashboard_data->totalOrders: "0"}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" col-sm-12 col-md-6">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded">
                    <div class="row g-0">
                        <div class="col-md-4 pt-lg-3 text-center">
                            <img src="{{ asset('images/seller/dash_three.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">Total Sales</p>
                                <h5 class="card-title">${{isset($dashboard_data->totalSales) ? $helper->formatMoney($dashboard_data->totalSales): "0"}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded">
                    <div class="row g-0">
                        <div class="col-md-4 pt-lg-3 text-center">
                            <img src="{{ asset('images/seller/dash_four.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text" style="color:#999">{{$helper->isweekend() ? "Last Friday's " : "Today's"}} Coffee Prices (As at: {{$helper->formatDateToTimeOnly($prices->arabica->dateTime)}})</p>
                                <h6 class="card-title">Arabica: {{$prices->arabica->currency}} {{$prices->arabica->price}} ({{$prices->arabica->unit}})</h6>
                                <h6 class="card-title">Robusta: {{$prices->robusta->currency}} {{$prices->robusta->price}} ({{$prices->arabica->unit}})</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 pt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3 shadow p-3 bg-body-tertiary rounded">
                            <div class="card-body overflow-x-auto">
                                <div id="purchaseChartdiv" style="min-width:700px; width: 100%; height:500px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </div>
</div>
@include('new_web_pages.seller_pages.order_details_modal')
@endsection
@section('scripts')
<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });

    });
</script>
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
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>
@include('dashboard.purchase_chart')

<!-- Clare Chat Component -->
<script src="{{ asset('js/clare-component.js') }}"></script>
@endsection