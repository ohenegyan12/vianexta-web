@extends('layouts.new_home_layout')
@section('title', 'Home')

<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/24342903.js"></script>
<!-- End of HubSpot Embed Code -->
@push('css')
<style>
    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus' viewBox='0 0 16 16'%3E%3Cpath d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/%3E%3C/svg%3E");
        transition: all 0.5s;
        background-color: #ffff;
    }

    .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-dash' viewBox='0 0 16 16'%3E%3Cpath d='M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z'/%3E%3C/svg%3E");
        background-color: #ffff;
    }
</style>
@endpush
@section('content')
@include('includes.new_home.new_home_header')
<div class="hero">
    <section class="hero-section px-1 pt-md-5 mt-md-5 mb-lg-0" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
        <div class="container">
            <div
                class="row align-items-center justify-content-md-center justify-content-sm-center mt-lg-5 py-5 pb-0 pb-lg-5">
                <div class="col-md-9 col-lg-6 align-items-center mt-lg-5">
                    <h1 class="fs-0 fw-bold text-primary text-center mb-4">We connect <span class="text-secondary">buyers
                            <br></span> directly to <span class="text-secondary">sellers</span>.
                    </h1>
                    @if(session('auth_user_tokin') ==null)
                    <div class="d-flex justify-content-center">
                        <a href="{{route('getStarted')}}" class="btn btn-primary"> Get started <i style="margin-left:20px;"
                                class="fa fa-chevron-right"></i></a>
                    </div>
                    @endif
                </div>
                {{-- <div class="col-12 hero-div-only-mobile d-flex align-items-center">  
                        <img class="mx-auto d-block d-lg-none img-fluid w-100"
                        src="{{ asset('images/hero_mobile.gif') }}" alt="We connect buyers ">
            </div> --}}
            <div class="col-12 hero-div-only-mobile">
                <img class="mx-auto img-fluid w-100"
                    src="{{ asset('images/mobile_hero.gif') }}" alt="We connect buyers ">
            </div>
        </div>
</div>
</section>

<section class="bottom-section mt-md-5 mt-lg-0 d-none d-md-block">
    <div class="w-100">
        <div class="row align-items-center justify-content-center text-center w-100 px-0 mx-0">
            <a href="#who" style="color:#07382F;text-decoration:none"
                class="col-md-3 col-sm-6 border border-primary border-2 p-3 d-flex align-items-center justify-content-center">
                <p class="my-auto fs-6 fw-bold">Who We Are</p>
            </a>
            <a href="#what" style="color:#07382F;text-decoration:none"
                class="col-md-3 col-sm-6 border border-primary border-2 p-3 d-flex align-items-center justify-content-center">
                <p class="my-auto fs-6 fw-bold">What We Do</p>
            </a>
            <a href="#why" style="color:#07382F;text-decoration:none"
                class="col-md-3 col-sm-6 border border-primary border-2 p-3 d-flex align-items-center justify-content-center">
                <p class="my-auto fs-6 fw-bold">Why We Do It</p>
            </a>
            <a href="#how" style="color:#07382F;text-decoration:none"
                class="col-md-3 col-sm-6 border border-primary border-2 p-3 d-flex align-items-center justify-content-center">
                <p class="my-auto fs-6 fw-bold">How We Do It</p>
            </a>

        </div>
    </div>
</section>
</div>


{{-- WHO WE ARE SECTION --}}
<section style="height:500px;" id="who">
    {{-- <img class="card-img-top mb-5 mb-md-0 w-100"
                        src="{{ asset('images/vid_thumb.jpg') }}" alt="..."> --}}
    <!-- <video  class="card-img-top mb-md-0 w-100" controls poster="{{ asset('images/vid_thumb.jpg') }}">
                            <source src="https://www.youtube.com/embed/xABqxa1OIvg?si=b0GQswfGkDS3Ze8p" type="video/mp4">
                            Your browser does not support the video tag. 
                             <iframe class="responsive-iframe" src="https://www.youtube.com/embed/xABqxa1OIvg?si=b0GQswfGkDS3Ze8p" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </video> -->
    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/rZIPrTT0cEA?si=ibybmbTacRyBkOlK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    <!-- <div class="youtubecontainer embed-responsive embed-responsive-16by9  mb-md-0 w-100" style="background: url({{ asset('images/vid_thumb.jpg') }}) top center no-repeat; background-size: cover;height:115px;">
                        <iframe  class="responsive-iframe" src="https://www.youtube.com/embed/rZIPrTT0cEA?si=uFr16PhirGcUrxMl" title="ViaNexta" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div> -->
