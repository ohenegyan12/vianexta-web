@extends('layouts.new_home_layout')
@section('title', 'Buyer Marketplace')
@push('css')
<!-- <link rel="stylesheet" href="{{ asset('css/market_sidebar_style.css') }}"> -->
<link rel="stylesheet" href="{{ asset('css/wizard_card_css.css') }}">
<style>
    .truncate-text {
        /* Limit the width of the text */


        display: -webkit-box;
        /* Creates a flexible box model */
        -webkit-box-orient: vertical;
        /* Sets box orientation to vertical */
        -webkit-line-clamp: 2;
        /* Limits the content to 2 lines */
        overflow: hidden;
        /* Hides overflowed text */
        text-overflow: ellipsis;
        /* Adds ellipsis (...) for truncated text */
        line-height: 1.5;
        /* Adjust line height if needed */
        max-height: 3em;

        .brand-slider .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .brand-slider .card:hover {
            transform: scale(1.05);
        }

        .brand-slider .card-body {
            padding: 10px;
        }
    }
</style>
@endpush

@section('content')
@include('includes.new_home.new_home_header')

<div class="wrapper">

    {{-- HERO SECTION --}}
    <section class="py-2">
        <div class="container px-2 px-lg-3 my-3">
            <div class="row gx-4 gx-lg-5 my-lg-5 align-items-start">
                <div class="col-md-12">
                    <div id="marketplaceCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <!-- <div class="carousel-item active">
                                <img class="d-block w-100 img-fluid"
                                    src="{{ asset('images/market_place/winwin_banner.jpg') }}"
                                    alt="Market Banner">
                            </div> -->
                            <div class="carousel-item active">
                                <img class="d-block w-100 img-fluid"
                                    src="{{ asset('images/market_place/greenstreet_banner.jpg') }}"
                                    alt="Greenstreet Banner">
                            </div>

                        </div>
                        <a class="carousel-control-prev" href="#marketplaceCarousel" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#marketplaceCarousel" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12">
                        <div class="brand-slider">
                            <div class="row">
                                @foreach ($brands as $brand)
                                <div class="col-6 col-md-3 col-lg-2 mb-3">
                                    <a href="{{ route('buyerBrandMarketplace', $helper->encode($brand->id)) }}" class="brand-card">
                                        <div class="card">
                                            <img class="card-img-top img-fluid"
                                                src="{{ $brand->imageUrl ? asset($brand->imageUrl) : asset('images/market_place/product_pattern.jpg') }}"
                                                alt="{{ $brand->businessName}}"
                                                style="max-width:100%; height:100px; object-fit:contain;">
                                            <div class="card-body text-center">
                                                <h6 class="card-title mb-0">{{ $brand->businessName }}</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>


                @if(empty($data))
                <div class="col-sm-12 col-md-12">
                    <div class="h-100 d-flex align-items-center justify-content-center">
                        <img class=" img-fluid" style="max-width:20%" src="{{ asset('images/market_place/no_product.png') }}" />
                    </div>
                    <h1 class="fs-4 fw-bolder d-flex align-items-center justify-content-center" style="margin-top:10px;color:#B2BEB5">No product found</h1>
                </div>
                @else

                @foreach ($data as $datum)
                <div class="col-md-6 col-lg-4 col-xxl-3 mb-4 mb-md-5 ">

                    <div class="hover01">
                        <figure>
                            <div class="card hover-1">
                                <a href="{{ route('get_product',$helper->encode($datum->id)) }}">
                                    <div class="img-container">
                                        <img class="card-img-top img-fluid" src="{{ $datum->imageUrl !=null ? urldecode($datum->imageUrl) : asset('images/market_place/market_coffee.svg') }}" style="max-width:100%;height:290px;object-fit: cover; " alt="product image">
                                        <!-- <img class="card-img-top img-fluid" src="{{ asset('images/market_place/product_pattern.jpg') }}" style="max-width:100%;height:290px;object-fit: cover; " alt="product image"> -->
                                    </div>
                                </a>
                                <div class="card-container" style="max-width: 150px; margin: auto;">
                                    <div class="card-custom d-flex" style="flex-direction: column; align-items: center; ">
                                        <div class="info-section" style="text-align: center;">
                                            <div class="truncate-text" style="font-size: 14px;">
                                                {{$datum->supplierInfo->firstName =='Win' || $datum->productType == 'whole_sale_brand'? strtoupper($datum->description) :(isset($datum->name)? $datum->name: ($datum->description != null? $datum->description:'Product Name'))}}
                                            </div>

                                            <div style="margin-top: 10px;">
                                                <span class="tags" style="font-size: 16px; font-weight: bold; background-color: var(--bs-primary); color: #fff; padding: 5px 10px; border-radius: 5px;">${{ number_format($datum->bagPrice, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </figure>
                    </div>

                </div>
                @endforeach
                @endif

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <!-- <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li> -->
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </section>
</div>
@include('new_web_pages.seller_pages.seller_confirm_modal')
@endsection
<script>
    window.addEventListener('scroll', function() {
        var header = document.getElementById('app_header');
        if (window.scrollY > 0) {
            header.style.backgroundColor = '#FFFF';

        } else {
            header.style.backgroundColor = '#FFFF';
        }
    });
</script>