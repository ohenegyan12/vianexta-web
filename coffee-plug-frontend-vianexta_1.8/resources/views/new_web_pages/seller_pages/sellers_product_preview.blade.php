@extends('layouts.new_home_layout')
@section('title', 'Add Product')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
@endpush

@section('content')
@include('includes.new_home.seller_landing_header')

    {{-- HERO SECTION --}}
    <section class="py-5" >
        <div class="container px-2 px-lg-3 my-3 pt-5">
            <div class="row">
                 <h1 class="fs-4 fw-bolder text-primary">Preview</h1>
                <hr>
                <div class="col-md-6">
                   <img class="card-img-top pt-3 img-fluid"
                        src="{{ asset('images/seller/coffee_bean1.svg') }}" style="height:600px;" alt="lady">  
                </div>
                <div class="col-md-6 pt-3">
                     <h1 class=" fs-4 fw-bolder text-primary">Arabica</h1>
                     <p class="text-primary fs-5 pl-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                     <div class="row py-5">
                        <div class="col-md-6">
                             <p class="text-primary fs-5 pl-10"><b>Quantity: </b> <span class="text-secondary fw-bolder"> 60kg bag</span></p>
                             <p class="text-primary fs-5 pl-10"><b>Price: </b> <span class="text-secondary fw-bolder"> $2,500</span></p>
                             <p class="text-primary fs-5 pl-10"><b>Washed: </b> <span class="text-secondary fw-bolder"> Yes</span></p>
                             <p class="text-primary fs-5 pl-10"><b>Grade: </b> <span class="text-secondary fw-bolder"> 84.0</span></p>
                        </div>
                        <div class="col-md-6">
                             <p class="text-primary fs-5 pl-10"><b>Harvest: </b> <span class="text-secondary fw-bolder"> Apr-Jun</span></p>
                             <p class="text-primary fs-5 pl-10"><b>Variety: </b> <span class="text-secondary fw-bolder"> Columbia</span></p>
                             <p class="text-primary fs-5 pl-10"><b>Fermentation: </b> <span class="text-secondary fw-bolder"> Dry,36hours</span></p>
                        </div>
                     </div>
                     <hr>
                    <div class="photo-gallery">
                        <div class="container">
                            <div class="row photos">
                                <div class="col-6 col-md-3 item d-flex justify-content-center"><a href="{{ asset('images/seller/coffee_bean2.svg') }}" data-lightbox="photos"><img class="img-fluid" src="{{ asset('images/seller/coffee_bean2.svg') }}"></a></div>
                                <div class="col-6 col-md-3 item d-flex justify-content-center"><a href="{{ asset('images/seller/coffee_bean2.svg') }}" data-lightbox="photos"><img class="img-fluid" src="{{ asset('images/seller/coffee_bean2.svg') }}"></a></div>
                                <div class="col-6 col-md-3 item d-flex justify-content-center"><a href="{{ asset('images/seller/coffee_bean2.svg') }}" data-lightbox="photos"><img class="img-fluid" src="{{ asset('images/seller/coffee_bean2.svg') }}"></a></div>
                                <div class="col-6 col-md-3 item d-flex justify-content-center"><a href="{{ asset('images/seller/coffee_bean2.svg') }}" data-lightbox="photos"><img class="img-fluid" src="{{ asset('images/seller/coffee_bean2.svg') }}"></a></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 text-center text-md-start py-2 py-md-5">
                    <button type="submit" class="btn btn-outline-dark py-2 px-3" > <span class="fa fa-chevron-left px-3"></span>   Back to Edit</button>
                </div>
                <div class="col-md-6 text-center text-md-end py-2 py-md-5">
                    <button type="submit"  data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-primary py-2 px-3" >Add to Marketplace      <span class="fa fa-chevron-right px-3"></span></button>
                </div>
            </div>
        </div>
    </section>
  @include('new_web_pages.seller_pages.seller_product_confirm_modal')
@endsection
@section('scripts')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
 @endsection