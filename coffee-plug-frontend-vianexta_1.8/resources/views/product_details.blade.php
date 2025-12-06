@extends('layouts.account_layout ')
<!-- yeild title -->
@section('title', 'Product Details')
@section('script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

{{-- ! * fix --}}
{{-- <script src="{{ asset('js/apexcharts.js') }}"></script> --}}
@endsection



@section('content')
{{-- hero --}}
<section class=" bg-accent">
    <div class="container-8xl bg-secondary sm:rounded-b-[90px] p-10 ">
        <a href="" class="flex gap-x-2 items-center text-white mb-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <p class="text-lg"> Return to marketplace</p>
        </a>
        <form action="{{ route('saveCartItem') }}" method="POST" class="align-middle">
            @csrf
            <input name="stockPostingId" id="stockPostingId" type="hidden" value="{{$helper->encode($products_data->id)}}" />
            <div class="grid grid-col-12 sm:grid-cols-2 gap-8 md:gap-16 items-center justify-center">
                <div class="text-center md:pl-28">
                    <img class="object-cover object-center rounded  " alt="hero"
                        src="{{ $products_data->imageUrl !=null ? $products_data->imageUrl : asset('images/green_beans.jpg') }}">
                </div>
                <div class=" justify-center sm:max-w-lg">

                    <h1
                        class="sm:max-w-xs lg:max-w-md text-2xl  md:text-5xl 2xl:tex t-7xl font-semibold text-white mb-4 text-center sm:text-start sm:mb-10">
                        South Kivu
                        K3 FW 15+ </h1>
                    <div class="sm:max-w-xs">
                        <div class="flex justify-between items-center mb-4">
                            <div class="text-base text-white font-semibold">
                                Spot Price
                            </div>
                            <div class="text-base text-white font-semibold">
                                $8.50/kg
                            </div>
                        </div>
                        <!-- <div class="mb-4">
                                <label for="stock location" class="block text-sm font-semibold text-white">In Stock
                                    Location</label>
                                <div class="mt-2">
                                    <select name="stock" id="stock" autocomplete="stock"
                                        class="accent-white mt-2 relative block w-full rounded-none  border bg-transparent py-3 px-4 text-white ring-1 ring-inset ring-gray-300 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option selected>Select stock location</option>
                                        <option class="text-black" value="maimi">Miami</option>
                                        <option class="text-black" value="philadelphia">Philadelphia</option>
                                </select>
                                </div>

                            </div> -->
                        <div class="mb-4">
                            <label for="package" class="block text-sm font-semibold text-white">Package</label>
                            <select id="package" name="package" autocomplete="package-name"
                                class="accent-white mt-2 relative block w-full rounded-none  border bg-transparent py-3 px-4 text-white ring-1 ring-inset ring-gray-300 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option selected>60 kg bag</option>
                            </select>
                            <!-- <p class="text-primary font-semibold mt-1">clear</p> -->
                        </div>
                        <div class="mb-4 text-white font-semibold">
                            {{$products_data->quantityPosted}} in stock
                        </div>
                        <div class="mb-4 flex items-center gap-x-4">
                            <!-- <select id="item_count" name="item_count" autocomplete="item_count"
                                    class="mt-2 w-1/3 relative block rounded-none  border bg-transparent py-3 px-4 text-white sm:text-sm sm:leading-6">
                                    <option selected>1</option>
                                    <option>2</option>
                                </select> -->
                            <input type="number" id="numBags" name="numBags" min="0" maxlength="2" max="{{$products_data->quantityPosted}}" required
                                value="{{ empty($numBags) ? old('numBags') : $numBags }}" class="block w-full rounded-md border-0 py-3 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">

                            <button type="submit" class="btn btn-primary py-2.5 w-2/3 text-center">
                                Add to cart
                            </button>

                        </div>
                        @if ($errors->has('numBags'))
                        <span class="invalid-feedback text-center w-full" role="alert">
                            <strong style="color: red;">{{ $errors->first('numBags') }}</strong>
                        </span>
                        @endif
                        <a href="#" class="mb-4 btn btn-primary py-2.5  text-center w-full">
                            Request a quote
                        </a>
                        <p class="font-sm text-white"> Vendor: <span class="text-white">{{$products_data->supplierInfo->firstName != null? $products_data->supplierInfo->firstName:''}}</span></p>
                    </div>
                </div>
            </div>
        </form>
    </div>

</section>

{{-- meet farms --}}
<section class="bg-accent py-10">
    <div class="mx-auto max-w-6xl lg:max-w-8xl px-4 sm:px-6 lg:px-8 sm:py-20 ">
        <div class="grid grid-cols-12 sm:grid-cols-3 gap-8 md:gap-16 ">
            <div class="order-2 sm:order-1 justify-center   col-span-12 sm:col-span-1">

                <h1
                    class="text-4xl md:text-5xl 2xl:text-7xl font-semibold text-secondary mb-4 text-center sm:text-start sm:mb-10">
                    Meet the famers </h1>
                <div class="sm:max-w-sm">
                    <p class=" mb-4 text-secondary text-xl text-center sm:text-start"> Our farmers come from
                        generations of coffee
                        farmers. We visit every farm, and meet every farmer.


                    </p>
                    <p class=" mb-8 text-secondary text-xl text-center sm:text-start"> We are problem solvers We
                        de-risk and assure
                        quality in every bean through technology and education.

                    </p>
                </div>
            </div>
            <div class="order-1 sm:order-2 col-span-12 sm:col-span-2">
                <img class="object-cover object-center rounded " alt="hero"
                    src="{{ asset('images/meet_farms.svg') }}">
            </div>

        </div>
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-8 xl:gap-16 mt-6">
            <!-- feature - start -->
            <div class="flex flex-col items-center">
                <img class="mb-6 flex h-12 w-12 items-center justify-center md:h-32 md:w-24 "
                    src="{{ asset('images/f_location.svg') }}" alt="" />

                <h3 class="mb-2 text-center text-lg font-semibold md:text-xl text-secondary">Location</h3>
                <p class="mb-2 text-center text-gray-900">{{$products_data->supplierInfo->country}}</p>

            </div>
            <!-- feature - end -->

            <!-- feature - start -->
            <div class="flex flex-col items-center">
                <img class="mb-6 flex h-12 w-12 items-center justify-center  md:h-32 md:w-32 "
                    src="{{ asset('images/f_elevation.svg') }}" alt="" />

                <h3 class="mb-2 text-center text-lg font-semibold md:text-xl text-secondary">Elevation</h3>
                <p class="mb-2 text-center text-gray-900">{{$products_data->supplierInfo->elevation}}</p>

            </div>
            <!-- feature - end -->

            <!-- feature - start -->
            <div class="flex flex-col items-center">
                <img class="mb-6 flex h-12 w-12 items-center justify-center  md:h-32 md:w-32 "
                    src="{{ asset('images/f_harvest.svg') }}" alt="" />

                <h3 class="mb-2 text-center text-lg font-semibold md:text-xl text-secondary">Harvest</h3>
                <p class="mb-2 text-center text-gray-900">{{$products_data->supplierInfo->harvestSeason}}</p>

            </div>
            <!-- feature - end -->

            <!-- feature - start -->
            <div class="flex flex-col items-center">
                <img class="mb-6 flex h-12 w-12 items-center justify-center  md:h-32 md:w-32 "
                    src="{{ asset('images/f_founded.svg') }}" alt="" />

                <h3 class="mb-2 text-center text-lg font-semibold md:text-xl text-secondary">Founded</h3>
                <p class="mb-2 text-center text-gray-900">{{$products_data->supplierInfo->foundedYear}}</p>

            </div>
            <!-- feature - end -->
        </div>
    </div>

</section>




{{-- analysis  --}}
@include('includes.product.sensory_stats')

{{-- process --}}
<section class="bg-primary sm:rounded-t-[90px] py-12 sm:py-32 ">
    <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8 py-5 sm:py-10 ">
        <div class="text-2xl md:text-4xl font-semibold text-white mb-12 sm:mb-24 text-center ">Type of Process</div>
        <div class="grid grid-cols-1 sm:grid-cols-2  gap-8 xl:gap-16">
            <div>
                <img class="" alt="hero" src="{{ asset('images/process.png') }} ">
            </div>
            <div class="flex flex-col  justify-center sm:max-w-sm">
                <div
                    class="text-center sm:text-start text-2xl md:text-3xl lg:text-4xl 2xl:text-5xl font-medium text-white mb-8">
                    Natural (dry)
                    Processing</div>
                <a href="{{route('process')}}"
                    class="btn btn-outline border-2 border-white text-white font-semibold hover:bg-white hover:text-slate-700 ">
                    Learn more
                </a>
            </div>
        </div>
</section>

{{-- footer --}}
<section class="bg-accent ">
    <div class="mx-auto max-w-7xl sm:max-w-8xl px-4 py-6">
        <div class="grid grid-col-12 sm:grid-cols-2 gap-8 md:gap-16 items-center">

            <div class="flex flex-col md:flex-row gap-x-4">
                <p class="mb-0 text-2xl  md:text-2xl font-semibold  text-secondary"> Let's Stay<br>
                    Connected</h2>
                </p>
                <p class=" text-secondary text-lg  self-end"> Sign up for our weekly newsletter for
                    stories from
                    our farmers and their stock
                </p>

            </div>

            <div class="">
                <form class="flex flex-col gap-2 mb-3" action="{{ route('saveNewLetter') }}" method="POST">
                    @csrf
                    <input placeholder="Email Address" name="email"
                        class="w-full bg-transparent input input-bordered placeholder:text-center placeholder:font-semibold placeholder:text-black border-secondary input-md " />
                    <button class="w-full border-0 btn btn-primary btn-md" type='submit'>
                        <span class="text-white font-sora"> Sign
                            Up</span>
                    </button>
                </form>
            </div>

        </div>
    </div>

</section>

<section class="bg-secondary ">
    <div class="mx-auto max-w-7xl sm:max-w-8xl px-4 py-8">
        <div class="flex  gap-8 md:gap-16 items-center justify-between">

            <h2 class="text-2xl   text-white sm:text-xl md:text-2xl font-semibold ">
                Learn more<br>
                from our agent</h2>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="#ffffff" class="w-16 h-16 sm:w-32 sm:h-20">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
            </svg>

        </div>
    </div>

</section>
@endsection
@include('includes.alerts.error_alert')
@include('includes.alerts.success_alert')