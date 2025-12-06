@extends('layouts.new_home_layout')
@section('title', '')
@push('css')
<style>
    body {
        background-color: #ffff;
    }

    .cards-row {
        column-gap: 40px
    }

    @media(min-width: 1280px) {
        .grind {
            width: 20%;
        }
    }

    .nav-link.active path {
        fill: #fff;
    }

    .btn-market {
        border: 1px solid #D8501C;
        color: #D8501C;
    }

    .btn-market:hover {
        background: #D8501C;
        color: #fff;
    }
</style>

@endpush

@section('content')
@include('includes.new_home.buyer_new_header')

<section class="pt-5">
    <div class="container px-2 px-lg-3 pt-4 pt-lg-5">
        <div class="tab-pane fade show active" role="tabpanel" id="step1" aria-labelledby="step1-tab">
            <div class="d-flex mb-5 py-lg-5 cards-row justify-content-center">
                <div class="card bg-white border-0 py-2 px-4">
                    <div class="card-body">
                        <div class="card-content">
                            <img src="{{ asset('images/buyer/rafiki.svg') }}" alt="yes image" class="h-60 w-full">
                            <h2 class="card-text text-center mt-3">All Done</h2>
                            <!-- Additional content -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center" style="column-gap: 20px;">
                <a href="{{route('buyer_market_place')}}" class="btn btn-market" style="width: 180px;">Go to marketplace</a>
                <a href="{{route('buyer_cart')}}" class="btn btn-primary" style="width: 180px;">Go to Cart</a>
            </div>
        </div>
    </div>
</section>
@include('new_web_pages.buyer_pages.order_placed_modal')
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    window.addEventListener('scroll', function() {
        var header = document.getElementById('app_header');
        if (window.scrollY > 0) {
            header.style.backgroundColor = '#FFFF';

        } else {
            header.style.backgroundColor = '#FFFF';
        }
    });
</script>