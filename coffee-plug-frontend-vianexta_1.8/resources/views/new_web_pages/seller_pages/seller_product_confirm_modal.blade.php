<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
          <img class="card-img-top mb-5 mb-md-0 img-fluid" style="max-width:20%;" src="{{ asset('images/checkout.png') }}"
                        alt="Seller">
          <div class="fs-4 py-5 fw-bolder" >Your product has been uplaoded... </div>
          <div class="row">
            <div class="col-md-6">
                <a href="{{route('sellers_add_product')}}" type="button" class="btn btn-secondary py-2">Go to dashboard <span
                        class="fa fa-chevron-right" style="margin-left:10px;margin-right:10px;"></span> </a>
            </div>
            <div class="col-md-6">
                <a href="{{route('sellers_add_product')}}" type="button" class="btn btn-primary py-2">Go to Marketplace <span
                        class="fa fa-chevron-right" style="margin-left:10px;margin-right:10px;"></span> </a>
            </div>
          </div>
          
      </div>
    </div>
  </div>
</div>