</section>
<section style="background: #07382F;" class="py-4 px-2">
    <h5 class="fs-4 text-center text-white">Who We Are</h5>
    <h3 class="text-center fs-01 fw-bold" style="color: #D8501C;">Stewards of Efficiency & Speed</h3>
    <div class="md-half w-px-lg-5 d-flex mx-auto">
        <p class="fs-5 text-center px-lg-5 text-white mx-auto">We are problem solvers who love people,
            the environment, and efficient supply chains.</p>
    </div>
</section>

{{-- WHAT WE DO SECTION --}}
<section id="what" class="py-4" style="background-color: #FFFFFF" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
    <div class="container px-2 px-lg-3 my-3">
        <div class="trading gx-4 gx-lg-5 align-items-center px-md-5">
            <div class="col-lg-6">
                <div class="fs-4 bold mb-1 text-primary text-center text-lg-start">What We Do</div>
                <h1 class="fs-01 fw-bolder  text-secondary text-center text-lg-start">Trading as a Service</h1>
                <p class="text-primary fs-5 text-center text-lg-start">
                    <b>
                        Purposefully built technology that fills gaps and removes bottlenecks in the supply chain by bringing the buyer and seller closer together.
                    </b>
                </p>
                <p class="text-primary fs-5 text-center text-lg-start">
                    <b>
                        With ViaNexta, the coffee industry has its own marketplace where buyers find competitively priced goods, and sellers earn more money.
                    </b>
                </p>
            </div>
            <div class="col-lg-6"><img class="card-img-top mb-4 mb-md-5 mb-lg-0 img-fluid"
                    src="{{ asset('images/trading.svg') }}" alt="what we do" width="519"
                    height="682">
            </div>
        </div>
    </div>
</section>

{{-- FIND FARMERS SECTION --}}
<section id="why" class="py-5" style="background-color: #FCEFE3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
    <div class="container px-2 px-lg-3 my-3">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="">
                <h1 class="fs-01 fw-bold text-center " style="color: #07382F">Find a farmer <br class="d-md-none"> <span
                        class="text-decoration-underline" style="text-decoration-color: #D8501C !important">across
                        the</span> globe
                </h1>
            </div>
            <div class=""><img class="globe mx-auto d-block img-fluid"
                    src="{{ asset('images/farmer_across.svg') }}" alt="what we do">
            </div>
        </div>
    </div>
</section>



{{-- WHY DO IT SECTION --}}
<!-- <section id="why" class="py-5" style="background-color: #07382F" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
        <div class="container px-2 px-lg-3 my-3">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="">
                    <div class="fs-5 fw-medium mb-1 text-center text-white">Why we do it</div>

                </div>
                <h1 class="display-5 fw-bolder text-center text-white">The coffee supply chain has a
                    <span class="text-decoration-underline" style="text-decoration-color: #D8501C !important">large
                        number of middlemen</span> and intermediaries adding marginal value but <span
                        class="text-decoration-underline" style="text-decoration-color: #D8501C !important">capturing
                        a
                        large amount of
                        the end-price paid by consumers</span>
                </h1>
                <div class=""><img class="mx-auto d-block img-fluid"
                        src="{{ asset('images/map.svg') }}" alt="what we do">
                </div>
            </div>
        </div>
    </section> -->
