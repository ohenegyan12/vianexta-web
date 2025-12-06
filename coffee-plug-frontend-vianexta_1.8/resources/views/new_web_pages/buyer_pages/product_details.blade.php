@extends('layouts.new_home_layout')
@section('title', 'Product Details')
@push('css')


@endpush

@section('content')
@include('includes.new_home.buyer_new_header')

{{-- HERO SECTION --}}
<form action="{{ route('saveCartItem') }}" method="POST" class="align-middle">
    @csrf
    <input name="stockPostingId" id="stockPostingId" type="hidden" value="{{$helper->encode($products_data->id)}}" />
    <input name="edit" value="{{ empty($numBags) ? 'no' : 'yes' }}" type="hidden" />
    <section class="py-2">
        <div class="container px-2 px-lg-3 my-3">
            <div class="row gx-4 gx-lg-5 my-lg-5 justify-content-center justify-content-xl-start" style="padding-top:60px;">
                <div class="col-md-12 mb-md-5">
                    <div class="">
                        <div class="fs-5"><a href="{{route('buyer_market_place')}}" class=" text-primary">
                                < Return to marketplace</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xl-6 col-xxl-7 mb-md-5 py-1 mt-3">
                    <img class="card-img-top img-fluid"
                        src="{{ $products_data->imageUrl !=null ? urldecode($products_data->imageUrl) : asset('images/market_place/product_big_img.svg') }}" style="max-width:100%;" alt="lady">

                    <div class="row py-3 gy-4">
                        <div class="col-md-3">
                            <img class="card-img-top img-fluid"
                                src="{{ $products_data->imageUrl !=null ? urldecode($products_data->imageUrl) : asset('images/market_place/prod_sub.png') }}" style="max-width:100%; " alt="lady">
                        </div>
                        <div class="col-md-3">
                            <img class="card-img-top img-fluid"
                                src="{{ $products_data->imageUrl !=null ? urldecode($products_data->imageUrl) : asset('images/market_place/prod_sub.png') }}" style="max-width:100%; " alt="lady">
                        </div>
                        <div class="col-md-3">
                            <img class="card-img-top img-fluid"
                                src="{{ $products_data->imageUrl !=null ? urldecode($products_data->imageUrl) : asset('images/market_place/prod_sub.png') }}" style="max-width:100%; " alt="lady">
                        </div>
                        <div class="col-md-3">
                            <img class="card-img-top img-fluid"
                                src="{{ $products_data->imageUrl !=null ? urldecode($products_data->imageUrl) : asset('images/market_place/prod_sub.png') }}" style="max-width:100%; " alt="lady">
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xl-6 col-xxl-5 mb-md-5 py-1 mt-2">
                    <h1 class="display-6 fw-bolder text-primary" style="text-transform:uppercase">{{$products_data->supplierInfo->firstName =='Win' || $products_data->productType == 'whole_sale_brand'? strtoupper($products_data->description) : (isset($products_data->name)? $products_data->name: $products_data->description)}}</h1>
                    <div class="row py-4">

                        <div class="col-md-6">
                            @if(session('roast') == 'whole_sale_brand')
                            <div class="fs-5 text-black pb-2">Bag Size</div>
                            <div class="py-2">
                                <div class="input-group" onclick="document.getElementById('bag_size').click()">
                                    <select class="form-control py-2 border border-dark " id="bag_size" name="bag_size" required>
                                        <option value="12oz Retail Bag">12oz Retail Bag</option>
                                        <option value="5lb Bulk Bag">5lb Bulk Bag</option>
                                        <option value="2 Pound">2 Pound</option>
                                    </select>
                                    {{-- <div class="input-group-text border border-dark border-start-0 bg-white" style="cursor: pointer">
                                        <i class="fa fa-caret-down"></i>
                                    </div> --}}
                                </div>
                            </div>
                            @endif

                            <div class="fs-5 text-black pb-2 py-2">{{session('roast') =='whole_sale_brand'?'Case Quantity':'Quantity'}}</div>
                            <div class=" py-2 ">
                                <input type="number" class=" py-2 form-control {{ $errors->has('numBags') ? 'is-invalid' : '' }} border border-dark" id="numBags" value="{{ empty($numBags) ? old('numBags') : $numBags }}" name="numBags"
                                    placeholder="Enter quantity" oninput="getAmount()" min="1" max="{{$products_data->quantityLeft}}" required>
                                @if($errors->has('numBags'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('numBags') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if(session('roast') != 'whole_sale_brand')
                            <div class="fs-5 text-black pb-2" style="visibility: hidden;">Package (lb)</div>
                            <div class="py-2 " style="visibility: hidden;">
                                <input type="text" class="py-2 form-control {{ $errors->has('package') ? 'is-invalid' : '' }} border border-dark" style="background-color:#D9D9D9;" value="{{$products_data->bagWeight}}" id="package" name="package"
                                    placeholder="70lb bag" readonly required>
                                @if($errors->has('package'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('package') }}
                                </div>
                                @endif
                            </div>
                            @endif
                            <div class="fs-5 text-black pb-2">{{session('roast') =='whole_sale_brand'?'Bag Price($)':'Spot Price($/per lb)'}}</div>
                            <div class=" py-2 ">
                                <input type="text" id="spot_price" class="form-control py-2 {{ $errors->has('spot_price') ? 'is-invalid' : '' }} border border-dark" value="{{$products_data->bagPrice}}" style="background-color:#D9D9D9;" name="spot_price"
                                    placeholder="$ 8.50/lb" readonly required>
                                @if($errors->has('spot_price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('spot_price') }}
                                </div>
                                @endif
                            </div>
                            <div class="fs-5 text-black pb-2 py-2">Amount</div>
                            <div class=" py-2 ">
                                <input type="text" class="py-2 form-control {{ $errors->has('package') ? 'is-invalid' : '' }} border border-dark" style="background-color:#D9D9D9;" value="$00.00" id="amount"
                                    placeholder="70lb bag" readonly required>
                                <!-- <div style="width:100%;background-color:#D9D9D9;"  class="border border-dark py-2 btn btn-primary text-black" id="amount">$00.00</div> -->
                            </div>
                        </div>
                        <div class="fs-5 text-black py-2 pt-4"><b>{{$products_data->quantityLeft}} bags available</b></div>
                        <div class="col-md-6 py-2 pt-4">
                            <button type="submit" class="btn btn-primary py-2">Proceed</button>
                        </div>
                        <div class="fs-5 text-black py-2 pt-4"><b>Product details</b></div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fs-5 text-black py-2 pt-4"><b>Vendor</b></td>
                                    <td class="fs-5 text-black py-2 pt-4"><b><span style="color: #D8501C">{{$products_data->supplierInfo->firstName != null? $products_data->supplierInfo->firstName:''}}</span> </b></td>
                                </tr>
                                <tr>
                                    <td class="fs-5 text-black py-2 pt-4"><b>Variety</b></td>
                                    <td class="fs-5 text-black py-2 pt-4"><b><span style="color: #D8501C">{{$products_data->variety != null? $products_data->variety:''}}</span> </b></td>
                                </tr>
                                <tr>
                                    <td class="fs-5 text-black py-2 pt-4"><b>Coffee Type</b></td>
                                    <td class="fs-5 text-black py-2 pt-4"><b><span style="color: #D8501C">{{$products_data->coffeeType != null? $products_data->coffeeType:''}}</span> </b></td>
                                </tr>
                                <tr>
                                    <td class="fs-5 text-black py-2 pt-4"><b>Quality</b></td>
                                    <td class="fs-5 text-black py-2 pt-4"><b><span style="color: #D8501C">{{$products_data->quality != null? $products_data->quality:''}}</span> </b></td>
                                </tr>
                                <tr>
                                    <td class="fs-5 text-black py-2 pt-4"><b>Notes</b></td>
                                    <td class="fs-5 text-black py-2 pt-4"><b><span style="color: #D8501C">{{$products_data->aroma != null? $products_data->aroma:''}}</span> </b></td>
                                </tr>
                                <tr>
                                    <td class="fs-5 text-black py-2 pt-4"><b>Process</b></td>
                                    <td class="fs-5 text-black py-2 pt-4"><b><span style="color: #D8501C">{{$products_data->process != null? $products_data->process:''}}</span> </b></td>
                                </tr>

                            </tbody>
                        </table>

                        </h1>

                    </div>

                </div>
                @if(session('roast') !='whole_sale_brand')
                <div class="col-md-12">
                    <div class="fs-5 text-black py-2 pt-4"><b>Certification(s)</b></div>
                    <table class="table table-striped table-hover">
                        <tbody>
                            <tr>
                                <!-- <td class="fs-5 text-black py-2 pt-4"><b>Certification(s)</b></td> -->
                                <td class="fs-5 text-black py-2 pt-4">
                                    @php $count=1; @endphp
                                    @foreach($helper->getCirtifications() as $certification)
                                    <b>
                                        <button class="badge rounded-pill bg-secondary " type="button" data-bs-toggle="modal" data-bs-target="#modal_{{$count}}">
                                            {{$certification->name}}
                                        </button>
                                    </b>
                                    @include('new_web_pages.buyer_pages.certification_modal')
                                    @php $count++; @endphp
                                    @endforeach
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12">
                    <div class="fs-5 text-black py-2 pt-4"><b>SCA Score</b></div>
                    <table class="table table-striped table-hover table-bordered table-success">
                        <thead>
                            <th>Fragrance</th>
                            <th>Flavor</th>
                            <th>Acidity</th>
                            <th>Body</th>
                            <th>Uniformity</th>
                            <th>Clean Cup</th>
                            <th>Overall</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fs-5 text-black py-2 pt-4">9</td>
                                <td class="fs-5 text-black py-2 pt-4">8</td>
                                <td class="fs-5 text-black py-2 pt-4">8.5</td>
                                <td class="fs-5 text-black py-2 pt-4">8</td>
                                <td class="fs-5 text-black py-2 pt-4">8.5</td>
                                <td class="fs-5 text-black py-2 pt-4">8</td>
                                <td class="fs-5 text-black py-2 pt-4"><b><span style="color: #07382F">{{number_format($total=50/6,2)}}</span></b></td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif


            </div>
        </div>
    </section>
</form>

{{-- FARMER SECTION --}}
<section class="py-5 " style="background-color:#ECECEC">
    <div class="container px-2 px-lg-3 ">
        <div class="row gx-4 gx-lg-5 align-items-center py-5">
            <div class="col-md-5 mb-md-5 pt-3 pt-md-1">
                <h1 class="display-6 fw-bolder text-primary">Meet the <br>Farmers </h1>
                <div class="fs-5">Our farmers come from generations of coffee farmers. We visit every farm, and meet every farmer.</div>

                <div class="fs-5 py-3">We are problem solvers We de-risk and assure quality in every bean through technology and education.</div>
                <form action="{{ route('farmerProfile') }}" method="POST" class="align-middle">
                    @csrf
                    @php
                    $supplier_data = $helper->encryptData(json_encode($products_data));
                    @endphp
                    <input name="supplier_data" value="{{$supplier_data}}" type="hidden" />
                    <div class="py-3">
                        <button href="{{route('farmerProfile')}}" type="submit" class="btn btn-primary">Learn more</button>
                    </div>

                </form>
            </div>
            <div class="col-md-7 mb-md-5 pt-3 text-center">
                <img class="card-img-top mb-5 mb-md-0 img-fluid" style="max-width:100%;" src="{{  asset('images/market_place/farmers.png') }}"
                    alt="farmers">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 text-center">
                <img class="mb-md-0 img-fluid" style="max-width:50%;" src="{{  asset('images/market_place/location.svg') }}"
                    alt="location">
                <div class="fs-5 py-1"><b>Location</b></div>
                <div class="fs-5">{{$products_data->supplierInfo->billingCountry}}</div>
            </div>
            <div class="col-md-3 text-center">
                <img class="mb-md-0 img-fluid" style="max-width:60%;" src="{{  asset('images/market_place/elevation.svg') }}"
                    alt="location">
                <div class="fs-5 py-1"><b>Elevation</b></div>
                <div class="fs-5">{{$products_data->supplierInfo->elevation}}</div>
            </div>
            <div class="col-md-3 text-center">
                <img class="mb-md-0 img-fluid" style="max-width:50%;" src="{{  asset('images/market_place/harvest.svg') }}"
                    alt="location">
                <div class="fs-5 py-1"><b>Harvest</b></div>
                <div class="fs-5">{{$products_data->supplierInfo->harvestSeason}}</div>
            </div>
            <div class="col-md-3 text-center">
                <img class="mb-md-0 img-fluid" style="max-width:50%;" src="{{  asset('images/market_place/founded.svg') }}"
                    alt="location">
                <div class="fs-5 py-1"><b>Founded</b></div>
                <div class="fs-5">{{$products_data->supplierInfo->foundedYear}}</div>
            </div>
        </div>
    </div>
</section>

{{-- analysis  --}}
<!-- @include('includes.product.new_sensory_stats') -->

{{-- PROCESS SECTION --}}
<!-- <section class="bg-secondary py-5 " style="border-radius: 90px 90px 0 0; " >
        <div class="container px-2 px-lg-3 ">
            <div class="row align-items-center ">
                <h1 class="display-6 fw-bolder text-white py-5 text-center">Type of Process</h1>
                <div class="col-md-6">
                  <img  class="card-img-top mb-5 mb-md-0 img-fluid" style="max-width:75%;" src="{{ asset('images/market_place/process_art.svg') }} ">
                </div>
                <div class="col-md-6 mb-md-5 pt-2 text-center">
                    <h4 class="display-8 text-white py-3 text-center"> Natural processing, also known as dry processing, is a fascinating method in the world of coffee production. 
                        In this unique approach, freshly harvested coffee cherries are left to dry in the sun, allowing the fruit to naturally ferment and impart distinct flavors to the beans.
                         The cherries are spread out on raised beds or patios, and as they dry, the pulp shrinks, leaving behind the beans enveloped in a protective layer of fruity sweetness.<br>
                        </h4>
                    
                    <a href="{{route('process')}}" 
                        class="btn btn-outline-light btn-lg ">
                        Learn more
                    </a>
                </div>
            </div>
        </div>
    </section> -->
{{-- NEWSLETTER SECTION --}}
<section class="py-5">
    <div class="container px-2 px-lg-3 my-3">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6 text-center text-md-start ">
                <div class="display-6 fw-bolder mb-1" style="color: #07382F">Let's stay connected</div>
                <h1 class="fs-6 fw-medium" style="color: #07382F">Sign up for our weekly
                    newsletter for stories from our farmers and their stock.
                </h1>

            </div>

            <div class="col-md-6 ">
                <form class="flex flex-col gap-2 mb-3" action="{{ route('saveNewLetter') }}" method="POST">
                    @csrf
                    <input type="email" name="email" class=" mb-3 form-control text-center fw-bold"
                        placeholder="Email address" aria-label="newsletter email"
                        aria-describedby="button-addon2" style="background-color:#FCEFE3;" />
                    <button class="btn w-100 text-white" type="submit" id="button-addon2"
                        style="background-color: #D8501C">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- LEARN MORE SECTION --}}
<section class="py-1" style="background-color: #D8501C">
    <div class="container px-2 px-lg-3 my-3">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <h1 class="fs-3 fw-bolder text-white">Learn more from our agents</h1>

            </div>
            <div class="col-md-6 text-end">
                <a href="https://calendar.google.com/calendar/u/0/appointments/schedules/AcZssZ0VzrtBRIYMPiHJG1DpCYxHXn-gRIUTuioGbMTO-KrsCZqGPPb7bEI1zolDgqg9Oc-FYXtBlKj3" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="26"
                        fill="#ffffff" class="bi bi-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
<script>
    window.onload = function() {
        getAmount();
        // Only run updateBagSize if the bag_size select exists
        const bagSizeSelect = document.getElementById("bag_size");
        if (bagSizeSelect) {
            updateBagSize();
        }
    }

    function updateBagSize() {
        const bagSizeSelect = document.getElementById("bag_size");
        const quantityInput = document.getElementById("numBags");
        const spotPriceInput = document.getElementById("spot_price");
        
        // Define bag size configurations
        const bagConfigs = {
            "12oz Retail Bag": {
                price: 12.99,
                minQuantity: 1
            },
            "5lb Bulk Bag": {
                price: 45.99,
                minQuantity: 1
            },
            "2 Pound": {
                price: 19.99,
                minQuantity: 1
            }
        };

        // Update price and quantity limits when bag size changes
        bagSizeSelect.addEventListener('change', function() {
            const selectedConfig = bagConfigs[this.value];
            if (selectedConfig) {
                spotPriceInput.value = selectedConfig.price;
                quantityInput.min = selectedConfig.minQuantity;
                quantityInput.value = selectedConfig.minQuantity;
                getAmount();
            }
        });

        // Initialize with the current selected value
        const currentValue = bagSizeSelect.value;
        const currentConfig = bagConfigs[currentValue];
        if (currentConfig) {
            spotPriceInput.value = currentConfig.price;
            quantityInput.min = currentConfig.minQuantity;
            quantityInput.value = currentConfig.minQuantity;
            getAmount();
        }
    }

    function getAmount() {
        var quantity = document.getElementById("numBags").value;
        var spot_price = document.getElementById("spot_price").value;
        var package_size = document.getElementById("package");
        var amount = document.getElementById("amount");

        if (spot_price != null && quantity != null) {
            // For wholesale brand, calculate based on bag price
            if (document.getElementById("bag_size")) {
                total_price = quantity * spot_price;
            } else {
                // For regular products, calculate based on weight
                total_price = quantity * (spot_price * (package_size ? package_size.value : 1));
            }
        } else {
            total_price = 0;
        }

        amount.value = "$ " + new Intl.NumberFormat().format(total_price.toFixed(2));
    }

    window.addEventListener('scroll', function() {
        var header = document.getElementById('app_header');
        if (window.scrollY > 0) {
            header.style.backgroundColor = '#FFFF';
        } else {
            header.style.backgroundColor = '#FFFF';
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>