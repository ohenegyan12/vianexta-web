<!-- Modal -->
<div class="modal modal-sm fade" id="change_state_{{$order->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Change status of Order #{{$order->id}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('asignOrderToRoaster') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row gx-2 gx-md-5 gy-5 mb-4">
                        <div class="col-md-12">
                            <input type="hidden" value="{{$order->id}}" name="order_id">
                            <label for="roasters" class="form-label">Change Order Status</label>
                            <select class="form-select" name='status' aria-label="Default select example">


                                <option value="Processing">Processing</option>
                                <option value="Shiping">Shiping</option>
                                <option value="Shiped">Shiped</option>
                                <option value="Paid">Paid</option>
                                <option value="Delivering">Delivering</option>
                                <option value="Delivered">Delivered</option>

                            </select>

                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>