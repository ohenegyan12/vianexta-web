@extends('layouts.new_home_layout')
@section('title', 'Home')

<!-- Start of HubSpot Embed Code -->
{{-- <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/24342903.js"></script> --}}
<!-- End of HubSpot Embed Code -->

<!-- Start of ElevenLabs Conversational AI -->
{{-- <elevenlabs-convai agent-id="7wWTiqx8x2196Da4kjtB"></elevenlabs-convai> --}}
{{-- <script src="https://elevenlabs.io/convai-widget/index.js" async type="text/javascript"></script> --}}
<!-- End of ElevenLabs Conversational AI -->
<script type="text/javascript">
    (function(d, t) {
        var v = d.createElement(t), s = d.getElementsByTagName(t)[0];
        v.onload = function() {
          window.voiceflow.chat.load({
            verify: { projectID: '683d80a29ea212a7c310cc9f' },
            url: 'https://general-runtime.voiceflow.com',
            versionID: 'production',
            voice: {
              url: "https://runtime-api.voiceflow.com"
            }
          });
        }
        v.src = "https://cdn.voiceflow.com/widget-next/bundle.mjs"; v.type = "text/javascript"; s.parentNode.insertBefore(v, s);
    })(document, 'script');
  </script>
@push('css')
<link href="{{ asset('css/new_landing_page_css.css') }}" rel="stylesheet">
{{-- <style>
    /* ElevenLabs Widget Positioning */
    elevenlabs-convai {
        position: fixed !important;
        bottom: 20px !important;
        left: 20px !important;
        right: auto !important;
        z-index: 9999 !important;
    }
</style> --}}
@endpush

@section('content')
@include('includes.new_home.new_home_header')
    <section class="hero-section vh-100 d-flex align-items-center position-relative" style="padding-top: 80px;">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                
                <div class="col-md-10 col-lg-8 text-center mb-4">
                    <h1 class="display-5 fw-bold text-primary mb-4" style="letter-spacing: -0.02em; line-height: 1.2;">
                        Idea today.<br class="d-block d-md-none">
                        Brand tomorrow.<br class="d-block d-md-none">
                    </h1>
                    
                    <p class="fs-5 mb-4">
                        ViaNexta gives you instant access to roasters, warehouses,<br class="d-block d-md-none">
                        and ethical sourcing, so you can scale without friction.
                    </p>
                    
                    <p class="fs-6 mb-4 px-4 d-none d-md-block">
                        Launch a premium coffee brand with ease. ViaNexta connects you with certified roasters,
                        verified warehouses, and ethically sourced beans—so you can focus on growth while we handle the rest.
                    </p>
                    
                    @if(session('auth_user_tokin') ==null)
                    <div class="d-flex justify-content-center position-relative mb-4" style="z-index: 10;">
                        <a href="{{route('getStarted')}}" class="btn btn-success d-inline-flex align-items-center px-4 py-2" style="background-color: #14261C; border: none; border-radius: 25px;"> 
                            <span class="me-2 fs-5">Get Started Now</span>
                            <div class="d-inline-flex align-items-center justify-content-center" style="background-color: #FBB03B; width: 32px; height: 32px; border-radius: 50%;">
                                <i class="fas fa-arrow-right" style="font-size: 16px; color: #14261C;"></i>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>

                <div class="col-12 text-center mb-4">
                    <div class="d-flex justify-content-center align-items-center gap-4">
                        <img src="{{ asset('images/award.png') }}" alt="Product of the Year" class="img-fluid" style="height: 160px; @media (max-width: 768px) { height: 80px; }">
                    </div>
                </div>
                
                <div class="col-12 position-relative floating-animation d-flex justify-content-center align-items-center" style="z-index: 1;">
                    <img class="img-fluid" src="{{ asset('images/mobile_hero.gif') }}" alt="We connect buyers" style="max-height: 70vh; @media (max-width: 768px) { max-height: 90vh; } object-fit: cover; object-position: center; display: block; margin: 0 auto;">
                </div>
            </div>
        </div>
    </section>

<section id="who" class="min-vh-100 d-flex align-items-center py-5" style="background-color: #14261C;">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="display-4 fw-bold mb-2">
                <span class="text-white">Why Brands Choose</span>
                <span style="color: #FBB03B;">ViaNexta</span>
            </h2>
            <p class="text-white fs-6 mb-4">
                Freshness, quality, and trust define your brand.<br>
                ViaNexta ensures every bag of coffee reflects your high standards with:
            </p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Mobile layout: 2x2 grid -->
            <div class="col-6 col-lg-3">
                <div class="feature-card h-100" style="background-color: #E8F3D6; border-radius: 20px; position: relative; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); min-height: 320px;">
                    <div class="card-body p-3 p-lg-5 d-flex flex-column justify-content-between" style="position: relative; z-index: 2;">
                        <div class="icon-wrapper mb-3 mb-lg-5 d-flex align-items-center">
                            <img src="{{ asset('images/icon1.svg') }}" alt="Certified Roasters" class="feature-icon" style="width: 48px; height: 48px; @media (min-width: 992px) { width: 80px; height: 80px; }">
                        </div>
                        <div>
                            <h4 class="fs-5 fs-lg-2 fw-bold text-primary mb-2 mb-lg-4" style="line-height: 1.2;">Certified Roasters</h4>
                            <p class="text-primary mb-0" style="font-size: 0.9rem; @media (min-width: 992px) { font-size: 1.25rem; line-height: 1.6; }">Industry experts ensuring consistency & quality</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-lg-3">
                <div class="feature-card h-100" style="background-color: #E8F3D6; border-radius: 20px; position: relative; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); min-height: 320px;">
                    <div class="card-body p-3 p-lg-5 d-flex flex-column justify-content-between" style="position: relative; z-index: 2;">
                        <div class="icon-wrapper mb-3 mb-lg-5 d-flex align-items-center">
                            <img src="{{ asset('images/icon2.svg') }}" alt="Ethically Sourced Beans" class="feature-icon" style="width: 48px; height: 48px; @media (min-width: 992px) { width: 80px; height: 80px; }">
                        </div>
                        <div>
                            <h4 class="fs-5 fs-lg-2 fw-bold text-primary mb-2 mb-lg-4" style="line-height: 1.2;">Ethically Sourced Beans</h4>
                            <p class="text-primary mb-0" style="font-size: 0.9rem; @media (min-width: 992px) { font-size: 1.25rem; line-height: 1.6; }">Direct partnerships with top-tier farms</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-lg-3">
                <div class="feature-card h-100" style="background-color: #E8F3D6; border-radius: 20px; position: relative; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); min-height: 320px;">
                    <div class="card-body p-3 p-lg-5 d-flex flex-column justify-content-between" style="position: relative; z-index: 2;">
                        <div class="icon-wrapper mb-3 mb-lg-5 d-flex align-items-center">
                            <img src="{{ asset('images/icon3.svg') }}" alt="Verified Warehouses" class="feature-icon" style="width: 48px; height: 48px; @media (min-width: 992px) { width: 80px; height: 80px; }">
                        </div>
                        <div>
                            <h4 class="fs-5 fs-lg-2 fw-bold text-primary mb-2 mb-lg-4" style="line-height: 1.2;">Verified Warehouses</h4>
                            <p class="text-primary mb-0" style="font-size: 0.9rem; @media (min-width: 992px) { font-size: 1.25rem; line-height: 1.6; }">Fast & reliable order fulfillment</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-lg-3">
                <div class="feature-card h-100" style="background-color: #E8F3D6; border-radius: 20px; position: relative; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); min-height: 320px;">
                    <div class="card-body p-3 p-lg-5 d-flex flex-column justify-content-between" style="position: relative; z-index: 2;">
                        <div class="icon-wrapper mb-3 mb-lg-5 d-flex align-items-center">
                            <img src="{{ asset('images/icon4.svg') }}" alt="Premium Packaging" class="feature-icon" style="width: 48px; height: 48px; @media (min-width: 992px) { width: 80px; height: 80px; }">
                        </div>
                        <div>
                            <h4 class="fs-5 fs-lg-2 fw-bold text-primary mb-2 mb-lg-4" style="line-height: 1.2;">Premium Packaging & Customization</h4>
                            <p class="text-primary mb-0" style="font-size: 0.9rem; @media (min-width: 992px) { font-size: 1.25rem; line-height: 1.6; }">Your brand, your design, your way</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="text-white fs-6 d-none d-lg-block">Unlike generic white-label solutions, ViaNexta gives you full control while handling the roasting,<br>packing, and fulfillment with unmatched precision.</p>
        </div>
    </div>
</section>
{{-- HOW IT WORKS SECTION --}}
<section id="what" class="min-vh-100 position-relative overflow-hidden py-5">
    <div class="container position-relative h-100">
        <!-- Title Section -->
        <div class="row justify-content-center mb-5">
            <div class="col-12 text-center position-relative">
                <img src="{{ asset('images/how_it_works_back.png') }}" alt="How It Works Background" class="title-background position-absolute w-100 h-100" style="top: -20px; left: 0; z-index: 1; object-fit: contain;">
                <div class="position-relative" style="z-index: 2;">
                    <h2 class="display-3 display-lg-2 fw-bold mb-3" style="color: #14261C;">How It Works</h2>
                    <div class="subtitle-wrapper position-relative">
                        <h3 class="fs-3 fs-lg-2" style="color: #14261C;">Launch Your Coffee Brand in <span style="color: #FBB03B; position: relative;">3 Simple Steps
                            <img src="{{ asset('images/underline.png') }}" alt="underline" class="position-absolute" style="bottom: -15px; left: 0; width: 100%;"></span></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="row align-items-center g-4">

            <!-- On mobile, image comes first -->
            {{-- <div class="col-12 d-lg-none">
                <div class="laptop-preview text-center">
                    <img src="{{ asset('images/laptop.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif active" data-step="0" style="max-width: 100%; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));">
                    <img src="{{ asset('images/laptop2.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif" data-step="1" style="max-width: 100%; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1)); position: absolute; top: 0; left: 0; opacity: 0;">
                    <img src="{{ asset('images/laptop3.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif" data-step="2" style="max-width: 100%; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1)); position: absolute; top: 0; left: 0; opacity: 0;">
                </div>
            </div> --}}
            <!-- Step Content -->
            <div class="col-12 col-lg-12">
                <div id="stepsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-indicators" style="bottom: -50px;">
                        <button type="button" data-bs-target="#stepsCarousel" data-bs-slide-to="0" class="active" style="background-color: #14261C;"></button>
                        <button type="button" data-bs-target="#stepsCarousel" data-bs-slide-to="1" style="background-color: #14261C;"></button>
                        <button type="button" data-bs-target="#stepsCarousel" data-bs-slide-to="2" style="background-color: #14261C;"></button>
                    </div>
                    
                    <div class="carousel-inner text-center text-lg-start">
                        <!-- Step 1 -->
                    <div class="carousel-item active">
                        <div class="step-content">
                            <div class="row"> 
                                <div class="col-12 d-lg-none">
                                    <div class="laptop-preview text-center">
                                        <img src="{{ asset('images/laptop.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif active" data-step="0" style="max-width: 100%; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));">
                                        {{-- <img src="{{ asset('images/laptop2.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif" data-step="1" style="max-width: 100%; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1)); position: absolute; top: 0; left: 0; opacity: 0;"> --}}
                                        {{-- <img src="{{ asset('images/laptop3.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif" data-step="2" style="max-width: 100%; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1)); position: absolute; top: 0; left: 0; opacity: 0;"> --}}
                                    </div>
                                </div>
                                <div class="col-12 col-lg-5">
                                    <div class="step-number mb-2 mb-lg-3" style="color: #FBB03B; font-size: 80px; font-size: lg-120px; font-weight: 700; line-height: 1; opacity: 0.3;">01</div>
                                    <h4 class="fs-3 fs-lg-2 fw-bold mb-3" style="color: #14261C;">Select Your Coffee Bean</h4>
                                    <ul class="list-unstyled fs-6 fs-lg-5" style="color: #14261C;">
                                        <li class="mb-3 d-flex align-items-start">
                                            <span class="me-3 mt-2" style="min-width: 8px; height: 8px; background-color: #14261C; border-radius: 50%; display: inline-block;"></span>
                                            <span>Browse and select premium, ethically sourced coffee beans,<br>(roasted, green, or wholesale)</span>
                                        </li>
                                        <li class="d-flex align-items-start">
                                            <span class="me-3 mt-2" style="min-width: 8px; height: 8px; background-color: #14261C; border-radius: 50%; display: inline-block;"></span>
                                            <span>Easily filter by country, ratings, and more to find your perfect beans.</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-7 d-none d-lg-block">
                                    <div class="laptop-preview position-relative" style="margin-left: -50px;">
                                        <img src="{{ asset('images/laptop.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif active" data-step="0" style="transform: perspective(1000px) rotateY(-10deg); filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- Step 2 -->
                        <div class="carousel-item">
                            <div class="step-content">
                                <div class="row"> 
                                    <div class="col-12 d-lg-none">
                                        <div class="laptop-preview text-center">
                                            <img src="{{ asset('images/laptop2.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif" data-step="1" style="max-width: 100%; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-5">
                                        <div class="step-number mb-2 mb-lg-3" style="color: #FBB03B; font-size: 80px; font-size: lg-120px; font-weight: 700; line-height: 1; opacity: 0.3;">02</div>
                                        <h4 class="fs-3 fs-lg-2 fw-bold mb-3" style="color: #14261C;">Select Your Grind & Roast Type</h4>
                                        <ul class="list-unstyled fs-6 fs-lg-5" style="color: #14261C;">
                                            <li class="mb-3 d-flex align-items-start">
                                                <span class="me-3 mt-2" style="min-width: 8px; height: 8px; background-color: #14261C; border-radius: 50%; display: inline-block;"></span>
                                                <span>Choose your preferred roast — light, medium, dark, or custom.</span>
                                            </li>
                                            <li class="d-flex align-items-start">
                                                <span class="me-3 mt-2" style="min-width: 8px; height: 8px; background-color: #14261C; border-radius: 50%; display: inline-block;"></span>
                                                <span>Select your grind size — whole bean, coarse, medium, fine, or espresso-ready.</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-7 d-none d-lg-block">
                                        <div class="laptop-preview position-relative" style="margin-left: -50px;">
                                            <img src="{{ asset('images/laptop2.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif" data-step="1" style="transform: perspective(1000px) rotateY(-10deg); filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="carousel-item">
                            <div class="step-content">
                                <div class="row"> 
                                    <div class="col-12 d-lg-none">
                                        <div class="laptop-preview text-center">
                                            <img src="{{ asset('images/laptop3.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif" data-step="2" style="max-width: 100%; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-5">
                                        <div class="step-number mb-2 mb-lg-3" style="color: #FBB03B; font-size: 80px; font-size: lg-120px; font-weight: 700; line-height: 1; opacity: 0.3;">03</div>
                                        <h4 class="fs-3 fs-lg-2 fw-bold mb-3" style="color: #14261C;">Customize Your Brand</h4>
                                        <ul class="list-unstyled fs-6 fs-lg-5" style="color: #14261C;">
                                            <li class="mb-3 d-flex align-items-start">
                                                <span class="me-3 mt-2" style="min-width: 8px; height: 8px; background-color: #14261C; border-radius: 50%; display: inline-block;"></span>
                                                <span>Upload your logo & brand assets</span>
                                            </li>
                                            <li class="d-flex align-items-start">
                                                <span class="me-3 mt-2" style="min-width: 8px; height: 8px; background-color: #14261C; border-radius: 50%; display: inline-block;"></span>
                                                <span>Preview real-time renders before finalizing</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-7 d-none d-lg-block">
                                        <div class="laptop-preview position-relative" style="margin-left: -50px;">
                                            <img src="{{ asset('images/laptop3.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif" data-step="2" style="transform: perspective(1000px) rotateY(-10deg); filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop Image -->
            {{-- <div class="col-lg-7 d-none d-lg-block">
                <div class="laptop-preview position-relative" style="margin-left: -50px;">
                    <img src="{{ asset('images/laptop.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif active" data-step="0" style="transform: perspective(1000px) rotateY(-10deg); filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));">
                    <img src="{{ asset('images/laptop2.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif" data-step="1" style="transform: perspective(1000px) rotateY(-10deg); filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1)); position: absolute; top: 0; left: 0; opacity: 0;">
                    <img src="{{ asset('images/laptop3.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif" data-step="2" style="transform: perspective(1000px) rotateY(-10deg); filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1)); position: absolute; top: 0; left: 0; opacity: 0;">
                </div>
            </div> --}}

            <!-- Mobile Image -->
            {{-- <div class="col-12 d-lg-none">
                <div class="laptop-preview text-center">
                    <img src="{{ asset('images/laptop.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif active" data-step="0" style="max-width: 100%; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));">
                    <img src="{{ asset('images/laptop2.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif" data-step="1" style="max-width: 100%; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1)); position: absolute; top: 0; left: 0; opacity: 0;">
                    <img src="{{ asset('images/laptop3.gif') }}" alt="Platform Preview" class="img-fluid laptop-gif" data-step="2" style="max-width: 100%; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1)); position: absolute; top: 0; left: 0; opacity: 0;">
                </div>
            </div> --}}
        </div>
    </div>
</section>
{{-- FIND FARMERS SECTION --}}
<section id="why_trust" class="position-relative overflow-hidden py-5">
    <div class="container py-4">
        <!-- Trust Section Title -->
        <div class="row justify-content-center text-center mb-5">
            <div class="col-12">
                <h2 class="display-2 fw-bold mb-4" style="color: #14261C;">Why Brands<br>Trust ViaNexta</h2>
            </div>
        </div>

        <!-- Reviews Container -->
        <div class="reviews-container">
            <!-- First Row - Scrolling Left -->
            <div class="review-row scroll-left">
                <div class="review-card gradient-1">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="danielraezorsharp">
                        </div>
                        <div class="review-user">
                            <h5>danielraezorsharp</h5>
                        </div>
                    </div>
                    <p>Ooouuu!!! This is TOP TIER!!!</p>
                </div>
                <div class="review-card gradient-2">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="mrwld101">
                        </div>
                        <div class="review-user">
                            <h5>mrwld101</h5>
                        </div>
                    </div>
                    <p>That's the way you do it! Big things</p>
                </div>
                <div class="review-card gradient-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/men/3.jpg" alt="rachboogie215">
                        </div>
                        <div class="review-user">
                            <h5>rachboogie215</h5>
                        </div>
                    </div>
                    <p>Love this! Yes</p>
                </div>
                <div class="review-card gradient-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="angelicmolos">
                        </div>
                        <div class="review-user">
                            <h5>angelicmolos</h5>
                        </div>
                    </div>
                    <p>OMG!!!</p>
                </div>
                <div class="review-card gradient-5">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/men/5.jpg" alt="bean2beancoffeeco">
                        </div>
                        <div class="review-user">
                            <h5>bean2beancoffeeco</h5>
                        </div>
                    </div>
                    <p>It's so goooooddd</p>
                </div>
            </div>

            <!-- Second Row - Scrolling Right -->
            <div class="review-row scroll-right">
                <div class="review-card gradient-1">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/women/6.jpg" alt="coffeelover22">
                        </div>
                        <div class="review-user">
                            <h5>coffeelover22</h5>
                        </div>
                    </div>
                    <p>Amazing quality and service! 🔥</p>
                </div>
                <div class="review-card gradient-2">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/men/7.jpg" alt="brewmaster">
                        </div>
                        <div class="review-user">
                            <h5>brewmaster</h5>
                        </div>
                    </div>
                    <p>Best decision for our brand!</p>
                </div>
                <div class="review-card gradient-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/women/8.jpg" alt="beanscene">
                        </div>
                        <div class="review-user">
                            <h5>beanscene</h5>
                        </div>
                    </div>
                    <p>Exceptional fulfillment speed</p>
                </div>
                <div class="review-card gradient-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/men/9.jpg" alt="roastedperfection">
                        </div>
                        <div class="review-user">
                            <h5>roastedperfection</h5>
                        </div>
                    </div>
                    <p>Quality never disappoints</p>
                </div>
                <div class="review-card gradient-5">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/women/10.jpg" alt="how.to.build.a.coffee">
                        </div>
                        <div class="review-user">
                            <h5>how.to.build.a.coffee</h5>
                        </div>
                    </div>
                    <p>This is amazing!</p>
                </div>
            </div>

            <!-- Third Row - Scrolling Left -->
            <div class="review-row scroll-left">
                <div class="review-card gradient-1">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/men/11.jpg" alt="mr.building">
                        </div>
                        <div class="review-user">
                            <h5>mr.building</h5>
                        </div>
                    </div>
                    <p>Love this!</p>
                </div>
                <div class="review-card gradient-2">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/women/12.jpg" alt="bring.my.coffee">
                        </div>
                        <div class="review-user">
                            <h5>bring.my.coffee</h5>
                        </div>
                    </div>
                    <p>Looking forward to this!</p>
                </div>
                <div class="review-card gradient-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/men/13.jpg" alt="baristaandbrewco">
                        </div>
                        <div class="review-user">
                            <h5>baristaandbrewco</h5>
                        </div>
                    </div>
                    <p>This is exactly what I was looking for!</p>
                </div>
                <div class="review-card gradient-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/women/14.jpg" alt="mr.roasting">
                        </div>
                        <div class="review-user">
                            <h5>mr.roasting</h5>
                        </div>
                    </div>
                    <p>Wow amazing work!</p>
                </div>
                <div class="review-card gradient-5">
                    <div class="d-flex align-items-center mb-3">
                        <div class="review-avatar me-3">
                            <img src="https://randomuser.me/api/portraits/men/15.jpg" alt="mr.coffee.plug">
                        </div>
                        <div class="review-user">
                            <h5>mr.coffee.plug</h5>
                        </div>
                    </div>
                    <p>Love what you guys are doing!</p>
                </div>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="text-center mt-5">
            <a href="{{route('getStarted')}}" class="btn btn-dark btn-lg px-5 py-3" style="background-color: #14261C; border-radius: 50px; font-size: 1.25rem;">
                Get Started Now
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- BIG WIN --}}
<section id="big_win" class="min-vh-100 py-5" style="background-color: #FFFFFF">
    <div class="container py-4">
        <!-- Benefits Cards -->
        <div class="row justify-content-center text-center mb-4">
            <div class="col-12">
                <h2 class="display-4 fw-bold mb-4" style="color: #14261C;">Built for brands that demand excellence:</h2>
            </div>
        </div>
        
        <div class="row justify-content-center g-4 mb-5">
            <!-- Better Than Traditional Card -->
            <div class="col-md-4">
                <div class="card border-0 h-100" style="background-color: #14261C; border-radius: 20px; padding: 2rem;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h3 class="text-white fs-4 fw-bold mb-0">Better Than Traditional Private Label Solutions</h3>
                            <span class="ms-2">
                                <img src="{{ asset('images/icon5.svg') }}" alt="asterisk" style="width: 24px; height: 24px; filter: invert(71%) sepia(74%) saturate(402%) hue-rotate(358deg) brightness(95%) contrast(92%);">
                            </span>
                        </div>
                        <p class="text-white mb-0">Full control over branding & customization</p>
                    </div>
                </div>
            </div>

            <!-- Scalable Fulfillment Card -->
            <div class="col-md-4">
                <div class="card border-0 h-100" style="background-color: #14261C; border-radius: 20px; padding: 2rem;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h3 class="text-white fs-4 fw-bold mb-0">Scalable Fulfillment</h3>
                            <span class="ms-2">
                                <img src="{{ asset('images/icon5.svg') }}" alt="asterisk" style="width: 24px; height: 24px; filter: invert(71%) sepia(74%) saturate(402%) hue-rotate(358deg) brightness(95%) contrast(92%);">
                            </span>
                        </div>
                        <p class="text-white mb-0">Grow your business without logistical headaches</p>
                    </div>
                </div>
            </div>

            <!-- Consistent Quality Card -->
            <div class="col-md-4">
                <div class="card border-0 h-100" style="background-color: #14261C; border-radius: 20px; padding: 2rem;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h3 class="text-white fs-4 fw-bold mb-0">Consistent Quality</h3>
                            <span class="ms-2">
                                <img src="{{ asset('images/icon5.svg') }}" alt="asterisk" style="width: 24px; height: 24px; filter: invert(71%) sepia(74%) saturate(402%) hue-rotate(358deg) brightness(95%) contrast(92%);">
                            </span>
                        </div>
                        <p class="text-white mb-0">Every order meets the highest standards</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certified Partners Section -->
        <div class="row align-items-center mt-4 gy-5">
            <!-- Coffee Bag Image -->
            <div class="col-lg-5 mb-4 mb-lg-0 text-center text-lg-start">
                <div class="position-relative">
                    <img src="{{ asset('images/bags.gif') }}" alt="Coffee Bag" class="img-fluid" style="max-height: 450px; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.15));">
                </div>
            </div>

            <!-- Collapsible Items -->
            <div class="col-lg-7">
                <div class="text-center text-lg-start mb-4">
                    <h2 class="fs-2 fw-bold mb-3" style="color: #14261C;">Certified Partners & Reliable Fulfillment</h2>
                    <p class="fs-4 mb-4" style="color: #14261C;">Trust is earned. Here's how we deliver:</p>
                </div>

                <div class="accordion" id="trustAccordion">
                    <!-- Industry Certified Roasters -->
                    <div class="accordion-item border-0 mb-3" style="background-color: #E8F3D6; border-radius: 15px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#roasters" style="background-color: #E8F3D6; border-radius: 15px;">
                                <span class="fs-5" style="color: #14261C;">Industry-Certified Roasters</span>
                            </button>
                        </h2>
                        <div id="roasters" class="accordion-collapse collapse" data-bs-parent="#trustAccordion">
                            <div class="accordion-body py-3">
                                <p class="fs-5 mb-0" style="color: #14261C;">Our network of certified roasters ensures consistent quality and exceptional taste in every batch.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Verified Warehouses -->
                    <div class="accordion-item border-0 mb-3" style="background-color: #E8F3D6; border-radius: 15px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#warehouses" style="background-color: #E8F3D6; border-radius: 15px;">
                                <span class="fs-5" style="color: #14261C;">Verified Warehouses</span>
                            </button>
                        </h2>
                        <div id="warehouses" class="accordion-collapse collapse" data-bs-parent="#trustAccordion">
                            <div class="accordion-body py-3">
                                <p class="fs-5 mb-0" style="color: #14261C;">Strategic warehouse locations ensure fast and reliable fulfillment for your orders.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sustainably & Ethically Sourced -->
                    <div class="accordion-item border-0 mb-3" style="background-color: #E8F3D6; border-radius: 15px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#sustainable" style="background-color: #E8F3D6; border-radius: 15px;">
                                <span class="fs-5" style="color: #14261C;">Sustainably & Ethically Sourced</span>
                            </button>
                        </h2>
                        <div id="sustainable" class="accordion-collapse collapse" data-bs-parent="#trustAccordion">
                            <div class="accordion-body py-3">
                                <p class="fs-5 mb-0" style="color: #14261C;">We partner with farms that prioritize sustainable practices and fair compensation for workers.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Fast, Trackable Shipping -->
                    <div class="accordion-item border-0 mb-3" style="background-color: #E8F3D6; border-radius: 15px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#shipping" style="background-color: #E8F3D6; border-radius: 15px;">
                                <span class="fs-5" style="color: #14261C;">Fast, Trackable Shipping</span>
                            </button>
                        </h2>
                        <div id="shipping" class="accordion-collapse collapse" data-bs-parent="#trustAccordion">
                            <div class="accordion-body py-3">
                                <p class="fs-5 mb-0" style="color: #14261C;">Real-time tracking and efficient shipping ensure your coffee arrives fresh and on time.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- GET STARTED SECTION --}}
