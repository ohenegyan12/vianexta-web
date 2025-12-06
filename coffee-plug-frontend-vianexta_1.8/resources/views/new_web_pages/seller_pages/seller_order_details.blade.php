@extends('layouts.dashboard_layout ')
@push('css')
<style>
    .main-preview {
        background-color: #f8f9fa;
        padding: 2rem;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
    }

    .design-overlay-12oz_frac_pack {
        position: absolute;
        /* max-width: 100px;*/
        cursor: move;
        user-select: none;
        /* Position and size for the design area - adjust these values as needed */
        left: 40%;
        top: 60%;
        transform: translate(-50%, -50%);
        width: 20%;
        /* Width of the design area */
        height: 30%;
        /* Height of the design area */
        /* overflow: hidden; */
    }

    .design-overlay-10oz_bag {
        position: absolute;
        /* max-width: 100px;*/
        cursor: move;
        user-select: none;
        /* Position and size for the design area - adjust these values as needed */
        left: 40%;
        top: 64%;
        transform: translate(-50%, -50%);
        width: 20%;
        /* Width of the design area */
        height: 30%;
        /* Height of the design area */
        /* overflow: hidden; */
    }

    .design-overlay-k_cup {
        position: absolute;
        /* max-width: 100px;*/
        cursor: move;
        user-select: none;

        /* Position the oval overlay */
        right: 34%;
        top: 35%;
        transform: translateY(-50%);
        /* Create oval shape */
        width: 32%;
        height: 37%;
        border-radius: 50%;

        /* overflow: hidden; */
    }

    .design-overlay-5lb_bag {
        position: absolute;
        /* max-width: 100px;*/
        cursor: move;
        user-select: none;
        /* Position and size for the design area - adjust these values as needed */
        left: 42%;
        top: 55%;
        transform: translate(-50%, -50%);
        width: 18%;
        /* Width of the design area */
        height: 25%;
        /* Height of the design area */
        /* overflow: hidden; */
        /* Optional - adds a subtle border to see the design area */
        /* border: 1px dashed rgba(0, 0, 0, 0.1); */
    }

    .design-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        /* Makes the image cover the entire area */
        object-position: center;
        /* Centers the image */
        transform: scale(1.02);
    }
</style>

@endpush
@section('content')
<div class="container-xxl mt-4">
    <h1 class="mb-5" style="color: #07382F"><a href="{{route('sellersDashboardHome')}}" class="btn btn-success" style="background-color: #07382F;color: #fff"><i class="fa fa-arrow-left"> Back </i></a> || #ORDER:{{ $order_id}}</h1>
    <div class="row">

        <div class="col-md-12">
            <div class="card border border-2" style="border-color: #07382F !important">
                <div class="">
                    <div class="p-3 border-bottom border-2" style="border-color: #07382F !important">
                        <h4 class="text-center">{{$order_id}}</h4>
                    </div>
                    <div class="p-3">
                        <div class="card-body table-border-style">
                            <div class="table-responsive table-striped">
                                <table class="table" id="dt_trans">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Coffee Type</th>
                                            <!-- put a condition to check if profile is a roaster  -->
                                            <th>Roast Type</th>
                                            <th>Grind Type</th>
                                            <th>Package Size</th>
                                            <th>Package Logo</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order_details as $order_detail)
                                        @php $count=1; @endphp
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{$order_detail->product}}</td>
                                            <td>{{$order_detail->size}} KG</td>
                                            <td>{{$order_detail->quantity}} bags</td>
                                            <td>${{number_format($order_detail->price,2)}}</td>

                                            <td>{{$order_detail->isRoast?'Roast':'Green'}}</td>
                                            <td>{{$order_detail->roastType}}</td>
                                            <td>{{$order_detail->grindType}}</td>
                                            <td>{{$order_detail->isRoast? ($helper->getBagDetails($order_detail->bagSize)['title']):''}}</td>
                                            <td>
                                                <a data-bs-toggle="modal" data-bs-target="#show_product{{$order_detail->stockPostingId}}" class="btn">
                                                    <!-- <span class="fa fa-eye"></span> -->
                                                    <img src="{{ $order_detail->bagImage !=null ? urldecode($order_detail->bagImage) : asset('images/market_place/coffee_logo.jpg') }}" class="img-fluid img-thumbnail" alt="Sheep">
                                                </a>
                                            </td>
                                            <!-- <td><img src="{{ asset('images/market_place/coffee_logo.jpg') }}" class="img-fluid img-thumbnail" alt="Sheep"> </td> -->
                                            <td>
                                                @if($order_detail->isRoast && session('auth_user_type') =='Admin')
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assign_roaster_{{$order_detail->lotOrderId}}"><span class="fa fa-plus-circle"></span>Asign roaster</button>
                                                @endif
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assign_print_{{$order_detail->lotOrderId}}"><span class="fa fa-print"></span>Logo print</button>

                                            </td>
                                        </tr>
                                        @if($order_detail->isRoast && session('auth_user_type') =='Admin')
                                        @include('new_web_pages.admin_pages.asign_roaster_modal')
                                        @endif
                                        @include('new_web_pages.admin_pages.asign_print_modal')
                                        @include('new_web_pages.seller_pages.show_product_modal')
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

@endsection