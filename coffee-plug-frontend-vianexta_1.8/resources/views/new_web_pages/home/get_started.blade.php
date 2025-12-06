@extends('layouts.new_home_layout')
@section('title', 'Home')


@section('content')
@include('includes.new_home.new_home_header')

 {{-- HERO SECTION --}}
    <section class="pt-5 " >
        <div class="container px-2 px-lg-3 " style="padding-top:100px;">
            <div class="row gx-4 gx-lg-5 align-items-center justify-content-lg-between justify-content-md-center justify-content-sm-center">
                <div class="col-md-12 text-center">
                    <h1 class="fs-5 fw-medium text-center mb-0 mb-lg-2" >Welcome to</h1>
                    {{-- <h1 class="display-4 fw-bolder text-primary d-none d-lg-block">ViaNexta </h1> --}}
                    <img class="mb-3 mt-2 gs-logo" src="{{ asset('images/logo_new_col.svg') }}"
                            alt="Logo">
                    <h1 class="fs-5 fw-medium" >Get your coffee from across the world right to your door step.</h1>
                    <div class="d-flex get-started-row">
                        <div class="col-12">
                            <img class="ms-2 img-fluid" src="{{ asset('images/map_bg.svg') }}" max-width="80%" alt="Logo">
                        </div>
                        <div class="col-12 mt-4">
                            <div>
                                <a href="{{route('login_page')}}" type="button" class="btn btn-secondary py-2">Login <span
                                       class="fa fa-chevron-right" style="margin-left:10px;margin-right:10px;"></span> </a>
                               <a href="{{route('languages')}}" style="margin-left:20px;" type="button" class="btn btn-primary py-2">Sign Up<span
                                       class="fa fa-chevron-right" style="margin-left:10px;margin-right:10px;"></span> </a>
                       </div>
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