<section id="get_started" class="min-vh-100 py-5" style="background-color: #14261C;">
    <div class="container py-4">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6 text-center text-lg-start">
                <h2 class="display-3 fw-bold text-white mb-4">Get Started Today</h2>
                <div class="mb-4">
                    <h3 class="display-5 fw-bold text-white mb-3" style="letter-spacing: -0.02em;">Your Brand. Your Coffee.</h3>
                    <h3 class="display-5 fw-bold text-white mb-4" style="letter-spacing: -0.02em;">Backed by Certified Roasters & Warehouses.</h3>
                </div>
                <p class="fs-4 text-white mb-5">Launch your premium coffee brand today, without worrying about sourcing, roasting, or fulfillment.</p>
                
                <div class="d-flex justify-content-center justify-content-lg-start">
                    <a href="{{route('getStarted')}}" class="btn btn-outline-light d-inline-flex align-items-center px-4 py-3" style="border-radius: 50px; border-width: 2px;">
                        <span class="fs-5 me-3">Get Started Now</span>
                        <div class="d-inline-flex align-items-center justify-content-center" style="background-color: #FBB03B; width: 32px; height: 32px; border-radius: 50%;">
                            <i class="fas fa-arrow-right" style="font-size: 16px; color: #14261C;"></i>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="position-relative" style="border-radius: 24px; overflow: hidden;">
                    <img src="{{ asset('images/warehouseworkers.png') }}" alt="Warehouse Workers" class="img-fluid w-100" style="border-radius: 24px; object-fit: cover; aspect-ratio: 16/9;">
                </div>
            </div>
        </div>
    </div> 
