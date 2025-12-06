@extends('layouts.new_home_layout')
@section('title', 'Home')

@push('css')
<link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">
@endpush

@section('content')
@include('includes.new_home.seller_landing_header')

    {{-- HERO SECTION --}}
    <section class="py-2 seller_background mt-5 pt-5 pt-lg-0 pt-xxl-1" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
        <div class="container px-2 pt-md-4 pt-lg-0 px-lg-3 my-3">
            <div class="row gx-4 gx-lg-5 my-lg-5">
                <div class="col-lg-6 mb-lg-5 py-3 py-md-0 py-lg-5">
                    <h1 class="fs-0 fw-bold text-primary">Start selling with <br>ViaNexta</h1>
                    <p class="text-primary fs-5 fw-medium">Sell more, increase your earnings and manage your online business with us. Your journey to digitisation starts here.
                    </p>
                    <div class="container my-3 py-3 py-md-0 py-lg-5">
                        <div class="p-3 p-md-3"
                            style="border-radius: 0.8125rem; background: #F0F0F0; box-shadow: 11px 13px 24px 4px rgba(0, 0, 0, 0.25); ">
                            <p class="fs-5 lead fw-normal  text-primary ">Selling your coffee beans has never been
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
                            {{-- Business Name --}}
                            <input type="text" class="form-control bg-transparent"
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;" id="business_name"
                                placeholder="Business Name" name="business_name" value="{{old('business_name')}}" required>
                            @if ($errors->has('business_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('business_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- Business Type --}}
                            <input type="text" class="form-control bg-transparent"
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;"
                                    id="business_type" name="business_type" placeholder="Business Type" value="{{old('business_type')}}" required>
                            @if ($errors->has('business_type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('business_type') }}</strong>
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
                            {{-- Postal code --}}
                            <input type="text" class="form-control bg-transparent"
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;" id="postal_code"
                                placeholder="Postal Code" name="postal_code" value="{{old('postal_code')}}" required>
                            @if ($errors->has('postal_code'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('postal_code') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- Tax ID Number --}}
                            <input type="text" class="form-control bg-transparent"
                                style="border: none; border-radius: 0; border-bottom: 2px solid #000;"
                                    id="tax_id" name="tax_id" placeholder="Tax ID Number" value="{{old('tax_id')}}" required>
                            @if ($errors->has('tax_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;">{{ $errors->first('tax_id') }}</strong>
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
                        <input name="account_type" type="hidden" value="Supplier"/>
                    </div>

                    <div class="d-flex  flex-column">
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
                </div>
                <div class="col-lg-6 mb-lg-5 text-start">
                    <img class="card-img-top img-fluid"
                        src="{{ asset('images/lady1.png') }}" style="max-width:92%;" alt="lady">
                    <p class="text-black fs-5 pl-10 mt-5 mt-xxl-3" >"Where Every Sip Uplifts Lives: Brewing Prosperity for Our Coffee Bean Heroes"
                    </p>
                    
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
        <div class="container px-2 px-lg-3 ">
            <ul class="nav nav-pills nav-justified rounded-5 " style="background-color: #EEEEEE">
                <li class="nav-item tab">
                    <div class="nav-link tab-link d-flex align-items-center justify-content-center active rounded-5" style="height: 100%" aria-current="page">Sell</div>
                </li>
                <li class="nav-item tab">
                    <div class="nav-link tab-link d-flex align-items-center justify-content-center rounded-5" style="height: 100%">Manage</div>
                </li>
                <li class="nav-item tab">
                    <div class="nav-link tab-link d-flex align-items-center justify-content-center rounded-5" style="height: 100%">Grow</div>
                </li>

            </ul>
            
            <div class="content-parent mt-4">
                <div class="content content-active gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-7 mb-md-5 pt-3 pt-md-1">
                        <div>
                            <h3 class="fs-3 fw-bold">Sell to customers and
                                neighbourhoods.</h3>
                            <p class="mt-3 fs-5">Expand your customer base and enhance your order 
                                fulfillment with our technology-driven online 
                                marketplace and a network of reliable buyers at 
                                your service.</p>
                        </div>
    
                    </div>
                    <div class="col-md-5 mb-md-5">
                        <img class="card-img-top mb-5 mb-md-0 img-fluid" src="{{ asset('images/seller/cuate1.svg') }}"
                            alt="what we do">
                    </div>
                </div>
                <div class="content row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-7 mb-md-5 pt-3 pt-md-1">
                        <div>
                            <h3 class="fs-3 fw-bold">Efficient Inventory 
                                Management</h3>
                            <p class="mt-3 fs-5">Track your coffee inventory in real-time, ensuring you always know what you have available and can meet buyer demands promptly. Experience hassle-free transactions with our user-friendly platform, designed to make selling your coffee as simple and efficient as possible</p>
                        </div>
    
                    </div>
                    <div class="col-md-5 mb-md-5">
                        <img class="card-img-top mb-5 mb-md-0 img-fluid" src="{{ asset('images/seller/cuate2.svg') }}"
                            alt="what we do">
                    </div>
                </div>
                <div class="content row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-7 mb-md-5 pt-3 pt-md-1">
                        <div>
                            <h3 class="fs-3 fw-bold">Enhance Your Farming 
                                Techniques</h3>
                            <p class="mt-3 fs-5">Receive feedback and insights from buyers, helping you improve your cultivation methods and produce even higher quality coffee. Develop lasting relationships with global buyers who value and seek out your coffee, ensuring a steady and reliable market for your products.</p>
                        </div>
    
                    </div>
                    <div class="col-md-5 mb-md-5">
                        <img class="card-img-top mb-5 mb-md-0 img-fluid" src="{{ asset('images/seller/cuate3.svg') }}"
                            alt="what we do">
                    </div>
                </div>
            </div>


        </div>
    </section>
    
     {{-- EXPERT SECTION --}}
    <section class="py-5 seller_bottom_back" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
        <div class="container px-2 px-lg-3">
            <div class="row gx-4 gx-lg-5 align-items-center py-4 py-xxl-5">
                <div class="col-md-4 mb-md-5 pt-1 pb-3 text-start">
                    <img style="z-index: 999;" class="supplier-img card-img-top mb-0 img-fluid h-100" src="{{ asset('images/seller_lady_two.png') }}"
                        alt="what we do">
                </div>
                <div class="col-md-8 mb-md-5 pt-4 pt-md-1">
                   <h1 class="fs-4 text-white">Previously, I was unaware of the internet's 
                        potential for this, and now, approximately 
                        30% of my earnings are derived from 
                        ViaNexta.
                  </h1>
                  <div class="fs-5 text-white">Marie - Coffee Supplier from Nairobi, Kenya</div>

                </div>
               
            </div>
        </div>
    </section>

    {{-- EXPERT SECTION --}}
    <section class="py-5 seller_bottom_back_white" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
        <div class="container px-2 px-lg-3 ">
            <div class="row gx-4 gx-lg-5 align-items-center py-5">
                <div class="col-md-7 mb-md-5 pt-3 pt-md-1">
                   <h1 class="fs-0 fw-bolder text-primary">Lets help your coffee beans <br>business 
                            <span style="color: #D8501C">go digital</span>
                  </h1>
                  <div class="">
                    We are committed to empowering countless local businesses to embrace digital transformation. With our comprehensive solutions and expertise in coffee, we aspire to be your ultimate digital partner, as we hold a deep appreciation for local entrepreneurs and economies. <br>
                    Join us today; <a href='#' data-bs-toggle="modal" data-bs-target="#staticBackdrop"><span class="text-decoration-underline" style="color: #D8501C;text-decoration-color: #D8501C !important">click here</span></a>
                  </div>

                </div>
                <div class="col-md-5 mb-md-5 pt-3 text-center">
                    <img class="card-img-top mb-5 mb-md-0 img-fluid" style="max-width:80%;" src="{{ asset('images/lady_cup.svg') }}"
                        alt="what we do">
                </div>
            </div>


        </div>
    </section>

  @include('new_web_pages.seller_pages.seller_confirm_modal')
@endsection
    <script>
        window.addEventListener('scroll', function() {
            var header = document.getElementById('app_header');
            

            if (window.scrollY > 0) {
                header.style.backgroundColor = '#07382F';
             
            } else {
                header.style.backgroundColor = '#07382F';
            }
        });
    </script>

<!-- Clare Chat Component -->
<script src="{{ asset('js/clare-component.js') }}"></script>
