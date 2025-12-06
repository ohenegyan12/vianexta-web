<section class="d-none" id="logoPreview">
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
    <div class="container px-2 px-lg-3 pt-4 pt-lg-5">
        <div class="tab-pane fade show active" role="tabpanel" id="step1" aria-labelledby="step1-tab">

            <div class="d-flex justify-content-center" style="column-gap: 20px;">
                <a href="{{route('buyer_market_place')}}" class="btn btn-market" style="width: 180px;">Go to marketplace</a>
                <a href="{{route('buyer_cart')}}" class="btn btn-primary" style="width: 180px;">Go to Cart</a>
            </div>
        </div>
    </div>
</section>