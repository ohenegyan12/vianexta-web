<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img class="card-img-top mb-5 mb-md-0 img-fluid" style="max-width:80%;" src="{{ asset('images/ice_cream_seller.svg') }}"
          alt="Seller">
        <div class="fs-5 py-2">Hi {{session('auth_user_name') !=null ? session('auth_user_name') : "there"}}! welcome </div>
        <a href="{{route('sellers_add_product')}}" type="button" class="btn btn-primary py-2">Upload your product <span class="fa fa-chevron-right"></span> </a>
      </div>
    </div>
  </div>
</div>