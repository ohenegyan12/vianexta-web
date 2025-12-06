@extends('layouts.new_home_layout')
@section('title', 'Home')

@push('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/css/flag-icon.min.css" />
<link rel="stylesheet" href="{{ asset('css/wizard_card_css.css') }}">
  <style>
        .truncate-text {
                        /* Limit the width of the text */
          
            
            display: -webkit-box;              /* Creates a flexible box model */
            -webkit-box-orient: vertical;      /* Sets box orientation to vertical */
            -webkit-line-clamp: 2;             /* Limits the content to 2 lines */
            overflow: hidden;                  /* Hides overflowed text */
            text-overflow: ellipsis;           /* Adds ellipsis (...) for truncated text */
            line-height: 1.5;                  /* Adjust line height if needed */
            max-height: 3em; 
        }
    </style>
 @endpush
@section('content')
@include('includes.new_home.buyer_landing_header')

    {{-- HERO SECTION --}}
    <section class="py-2 curve" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
        <div class="container px-2 px-lg-3 my-3">
            <div class="row gx-4 gx-lg-5 align-items-center  my-lg-5">
                <div class="col-md-6 mb-md-5"><img class="card-img-top pt-5 mb-5 mb-md-0 img-fluid"
                        src="{{ asset('images/buyer_hero.jpg') }}" alt="what we do">
                </div>
                <div class="col-md-6 mb-md-5 pt-md-5 pt-lg-0">
                    <h1 class="fs-0 fw-bolder text-white">Let us take care of
                        all your coffee needs</h1>
                    <p class="lead text-white fs-5 fw-medium mb-4">We build technology that fills gaps in the Experience seamless
                        global fulfillment: from sourcing to delivery,
                        ensuring top-tier products tailored to your needs.

                    </p>

                    <form action="{{ route('filterProduct') }}" method="POST">
                                @csrf
                        <div class="input-group">
                            <input type="text" class="form-control " placeholder="what are you looking for?"
                                aria-label="Search" aria-describedby="search-addon" required value="{{empty($product_filter) ? old('product_filter') : $product_filter}}" name="product_filter" id="product_filter" >
                            <button class="btn" style="background-color: #07382F" type="submit" id="search-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- EXLORE SECTION --}}
    <section class="py-5" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
        <div class="container px-2 px-lg-3 my-3">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="mx-auto w-75 mb-5">
                    <h1 class="fs-0 fw-bolder text-center text-primary px-lg-5">Top farmers from <span class="text-decoration-underline" style="text-decoration-color: #D8501C !important; color:#D8501C;">
                            across <br class="d-none d-lg-block"/> the globe</span> on ViaNexta
                    </h1>
                </div>
               
            </div>
            <div class="row gx-lg-3 gy-4 mt-3">
                @php $count = 0; @endphp
                @foreach($suppliers as $supplier)
                    @php 
                    $supplier_data = $helper->encryptData(json_encode($supplier));
                    if($count > 3) 
                       break;
                    @endphp
                    <div class="col-md-6 col-lg-3">
                    <form action="{{ route('farmerProfile') }}" method="POST" class="align-middle">
                         @csrf
                        <!-- <button type="submit" style="border:none;background: none;"> -->
                            <!-- <input name="supplier_data" value="{{$supplier_data}}" type="hidden"/> -->
                            <div class="hover01">
                                <figure>
                                    <div class="img-container">
                                        <img src="{{ $supplier->imageUrl !=null ? urldecode($supplier->imageUrl) :  $dummy_images[$count]}}" class="img-fluid" alt="Sample Image">
                                        <div class="card-container">
                                            <div class="card  bg-white opacity-75">
                                                <div class="card-body p-0">
                                                    <div class="row mx-0 px-0">
                                                        <div class="col-8 card-left p-3">
                                                            <h5 class="fw-bold">{{$supplier->firstName}}</h5>
                                                              @php
                                                                   
                                                                    $prodCountry = $supplier->billingCountry;

                                                                    $prodCountryCode = strtoupper($helper->getCountryCode($prodCountry));
                                                                    $countImg = strtolower($prodCountryCode).".png";
                                                                @endphp
                                                            <div class="">
                                                               
                                                                <span class="flag-icon flag-icon-{{$prodCountryCode}}" style="margin-right:10px;"></span>
                                                                {{$supplier->billingCountry}}
                                                            </div>
                                                        </div>
                                                        <div class="col-4 card-right p-3 rounded-md bg-primary">
                                                            <h5 class="text-white fw-bold">{{$supplier->foundedYear == null? "2022": $supplier->foundedYear}}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </figure>
                            </div>
                        <!-- </button> -->
                    </form>
                    </div>
                @php $count++; @endphp
                @endforeach

            </div>

            <div class="text-center mt-5">
                <a href="#" data-bs-toggle="modal" data-bs-target="#welcome" class="btn text-white" style="background-color: #07382F">
                    Explore
                    <span class="btn-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chevron-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </span>

                </a>
            </div>
        </div>
        </div>
        </div>
        </div>
    </section>

    {{-- WORLDWIDE SECTION --}}
    <section class="py-5" style="background-color: #EEEEEE" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
        <div class="container px-2 px-lg-3 my-3">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="mx-auto w-75 mb-5">
                    <h1 class="fs-0 fw-bolder text-center text-primary ">We ship coffee beans <span
                            class="text-secondary">
                            worldwide!</span>
                    </h1>
                </div>
            </div>
            <div class="row gx-lg-3 gy-4 mt-3">
                  @php $count_prod = 0; @endphp
               @foreach ($products as $datum)
                @php 
                if($count_prod > 11) 
                       break;
                    @endphp
                    <div class="col-md-6 col-lg-4 col-xxl-3 mb-4 mb-md-5 animate__animated animate__fadeInDown animate__delay-1s">
                       

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
                                                                class="country-flag"
                                                                />
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
                                        </div>
                                    </div>
                                </figure>
                            </div>
                       
                    </div>
                      @php $count_prod++; @endphp
                 @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{route('buyer_market_place')}}" class="btn text-white" style="background-color: #07382F">
                    explore our marketplace
                    <span class="btn-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chevron-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </span>

                </a>
            </div>
        </div>
        </div>
        </div>
        </div>
    </section>

    {{-- EXPERT SECTION --}}
    <section class="py-5" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
        <div class="container px-2 px-lg-3 ">
            <ul class="nav nav-pills nav-justified rounded-5 " style="background-color: #EEEEEE">
                <li class="nav-item tab">
                    <div class="nav-link tab-link d-flex align-items-center justify-content-center active rounded-5" style="height: 100%" aria-current="page">One-Stop
                        Shop</div>
                </li>
                <li class="nav-item tab">
                    <div class="nav-link tab-link d-flex align-items-center justify-content-center rounded-5" style="height: 100%">Top Quality Products</div>
                </li>
                <li class="nav-item tab">
                    <div class="nav-link tab-link d-flex align-items-center justify-content-center rounded-5" style="height: 100%">World-Wide Shipping</div>
                </li>

            </ul>
            
            <div class="content-parent mt-4">
                <div class="content content-active gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-7 mb-md-5 pt-3 pt-md-1">
                        <div class="fs-3">Our expert team handles all your sourcing needs,
                            streamlining operations and maximizing your
                            value for money.</div>
    
                    </div>
                    <div class="col-md-5 mb-md-5">
                        <img class="card-img-top mb-5 mb-md-0 img-fluid" src="{{ asset('images/group_36905.svg') }}"
                            alt="what we do">
                    </div>
                </div>
                <div class="content row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-7 mb-md-5 pt-3 pt-md-1">
                        <div class="fs-3">Bridging the gap between farmers and buyers, we ensure top-quality coffee products by fostering strong relationships, supporting sustainable practices, and delivering excellence from bean to cup.</div>
    
                    </div>
                    <div class="col-md-5 mb-md-5">
                        <img class="card-img-top mb-5 mb-md-0 img-fluid" src="{{ asset('images/rafiki.svg') }}"
                            alt="what we do">
                    </div>
                </div>
                <div class="content row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-7 mb-md-5 pt-3 pt-md-1">
                        <div class="fs-3">Fostering global connections for a seamless and sustainable coffee trading experience that benefits everyone involved.</div>
    
                    </div>
                    <div class="col-md-5 mb-md-5">
                        <img class="card-img-top mb-5 mb-md-0 img-fluid" src="{{ asset('images/bro.svg') }}"
                            alt="what we do">
                    </div>
                </div>
            </div>


        </div>
    </section>

    {{-- HELP SECTION --}}
    <section class="py-1 mb-5" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
        <div class="container px-2 px-lg-3 my-3">
            <div class="p-2 p-md-5"
                style="border-radius: 0.8125rem; background: #F0F0F0; box-shadow: 11px 13px 24px 4px rgba(0, 0, 0, 0.25); ">
                <h1 class="fs-0 fw-bolder text-center text-primary ">Lets help get you started
                </h1>
                <p class="fs-5 lead fw-normal text-center text-primary ">Buying your coffee beans has never been
                    easier.
                </p>
                <form action="{{ route('saveAccountDetails') }}" method="POST">
                 @csrf
                    <div class="row gx-md-5 gy-5 mb-4">
                        <div class="col-md-6 mb-3">
                            {{-- first name --}}
                            <input type="text" class="form-control bg-transparent"
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;" id="first_name"
                                value="{{old('first_name')}}" name="first_name" required placeholder="First Name">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- last name --}}
                            <input type="text" class="form-control bg-transparent"
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;" id="last_name"
                                 value="{{old('last_name')}}" name="last_name" required
                                placeholder="Last Name">
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-4 mb-3">
                            {{-- Country --}}
                            <select type="text" class=" form-control bg-transparent "
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;" id="country" name="country" required placeholder="Billing Country">
                                @foreach($countries as $country)
                                    <option value="{{$country->name}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-4 mb-3">
                            {{-- City --}}
                            <input type="text" class="form-control bg-transparent"
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;" id="city"
                                 value="{{old('city')}}" name="city" required
                                placeholder="Billing City">
                            @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-4 mb-3">
                            {{-- State --}}
                            <input type="text" class="form-control bg-transparent"
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;" id="state"
                                 value="{{old('state')}}" name="state" required
                                placeholder="Billing State">
                            @if ($errors->has('state'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- address_line1 --}}
                            <input type="text" class="form-control bg-transparent"
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;" id="address_line1"
                                value="{{old('address_line1')}}" name="address_line1" required placeholder="Billing Address Line 1">
                            @if ($errors->has('address_line1'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('address_line1') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- address_line2 --}}
                            <input type="text" class="form-control bg-transparent"
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;" id="address_line2"
                                 value="{{old('address_line2')}}" name="address_line2" required
                                placeholder="Billing Address Line 2">
                            @if ($errors->has('address_line2'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('address_line2') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- email --}}
                            <input type="text" class="form-control bg-transparent"
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;" id="email"
                                placeholder="Email" name="email" value="{{old('email')}}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- phone --}}
                            <input type="text" class="form-control bg-transparent"
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;"
                                    id="phone" name="phone_number" placeholder="Phone" value="{{old('phone_number')}}" required>
                            @if ($errors->has('phone_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- password --}}
                            <div class="input-group">
                                <input type="password" class="form-control bg-transparent"
                                    style="border: none; border-radius: 0; border-bottom: 2px solid #000;"
                                    placeholder="Password" name="password" aria-label="Password" aria-describedby="basic-addon1">
                            </div>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- confrim password --}}
                            <div class="input-group">
                                <input type="password" class="form-control bg-transparent"
                                    style="border: none; border-radius: 0; border-bottom: 2px solid #000;"
                                    placeholder="Confirm Password" aria-label="Password"
                                    aria-describedby="basic-addon1" name="password_confirmation" value="{{old('password_confirmation')}}">
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <input name="language" type="hidden" value="English"/>
                        <input name="business_name" type="hidden" value="Buyer Defualt"/>
                        <input name="business_type" type="hidden" value="defualt"/>
                        <input name="postal_code" type="hidden" value="0000"/>
                        <input name="tax_id" type="hidden" value="0000000"/>
                        <input name="account_type" type="hidden" value="Buyer"/>
                    </div>

                    <div class="d-flex align-items-center flex-column">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                I accept to receive updates from ViaNexta via email
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                            <label class="form-check-label" for="flexCheckChecked">
                                I accept the terms and conditions
                            </label>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary">Get Started</a>
                    </div>
                </form>

            </div>


        </div>
    </section>

    {{-- LEARN MORE SECTION --}}
    <section class="py-1 bg-secondary" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
        <div class="container px-2 px-lg-3 my-3">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    <h1 class="fs-4 fw-bolder text-white">Learn more from our agents</h1>

                </div>
                <div class="col-md-6 text-end"><svg xmlns="http://www.w3.org/2000/svg" width="100" height="26"
                        fill="#ffffff" class="bi bi-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                    </svg>

                </div>
            </div>
        </div>
    </section>
@include('new_web_pages.buyer_pages.welcome_modal')
@endsection
@section('scripts')
    <script>
        window.addEventListener('scroll', function() {
            var header = document.getElementById('app_header');
            // var logo = header.querySelector('.navbar-brand');
            // var links = header.querySelectorAll('.nav-link');
            // var button = header.querySelector('.btn');

            if (window.scrollY > 0) {
                header.style.backgroundColor = '#06382F';
                // logo.style.color = '#fff';
                // links.forEach(function(link) {
                //     link.style.color = '#fff';
                // });
                // button.style.backgroundColor = '#fff';
                // button.style.color = '#000';
            } else {
                header.style.backgroundColor = 'transparent';
                // color
                // logo.style.color = '#fff';
                // links.forEach(function(link) {
                //     link.style.color = '#fff';
                // });
                // button.style.backgroundColor = 'transparent';
                // button.style.color = '#fff';
            }
        });
    </script>
@endsection
