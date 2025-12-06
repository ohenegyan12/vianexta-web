@extends('layouts.new_home_layout')
@section('title', 'Farmer Profile')
@push('css')
 <style>
    body{
        background-color:#ECECEC;
    }
  </style> 
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/css/flag-icon.min.css" />
@endpush

@section('content')
@include('includes.new_home.buyer_new_header')

    {{-- HERO SECTION --}}
    <section class="pt-5 " >
        <div class="container px-2 px-lg-3 py-5">
            <div class="row gx-4 gx-lg-5 justify-content-center justify-content-lg-start">
                <div class="col-md-12 ">
                    <div class="position-relative">
                          <h1 class="display-6 fw-bolder text-primary text-center text-lg-start">Farmer</h1>
                    </div>
                </div>
                <div class="col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                  <button class="btn btn-primary" style="width:100%;">{{$supplier_data->supplierInfo->firstName}}  {{!isset($supplier_data->supplierInfo->lastName) ? "":$supplier_data->supplierInfo->lastName}}</button> 
                  <div class="row py-3">
                      <div class="col-md-12">
                        <button class="btn btn-light mb-3 mb-md-0"><span class="flag-icon flag-icon-{{strtolower($helper->getCountryCode($supplier_data->supplierInfo->billingCountry))}}" style="margin-right:10px;"></span>{{$supplier_data->supplierInfo->billingCountry}}</button>
                        <!-- <button class="btn btn-light ms-md-4"><span class="fa fa-send" style="padding-right:10px;color:#D8501C"></span>Sandona nariño</button> -->
                    </div>
                    
                  </div> 
                 
                </div>
                <div class="col-md-8"></div>
            </div>

             <div class="row gx-4 gx-lg-5 justify-content-center justify-content-lg-start">
                <div class="col-md-8 col-lg-4 mb-3 mb-lg-0">
                   <img class="card-img-top mb-5 mb-md-0 img-fluid" style="max-width:100%;" src="{{ $supplier_data->supplierInfo->imageUrl !=null ? urldecode($supplier_data->supplierInfo->imageUrl) :  'https://cdn.discordapp.com/attachments/1072084741358092379/1240268119927164928/justcoby_coffee_farm_photography_48533e3f-a923-4e6f-a685-a9e5e89f72c7.png?ex=6645f132&is=66449fb2&hm=62809796f138c7ac2986f929a16e007b224ec0f7381fcacc3a4aad5a8ffe54e8&'}}"
                        alt="farmers">
                </div>
                <div class="col-md-8">
                    <div class="row mx-0 justify-content-between">
                        <div class="col-md-6 px-0 mb-3 mb-lg-0">
                           <div class="card h-100" >
                               <div class="row mx-0">
                                    <div class="col-md-5 d-flex justify-content-center align-items-center" style="border-radius: 10px 10px 10px 10px; background-color:1CD845; "><h1 class="fs-2 fw-bolder text-white align-middle">{{$supplier_data->quality==null?"0.0":$supplier_data->quality}}</h1></div>
                                    <div class="col-md-7"><div class="fs-5">grade<br><b>overall quality</b></div></div>
                               </div>
                           </div>
                        </div>
                        <div class="col-md-6 px-0 px-lg-2">
                           <!-- <div class="card h-100">
                            <div class="fs-5 px-2">farm<br><b>El Aguacate farms</b></div>
                           </div> -->
                        </div>

                        <div class="col-lg-6 py-3 px-0 px-lg-0">
                           <div class="card h-100" >
                               <!-- <div class="row mx-0">
                                    <div class="col-md-5 d-flex justify-content-center align-items-center" style="border-radius: 10px 10px 10px 10px; background-color:1CD845; "><h1 class="fs-2 fw-bolder text-white align-middle">{{$supplier_data->quality==null?"0.0":$supplier_data->quality}}</h1></div>
                                    <div class="col-md-7"><div class="fs-5">grade<br><b>overall quality</b></div></div>
                               </div> -->
                               <div class="row mx-0 py-2 px-1"> 
                                    <div class="col-md-4 d-flex justify-content-center align-items-center"><h6 class="px-2 py-2">Coffee type</h6></div>
                                    <div class="col-md-8 d-flex justify-content-center align-items-center" style="border-radius: 10px 10px 10px 10px; background-color:D8501C; "><h6 class=" fw-bolder text-white align-middle">{{$supplier_data->coffeeType}} </h6> </div>
                               </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-4 py-lg-3 px-0 px-lg-2 mb-3 mb-md-0">
                           <div class="card h-100" >
                            <h4 class="  text-secondary px-2">{{$supplier_data->bagWeight==null?"0":$supplier_data->bagWeight}}</h4>
                            <div class="fs-6 px-2">coffee produced (kg)</b></div>
                           </div>
                        </div>
                        <div class="col-md-2 py-lg-3 px-0 px-lg-0 mb-3 mb-md-0">
                           <div class="card h-100" >
                            <h4 class=" text-secondary px-2">{{$supplier_data->quantityPosted==null?"0":$supplier_data->quantityPosted}}</h4>
                            <div class="fs-6 px-2">In stock</b></div>
                           </div>
                        </div>

                        <div class="col-md-4 px-0 px-lg-0">
                           <div class="card h-100" >
                            <div class="fs-5 px-2">Year Founded<br><b>{{$supplier_data->supplierInfo->foundedYear==null? "NA":$supplier_data->supplierInfo->foundedYear}}</b></div>
                           </div>
                        </div>
                        <div class="col-md-4 pt-3 pt-lg-0 px-0 ps-lg-2">
                           <div class="card h-100" >
                            <div class="fs-5 px-2">Harvest<br><b>{{$supplier_data->supplierInfo->harvestSeason==null? "NA" :$supplier_data->supplierInfo->harvestSeason}}</b></div>
                           </div>
                        </div>
                        <div class="col-md-4 px-0">
                           <div class="card border-0">
                           
                           </div>
                        </div>
                        <div class="col-md-4 d-lg-none">
                            <div class="card border-0">
                            
                            </div>
                        </div>

                        <div class="col-md-8 col-lg-6 col-xxl-4 mx-0 px-0 py-3 justify-self-center"><a href="{{route('buyer_market_place')}}" style="width:100%;" class="btn btn-primary">go to marketplace <span class="fa fa-arrow-right pull-right"></span></a></div>


                    </div>
                </div>
            </div>
        </div>
    </section>

     {{-- HERO SECTION --}}
    <section class="pt-5 farmer_bottom_back" style="margin-top:60px;">
       
    </section>

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
