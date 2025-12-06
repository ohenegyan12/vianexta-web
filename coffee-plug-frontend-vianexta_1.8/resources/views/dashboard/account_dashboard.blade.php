@extends('layouts.dashboard_layout ')

@section('content')
    <div class="container-xxl mt-4">
        <h1 class="mb-5" style="color: #07382F">Account Dashboard</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card border border-2" style="border-color: #07382F !important">
                    <div class="">
                        <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                            <h4 class="text-center">Total number of purchases</h4>
                        </div>
                        <div class="p-3">
                            <h5 class="text-center"><span>{{$total_order_details->totalPurchases->quantity}} bags</span> Quantity</h5>
                            <h5 class="text-center"><span>USD ${{$total_order_details->totalPurchases->totalPrice}}</span> Amount</h5>
                            <a href= "{{ route('purchases',$helper->encryptData('total_purchase')) }}" class="btn btn-seconday w-100 mt-2" style="background-color: #07382F;color: #fff">View
                                details</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border border-2" style="border-color: #07382F !important">
                    <div class="">
                        <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                            <h4 class="text-center">Total pending orders</h4>
                        </div>
                        <div class="p-3">
                            <h5 class="text-center"><span>{{$total_order_details->pendingOrders->quantity}} bags</span> Quantity</h5>
                            <h5 class="text-center"><span>USD ${{$total_order_details->pendingOrders->totalPrice}}</span> Amount</h5>
                            <a href="{{ route('purchases',$helper->encryptData('pending_orders')) }}" class="btn btn-seconday w-100 mt-2" style="background-color: #07382F; color: #fff">View
                                details</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border border-2" style="border-color: #07382F !important">
                    <div class="">
                        <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                            <h4 class="text-center">Total of completed orders</h4>
                        </div>
                        <div class="p-3">
                            <h5 class="text-center"><span>{{$total_order_details->completedOrders->quantity}} bags</span> Quantity</h5>
                            <h5 class="text-center"><span>USD ${{$total_order_details->completedOrders->totalPrice}}</span> Amount</h5>
                            <a href="{{ route('purchases',$helper->encryptData('completed_orders')) }}" class="btn btn-seconday w-100 mt-2" style="background-color: #07382F;color: #fff">View
                                details</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border border-2" style="border-color: #07382F !important">
                    <div class="">
                        <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                            <h4 class="text-center">Last order made</h4>
                        </div>
                        <div class="p-3">
                            <h5 class="text-center"><span>19/09/2023</span> Date</h5>
                            <h5 class="text-center"><span>7</span> No. of bags</h5>
                            <h5 class="text-center"><span>USD $5,000</span> Amount</h5>
                        </div>
                    </div>
                </div>
                <div class="card border border-2" style="border-color: #07382F !important">
                    <div class="">
                        <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                            <h4 class="text-center">Arabica Price Today</h4>
                        </div>
                        <div class="p-3">
                            <h5 class="text-center"><span style="color: #07382F; font-size: 20px">{{$prices->arabica->currency}} {{$prices->arabica->price}}</span> ({{$prices->arabica->unit}})</h5>
                            <h5 class="text-center"><span style="color: #07382F; font-size: 20px">{{$prices->arabica->dateTime}}</span> Date</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border border-2" style="border-color: #07382F !important">
                    <div class="">
                        <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                            <h4 class="text-center">List of most often bought coffee types</h4>
                        </div>
                        <div class="p-3">
                            <div class="card-body table-border-style">
                                <div class="table-responsive table-striped">
                                    <table class="table" id="dt_trans">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($total_order_details->mostFrequentOrders as $order)
                                            @php $count=1; @endphp
                                            <tr>
                                                <td>{{$count}}</td>
                                                <td>{{$order->coffeeType}}</td>
                                                <td>{{$order->quantity}}</td>
                                                <td><span>USD ${{number_format($order->totalPrice,2)}}</span></td>
                                                <td><a href="{{ route('productPurchasesHistory',$helper->encode($order->stockPostingId)) }}" class="btn btn-seconday w-50 mt-2" style="background-color: #07382F; color: #fff">view</a></td>
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
            <div class="col-md-4">
                <div class="card border border-2" style="border-color: #07382F !important">
                    <div class="">
                        <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                            <h4 class="text-center">Robusta Price Today</h4>
                        </div>
                       <div class="p-3">
                           <h5 class="text-center"><span style="color: #07382F; font-size: 20px">{{$prices->robusta->currency}} {{$prices->robusta->price}}</span> ({{$prices->robusta->unit}})</h5>
                           <h5 class="text-center"><span style="color: #07382F; font-size: 20px">{{$prices->robusta->dateTime}}</span> Date</h5>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border border-2" style="border-color: #07382F !important">
                    <div class="">
                        <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                            <h4 class="text-center">Arabica Previous day's prices</h4>
                        </div>
                        <div class="p-3">
                           <h5 class="text-center"><span style="color: #07382F; font-size: 20px">{{$prices->arabica->currency}} {{$prices->arabica->closingPrice}}</span> ({{$prices->arabica->unit}})</h5>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border border-2" style="border-color: #07382F !important">
                    <div class="">
                        <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                            <h4 class="text-center">Robusta Previous day's prices</h4>
                        </div>
                        <div class="p-3">
                           <h5 class="text-center"><span style="color: #07382F; font-size: 20px">{{$prices->robusta->currency}} {{$prices->robusta->closingPrice}}</span> ({{$prices->robusta->unit}})</h5>
                       </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card border border-2" style="border-color: #07382F !important">
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
@endsection
@section('scripts')
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>
@include('dashboard.purchase_chart')
@endsection
