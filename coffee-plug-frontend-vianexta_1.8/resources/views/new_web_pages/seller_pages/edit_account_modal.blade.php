<!-- Modal -->
<div class="modal modal-xl fade" id="edit_account" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
      <div class="modal-header" style="background: linear-gradient(135deg, #07382F 0%, #0d5a4a 100%); color: white; border-radius: 15px 15px 0 0; border: none;">
        <h1 class="modal-title fs-4 fw-bold" id="exampleModalLabel">
          <i class="fas fa-user-edit me-2"></i>Edit Profile
        </h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form action="{{ route('saveProfile') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                         @csrf

      <div class="modal-body" style="padding: 2rem; background: #f8f9fa; position: relative;">
        <!-- Loading Overlay -->
        <div id="loadingOverlay" style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(248, 249, 250, 0.9); z-index: 1000; border-radius: 12px;">
          <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
            <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
              <span class="visually-hidden">Loading...</span>
            </div>
            <h5 style="color: #07382F; font-weight: 600;">Saving Profile...</h5>
            <p class="text-muted mb-0">Please wait while we update your information</p>
          </div>
        </div>
                       <!-- Profile Image Section -->
                       <div class="row mb-4">
                           <div class="col-12">
                               <div class="card" style="border: none; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                   <div class="card-body p-4">
                                       <h5 class="card-title mb-3" style="color: #07382F; font-weight: 600;">
                                           <i class="fas fa-camera me-2"></i>Profile Picture
                                       </h5>
                                       
                                       <!-- Current Profile Image Display -->
                                       <div class="text-center mb-3">
                                           <div id="currentImageContainer" style="display: none;">
                                               <img id="currentProfileImage" src="" alt="Current Profile" 
                                                    style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid #07382F;">
                                               <p class="text-muted mt-2 mb-0">Current Profile Picture</p>
                                           </div>
                                           <div id="noImageContainer" style="display: block;">
                                               <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #07382F 0%, #0d5a4a 100%); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                                   <i class="fas fa-user" style="font-size: 3rem; color: white;"></i>
                                               </div>
                                               <p class="text-muted mt-2 mb-0">No profile picture</p>
                                           </div>
                                       </div>
                                       
                                       <!-- Dropzone for Image Upload -->
                                       <div class="dropzone-container">
                                           <div id="profileDropzone" class="dropzone dropzone-drag-area" style="border: 2px dashed #07382F; background: #f8f9fa; border-radius: 12px; padding: 2rem; text-align: center; cursor: pointer; transition: all 0.3s ease;">
                                               <div class="dz-message">
                                                   <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #07382F; margin-bottom: 1rem;"></i>
                                                   <h6 style="color: #07382F; margin-bottom: 0.5rem;">Drop your profile image here</h6>
                                                   <p class="text-muted mb-0">or click to browse</p>
                                                   <small class="text-muted">Supports: JPG, PNG, GIF (Max: 5MB)</small>
                                               </div>
                                           </div>
                                           <div id="previews" class="mt-3"></div>
                                           <div class="invalid-feedback" id="imageError" style="display: none;">
                                               Please upload a valid image file.
                                           </div>
                                           
                                           <!-- Fallback file input (hidden) -->
                                           <input type="file" id="fallbackFileInput" name="imageUrl" accept=".jpeg,.jpg,.png,.gif" style="display: none;">
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>

                       <!-- Personal Information Section -->
                       <div class="row mb-4">
                           <div class="col-12">
                               <div class="card" style="border: none; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                   <div class="card-body p-4">
                                       <h5 class="card-title mb-4" style="color: #07382F; font-weight: 600;">
                                           <i class="fas fa-user me-2"></i>Personal Information
                                       </h5>
                                       
                                       <div class="row g-3">
                            <div class="col-md-6">
                                               <label for="firstName" class="form-label fw-medium" style="color: #07382F;">First Name <span class="text-danger">*</span></label>
                                               <input type="text" class="form-control {{ $errors->has('firstName') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->firstName) ? $data->firstName : (empty(old('firstName')) ? '' : old('firstName')) }}"  
                                                      name="firstName" placeholder="Enter your first name" required>
                                @if($errors->has('firstName'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('firstName') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                               <label for="lastName" class="form-label fw-medium" style="color: #07382F;">Last Name <span class="text-danger">*</span></label>
                                               <input type="text" class="form-control {{ $errors->has('lastName') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->lastName) ? $data->lastName : (empty(old('lastName')) ? '' : old('lastName')) }}"  
                                                      name="lastName" placeholder="Enter your last name" required>
                                @if($errors->has('lastName'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('lastName') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-6">
                                               <label for="email" class="form-label fw-medium" style="color: #07382F;">Email Address <span class="text-danger">*</span></label>
                                               <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty(session('auth_user_email')) ? session('auth_user_email') : (empty(old('email')) ? '' : old('email')) }}" 
                                                      name="email" placeholder="Enter your email address" required>
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                               <label for="phoneNumber" class="form-label fw-medium" style="color: #07382F;">Phone Number <span class="text-danger">*</span></label>
                                               <input type="tel" class="form-control {{ $errors->has('phoneNumber') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->phoneNumber) ? $data->phoneNumber : (empty(old('phoneNumber')) ? '' : old('phoneNumber')) }}"  
                                                      name="phoneNumber" placeholder="Enter your phone number" maxlength="13" required>
                                @if($errors->has('phoneNumber'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('phoneNumber') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-6">
                                               <label for="jobTitle" class="form-label fw-medium" style="color: #07382F;">Job Title</label>
                                               <input type="text" class="form-control {{ $errors->has('jobTitle') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->jobTitle) ? $data->jobTitle : (empty(old('jobTitle')) ? '' : old('jobTitle')) }}"  
                                                      name="jobTitle" placeholder="Enter your job title">
                                @if($errors->has('jobTitle'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('jobTitle') }}
                                    </div>
                                @endif
                            </div>
                                       </div>
                                   </div>
                               </div>
                                    </div>
                            </div>

                       <!-- Billing Address Section -->
                       <div class="row mb-4">
                           <div class="col-12">
                               <div class="card" style="border: none; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                   <div class="card-body p-4">
                                       <h5 class="card-title mb-4" style="color: #07382F; font-weight: 600;">
                                           <i class="fas fa-credit-card me-2"></i>Billing Address
                                       </h5>
                                       
                                       <div class="row g-3">
                            <div class="col-md-6">
                                               <label for="billingAddressLine1" class="form-label fw-medium" style="color: #07382F;">Address Line 1</label>
                                               <input type="text" class="form-control {{ $errors->has('billingAddressLine1') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->billingAddressLine1) ? $data->billingAddressLine1 : (empty(old('billingAddressLine1')) ? '' : old('billingAddressLine1')) }}"  
                                                      name="billingAddressLine1" placeholder="Enter billing address line 1">
                                @if($errors->has('billingAddressLine1'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('billingAddressLine1') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                               <label for="billingAddressLine2" class="form-label fw-medium" style="color: #07382F;">Address Line 2</label>
                                               <input type="text" class="form-control {{ $errors->has('billingAddressLine2') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->billingAddressLine2) ? $data->billingAddressLine2 : (empty(old('billingAddressLine2')) ? '' : old('billingAddressLine2')) }}"  
                                                      name="billingAddressLine2" placeholder="Enter billing address line 2">
                                @if($errors->has('billingAddressLine2'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('billingAddressLine2') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                               <label for="billingCountry" class="form-label fw-medium" style="color: #07382F;">Country</label>
                                               <select class="form-select {{ $errors->has('billingCountry') ? 'is-invalid' : '' }}" 
                                                       style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                       name='billingCountry' aria-label="Select country">
                                                   <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->name}}" {{(!empty($data->billingCountry) && $data->billingCountry==$country->name) ? 'selected' : (old('billingCountry')==$country->name? 'selected':'')  }}>{{$country->name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('billingCountry'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('billingCountry') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                               <label for="billingState" class="form-label fw-medium" style="color: #07382F;">State/Province</label>
                                               <input type="text" class="form-control {{ $errors->has('billingState') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->billingState) ? $data->billingState : (empty(old('billingState')) ? '' : old('billingState')) }}"  
                                                      name="billingState" placeholder="Enter state or province">
                                @if($errors->has('billingState'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('billingState') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                               <label for="billingCity" class="form-label fw-medium" style="color: #07382F;">City</label>
                                               <input type="text" class="form-control {{ $errors->has('billingCity') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->billingCity) ? $data->billingCity : (empty(old('billingCity')) ? '' : old('billingCity')) }}"  
                                                      name="billingCity" placeholder="Enter city">
                                @if($errors->has('billingCity'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('billingCity') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                               <label for="billingZipCode" class="form-label fw-medium" style="color: #07382F;">ZIP/Postal Code</label>
                                               <input type="text" class="form-control {{ $errors->has('billingZipCode') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->billingZipCode) ? $data->billingZipCode : (empty(old('billingZipCode')) ? '' : old('billingZipCode')) }}"  
                                                      name="billingZipCode" placeholder="Enter ZIP or postal code">
                                @if($errors->has('billingZipCode'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('billingZipCode') }}
                                    </div>
                                @endif
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                            </div>
                            
                       <!-- Shipping Address Section -->
                       <div class="row mb-4">
                           <div class="col-12">
                               <div class="card" style="border: none; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                   <div class="card-body p-4">
                                       <h5 class="card-title mb-4" style="color: #07382F; font-weight: 600;">
                                           <i class="fas fa-shipping-fast me-2"></i>Shipping Address
                                       </h5>

                                       <div class="row g-3">
                            <div class="col-md-6">
                                               <label for="shippingAddressLine1" class="form-label fw-medium" style="color: #07382F;">Address Line 1</label>
                                               <input type="text" class="form-control {{ $errors->has('shippingAddressLine1') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->shippingAddressLine1) ? $data->shippingAddressLine1 : (empty(old('shippingAddressLine1')) ? '' : old('shippingAddressLine1')) }}"  
                                                      name="shippingAddressLine1" placeholder="Enter shipping address line 1">
                                @if($errors->has('shippingAddressLine1'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('shippingAddressLine1') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                               <label for="shippingAddressLine2" class="form-label fw-medium" style="color: #07382F;">Address Line 2</label>
                                               <input type="text" class="form-control {{ $errors->has('shippingAddressLine2') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->shippingAddressLine2) ? $data->shippingAddressLine2 : (empty(old('shippingAddressLine2')) ? '' : old('shippingAddressLine2')) }}"  
                                                      name="shippingAddressLine2" placeholder="Enter shipping address line 2">
                                @if($errors->has('shippingAddressLine2'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('shippingAddressLine2') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                               <label for="shippingCountry" class="form-label fw-medium" style="color: #07382F;">Country</label>
                                               <select class="form-select {{ $errors->has('shippingCountry') ? 'is-invalid' : '' }}" 
                                                       style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                       name='shippingCountry' aria-label="Select country">
                                                   <option value="">Select Country</option>
                                @foreach($countries as $country)
                                        <option value="{{$country->name}}" {{(!empty($data->shippingCountry) && $data->shippingCountry==$country->name) ? 'selected' : (old('shippingCountry')==$country->name? 'selected':'')  }}>{{$country->name}}</option>
                                        @endforeach
                                </select>
                                @if($errors->has('shippingCountry'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('shippingCountry') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                               <label for="shippingState" class="form-label fw-medium" style="color: #07382F;">State/Province</label>
                                               <input type="text" class="form-control {{ $errors->has('shippingState') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->shippingState) ? $data->shippingState : (empty(old('shippingState')) ? '' : old('shippingState')) }}"  
                                                      name="shippingState" placeholder="Enter state or province">
                                @if($errors->has('shippingState'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('shippingState') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                               <label for="shippingCity" class="form-label fw-medium" style="color: #07382F;">City</label>
                                               <input type="text" class="form-control {{ $errors->has('shippingCity') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->shippingCity) ? $data->shippingCity : (empty(old('shippingCity')) ? '' : old('shippingCity')) }}"  
                                                      name="shippingCity" placeholder="Enter city">
                                @if($errors->has('shippingCity'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('shippingCity') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                               <label for="shippingZipCode" class="form-label fw-medium" style="color: #07382F;">ZIP/Postal Code</label>
                                               <input type="text" class="form-control {{ $errors->has('shippingZipCode') ? 'is-invalid' : '' }}" 
                                                      style="border: 2px solid #e9ecef; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;" 
                                                      value="{{ !empty($data->shippingZipCode) ? $data->shippingZipCode : (empty(old('shippingZipCode')) ? '' : old('shippingZipCode')) }}"  
                                                      name="shippingZipCode" placeholder="Enter ZIP or postal code">
                                @if($errors->has('shippingZipCode'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('shippingZipCode') }}
                                    </div>
                                @endif
                            </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                        </div>
      </div>
      <div class="modal-footer" style="background: #f8f9fa; border-radius: 0 0 15px 15px; border: none; padding: 1.5rem 2rem;">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="cancelBtn" style="border: 2px solid #6c757d; color: #6c757d; border-radius: 8px; padding: 0.75rem 1.5rem; font-weight: 500;">
          <i class="fas fa-times me-2"></i>Cancel
        </button>
        <button type="submit" class="btn" id="saveBtn" style="background: linear-gradient(135deg, #07382F 0%, #0d5a4a 100%); border: none; color: white; border-radius: 8px; padding: 0.75rem 1.5rem; font-weight: 500; transition: all 0.3s ease; position: relative;">
          <span id="saveText">
            <i class="fas fa-save me-2"></i>Save Changes
          </span>
          <span id="saveSpinner" style="display: none;">
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Saving...
          </span>
        </button>
      </div>
    </form>
    </div>
  </div>
</div>