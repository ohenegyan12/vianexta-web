@extends('layouts.account_layout ')
@section('title', 'Order Tracking ')


@section('content')
    <main class="py-4 pb-40 sm:py-8 h-5/6">
        <div class="p-5 mx-auto max-w-screen-2xl">
            <h1 class="mb-8 text-2xl font-semibold md:text-4xl text-secondary text-start md:mb-10 xl:mb-0">Order Tracking
            </h1>
            <div class="flex mt-6 rounded-md shadow-sm">
                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                    <input type="email" name="email" id="email"
                        class="w-full text-sm text-gray-900 bg-white border rounded-none input rounded-l-xl sm:text-base ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:outline-none focus:border-secondary focus:ring-secondary ">
                </div>
                <button type="button"
                    class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-xl px-8 py-2 text-sm border-r border-b border-t border-secondary font-semibold text-secondary ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Search
                </button>
            </div>
            <h1 class="mt-5 mb-8 text-2xl font-semibold text-center md:mt-10 md:text-4xl text-secondary md:mb-5 ">
                Your order #234325235 is <span class="text-primary">delivered</span>
            </h1>
            <ul class="w-full steps">
                <li class=" step" data-content="✓">Being processed</li>
                <li class="step " data-content="✓">On it’s way!</li>
                <li class="step step-primary" data-content="✓">Delivered</li>

            </ul>
            <hr class="w-full my-10 border md:my-20 border-secondary">
            <h1 class="mb-8 text-2xl font-semibold md:text-4xl text-secondary text-start md:mb-10 ">Order Details
            </h1>
            <div class="flex flex-col items-center justify-between md:flex-row">
                <div class="flex flex-col gap-y-4">
                    <h1 class="font-semibold text-md md:text-xl text-secondary">Order Number</h1>
                    <p class="text-secondary">#234325235</p>
                </div>
                <div class="flex flex-col gap-y-4">
                    <h1 class="font-semibold text-md md:text-xl text-secondary">Created at</h1>
                    <p class="text-secondary">Friday, September 29, 2023</p>
                </div>
                <div class="flex flex-col gap-y-4">
                    <h1 class="font-semibold text-md md:text-xl text-secondary">Last updated</h1>
                    <p class="text-secondary">2 months ago</p>
                </div>
            </div>
            <hr class="w-full my-10 border md:my-20 border-secondary">
            <h1 class="mb-8 text-2xl font-semibold md:text-4xl text-primary text-start md:mb-10 ">Delivered
            </h1>
            <div class="flex flex-col items-center justify-between pb-20 md:flex-row">
                <div class="flex flex-col gap-y-4">
                    <h1 class="font-semibold text-md md:text-xl text-secondary">Shipment ID</h1>
                    <p class="text-secondary">SAE9327D0</p>
                </div>
                <div class="flex flex-col gap-y-4">
                    <h1 class="font-semibold text-md md:text-xl text-secondary">Carrier</h1>
                    <p class="text-secondary">UPS</p>
                </div>
                <div class="flex flex-col gap-y-4">
                    <h1 class="font-semibold text-md md:text-xl text-secondary">Tracking Number</h1>
                    <p class="text-secondary">NMAH-DFA-2342266</p>
                </div>
                <a class="btn btn-outline btn-outline-primary hover:btn-ghost">Track package</a>
            </div>
        </div>

    </main>

@endsection
