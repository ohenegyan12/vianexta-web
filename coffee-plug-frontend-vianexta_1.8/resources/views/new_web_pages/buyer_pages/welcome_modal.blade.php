<!-- Modal -->
<div class="modal fade" id="welcome" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
          <img class="card-img-top mb-5 mb-md-0 img-fluid" style="max-width:20%;" src="{{ asset('images/market_place/amico.svg') }}"
                        alt="Seller">
          <div class="fs-4 pt-5 fw-bolder">Hi {{session('auth_user_name') !=null ? session('auth_user_name') : "there"}}, welcome </div>
          <div class="row">
            <div class="col-md-12 text-center py-3">
                <a href="{{route('buyer_market_place')}}" type="button" class="btn btn-primary py-2">Explore our marketplace <span
                        class="fa fa-chevron-right" style="margin-left:10px;margin-right:10px;"></span> </a>
            </div>
            <!-- <div class="col-md-6">
                <a href="{{route('buyer_market_place')}}" type="button" class="btn btn-primary py-2">Go to Marketplace <span
                        class="fa fa-chevron-right" style="margin-left:10px;margin-right:10px;"></span> </a>
            </div> -->
          </div>
          
      </div>
    </div>
  </div>
</div>