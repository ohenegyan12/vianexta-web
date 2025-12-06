@extends('layouts.new_home_layout')
@section('title', 'Home')

@push('css')
<link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">
@endpush

@section('content')
@include('includes.new_home.new_home_header')

 {{-- HERO SECTION --}}
    <section class="pt-5 bodyy" >
        <div class="container px-2 px-lg-3 pt-5">
            <h1 class="mb-5 text-center text-white">MEET THE TEAM</h1>
            <div class="row gx-4 gx-lg-5 align-items-center justify-content-lg-between justify-content-md-center justify-content-sm-center mt-5 pb-5">
                <div class="col-md-6 col-lg-4 col-xxl-4" style="margin-top: 170px;">
                    <div class="card bg-white">
                        <div class="card-body align-items-center">
                            <div style="width:100%; text-align:center">
                                <img class="items-center rounded-full img-fluid w-50 team-img " src="{{ asset('images/profiles/MATT.png') }}"
                        alt="matt">
                            </div>
                            <h5 class="text-center text-black fw-bold mt-3">Matthew Nam</h5>
                            <h6 class="text-center pos-title fw-bold">Founder & CEO</h6>
                            <p class="text-center text-grey">United States of America</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xxl-4" style="margin-top: 170px;">
                    <div class="card bg-white">
                        <div class="card-body">
                            <div style="width:100%; text-align:center">
                                <img class="items-center rounded-full img-fluid w-50 team-img" src="{{ asset('images/profiles/NIKISHA.png') }}"
                        alt="matt">
                            </div>
                            <h5 class="text-center text-black fw-bold mt-3">Nikisha
                                Bailey</h5>
                            <h6 class="text-center pos-title fw-bold">Co-Founder & COO</h6>
                            <p class="text-center text-grey">United States of America</p>
                        </div>
                    </div>
                </div>
                 <!-- <div class="col-md-6 col-lg-4 col-xxl-3" style="margin-top: 170px;">
                    <div class="card bg-white">
                        <div class="card-body">
                            <img class="items-center rounded-circle img-fluid w-100 team-img" src="{{ asset('images/profiles/rishi.png') }}"
                        alt="matt">
                            <h5 class="text-center text-black fw-bold mt-3">Rishi Abrol</h5>
                            <h6 class="text-center pos-title fw-bold">Technology Advisor</h6>
                            <p class="text-center text-grey">United States of America</p>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-6 col-lg-4 col-xxl-4" style="margin-top: 170px;">
                    <div class="card bg-white">
                        <div class="card-body">
                            <div style="width:100%; text-align:center">
                                <img class="items-center rounded-circle img-fluid w-50 team-img" src="{{ asset('images/profiles/STEFFEN.png') }}"
                        alt="matt">
                            </div>
                            <h5 class="text-center text-black fw-bold mt-3">Steffen Cornwell</h5>
                            <h6 class="text-center pos-title fw-bold">Backend Engineer</h6>
                            <p class="text-center text-grey">United States of America</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xxl-4" style="margin-top: 170px;">
                    <div class="card bg-white">
                        <div class="card-body">
                            <div style="width:100%; text-align:center">
                                <img class="items-center rounded-circle img-fluid w-50 team-img" src="{{ asset('images/profiles/CHUYAN.png') }}"
                            alt="matt">
                            </div>
                            <h5 class="text-center text-black fw-bold mt-3">Chuyan Chen</h5>
                            <h6 class="text-center pos-title fw-bold">Software Engineer</h6>
                            <p class="text-center text-grey">United States of America</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xxl-4" style="margin-top: 170px;">
                    <div class="card bg-white">
                        <div class="card-body">
                            <div style="width:100%; text-align:center">
                                <img class="items-center rounded-full img-fluid w-50 team-img" src="{{ asset('images/profiles/SOLOMON.png') }}"
                        alt="matt">
                            </div>
                            <h5 class="text-center text-black fw-bold mt-3">Solomon Darko</h5>
                            <h6 class="text-center pos-title fw-bold">Graphic Designer</h6>
                            <p class="text-center text-grey">Ghana</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xxl-4" style="margin-top: 170px;">
                    <div class="card bg-white">
                        <div class="card-body">
                            <div style="width:100%; text-align:center">
                                <img class="items-center rounded-full img-fluid w-50 team-img" src="{{ asset('images/profiles/SOPHIA.png') }}"
                        alt="matt">
                            </div>
                            <h5 class="text-center text-black fw-bold mt-3">Sophia Ye</h5>
                            <h6 class="text-center pos-title fw-bold">Frontend Designer</h6>
                            <p class="text-center text-grey">United States of America</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xxl-4" style="margin-top: 170px;">
                    <div class="card bg-white">
                        <div class="card-body">
                            <div style="width:100%; text-align:center">
                                <img class="items-center rounded-circle img-fluid w-50 team-img" src="{{ asset('images/profiles/HENRY.png') }}"
                        alt="matt">
                            </div>
                            <h5 class="text-center text-black fw-bold mt-3">Henry Miller</h5>
                            <h6 class="text-center pos-title fw-bold">Software Engineer</h6>
                            <p class="text-center text-grey">Ghana</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xxl-4" style="margin-top: 170px;">
                    <div class="card bg-white">
                        <div class="card-body">
                            <div style="width:100%; text-align:center">
                                <img class="items-center rounded-circle img-fluid w-50 team-img" src="{{ asset('images/profiles/REYA.png') }}"
                        alt="matt">
                            </div>
                            <h5 class="text-center text-black fw-bold mt-3">Reya Grace Badlang</h5>
                            <h6 class="text-center pos-title fw-bold">Customer Success</h6>
                            <p class="text-center text-grey">Phillipines</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xxl-4" style="margin-top: 170px;">
                    <div class="card bg-white">
                        <div class="card-body">
                            <div style="width:100%; text-align:center">
                                <img class="items-center rounded-circle img-fluid w-50 team-img" src="{{ asset('images/profiles/JEFFTER.png') }}"
                        alt="matt">
                            </div>
                            <h5 class="text-center text-black fw-bold mt-3">Jeffter Donkoh</h5>
                            <h6 class="text-center pos-title fw-bold">Graphic Designer</h6>
                            <p class="text-center text-grey">Ghana</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
 <script>
        window.addEventListener('scroll', function() {
            const header = document.getElementById('app_header');
            const yOffset = window.pageYOffset;

            if (yOffset > 100) {
                header.classList.add('navbar-scrolled');
            } else {
                header.classList.remove('navbar-scrolled');
            }
        });
</script>

<!-- Clare Chat Component -->
<script src="{{ asset('js/clare-component.js') }}"></script>