</section>

@push('scripts')

<script>



    // Review data
    const reviews = [
        {
            name: 'danielraezorsharp',
            avatar: 'https://randomuser.me/api/portraits/men/1.jpg',
            text: 'Ooouuu!!! This is TOP TIER!!!',
            gradient: 'gradient-1'
        },
        {
            name: 'mrwld101', 
            avatar: 'https://randomuser.me/api/portraits/women/2.jpg',
            text: 'That's the way you do it! Big things',
            gradient: 'gradient-2'
        },
        {
            name: 'rachboogie215',
            avatar: 'https://randomuser.me/api/portraits/men/3.jpg',
            text: 'Love this! Yes',
            gradient: 'gradient-3'
        },
        {
            name: 'angelicmolos',
            avatar: 'https://randomuser.me/api/portraits/women/4.jpg',
            text: 'OMG!!!',
            gradient: 'gradient-4'
        },
        {
            name: 'bean2beancoffeeco',
            avatar: 'https://randomuser.me/api/portraits/men/5.jpg',
            text: 'It's so goooooddd',
            gradient: 'gradient-5'
        },
        {
            name: 'coffeelover22',
            avatar: 'https://randomuser.me/api/portraits/women/6.jpg',
            text: 'Amazing quality and service! 🔥',
            gradient: 'gradient-1'
        },
        {
            name: 'brewmaster',
            avatar: 'https://randomuser.me/api/portraits/men/7.jpg',
            text: 'Best decision for our brand!',
            gradient: 'gradient-2'
        },
        {
            name: 'beanscene',
            avatar: 'https://randomuser.me/api/portraits/women/8.jpg',
            text: 'Exceptional fulfillment speed',
            gradient: 'gradient-3'
        },
        {
            name: 'roastedperfection',
            avatar: 'https://randomuser.me/api/portraits/men/9.jpg',
            text: 'Quality never disappoints',
            gradient: 'gradient-4'
        },
        {
            name: 'how.to.build.a.coffee',
            avatar: 'https://randomuser.me/api/portraits/women/10.jpg',
            text: 'This is amazing!',
            gradient: 'gradient-5'
        },
        {
            name: 'mr.building',
            avatar: 'https://randomuser.me/api/portraits/men/11.jpg',
            text: 'Love this!',
            gradient: 'gradient-1'
        },
        {
            name: 'bring.my.coffee',
            avatar: 'https://randomuser.me/api/portraits/women/12.jpg',
            text: 'Looking forward to this!',
            gradient: 'gradient-2'
        },
        {
            name: 'baristaandbrewco',
            avatar: 'https://randomuser.me/api/portraits/men/13.jpg',
            text: 'This is exactly what I was looking for!',
            gradient: 'gradient-3'
        },
        {
            name: 'mr.roasting',
            avatar: 'https://randomuser.me/api/portraits/women/14.jpg',
            text: 'Wow amazing work!',
            gradient: 'gradient-4'
        },
        {
            name: 'mr.coffee.plug',
            avatar: 'https://randomuser.me/api/portraits/men/15.jpg',
            text: 'Love what you guys are doing!',
            gradient: 'gradient-5'
        }
    ];

    // Function to create a review card
    function createReviewCard(review) {
        return `
            <div class="review-card ${review.gradient}">
                <div class="d-flex align-items-center mb-3">
                    <div class="review-avatar me-3">
                        <img src="${review.avatar}" alt="${review.name}">
                    </div>
                    <div class="review-user">
                        <h5>${review.name}</h5>
                    </div>
                </div>
                <p>${review.text}</p>
            </div>
        `;
    }

    // Function to populate a row with reviews
    function populateReviewRow(rowId, startIndex, count) {
        const row = document.getElementById(rowId);
        if (!row) return; // Skip if row doesn't exist
        
        let html = '';
        
        // Add original reviews
        for (let i = 0; i < count; i++) {
            const reviewIndex = (startIndex + i) % reviews.length;
            html += createReviewCard(reviews[reviewIndex]);
        }
        
        // Add duplicate reviews for smooth infinite scroll
        for (let i = 0; i < count; i++) {
            const reviewIndex = (startIndex + i) % reviews.length;
            html += createReviewCard(reviews[reviewIndex]);
        }
        
        row.innerHTML = html;
    }

    // Initialize reviews when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Wait a short delay to ensure all elements are rendered
        setTimeout(function() {
            // Populate each row with different starting points
            populateReviewRow('reviewRow1', 0, 3);
            populateReviewRow('reviewRow2', 3, 3);
            populateReviewRow('reviewRow3', 6, 3);
        }, 100);
    });

    // Also try to initialize on window load as a fallback
    window.addEventListener('load', function() {
        populateReviewRow('reviewRow1', 0, 3);
        populateReviewRow('reviewRow2', 3, 3);
        populateReviewRow('reviewRow3', 6, 3);
    });

    // Add carousel GIF switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('stepsCarousel');
        const laptopGifs = document.querySelectorAll('.laptop-gif');

        if (carousel) {
            // Function to switch GIFs
            function switchGif(stepIndex) {
                // Hide all GIFs
                laptopGifs.forEach(gif => {
                    gif.style.opacity = '0';
                    gif.classList.remove('active');
                });

                // Show the corresponding GIF
                const activeGif = document.querySelector(`.laptop-gif[data-step="${stepIndex}"]`);
                if (activeGif) {
                    activeGif.style.opacity = '1';
                    activeGif.classList.add('active');
                }
            }

            // Handle carousel slide events
            carousel.addEventListener('slide.bs.carousel', function (e) {
                switchGif(e.to);
            });

            // Handle manual navigation
            const carouselControls = carousel.querySelectorAll('[data-bs-slide]');
            carouselControls.forEach(control => {
                control.addEventListener('click', function() {
                    const targetSlide = this.getAttribute('data-bs-slide-to');
                    if (targetSlide !== null) {
                        switchGif(targetSlide);
                    }
                });
            });

            // Initialize with first GIF
            switchGif(0);
        }
    });
</script>
@endpush

