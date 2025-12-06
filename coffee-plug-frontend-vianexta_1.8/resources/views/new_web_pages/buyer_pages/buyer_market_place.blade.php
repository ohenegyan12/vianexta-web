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
    }
</style>
@endpush
@section('content')
@include('includes.new_home.buyer_new_header')

<div class="wrapper">

    {{-- HERO SECTION --}}
    <section class="py-2">
        <div class="container px-2 px-lg-3 my-3">
            <div class="row gx-4 gx-lg-5 my-lg-5 align-items-start">
                <div class="col-md-12">
                    <img class="card-img-top img-fluid"
                        src="{{ asset('images/market_place/market_banner.png') }}" style="max-width:100%;" alt="lady">
                </div>

                <div class="col-md-12">
                    <form action="{{ route('filterProduct') }}" method="POST">
                        @csrf
                        <div class="">
                            <div class="input-group mt-5 py-4">
                                <input type="text" class="form-control" style="background-color:#DADADA;" placeholder="what are you looking for?" aria-label="search" aria-describedby="search" required value="{{empty($product_filter) ? old('product_filter') : $product_filter}}" name="product_filter" id="product_filter">
                                <!-- <div class="form-group"> -->
                                @if(empty($product_filter))
                                <button class="btn btn-secondary" type="submit" id=""><span class="fa fa-search"></span></button>
                                @else
                                <a href="{{route('buyer_market_place')}}" class="btn btn-secondary" type="reset" id=""><span class="fa fa-times"></span></a>
                                @endif
                                <!-- </div> -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-12  mb-md-3">
                    <form action="{{ route('filterMultiProduct') }}" method="POST">
                        @csrf
                        <div class="row ">
                            <div class="col-md-3">
                                <label for="country" class="form-label">Origin Country</label>
                                <select class="form-control form-select multi-select" multiple name='country' aria-label="Default select example">
                                    @if(isset($stock_params->countryOptions))
                                    @foreach($stock_params->countryOptions as $country)
                                    <option value="{{$country}}" {{(isset($filter_params['originCountry']) && $filter_params['originCountry']=="$country") ? 'selected' : ""  }}>{{$country}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="species" class="form-label">Species</label>
                                <select class="form-select multi-select" multiple name="species" aria-label="Default select example">
                                    <option value="">Type</option>
                                    <option value="Arabica" {{(isset($filter_params['species']) && $filter_params['species']=="Arabica") ? 'selected' : ""  }}>Arabica</option>
                                    <option value="Robusta" {{(isset($filter_params['species']) && $filter_params['species']=="Robusta") ? 'selected' : ""  }}>Robusta</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="variety" class="form-label">Variety</label>
                                <select class="form-select multi-select" multiple name="variety" aria-label="Default select example" style="background-color:#DADADA;">
                                    <option value="">Variety</option>
                                    @if(isset($stock_params->varietyOptions))
                                    @foreach($stock_params->varietyOptions as $variety)
                                    <option value="{{$variety}}" {{(isset($filter_params['variety']) && $filter_params['variety']=="$variety") ? 'selected' : ""  }}>{{$variety}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="coffeeType" class="form-label">Specialty/Commercial</label>
                                <select class="form-select multi-select" multiple name="coffeeType" aria-label="Default select example">
                                    <option value="">Specialty/Commercial</option>
                                    <option value="Commercial" {{(isset($filter_params['coffeeType']) && $filter_params['coffeeType']=="Commercial") ? 'selected' : ""  }}>Commercial</option>
                                    <option value="Specialty" {{(isset($filter_params['coffeeType']) && $filter_params['coffeeType']=="Specialty") ? 'selected' : ""  }}>Specialty</option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <label for="process" class="form-label">Process</label>
                                <select class="form-select multi-select" multiple name="process" aria-label="Default select example" style="background-color:#DADADA;">
                                    <option value="">Process</option>
                                    @if(isset($stock_params->processOptions))
                                    @foreach($stock_params->processOptions as $process)
                                    <option value="{{$process}}" {{(isset($filter_params['process']) && $filter_params['process']=="$process") ? 'selected' : ""  }}>{{$process}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <label for="quality" class="form-label">SCA Quality Score</label>
                                <select class="form-select multi-select" multiple name="quality" aria-label="Default select example" style="background-color:#DADADA;">
                                    <option value="">SCA Quality Score</option>
                                    <option value="90-100" {{(isset($filter_params['quality']) && $filter_params['quality']=="90-100") ? 'selected' : ""  }}>90-100</option>
                                    <option value="85-89" {{(isset($filter_params['quality']) && $filter_params['quality']=="85-89") ? 'selected' : ""  }}>85-89</option>
                                    <option value="80-84" {{(isset($filter_params['quality']) && $filter_params['quality']=="80-84") ? 'selected' : ""  }}>80-84</option>
                                    <option value="0" {{(isset($filter_params['quality']) && $filter_params['quality']=="0") ? 'selected' : ""  }}>
                                        < 80</option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <label for="certification" class="form-label">Certification </label>
                                <select class="form-select multi-select" multiple name="certification" aria-label="Default select example" style="background-color:#DADADA;">
                                    @if(isset($cirtifications))
                                    @foreach($cirtifications as $cirtification)
                                    <option value="{{$cirtification->name}}" {{(isset($filter_params['cirtification']) && $filter_params['cirtification']=="$cirtification->name") ? 'selected' : ""  }}>{{$cirtification->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-3 text-center mt-2">
                                <label for="certification" class="form-label">. </label>
                                <div class="text-center mt-2">
                                    @if(empty($filter_params) && empty($product_filter))
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    @else
                                    <a href="{{route('buyerGreenMarketPlace')}}" class="btn btn-primary">Reset</a>
                                    <button type="submit" class="btn btn-secondary">Filter</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- <div class="col-md-8 mb-md-5 pb-3">
                    <div class="card ">
                        <img class="card-img-top img-fluid"
                            src="{{ asset('images/market_place/sell.jpg') }}" style="max-width:100%;" alt="lady">
                    </div>
                </div> -->
                <!-- <div class="col-md-4 mb-md-5 pb-3">
                    <div class="card ">
                        <img class="card-img-top img-fluid"
                            src="{{ asset('images/market_place/learn.png') }}" style="max-width:100%; " alt="lady">
                        </h1>
                    </div>
                </div> -->
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
                                <div class="card-container">
                                    <div class="card-custom d-flex">
                                        <div class="info-section">
                                            <div class="truncate-text">
                                                {{$datum->supplierInfo->firstName =='Win'? strtoupper($datum->description) :(isset($datum->name)? $datum->name: ($datum->description != null? $datum->description:'Product Name'))}}
                                                <!-- <span class="text-secondary float-right" style="margin-left: 20px;">${{$datum->bagPrice}}</span> -->
                                            </div>
                                            <div class="d-flex align-items-center mb-2 tags w-50">
                                                @php
                                                if($datum->supplierInfo->firstName =='Win'){
                                                $countryFromDesc = explode(' ', $datum->description);
                                                // Handle multi-word country names like "Costa Rica", "United States", etc.
                                                $prodCountry = '';
                                                $words = $countryFromDesc;
                                                for($i = 0; $i < count($words); $i++){
                                                    $testCountry = implode(' ', array_slice($words, 0, $i + 1));
                                                    $testCode = $helper->getCountryCode($testCountry);
                                                    if($testCode != 'US' || $i == 0){
                                                        $prodCountry = $testCountry;
                                                        if($testCode != 'US'){
                                                            break;
                                                        }
                                                    }
                                                }
                                                }else{
                                                $prodCountry = $datum->supplierInfo->billingCountry;
                                                }

                                                $countImg = $helper->getCountryCode($prodCountry);
                                                $countImg = strtolower($countImg).".png";
                                                @endphp
                                                <img
                                                    src="https://flagcdn.com/w20/{{$countImg}}"
                                                    alt="Columbia"
                                                    class="country-flag" />
                                                <span>{{$prodCountry}}</span>
                                            </div>
                                            <div>
                                                <span class="tags">{{$datum->coffeeType != null? $datum->coffeeType:''}}</span>
                                                <!-- <span class="tags">{{$datum->aroma != null? $datum->aroma:''}}</span> -->
                                            </div>
                                        </div>
                                        <div class="grade-section">
                                            <h2 class="mb-0 font-weight-bold">{{(isset($datum->quality) && $datum->quality != null) ? $datum->quality:'0'}}</h2>
                                            <h4 class="mb-0 font-weight-bold">Score</h4>
                                        </div>
                                    </div>


                                    <!-- <div class="accordion bg-white opacity-75" id="accordionExample{{$datum->id}}">
                                                <div class="accordion-item">
                                                    <h1 class="accordion-header">
                                                    
                                                    <button class="accordion-button btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$datum->id}}" aria-expanded="true" aria-controls="collapseOne{{$datum->id}}">
                                                         {{$datum->supplierInfo->firstName =='Win'? strtoupper($datum->description) :(isset($datum->name)? $datum->name: ($datum->description != null? $datum->description:'Product Name'))}}<span class="text-secondary float-right" style="margin-left: 20px;">${{$datum->bagPrice}}</span>
                                                    </button>
                                                    </h1>
                                                    <div id="collapseOne{{$datum->id}}" class="accordion-collapse collapse " data-bs-parent="#accordionExample{{$datum->id}}">
                                                    <div class="accordion-body">
                                                        Type: {{$datum->coffeeType != null? $datum->coffeeType:''}}<br>
                                                        Farmer: {{$datum->supplierInfo->firstName != null? $datum->supplierInfo->firstName:'Vendor name not availbale'}}</br>
                                                        Notes: {{$datum->aroma != null? $datum->aroma:''}}<br>
                                                        @if(isset($datum->isSpecialty) && $datum->isSpecialty)
                                                          Score: {{(isset($datum->quality) && $datum->quality != null) ? $datum->quality:'0'}}
                                                        @endif
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>   -->
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