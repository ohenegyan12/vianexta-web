<!-- Modal -->
<div class="modal modal-sm fade" id="assign_print_{{$order_detail->lotOrderId}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Asign Print House to Order #{{$order_detail->lotOrderId}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('asignOrderToRoaster') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row gx-2 gx-md-5 gy-5 mb-4">
                        <div class="col-md-12">
                            <input type="hidden" value="{{$order_detail->lotOrderId}}" name="order_id">
                            <label for="roasters" class="form-label">Asign print house</label>
                            <select class="form-select" name='roaster_id' aria-label="Default select example">

                                @foreach($roasters as $roaster)
                                <option value="{{$roaster->id}}" {{(!empty($data->roaster_id) && $data->roaster_id==$roaster->id) ? 'selected' : (old('roaster_id')==$roaster->id? 'selected':'')  }}>{{$roaster->firstName." ".$roaster->lastName}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('roaster_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('roaster_id') }}
                            </div>
                            @endif
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