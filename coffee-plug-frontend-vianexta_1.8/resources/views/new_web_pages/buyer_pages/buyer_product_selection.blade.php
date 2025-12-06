<div class="row position-relative">
    <h4 class="mb-5 text-center">How do you want your coffee?</h4>
    <div class="col-12 col-md-12 text-center">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" checked name="coffee_type" id="single_origin" value="single_origin" style="transform: scale(1.5); accent-color: #D8501C;">
            <label class="form-check-label" for="single_origin" style="font-size: 1.2rem; font-weight: bold;">Single Origin</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="coffee_type" id="blend" value="blend" style="transform: scale(1.5); accent-color: #D8501C;">
            <label class="form-check-label" for="blend" style="font-size: 1.2rem; font-weight: bold;">Blend</label>
        </div>
    </div>
    <div class="col-12 col-md-5">
        <div class="form-group mt-5" id="product_selection_div">
            <label for="product_selection">Select Products</label>
            <select class="form-control" id="product_selection" name="product_selection">
                <option value="">Select Product</option>
                @foreach($winwin_products as $product)
                @php $prod = json_encode($product); @endphp
                <option value="{{ $product->id }}" data-product="{{ $prod }}" {{ session('product') == $product->id ? 'selected' : '' }}>
                    {{ $product->description }}
                </option>
                @endforeach
            </select>
        </div>
        <div id="product_selection_div">
            @include('new_web_pages.buyer_pages.wizard.product_score_details')
        </div>

    </div>
    <div class="col-md-2 d-none d-md-block">
        <div class="vertical-divider" id="product_selection_div"></div>
    </div>

    <div class="col-12 col-md-5" id="product_selection_div">
        @include('new_web_pages.buyer_pages.wizard.product_details')
    </div>

    @include('new_web_pages.buyer_pages.wizard.product_market_place')

    <input type="hidden" name="session_product" id="session_product" value="{{ session('product') ?? '' }}" />

</div>