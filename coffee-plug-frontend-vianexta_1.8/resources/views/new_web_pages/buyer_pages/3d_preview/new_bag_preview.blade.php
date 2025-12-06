<div class="row g-4">
    <!-- Left Column -->
    <div class="col-12 col-md-3">
        <h5 class="mb-4">Select your package size?</h5>

        <!-- Package Buttons -->
        <div class="d-grid gap-2 mb-4" id="packageButtons">
            <button class="btn btn-light package-btn" id="5lb_bag" data-size="5lb">5lb Bag</button>
            <button class="btn btn-light package-btn" id="12oz_frac_pack" data-size="12oz">12oz Bag</button>
            <button class="btn btn-light package-btn" id="10oz_bag" data-size="10oz">10oz Bag</button>
            <button class="btn btn-light package-btn" id="k_cup" data-size="kcup">K Cup</button>
        </div>

        <!-- Upload Zone -->
        <form id="formDropzone" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="form-group mb-4">
                <div class=" dropzone-drag-area form-control mt-4" id="previews">
                    <div class="dz-message text-muted opacity-50" data-dz-message>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-upload mb-2" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
                        </svg>
                        <p class="text-muted small mb-0">DRAG YOUR LOGO HERE TO UPLOAD</p>
                    </div>
                    <div class="d-none" id="dzPreviewContainer">
                        <div class="dz-preview dz-file-preview">
                            <div class="dz-photo">
                                <img class="dz-thumbnail" data-dz-thumbnail>
                            </div>
                            <button class="dz-delete border-0 p-0" type="button" data-dz-remove>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="times">
                                    <path fill="#FFFFFF" d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Right Column -->
    <div class="col-12 col-md-6">
        <!-- Main Preview -->
        <div class="card mb-4 top_space">
            <div class="card-body">
                <div class="main-preview mb-3">
                    <img src="{{ asset('images/buyer/12oz_1.png')}}" style="height: 400px; display: block; margin-left: auto; margin-right: auto;" alt="Coffee package" class="img-fluid" id="mainImage">
                    <div class="logo-placeholder" id="logoPlaceholder" style="display:none">
                        <p>YOUR LOGO</p>
                        <div class="resize-handle top-left"></div>
                        <div class="resize-handle top-right"></div>
                        <div class="resize-handle bottom-left"></div>
                        <div class="resize-handle bottom-right"></div>
                    </div>
                    <div class="design-overlay-12oz" id="designOverlay">
                        @if(session('bag_image'))
                        <img class="design-image" id="logoOverlay" src="{{ urldecode(session('bag_image')) }}" style="position: absolute; pointer-events: auto;">
                        @else
                        <img class="design-image" id="logoOverlay" style="position: absolute; pointer-events: auto;">
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Product Details -->
    <div class="col-12 col-md-3">
        <div id="productDetails">
            <h4 class="mb-3 top_space"> <b>12oz Bag</b></h4>
            <h6>Bag details</h6>
            <p class="mb-1">Size: ~4" W x 3" D x 12" H</p>
            <p class="mb-1">Color: Matte black</p>
            <p class="mb-1">Roasted in the USA</p>
            <p class="small text-muted mb-4">Label size: 1.75 in (H) x 3.75 in (L)</p>
        </div>

        <input id="bag_quantity" value="" type="hidden" />
        <div id="quantity_section">
            <div class="fs-5 text-black pb-2 py-2">Quantity (# of Bags)</div>
            <div class=" py-2 ">
                <input type="number" class=" py-2 form-control {{ $errors->has('numBags') ? 'is-invalid' : '' }} border border-dark" id="numBags" value="{{session('num_of_bags') ?? ''}}" name="numBags"
                    placeholder="Enter quantity" oninput="getAmount()" min="1" max="1000" required>
                @if($errors->has('numBags'))
                <div class="invalid-feedback">
                    {{ $errors->first('numBags') }}
                </div>
                @endif
            </div>
        </div>
        <input id="session_num_of_bags" value="{{session('num_of_bags') ?? ''}}" type="hidden" />
        <input id="selected_bag" value="" type="hidden" />
        <input id="session_bag_size" value="{{session('bag_size') ?? ''}}" type="hidden" />
        <!-- <div id="btn_roast_next">
            <a href="{{route('buyerWizardSuccess',[$helper->encode($num_of_bags),$helper->encode($stockPostingId)] )}}" style="display: none;" class="btn btn-primary w-100 text-white">Next</a>
        </div> -->
    </div>
</div>