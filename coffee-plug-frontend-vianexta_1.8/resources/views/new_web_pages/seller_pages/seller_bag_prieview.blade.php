<div class="row g-4">
    <!-- Left Column -->
    <div class="col-12 col-md-6">
        <!-- Product Details -->
        <div id="productDetails">
            @php $bag_details = $helper->getBagDetails($order_detail->bagSize); @endphp
            <h4 class="mb-3"> <b>{{$bag_details['title']}}</b></h4>
            <h6>Bag details</h6>
            <p class="mb-1">Size: {{$bag_details['size']}}</p>
            <p class="mb-1">{{$bag_details['color']}}</p>
            <p class="mb-1">{{$bag_details['origin']}}</p>
            <p class="small text-muted mb-4">{{$bag_details['note']}}</p>
        </div>

        <!-- Logo -->
        <div>
            <img src="{{ $order_detail->bagImage !=null ? urldecode($order_detail->bagImage) : asset('images/market_place/coffee_logo.jpg') }}" style="height: 300px;" class=" img-fluid img-thumbnail" alt="Logo to print on package">
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-12 col-md-6">
        <!-- Main Preview -->
        <div class="card mb-4 top_space">
            <div class="card-body">
                <div class="main-preview mb-3">
                    @php
                    $mainImagePath = 'images/buyer/'.$bag_details["mainImage"];
                    $mainImageUrl = asset($mainImagePath);
                    @endphp
                    <img src="{{ $mainImageUrl }}" style="height: 400px; display: block; margin-left: auto; margin-right: auto;" alt="Coffee package" class="img-fluid" id="mainImage">
                    <div class="design-overlay-{{ $order_detail->bagSize }}" id="designOverlay">
                        <img src="{{ $order_detail->bagImage !=null ? urldecode($order_detail->bagImage) : asset('images/market_place/coffee_logo.jpg') }}" class="design-image" id="logoOverlay" style="position: absolute; pointer-events: auto;">
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>