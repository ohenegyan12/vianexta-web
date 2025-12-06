@extends('layouts.new_home_layout')
@section('title', 'Buyer Dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">
<link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">
@endpush

@section('content')
<div class="wrapper">
@include('includes.new_home.buyer_sidebar')
<!-- Page Content  -->
    <div id="content">
        
        @include('includes.new_home.buyer_nav')
        
        <div class="row gx-2 gx-lg-3 gy-5 gy-lg-0 mt-3">
              <div class="container-xxl mt-4">
        <h1 class="mb-5" style="color: #07382F">{{session('auth_user_type')}}'s Dashboard</h1>
        <div class="row gx-2 gx-lg-3 gy-5 gy-lg-0 mt-3 row-gap-3">

             <div class="col-sm-12 col-md-4">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded" >
                    <div class="row g-0">
                        <div class="col-md-4 pt-lg-3 text-center">
                        <img src="{{ asset('images/seller/dash_two.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">Total number of purchases</p>
                                <h5 class="text-center"><span>Quantity:</span> {{$total_order_details->totalPurchases->quantity}} bags</h5>
                                <h5 class="text-center"><span>Amount:</span> USD {{$helper->formatMoney($total_order_details->totalPurchases->totalPrice)}}</h5>
                               
                            </div>
                        </div>
                         <a href= "{{ route('purchases',$helper->encryptData('total_purchase')) }}" class="btn btn-seconday w-100 mt-2" style="background-color: #07382F;color: #fff">View
                                    details</a>
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded" >
                    <div class="row g-0">
                        <div class="col-md-4 pt-lg-3 text-center">
                            <img src="{{ asset('images/seller/dash_one.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">Total pending orders</p>
                                <h5 class="text-center"><span>Quantity:</span> {{$total_order_details->pendingOrders->quantity}} bags</h5>
                                <h5 class="text-center"><span>Amount:</span> USD {{$helper->formatMoney($total_order_details->pendingOrders->totalPrice)}}</h5>
                            </div>
                        </div>
                        <a href="{{ route('purchases',$helper->encryptData('pending_orders')) }}" class="btn btn-seconday w-100 mt-2" style="background-color: #07382F; color: #fff">View
                                details</a>
                    </div>
                </div>
            </div>
            <div class=" col-sm-12 col-md-4">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded" >
                    <div class="row g-0">
                        <div class="col-md-4 pt-lg-3 text-center">
                            <img src="{{ asset('images/seller/dash_three.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">Total of completed orders</p>
                                <h5 class="text-center"><span>Quantity:</span> {{$total_order_details->completedOrders->quantity}} bags</h5>
                                <h5 class="text-center"><span>Amount:</span> USD {{$helper->formatMoney($total_order_details->completedOrders->totalPrice)}} </h5>
                                
                            </div>
                        </div>
                        <a href="{{ route('purchases',$helper->encryptData('completed_orders')) }}" class="btn btn-seconday w-100 mt-2" style="background-color: #07382F;color: #fff">View
                                details</a>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-12">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded">
                    <div class="">
                        <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                            <h4 class="text-center">List of most often bought coffee type</h4>
                        </div>
                        <div class="p-3">
                            <div class="card-body table-border-style">
                                <div class="table-responsive table-striped">
                                    <table class="table table-responsive" id="dt_trans">
                                        <thead>
                                            <tr class="d-flex">
                                                <th class="col-1">#</th>
                                                <th class="col-4">Name</th>
                                                <th class="col-2">Quantity</th>
                                                <th class="col-2">Amount</th>
                                                <th class="col-3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @php $count=1; @endphp
                                        @foreach($total_order_details->mostFrequentOrders as $order)
                                            <tr class="d-flex">
                                                <td class="col-1">{{$count}}</td>
                                                <td class="col-4">{{$order->productName}}</td>
                                                <td class="col-2">{{$order->quantity}}</td>
                                                <td class="col-2"><span>${{number_format($order->totalPrice,2)}}</span></td>
                                                <td class="col-3"><a href="{{ route('productPurchasesHistory',$helper->encode($order->stockPostingId)) }}" class="btn btn-seconday w-50 mt-2" style="background-color: #07382F; color: #fff">view</a></td>
                                            </tr>
                                            @php $count++; @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-3">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded" >
                    <div class="row g-0">
                        <div class="col-md-3 pt-lg-3 text-center">
                            <img src="{{ asset('images/seller/dash_four.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <p class="card-text" >Arabica Price {{$helper->isweekend() ? "Last Friday " : "Today"}} ({{$helper->formatDateToTimeOnly($prices->arabica->dateTime)}})</p>
                                <h6 class=""><span >{{$prices->arabica->currency}} {{$prices->arabica->price}}</span> ({{$prices->arabica->unit}})</h6>
                                <!-- <h6 class=""><span >Date: </span> {{$helper->formatDate($prices->arabica->dateTime)}}</h5> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

              <div class="col-sm-12 col-md-3">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded" >
                    <div class="row g-0">
                        <div class="col-md-3 pt-lg-3 text-center">
                            <img src="{{ asset('images/seller/dash_four.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                 <p class="card-text" >Robusta Price {{$helper->isweekend() ? "Last Friday " : "Today"}}  ({{$helper->formatDateToTimeOnly($prices->robusta->dateTime)}})</p>
                                <h6 class=""><span >{{$prices->robusta->currency}} {{$prices->robusta->price}}</span> ({{$prices->robusta->unit}})</h6>
                                <!-- <h6 class=""><span >Date: </span> {{$helper->formatDate($prices->robusta->dateTime)}}</h5> -->
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-3">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded" >
                    <div class="row g-0">
                        <div class="col-md-3 pt-lg-3 text-center">
                            <img src="{{ asset('images/seller/dash_four.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                 <p class="card-text" >Arabica Previous day's prices</p>
                                <h6 class=""><span >{{$prices->arabica->currency}} {{$prices->arabica->closingPrice}}</span> ({{$prices->arabica->unit}})</h5>                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-3">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded" >
                    <div class="row g-0">
                        <div class="col-md-3 pt-lg-3 text-center">
                            <img src="{{ asset('images/seller/dash_four.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                 <p class="card-text" >Robusta Previous day's prices</p>
                                <h6 class=""><span >{{$prices->robusta->currency}} {{$prices->robusta->closingPrice}}</span> ({{$prices->robusta->unit}})</h5>                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded" style="border-color: #07382F !important">
                    <div class="">
                        <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                            <h4 class="text-center">Analytics of monthly orders</h4>
                        </div>
                        <div class="p-3">
                           <div id="purchaseChartdiv" style=" width: 100%; height: 500px;"></div>
                        </div>
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
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>
@include('dashboard.buyer_purchase_chart')

<!-- Clare Chat Component -->
<script src="{{ asset('js/clare-component.js') }}"></script>
@endsection