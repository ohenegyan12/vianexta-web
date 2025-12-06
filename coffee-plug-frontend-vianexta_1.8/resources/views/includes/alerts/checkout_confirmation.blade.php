<div id="confirmation_alert" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="max-w-xs rounded overflow-hidden shadow-lg">
                    <div class="px-6 py-4 flex flex-col items-center">
                    <div class="bg-gray-200 rounded-full h-12 w-12 flex items-center justify-center">
                        <img class="object-cover object-center w-full h-25" src="{{ asset('images/checkout.png') }}" alt="product" />
                    </div>
                    <div class="font-bold text-xl">Your order has been made...</div>
                    </div>
                    <div class="px-6 py-4">
                    <div class="flex justify-between gap-2">
                        <a href="{{ route('marketplace_buyer') }}"
                            class="hidden px-20 mt-6 capitalize border-2 md:flex btn btn-secondary btn-md outline-4 text-secondary ">
                            Track your order
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        
                        </a>
                        <a href="{{ route('marketplace_buyer') }}" class=" px-20 mt-10 text-white capitalize btn btn-primary btn-md ">
                            Continue Shopping
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        
                        </a>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>