<section class="py-lg-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
    <div class="container my-3">
        <div class="row gx-4 gx-lg-5 align-items-center px-lg-5">

            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="3000">
                        <img src="{{ asset('images/slider/slide1.jpg') }}" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <img src="{{ asset('images/slider/slide2.jpg') }}" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <img src="{{ asset('images/slider/slide3.jpg') }}" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</section>

{{-- BIG WIN --}}
<section id="big_win" class="py-4" style="background-color: #FFFFFF" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
    <div class="container px-2 px-lg-3 my-3">
        <div class="trading gx-4 gx-lg-5 align-items-center px-md-5">
            <div class="col-lg-6">
                <div class="fs-4 bold mb-1 text-primary text-center text-lg-start"></div>
                <h1 class="fs-01 fw-bolder  text-secondary text-center text-lg-start">Award Winning</h1>
                <p class="text-primary fs-5 text-center text-lg-start">
                    <!-- <b>
                        Award-Winning Innovation in Coffee Trade
                        We’re proud to introduce ViaNexta, the Product of the Year—a groundbreaking platform transforming the coffee trade. ViaNexta bridges the gap between farmers and buyers, ensuring transparency, fairness, and sustainability at every step.
                    </b> -->
                </p>
                <p class="text-primary fs-5 text-center text-lg-start">
                    <!-- <b>
                        By empowering farmers with direct market access, we’re creating better opportunities, strengthening supply chains, and redefining the future of coffee.

                        This achievement is possible because of your support. Thank you for believing in our mission. Together, we’re making every cup a true win-win for everyone.
                    </b> -->
                </p>
                <p class="text-primary fs-5 text-center text-lg-start">
                    <!-- <b>
                        Join the revolution. Experience ViaNexta today.
                    </b> -->
                </p>
            </div>
            <div class="col-lg-6 d-flex justify-content-center">
                <img class="card-img-top mb-4 mb-md-5 mb-lg-0 img-fluid"
                    src="{{ asset('images/big_win.png') }}" alt="what we do" width="519"
                    height="682">
            </div>
        </div>
    </div>
</section>

<section id="lap_background" style="background-color: #F8F4F4" class="py-lg-5 px-md-5 px-lg-0" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
    {{-- <div class="container px-1 px-lg-3 my-3 mx-0"> --}}
    <div class="row gx-4 gx-lg-5 align-items-center">
        <div class="px-0 w-100 px-md-5 px-lg-0">
            <img class="mx-auto d-block d-lg-none img-fluid px-3 px-md-5 px-lg-0"
                src="{{ asset('images/laptop_mobile.svg') }}" alt="what we do">
        </div>
    </div>
    {{-- </div> --}}
</section>

<section id="sdg_background" class="py-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
    <div class="container">
        <div class="row  align-items-center">
            <div class="">
                <!-- <img class="mx-auto d-block img-fluid"
                        src="{{ asset('images/unesco.svg') }}" alt="what we do"> -->
            </div>
        </div>
    </div>
</section>



{{-- HOW WE DO IT SECTION --}}
<section id="how" style="background-color: #F8F4F4" class="py-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
    <div class="container px-lg-3 my-3">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="">
                <div class="fs-4 mb-1 text-center text-secondary">How We Do It</div>

            </div>
            <!-- <h1 class="display-4 fw-bolder text-center text-primary>We use cutting edge technology
                    assisted by <span class="text-decoration-underline decoration-primary"> artificial
                        intelligence</span> and <span class="text-decoration-underline decoration-secondary">machine
                        learning</span> to remove bottle necks and waste from the coffee supply chain
                </h1> -->
            <p class="fs-01 fw-bold mb-1 text-center text-primary"><b>We use cutting edge technology assisted
                    by artificial intelligence and machine learning to remove bottle necks and waste from the coffee supply chain
                </b>
            </p>
        </div>
    </div>
</section>

