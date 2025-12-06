@extends('layouts.new_home_layout')
@section('title', 'Wishlist Dashboard')
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
                <h1 class="display-6 fw-bolder" style="color: #07382F;">Hi {{session('auth_user_name')}}!</h1>
                <img class="card-img-top img-fluid rounded"
                    src="{{ asset('images/seller/male_farmer.jpg') }}" style="height:40px; width:40px" alt="farmer">
            </div>
        </nav>


        <div class="row gx-2 gx-lg-3 gy-5 gy-lg-0 mt-3">

            <h1 class="col-sm-12 col-md-12 fs-2 fw-bolder" style="margin-top:30px;color:#656565;">Cart</h1>
            @if(empty($cart_items))
            <div class="col-sm-12 col-md-12" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                <div class="h-100 d-flex align-items-center justify-content-center">
                    <img class=" img-fluid" style="max-width:20%" src="{{ asset('images/buyer/noitems.jpg') }}" />
                </div>
                <h1 class="fs-4 fw-bolder d-flex align-items-center justify-content-center" style="margin-top:10px;color:#B2BEB5">No items added to cart yet</h1>
            </div>
            @else
            @foreach($cart_items as $cart_item)
            <div class="col-md-6 col-xl-4 py-3">
                <div class="card">
                    <img class="img-fluid card-img-top" src="{{ $cart_item->stockPosting->imageUrl !=null ? urldecode($cart_item->stockPosting->imageUrl) : asset('images/market_place/prod_sub.png') }}" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text"></p>
                        <div class="fw-bold fs-4" style="text-transform:uppercase">{{$cart_item->stockPosting->description}}</div>
                        <h5 class="fw-medium fs-5" style="color: #656565">Vendor: {{$cart_item->stockPosting->supplierInfo->firstName}}</h5>
                        <h5 class="fw-medium fs-5" style="color: #656565">Quantity: {{ $cart_item->numBags }} Bags</h5>
                        <h5 class="fw-medium fs-5" style="color: #D8501C">$ {{$cart_item->stockPosting->bagPrice * $cart_item->numBags * $cart_item->stockPosting->bagWeight}}</h5>
                        @php
                        $product_data = array('stockPostingId'=>$cart_item->stockPosting->id,'numBags'=>$cart_item->numBags);
                        $product_data = $helper->encryptData(json_encode($product_data));
                        @endphp
                        <div class="row pt-5">
                            <a href="{{ route('editOrder',$product_data) }}" class="btn btn-primary btn-small col">Order now</a>
                            <a href="{{ route('deleteOrder',$helper->encode($cart_item->stockPosting->id))}}" class="text-end col align-self-center" style="color:#D8501C;text-decoration:underline">Remove</a>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
            @endif

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
    $(document).ready(function() {

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });

    });
</script>
@endsection