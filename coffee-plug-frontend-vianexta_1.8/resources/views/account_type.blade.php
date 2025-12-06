@extends('layouts.auth_layout ')
@section('title', 'Account Type ')

@section('content')
    <section class="py-4 sm:py-8 pb-40 h-5/6">
        <div class="mx-auto max-w-screen-2xl p-3 p-lg-5 pt-5">
            <h1 class="text-2xl md:text-4xl font-semibold text-primary text-start mb-8 md:mb-10 "> Choose your
                account type
            </h1>
            <form action="{{ route('saveAccountType') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-4 sm:mx-0 md:grid-cols-2 xl:grid-cols-4 md:gap-6">
                    <div class="rounded-2xl border border-primary ">
                        <img src="{{ asset('images/market_place/buyer_art_new.svg') }}" alt="buyer" class="h-60 w-full">
                        <div class="flex justify-between items-center p-8 border-t border-secondary">
                            <h3 class=" font-semibold heading-8">I am a buyer</h3>
                            <input id="account_type" checked name="account_type" type="radio" value="Buyer"
                                class="radio radio-lg">
                        </div>
                    </div>
                    <div class="rounded-2xl border border-primary ">
                        <img src="{{ asset('images/market_place/seller_art.svg') }}" alt="buyer" class="h-60 w-full">
                        <div class="flex justify-between items-center p-8 border-t border-secondary">
                            <h3 class=" font-semibold heading-8">I am a seller</h3>
                            <input id="account_type" name="account_type" type="radio" value="Supplier"
                                class="radio radio-lg">
                        </div>
                    </div>
                    <div class="rounded-2xl border border-primary ">
                        <img src="{{ asset('images/market_place/roaster.svg') }}" alt="buyer" class="h-60 w-full">
                        <div class="flex justify-between items-center p-8 border-t border-secondary">
                            <h3 class=" font-semibold heading-8">I am a roaster</h3>
                            <input id="account_type" name="account_type" type="radio" value="Roaster"
                                class="radio radio-lg">
                        </div>
                    </div>
                    <div class="rounded-2xl border border-primary ">
                        <img src="{{ asset('images/market_place/cafe.svg') }}" alt="buyer" class="h-60 w-full">
                        <div class="flex justify-between items-center p-8 border-t border-secondary">
                            <h3 class=" font-semibold heading-8">I am a cafe owner</h3>
                            <input id="account_type" name="account_type" type="radio" value="Cafe"
                                class="radio radio-lg">
                        </div>
                    </div>
                </div>
                <div class="mt-20">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('languages') }}"
                                class="btn btn-outline-secondary mb-md-3 mt-6 m-2 text-primary capitalize btn-md  md:w-max px-20" style="border-width: medium;">
                                <i class="fa fa-angle-left" style="margin-right:15px;margin-left:15px;"></i>Previous Step
                        </a>
                        <button type="submit" class="mt-6 btn btn-primary btn-md m-2 md:w-max px-20 text-white capitalize ">
                            Next Step
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </section>

@endsection
