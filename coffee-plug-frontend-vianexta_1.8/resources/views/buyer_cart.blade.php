@extends('layouts.account_layout ')
@section('title', 'Cart ')

@section('script')
<link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">
@endsection

@section('content')

    <main class="py-4 pb-40 sm:py-8 h-5/6">
        <div class="p-5 mx-auto max-w-screen-2xl">

            <div class="grid grid-cols-1 gap-x-20 gap-y-16 md:grid-cols-3">
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between pb-4 mb-4 border-b-2 md:mb-10 border-secondary md:pb-10">
                        <h3 class="font-semibold md:text-xl lg:text-3xl text-secondary">My Cart</h3>
                        <p class="font-medium md:text-lg text-secondary">{{count($cart_items)}} <span>item(s)</span></p>
                    </div>

                    <div class="flow-root">
                        <ul role="list" class="-my-6 divide-y divide-gray-200">

                         @foreach($cart_items as $cart_item)
                            <li class="flex py-6 space-x-6 border-b-2 border-secondary">
                                <img src="{{ asset('images/coffee_green.jpg') }}"
                                    alt="product"
                                    class="flex-none object-cover object-center bg-gray-100 border rounded-md w-52 h-52 border-secondary ">
                                <div class="flex-auto">
                                    <div class="space-y-1 sm:flex sm:items-start sm:justify-between sm:space-x-6">
                                        <div class="flex flex-col justify-between">
                                            <div class="flex-col mb-20 space-y-1 text-sm font-medium">
                                                <h3 class="font-semibold md:text-xl lg:text-3xl text-secondary">
                                                    <a href="#">{{$cart_item->description}}</a>
                                                </h3>
                                                <p class="text-gray-900">{{$cart_item->stockPosting->supplierInfo->country}}</p>
                                                <p class="text-gray-900">Quantity: {{$cart_item->numBags}}</p>
                                                <p class="text-gray-900">Type: {{$cart_item->stockPosting->coffeeType}}</p>
                                                <select
                                                    class="w-full max-w-xs font-semibold bg-white border-2 select select-secondary">
                                                    <option selected>60kg bag</option>
                                                    <!-- <option>70kg bag</option>
                                                    <option>80kg bag</option> -->
                                                </select>
                                                <p class="block mt-20 text-2xl font-semibold md:hidden text-primary">
                                                    <span>$</span>4000
                                                </p>

                                            </div>
                                            <div class="flex flex-none space-x-4">
                                                @php 
                                                $product_data = array('stockPostingId'=>$cart_item->stockPosting->id,'numBags'=>$cart_item->numBags); 
                                                $product_data = $helper->encryptData(json_encode($product_data));
                                                @endphp
                                                <a href="{{ route('editOrder',$product_data) }}" class="text-sm font-medium underline ">Edit</a>
                                                <div class="flex pl-4 ">
                                                    <a href="{{ route('deleteOrder',$helper->encode($cart_item->stockPosting->id))}}"
                                                        class="text-sm font-medium underline ">Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- PRICE --}}

                                        <p class="hidden font-semibold md:block md:text-xl lg:text-3xl text-primary">
                                            <span>$</span>4000
                                        </p>

                                    </div>
                                </div>
                            </li>
                        @endforeach
                            <!-- More products... -->
                        </ul>
                    </div>


                </div>

                <div class="md:col-span-1">
                    <h3 class="mb-2 text-4xl font-semibold md:mb-6 text-secondary">Order Summary</h3>
                    <dl class="space-y-6 text-sm font-medium text-gray-500 ">
                        <div class="flex justify-between">
                            <dt class="font-semibold text-black md:text-lg">Subtotal</dt>
                            <dd class="text-gray-900 md:text-md">$104.00</dd>
                        </div>

                        <div class="flex justify-between">
                            <dt class="font-semibold text-black md:text-lg">Shipping</dt>
                            <dd class="text-gray-900 md:text-md">$14.00</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-semibold text-black md:text-lg">Sales Tax</dt>
                            <dd class="text-gray-900 md:text-md">$8.32</dd>
                        </div>
                        <div class="flex flex-col justify-between pt-6 text-gray-900 border-t border-gray-200">
                            <dt class="font-semibold sm:text-md lg:text-lg">Total amounttt</dt>
                            <dd class="font-semibold sm:text-md md:text-2xl lg:text-4xl text-primary">$126.32</dd>
                        </div>
                    </dl>
                    <button onclick="showCheckoutConfirmationModal()"  class="w-full px-20 mt-10 text-white capitalize btn btn-primary btn-md ">
                        Checkout
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>

                    </button>


                </div>
            </div>
            <div>
                <div class="flex items-center justify-between mt-20">
                    <a href="{{ route('marketplace_buyer') }}"
                        class="hidden px-20 mt-6 capitalize border-2 md:flex btn btn-outline btn-md outline-4 text-secondary ">

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
@include('includes.alerts.error_alert')
@include('includes.alerts.success_alert')
@include('includes.alerts.checkout_confirmation')
<script>
  function showCheckoutConfirmationModal() {
            var modal = document.getElementById("confirmation_alert");
            modal.classList.remove("hidden");
            // setTimeout(function() {
            //     modal.classList.add("hidden");
            // }, 8000);
        }
</script>

<!-- Clare Chat Component -->
<script src="{{ asset('js/clare-component.js') }}"></script>