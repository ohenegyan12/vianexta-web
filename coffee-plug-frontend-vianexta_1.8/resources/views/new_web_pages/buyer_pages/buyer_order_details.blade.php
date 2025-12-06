@extends('layouts.dashboard_layout ')

@section('content')
    <div class="container-xxl mt-4">
        <h1 class="mb-5" style="color: #07382F"><a href="{{route('buyerOrderHistory')}}" class="btn btn-success" style="background-color: #07382F;color: #fff"><i class="fa fa-arrow-left"> Back </i></a> || {{$purchase_title}}</h1>
        <div class="row">

            <div class="col-md-12">
                <div class="card border border-2" style="border-color: #07382F !important">
                    <div class="">
                        <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                            <h4 class="text-center">{{$purchase_title}}</h4>
                        </div>
                         <div class="p-3">
                            <div class="card-body table-border-style">
                                <div class="table-responsive table-striped">
                                    <table class="table" id="dt_trans">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Product</th>
                                                <th>Number of Bags</th>
                                                <th>Total Weight</th>
                                                <th>Total Price</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @php $count=1; @endphp
                                        @foreach($transactions as $transaction)
                                          
                                                <tr>
                                                    <td>{{$count}}</td>
                                                    <td>
                                                        @php
                                                            $date = \Carbon\Carbon::parse($transaction->createdDate);
                                                            echo $date->format('M d, Y \a\t g:i A');
                                                        @endphp
                                                    </td>
                                                    <td>{{$transaction->productName}}</td>
                                                    <td>{{$transaction->numBags}} bags</td>
                                                    <td>{{$transaction->totalWeight}}</td>
                                                    <td>USD ${{number_format($transaction->totalPrice,2)}}</td>
                                                    @if($transaction->status=="Processing")
                                                        <td><span class="badge rounded-pill text-bg-warning"><span class="fa fa-circle text-c-red f-10 m-r-5" style="color:#07382F;"></span> {{$transaction->status}}</span></td>
                                                    @else
                                                        <td><span class="badge rounded-pill text-bg-success"><span class="fa fa-circle text-c-red f-10 m-r-5" style="color:#D8501C;"></span> {{$transaction->status}}</span></td>
                                                    @endif
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

        </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>
@endsection
