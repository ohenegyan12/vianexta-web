@extends('layouts.auth_layout ')
<!-- yeild title -->
@section('title', 'Work With Us')


@section('content')
    <section class="bg-white h-2/3 ">
        <div class="mx-auto max-w-6xl lg:max-w-8xl px-4 py-4 sm:px-6 lg:px-8 sm:py-20 ">
            <div class="grid grid-col-12 sm:grid-cols-2 gap-8 md:gap-16 ">
                <div class=" xl:pl-24 2xl:pl-0" style="margin-top: 40px;">

                    <h1 class="text-3xl md:text-4xl font-semibold text-primary mb-4  sm:text-start sm:mb-10">
                        Work
                        with us </h1>
                    <p class=" text-primary sm:text-xl  sm:text-start"> Welcome to ViaNexta – where passion meets precision in the world of coffee. If you're enthusiastic about fostering relationships, fueled by a love for coffee, and dedicated to excellence, we might just be the perfect blend.

                    </p>
                    <p class="text-3xl sm:mb-10"></p>
                     <h1 class="text-3xl md:text-4xl font-semibold text-primary mb-4  sm:text-start sm:mb-7">
                       How to apply
                    </h1>
                    <p class=" text-primary sm:text-xl  sm:text-start sm:mb-5">
                        Ready to be a part of our coffee journey? 
                        Send us a message on our socials. Be sure to let us know why you're the perfect fit for ViaNexta  or how best we can work on a partnership.
                    </p>
                    
                     <p class=" text-primary sm:text-xl  sm:text-start">
                        ViaNexta is an equal opportunity employer. We celebrate diversity and are 
                        committed to creating an inclusive environment for all employees.
                    </p>

                </div>
                <div class=" ">
                      <img src="{{ asset('images/market_place/work_new.png') }}" alt="buyer" class="h-70 w-full">
                      <!-- <img src="{{ asset('images/market_place/under_work.svg') }}" alt="buyer" class="h-70 w-full"> -->

                </div>

            </div>
        </div>

    </section>
@endsection