{{-- PONTIS SECTION --}}
<section id="pontis" class="pt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 pt-lg-5 pe-lg-5">
                <div class="fs-01 mb-1 text-secondary pe-lg-5">
                    <h1>Meet <b>PONTIS &#8482;</b>,</br>
                        our inhouse Ai technology</h1>
                </div>
                <p class="fs-5 mb-5 fw-bold text-primary pe-lg-5">PONTIS is an advanced AI platform transforming the agricultural supply chain. By leveraging machine learning and predictive analytics, Pontis connects global demand with smallholder farmers, ensuring fair, dynamic pricing and efficient transactions. The platform offers real-time tracking and optimization, creating a more transparent and equitable marketplace for all.
                </p>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Inclusive Fintech

                            </button>

                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <b>Dynamic Pricing:</b>Leverages AI to implement dynamic pricing models, ensuring fair prices for both suppliers and buyers based on real-time market conditions.
                                </br></br><b>Instant Digital Payments:</b>Facilitates instant digital payments to suppliers in their ensuring timely and efficient financial transactions.
                                <!-- </br></br><b>Counterparty Risk Management:</b>Utilizes AI to assess and mitigate counterparty risk,ensuring secure and reliable transactions between farmers and buyers. -->
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Adaptive Environment
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <b>Counterparty Risk Management:</b>
                                Utilizes AI to assess and mitigate counterparty risk, ensuring secure and reliable transactions between suppliers and buyers.
                                </br></br>Using a digital supply chain, we are able to predict procurement cycles for each buyer.

                                <!-- <b>Crop Yield Prediction:</b> Employs AI to predict crop yields, helping farmers optimize their output and plan effectively for future production.
                                 Enhances soil diagnostics, scales regenerative agriculture, and streamlines supply chains.
                                 Enables smallholder farmers to improve yields, protect the environment, and adopt sustainable practices. -->
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                Climate Smart Technologies
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <b>Crop Disease Assessment & Recovery:</b> Uses AI to identify and manage crop diseases, providing timely interventions to protect crop health and improve recovery efforts.
                                Protects forests, land, and oceans, strengthens climate resilience, and enhanses sustainability for smallholder farmers, indigenous communities , and low-income populations.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img class="img-fluid w-100"
                    src="{{ asset('images/pontis.jpg') }}" alt="pontis AI">
            </div>
        </div>
    </div>
</section>

{{-- NEWSLETTER SECTION --}}
<section class="py-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
    <div class="container px-lg-3 my-3">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6 text-center text-md-start ">
                <div class="fs-01 fw-bolder mb-1" style="color: #07382F">Let’s stay connected</div>
                <p class="fs-5 fw-bold" style="color: #07382F">Sign up for our weekly
                    newsletter for stories from our farmers and their stock.
                </p>

            </div>

            <div class="col-md-6 ">
                <form class="flex flex-col gap-2 mb-3" action="{{ route('saveNewLetter') }}" method="POST">
                    @csrf
                    <input type="email" name="email" class=" mb-3 form-control text-center fw-bold"
                        placeholder="Email address" aria-label="newsletter email"
                        aria-describedby="button-addon2" style="background-color:#FCEFE3;" />
                    <button class="btn w-100 text-white" type="submit" id="button-addon2"
                        style="background-color: #D8501C">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- LEARN MORE SECTION --}}
<section class="py-1" style="background-color: #D8501C" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
    <div class="container px-2 px-lg-3 my-3">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <h1 class="fs-3 fw-bolder text-white">Learn more from our agents</h1>
            </div>

            <div class="col-md-6 text-end">
                <a href="https://calendar.google.com/calendar/u/0/appointments/schedules/AcZssZ0VzrtBRIYMPiHJG1DpCYxHXn-gRIUTuioGbMTO-KrsCZqGPPb7bEI1zolDgqg9Oc-FYXtBlKj3" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="26"
                        fill="#ffffff" class="bi bi-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                    </svg>
                </a>
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
            //header.classList.add('navbar-scrolled');
            // links.forEach(function(link) {
            //     link.style.color = '#fff';
            // });
        } else {
            //header.classList.remove('navbar-scrolled');
        }
    });
</script>