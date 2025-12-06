@extends('layouts.account_layout ')
@section('title', 'Proecess Types ')


@section('content')

    <main class="py-4 pb-40 sm:py-8 h-5/6">
        <div class="p-5 mx-auto max-w-screen-2xl">
            <div class="flow-root">
                <ul role="list" class="-my-6 divide-y divide-gray-200">
                    <li class="flex flex-col py-6 space-x-6 border-b-2 md:flex-row border-secondary">
                        <img src="{{ asset('images/prdo.svg') }}" alt="product"
                            class="flex-none object-cover object-center mb-4 bg-gray-100 border rounded-md md:w-52 md:h-52 md:mb-0 border-secondary ">
                        <div class="flex-auto">
                            <div class="space-y-1 sm:flex sm:items-start sm:justify-between sm:space-x-6">
                                <div class="flex flex-col justify-between mb-5">
                                    <div class="flex-col mb-4 space-y-1 text-sm font-medium md:mb-20">
                                        <h3 class="font-semibold md:text-xl lg:text-3xl text-secondary">
                                            <a href="#">Arrives tomorrow</a>
                                        </h3>
                                        <p class="text-gray-900">Delivered on 08/09/2023</p>




                                        <p class="block mt-20 text-2xl font-semibold md:hidden text-primary">
                                            <span>$</span>4000
                                        </p>

                                    </div>
                                    <div class="flex flex-none space-x-4">
                                        <button type="button" class="text-sm font-medium underline ">Edit Order</button>

                                    </div>
                                </div>
                                {{-- PRICE --}}

                                <div class="flex flex-col gap-y-4 ">
                                    <a href="{{route('order_tracking')}}" class="capitalize btn btn-primary"> Track order</a>
                                    <div class="capitalize btn btn-outline hover:bg-transparent"> View order details</div>
                                    <div class="capitalize btn btn-outline hover:bg-transparent"> Get Invoice</div>
                                </div>

                            </div>
                        </div>
                    </li>

                    <!-- More products... -->
                </ul>
            </div>
            <div>
                <div class="flex items-center justify-between mt-20">
                    <a href="{{ route('marketplace_buyer') }}"
                        class="px-20 mt-6 capitalize border-2 btn btn-outline btn-md outline-4 text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 text-secondary ">
                            <path stroke-linecap="round" stroke-linejoin="round" d=" M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                        Continue Shopping
                    </a>

                </div>
            </div>
        </div>
    </main>

@endsection
