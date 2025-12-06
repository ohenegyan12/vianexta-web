@extends('layouts.new_home_layout')
@section('title', 'Seller Dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">
@endpush

@section('content')
<div class="wrapper">
@include('includes.new_home.new_sidebar')
<!-- Page Content  -->
    <div id="content">
         @include('includes.new_home.seller_nav')
    
        
        <div class="row gx-2 gx-lg-3 gy-5 gy-lg-0 mt-3 row-gap-3">
            <h3 class="mb-5" style="color: #07382F">Roast Orders</h3>

               <div class="col-12 pb-5">
                    <div class="col-md-12">
                       <div class="card mb-3 shadow p-3 bg-body-tertiary rounded" >
                            <div class="card-body overflow-x-auto">
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
                                            @foreach($supplier_orders as $order)
                                            <tr>
                                            <th scope="row">#{{$order->id}}</th>
                                            <td>{{$order->name}}</td>
                                            <td>{{$order->date}}</td>
                                            <td>${{$helper->formatMoney($order->amount)}}</td>
                                            <td>{{$order->state}}</td>
                                            <td>
                                                <a href="{{ route('sellersOrderDetails',$helper->encode($order->id)) }}" class="btn btn-secondary" ><span class="fa fa-eye"></span></a>
                                            </td>
                                            </tr>
                                        
                                          @endforeach
                                           
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
 @endsection