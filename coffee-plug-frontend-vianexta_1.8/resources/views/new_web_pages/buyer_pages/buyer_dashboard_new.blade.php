@extends('layouts.new_home_layout')
@section('title', 'Buyer Dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">
@endpush

@section('content')
<div class="wrapper">
@include('includes.new_home.buyer_sidebar')
<!-- Page Content  -->
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-secondary">
                    <i class="fa fa-align-left"></i>
                    
                </button>
                <h1 class="display-6 fw-bolder text-primary">Hi Matt,</h1>
                <img class="card-img-top img-fluid rounded"
                        src="{{ asset('images/seller/male_farmer.jpg') }}" style="height:40px; width:40px"  alt="farmer">
            </div>
        </nav>
    
        
        <div class="row gx-2 gx-lg-3 gy-5 gy-lg-0 mt-3 row-gap-3">
            <div class="col-sm-12 col-md-6">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded" >
                    <div class="row g-0">
                        <div class="col-md-4 pt-lg-3 text-center">
                        <img src="{{ asset('images/seller/dash_two.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">Pending Orders</p>
                                <h5 class="card-title">305</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            
            <div class="col-sm-12 col-md-6">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded" >
                    <div class="row g-0">
                        <div class="col-md-4 pt-lg-3 text-center">
                        <img src="{{ asset('images/seller/dash_one.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                        <div class="card-body">
                            <p class="card-text">Total Number of Orders</p>
                            <h5 class="card-title">1,205</h5>
                        </div>
                        </div>
                    </div>
                </div>
            </div> 

            <div class=" col-sm-12 col-md-6">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded" >
                    <div class="row g-0">
                        <div class="col-md-4 pt-lg-3 text-center">
                        <img src="{{ asset('images/seller/dash_three.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                        <div class="card-body">
                            <p class="card-text">Total Sales</p>
                            <h5 class="card-title">$42,405</h5>
                        </div>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="col-sm-12 col-md-6">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded" >
                    <div class="row g-0">
                        <div class="col-md-4 pt-lg-3 text-center">
                            <img src="{{ asset('images/seller/dash_four.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text" style="color:#999">Today Coffee Prices</p>
                                <h6 class="card-title">Arabica: $20 per bag</h6>
                                <h6 class="card-title">Robusta: $25 per bag</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 pt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3 shadow p-3 bg-body-tertiary rounded" >
                            <div class="card-body overflow-x-auto">
                                <div id="purchaseChartdiv" style="min-width:700px; width: 100%; height:500px;"></div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>

            <div class="col-12 pb-5">
                <div class="col-md-12">
                   <div class="card mb-3 shadow p-3 bg-body-tertiary rounded" >
                        <div class="card-body overflow-x-auto">
                            <form class="row row-cols-lg-auto g-3 align-items-center">
                                 <div class="col-12">
                                    <label class="visually-hidden" for="inlineFormSelectPref">Day</label>
                                    <select class="form-select" id="inlineFormSelectPref">
                                    <option selected>Day</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="visually-hidden" for="inlineFormSelectPref">Month</label>
                                    <select class="form-select" id="inlineFormSelectPref">
                                    <option selected>Month</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="visually-hidden" for="inlineFormSelectPref">Year</label>
                                    <select class="form-select" id="inlineFormSelectPref">
                                    <option selected>Year</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    </select>
                                </div>


                                <div class="col-12">
                                    <button type="submit" class="btn btn-dark">Filter</button>
                                </div>
                            </form>

                            <div class="table-responsive overflow-x-hidden py-5 w-100" style="min-width: 700px;">
                                <table class="table table-striped table-striped table-hover" id="dt_trans">
                                    <thead>
                                        <tr>
                                        <th scope="col">Order No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">State</th>
                                        <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <th scope="row">00101</th>
                                        <td>Mattew</td>
                                        <td>11/02/2023</td>
                                        <td>$4000</td>
                                        <td>Processing</td>
                                        <td><a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#order_details"><span class="fa fa-eye"></span></a></td>
                                        </tr>
                                        <tr>
                                        <th scope="row">00101</th>
                                        <td>Henry</td>
                                        <td>11/02/2023</td>
                                        <td>$4000</td>
                                        <td>Processing</td>
                                        <td><a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#order_details"><span class="fa fa-eye"></span></a></td>
                                        </tr>
                                        <tr>
                                        <th scope="row">00101</th>
                                        <td>Nikisha</td>
                                        <td>11/02/2023</td>
                                        <td>$4000</td>
                                        <td>Processing</td>
                                        <td><a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#order_details"><span class="fa fa-eye"></span></a></td>
                                        </tr>
                                        <tr>
                                        <th scope="row">00101</th>
                                        <td>Chuyan</td>
                                        <td>11/02/2023</td>
                                        <td>$4000</td>
                                        <td>Processing</td>
                                        <td><a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#order_details"><span class="fa fa-eye"></span></a></td>
                                        </tr>
                                    </tbody>
                                </table>
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
    $(document).ready(function () {

        $('#sidebarCollapse').on('click', function () {
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
 @endsection