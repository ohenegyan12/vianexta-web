@extends('layouts.auth_layout ')
<!-- yeild title -->
@section('title', 'Recommend')

@section('content')
    <section class="py-12 sm:py-20 h-5/6">
        <div class="mx-auto max-w-screen-2xl p-10">
            <div class="text-3xl sm:text-4xl font-semibold text-primary mb-4">
                Recommend
            </div>
            <p class=" text-primary sm:text-md  mb-4 sm:mb-10 "> Recommend a farmer to join our
                team.
            </p>
            <form action="{{ route('saveRecommend') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div class="">
                        <label for="first_name" class="block text-sm md:text-md font-semibold text-primary ">Farmers
                            Name<sup>*</sup></label>
                        <div class="mt-1">
                            <input type="text" id="first_name" name="first_name" autocomplete="first_name" required
                                value="{{  old('first_name') }}"
                                class="input py-2 w-full border sm:border-2 focus:ring-0 border-primary">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong class='text-red-600'>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="">
                        <label for="email"
                            class="block text-sm md:text-md font-semibold text-primary">Email<sup>*</sup></label>
                        <div class="mt-1">
                            <input type="email" id="email" name="email" autocomplete="email" required
                                value="{{ old('email') }}"
                                class="input py-2 w-full border sm:border-2  border-primary">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong class='text-red-600'>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="">
                        <label for="phone_number" class="block text-sm md:text-md font-semibold text-primary">Farmers
                            Number<sup>*</sup></label>
                        <div class="mt-1">
                            <input type="tel" id="phone_number" required maxlength="15" name="phone_number"
                                autocomplete="phone_number"
                                value="{{old('phone_number') }}"
                                class="input py-2 w-full border sm:border-2  border-primary">
                            @if ($errors->has('phone_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong class='text-red-600'>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="">
                        <label for="recommenderEmail" class="block text-sm md:text-md font-semibold text-primary">Recommender's
                            Email<sup>*</sup></label>
                        <div class="mt-1">
                            <input type="email" id="recommenderEmail" name="recommenderEmail" autocomplete="email"
                                value="{{ old('recommenderEmail') }}" required
                                class="input py-2 w-full border sm:border-2  border-primary">
                            @if ($errors->has('recommenderEmail'))
                                <span class="invalid-feedback" role="alert">
                                    <strong class='text-red-600'>{{ $errors->first('recommenderEmail') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="password_confirmation"
                            class="block text-sm md:text-md font-semibold text-primary">Farmers
                            Description</label>
                        <div class="mt-1 ">
                            <textarea name="description" class="textarea textarea-bordered textarea-lg border-2 border-primary w-full " style="background:#ffff">{{old('description')}}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary  w-full mt-6">
                    Submit
                </button>
            </form>
        </div>

    </section>

@endsection