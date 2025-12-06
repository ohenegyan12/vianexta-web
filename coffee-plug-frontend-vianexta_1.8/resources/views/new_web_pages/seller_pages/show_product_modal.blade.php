<!-- Modal -->
<div class="modal modal-xl fade" id="show_product{{$order_detail->stockPostingId}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Logo to print on package </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <!-- <img src="{{ $order_detail->bagImage !=null ? urldecode($order_detail->bagImage) : asset('images/market_place/coffee_logo.jpg') }}" class="img-fluid img-thumbnail" alt="Sheep"> -->

        <!-- <div>
          <h5><b>Bag Dimension:</b></h5>
          <h6> Flat-Bottom Bag: ~8" W x 5" D x 19" H</h6>
        </div> -->
        @include('new_web_pages.seller_pages.seller_bag_prieview')

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Add product</button> -->
      </div>
    </div>
  </div>
</div>