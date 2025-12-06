<!-- Modal -->
<div class="modal modal-xl fade" id="reset_password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form action="{{ route('resetPassword') }}" method="POST" enctype="multipart/form-data">
                         @csrf

      <div class="modal-body">
                       <div class="row gx-2 gx-md-5 gy-5 mb-4">
                            <div class="col-md-6">
                                        {{--Old Password --}}
                                <label for="oldPassword" class="form-label">Old Password</label>
                                <input type="password" class="form-control {{ $errors->has('oldPassword') ? 'is-invalid' : '' }} border border-dark" value="{{ empty(old('oldPassword')) ? '' : old('oldPassword') }}"  name="oldPassword"
                                            placeholder="Old password" required>
                                @if($errors->has('oldPassword'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('oldPassword') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                        {{--New password--}}
                                <label for="newPassword" class="form-label">New password</label>
                                <input type="password" class="form-control {{ $errors->has('newPassword') ? 'is-invalid' : '' }} border border-dark" value="{{ empty(old('newPassword')) ? '' : old('newPassword') }}"  name="newPassword"
                                            placeholder="New password" required>
                                @if($errors->has('newPassword'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('newPassword') }}
                                    </div>
                                @endif
                            </div>

                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Reset password</button>
      </div>
    </form>
    </div>
  </div>
</div>