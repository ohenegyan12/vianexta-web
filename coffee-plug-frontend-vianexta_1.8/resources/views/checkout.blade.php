@extends('layouts.account_layout ')
@section('title', 'Checkout ')


@section('content')

    <main class="py-4 pb-40 sm:py-8 h-5/6">
        <div class="p-5 mx-auto max-w-screen-2xl">
            <section class="py-4 pb-40 sm:py-8 h-5/6">
                <div class="p-5 mx-auto max-w-screen-2xl">
                    <div class="flex flex-col items-center justify-between mb-5 xl:flex-row sm:mb-10">
                        <h1 class="mb-8 text-2xl font-semibold md:text-4xl text-secondary text-start md:mb-10 xl:mb-0">Secure
                            Checkout</h1>

                    </div>
                    <h1 class="mb-8 font-medium text-md md:text-xl text-secondary text-start ">Billing
                        details</h1>

                    <form action="{{ route('savePersonalData') }}" method="POST" class="pb-10 md:pb-20 ">
                        @csrf
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6">
                            <div class="">
                                <label for="full_name" class="block text-sm font-semibold md:text-md text-secondary">Full
                                    name
                                </label>
                                <div class="mt-1">
                                    <input type="text" id="full_name" name="full_name" autocomplete="full_name"
                                        value="{{ empty(session('full_name')) ? old('full_name') : session('full_name') }}"
                                        class="w-full border input sm:border-2 border-primary">
                                    @if ($errors->has('full_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong style="color: red;">{{ $errors->first('full_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="">
                                <label for="country" class="block text-sm font-semibold md:text-md text-secondary">Country
                                </label>
                                <div class="mt-1">
                                    <input type="text" id="country" name="country" autocomplete="country"
                                        value="{{ empty(session('country')) ? old('country') : session('country') }}"
                                        class="w-full border input sm:border-2 border-primary">
                                    @if ($errors->has('country'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong style="color: red;">{{ $errors->first('country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="">
                                <label for="email"
                                    class="block text-sm font-semibold md:text-md text-secondary">Email</label>
                                <div class="mt-1">
                                    <input type="text" id="email" name="email" autocomplete="email"
                                        value="{{ empty(session('email')) ? old('email') : session('email') }}"
                                        class="w-full border input sm:border-2 border-primary">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong style="color: red;">{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="">
                                <label for="zip_code" class="block text-sm font-semibold md:text-md text-secondary">Zip
                                    code</label>
                                <div class="mt-1">
                                    <input type="zip_code" id="zip_code" name="zip_code" autocomplete="zip_code"
                                        value="{{ empty(session('zip_code')) ? old('zip_code') : session('zip_code') }}"
                                        class="w-full border input sm:border-2 border-primary">
                                    @if ($errors->has('zip_code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong style="color: red;">{{ $errors->first('zip_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="">
                                <label for="phone_number"
                                    class="block text-sm font-semibold md:text-md text-secondary">Phone
                                </label>
                                <div class="mt-1">
                                    <input type="tel" id="phone_number" required maxlength="15" name="phone_number"
                                        autocomplete="phone_number"
                                        value="{{ empty(session('phone_number')) ? old('phone_number') : session('phone_number') }}"
                                        class="w-full border input sm:border-2 border-primary">
                                    @if ($errors->has('phone_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong style="color: red;">{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="">
                                <label for="city"
                                    class="block text-sm font-semibold md:text-md text-secondary">City</label>
                                <div class="mt-1">
                                    <input type="zip_code" id="city" name="city" autocomplete="confirm_zip_code"
                                        class="w-full border input sm:border-2 border-primary">
                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong style="color: red;">{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <hr class="w-full my-10 border md:my-20 border-secondary">
                        <div class="max-w-xl">
                            <fieldset class="my-4">
                                <legend class="mb-3 md:mb-6 text-secondary">Payment method</legend>
                                <div class="space-y-4 sm:flex sm:items-center sm:space-x-10 sm:space-y-0">
                                    <div class="flex items-center">
                                        <input id="credit-card" name="payment-type" type="radio" checked
                                            class="radio radio-primary">
                                        <label for="credit-card"
                                            class="block ml-3 text-sm font-semibold text-secondary">Credit
                                            card</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="paypal" name="payment-type" type="radio" class="radio">
                                        <img src={{ asset('images/paypal.svg') }} alt="paypal" class="h-5 ml-3">
                                    </div>

                                </div>
                                <div class="mt-5 md:mt-10">
                                    <label for="credit_card"
                                        class="block text-sm font-semibold md:text-md text-secondary">Credit card number
                                    </label>
                                    <div class="mt-1">
                                        <div class="flex items-center gap-x-6">
                                            <input type="text" id="credit_card" name="credit_card"
                                                autocomplete="credit_card" value=""
                                                class="w-full border input sm:border-2 border-primary">
                                        </div>

                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-5 gap-x-10 md:mt-10">
                                    <div class="flex items-center gap-x-6">
                                        <div class="">
                                            <label for="credit_card"
                                                class="block text-sm font-semibold md:text-md text-secondary">Expiration
                                            </label>
                                            <div class="mt-1">
                                                <div class="flex items-center gap-x-6">
                                                    <input type="text" id="credit_card" name="credit_card"
                                                        autocomplete="credit_card" value=""
                                                        class="w-full border input sm:border-2 border-primary"
                                                        placeholder="Month">
                                                </div>

                                            </div>
                                        </div>



                                        <div class="flex self-end gap-x-6">
                                            <input type="text" id="credit_card" name="credit_card"
                                                autocomplete="credit_card" value=""
                                                class="w-full border input sm:border-2 border-primary "
                                                placeholder="Year">
                                        </div>



                                    </div>
                                    <div class="w-full md:w-auto">
                                        <label for="credit_card"
                                            class="block text-sm font-semibold md:text-md text-secondary">Security Code
                                        </label>
                                        <div class="mt-1">
                                            <div class="flex items-center gap-x-6">
                                                <input type="text" id="credit_card" name="credit_card"
                                                    autocomplete="credit_card" value=""
                                                    class="w-full border input sm:border-2 border-primary">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <a type="submit" class="w-full px-20 mt-10 text-white capitalize btn btn-primary btn-md ">

                                Complete purchase


                            </a>
                        </div>
                    </form>




                </div>



            </section>



        </div>

    </main>

@endsection
