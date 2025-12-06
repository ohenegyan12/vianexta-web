@extends('layouts.new_home_layout')
@section('title', 'Buyer Account')
@push('css')
<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropzone_css.css') }}">
<link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="wrapper" style="background: #F5F5F5">
    <style>
        .profile-btn {
            background: #07382F;
            color: white;
        }

        .profile-btn:hover {
            background: transparent;
            color: #07382F;
            border: 1px solid #07382F;
        }

        .profile-btn-outline {
            background: transparent;
            color: #07382F;
            border: 1px solid #07382F;
        }

        .profile-btn-outline:hover {
            background: #07382F;
            color: white;
        }

        .default-avatar {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #07382F 0%, #0d5a4a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
        }

        .default-avatar svg {
            width: 120px;
            height: 120px;
            fill: white;
        }

        /* Enhanced Dropzone Styling */
        .dropzone {
            border: 2px dashed #07382F !important;
            background: #f8f9fa !important;
            border-radius: 12px !important;
            padding: 2rem !important;
            text-align: center !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            min-height: 150px !important;
        }

        .dropzone:hover {
            border-color: #0d5a4a !important;
            background: #e8f5f3 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(7, 56, 47, 0.1);
        }

        .dropzone.dz-drag-hover {
            border-color: #0d5a4a !important;
            background: #e8f5f3 !important;
            transform: scale(1.02);
        }

        .dropzone.is-invalid {
            border-color: #dc3545 !important;
            background: #f8d7da !important;
        }

        .dropzone .dz-message {
            margin: 0 !important;
            height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .dropzone .dz-preview {
            display: none !important;
        }

        /* Form Input Focus Effects */
        .form-control:focus {
            border-color: #07382F !important;
            box-shadow: 0 0 0 0.2rem rgba(7, 56, 47, 0.25) !important;
        }

        .form-select:focus {
            border-color: #07382F !important;
            box-shadow: 0 0 0 0.2rem rgba(7, 56, 47, 0.25) !important;
        }

        /* Card Hover Effects */
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        }

        /* Button Hover Effects */
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        /* Modal Animation */
        .modal.fade .modal-dialog {
            transform: scale(0.8);
            transition: transform 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: scale(1);
        }

        /* Loading State Styles */
        .disabled {
            pointer-events: none !important;
            opacity: 0.6 !important;
        }

        .spinner-border {
            color: #07382F !important;
        }

        .alert {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: none;
            border-radius: 8px;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 4px solid #dc3545;
        }

        /* Loading overlay animation */
        #loadingOverlay {
            backdrop-filter: blur(2px);
        }

        /* Button loading state */
        #saveBtn:disabled {
            cursor: not-allowed;
        }

        #saveBtn:disabled:hover {
            transform: none;
            box-shadow: none;
        }
    </style>
    @include('includes.new_home.buyer_sidebar')

    <!-- Page Content  -->
    <div class="container">
        <div id="content" class="px-xl-5">
            @include('includes.new_home.buyer_nav')

            <div class="row gx-2 gx-lg-3 gy-5 gy-lg-0 mt-3">
                <h1 class="col-sm-6 col-md-6 fs-5 fw-medium" style="color:#656565;margin-top:10px;">ACCOUNT INFORMATION</h1>
                <hr>
                <div class="col-sm-4 col-md-4 py-2">
                    <div class="card mb-3 rounded-3 p-2" style="max-width: 1000px;">
                        @if($data->imageUrl != null)
                        <img src="{{ urldecode($data->imageUrl) }}" class="img-fluid rounded-3" height="300px;" alt="Profile Image">
                        @else
                        <div class="default-avatar">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                        @endif
                        <div class="card-body">
                            <h1 class="fs-4 fw-bolder" style="color: #07382F;">{{session('auth_user_name')}}</h1>
                            <h1 class="card-text fs-6 fw-medium">Email: {{session('auth_user_email')}}</h1>
                            <h1 class="card-text fs-6 fw-medium">Number: {{isset($data->phoneNumber)?$data->phoneNumber:""}}</h1>

                            <h1 class="card-text fs-6 fw-medium">Job Title: {{isset($data->jobTitle)?$data->jobTitle:""}}</h1>
                            <h1 class="card-text fs-6 fw-medium">Elevation: {{isset($data->elevation)?$data->elevation:""}}</h1>
                            <h1 class="card-text fs-6 fw-medium">Founded Year: {{isset($data->foundedYear)?$data->foundedYear:""}}</h1>
                            <div class="d-lg-flex justify-content-between mt-4">
                                <button class="btn profile-btn" data-bs-toggle="modal" data-bs-target="#edit_account">Edit Profile</button>
                                <button class="btn profile-btn-outline" data-bs-toggle="modal" data-bs-target="#reset_password">Reset Password</button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-8 col-md-8 py-2">
                    <div class="card mb-3 rounded-3" style="max-width: 1000px;">
                        <div class="card-body px-0 py-4">
                            <div class="d-flex g-0">
                                <div class="py-2 px-4 w-50 border-end">
                                    <h1 class="fs-5 fw-medium" style="color:#656565;">DEFAULT SHIPPING ADDRESS</h1>
                                    {{-- <input class="form-control bg-light" type="text" value="Shipping Address Line 1:" aria-label="readonly input example" readonly> --}}
                                    <div class="w-100 rounded-2 py-2 px-3 mb-3" style="background: #EDEBEB;
                                ">
                                        <h1 class="fs-6 fw-medium mb-0">Shipping Address Line 1: {{isset($data->shippingAddressLine1)?$data->shippingAddressLine1:""}}</h1>
                                    </div>
                                    <div class="w-100 rounded-2 py-2 px-3 mb-3" style="background: #EDEBEB;
                            ">
                                        <h1 class="fs-6 fw-medium mb-0">Shipping Address Line 2: {{isset($data->shippingAddressLine2)?$data->shippingAddressLine2:""}}</h1>
                                    </div>
                                    <div class="w-100 rounded-2 py-2 px-3 mb-3" style="background: #EDEBEB;
                            ">
                                        <h1 class="fs-6 fw-medium mb-0">Shipping Country: {{isset($data->shippingCountry)?$data->shippingCountry:""}}</h1>
                                    </div>
                                    <div class="w-100 rounded-2 py-2 px-3 mb-3" style="background: #EDEBEB;
                            ">
                                        <h1 class="fs-6 fw-medium mb-0">Shipping State: {{isset($data->shippingState)?$data->shippingState:""}}</h1>
                                    </div>
                                    <div class="w-100 rounded-2 py-2 px-3 mb-3" style="background: #EDEBEB;
                            ">
                                        <h1 class="fs-6 fw-medium mb-0">Shipping City: {{isset($data->shippingCity)?$data->shippingCity:""}}</h1>
                                    </div>
                                    <div class="w-100 rounded-2 py-2 px-3 mb-3" style="background: #EDEBEB;
                            ">
                                        <h1 class="fs-6 fw-medium mb-0">Shipping Zip Code: {{isset($data->shippingZipCode)?$data->shippingZipCode:""}}</h1>
                                    </div>

                                    <!-- <a href="#" class="py-5"><h1 class="fs-6 fw-medium py-5" style="color:#D8501C;text-decoration:underline">Edit address information</h1></a>  -->
                                </div>
                                <div class="py-2 px-4 w-50">
                                    <h1 class="fs-5 fw-medium" style="color:#656565;">DEFAULT BILLING ADDRESS</h1>
                                    <div class="w-100 rounded-2 py-2 px-3 mb-3" style="background: #EDEBEB;
                            ">
                                        <h1 class="fs-6 fw-medium mb-0 ">Billing Address Line 1: {{isset($data->billingAddressLine1)?$data->billingAddressLine1:""}}</h1>
                                    </div>
                                    <div class="w-100 rounded-2 py-2 px-3 mb-3" style="background: #EDEBEB;
                            ">
                                        <h1 class="fs-6 fw-medium mb-0">Billing Address Line 2: {{isset($data->billingAddressLine2)?$data->billingAddressLine2:""}}</h1>
                                    </div>
                                    <div class="w-100 rounded-2 py-2 px-3 mb-3" style="background: #EDEBEB;
                            ">
                                        <h1 class="fs-6 fw-medium mb-0">Billing Country: {{isset($data->billingCountry)?$data->billingCountry:""}}</h1>
                                    </div>
                                    <div class="w-100 rounded-2 py-2 px-3 mb-3" style="background: #EDEBEB;
                            ">
                                        <h1 class="fs-6 fw-medium mb-0">Billing State: {{isset($data->billingState)? $data->billingState: ""}}</h1>
                                    </div>
                                    <div class="w-100 rounded-2 py-2 px-3 mb-3" style="background: #EDEBEB;
                            ">
                                        <h1 class="fs-6 fw-medium mb-0">Billing City: {{isset($data->billingCity)?$data->billingCity:""}}</h1>
                                    </div>
                                    <div class="w-100 rounded-2 py-2 px-3 mb-3" style="background: #EDEBEB;
                            ">
                                        <h1 class="fs-6 fw-medium mb-0">Billing Zip Code: {{isset($data->billingZipCode)?$data->billingZipCode:""}}</h1>
                                    </div>
                                    <!-- <a href="#" class="py-5"><h1 class="fs-6 fw-medium py-5" style="color:#D8501C;text-decoration:underline">Edit billing information</h1></a> -->
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col-sm-12 col-md-8">
                            <div class="mb-3 p-3 rounded-3" style="max-width: 1000px;background-image: url('{{asset('images/profiles/profile_coffee_background.png')}}');background-repeat:no-repeat;background-size:cover">
                                <!-- <img src="{{ $data->imageUrl !=null ? urldecode($data->imageUrl) : asset('images/profiles/profile_coffee_background.png') }}" class="img-fluid rounded-3" height="300px;" alt="...">  -->
                                <div class="card-body">
                                    <div class="fw-bold fs-4" style="color: #ffff">
                                        ViaNexta
                                    </div>
                                    <div class="fw-bold fs-4 mb-2" style="color: #D8501C">NEWSLETTER</div>
                                    <h2 class="fs-6 fw-medium mb-4" style="color: #ffff">Keep up to date with all the latest news, <br>updates and promotions from us</h2>
                                    <form class="flex flex-col gap-2 mb-3" action="{{ route('saveNewLetter') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="email" class=" mb-3 form-control text-center fw-bold"
                                            placeholder="Email address" value="{{session('auth_user_email')}}" />
                                        <button class="btn btn-primary" type="submit">Subscribe now <span class="fa fa-angle-double-right"></span></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-sm-6 col-md-6">
                        <div class="card mb-3 rounded-3" style="max-width: 1000px;">
                        <!-- <img src="{{ $data->imageUrl !=null ? urldecode($data->imageUrl) : asset('images/profiles/profile.png') }}" class="img-fluid rounded-3" height="300px;" alt="..."> -->
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
</div>
</div>

</div>
@include('new_web_pages.seller_pages.edit_account_modal')
@include('new_web_pages.seller_pages.reset_password_modal')
@endsection
@section('scripts')
<!-- jQuery CDN - Full version (with AJAX support) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Dropzone JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<script>
    $(document).ready(function() {

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });

        // Initialize Dropzone for profile image upload
        Dropzone.autoDiscover = false;
        
        // Check if current user has a profile image
        @if(isset($data->imageUrl) && $data->imageUrl != null)
            $('#currentImageContainer').show();
            $('#noImageContainer').hide();
            $('#currentProfileImage').attr('src', '{{ urldecode($data->imageUrl) }}');
        @endif

        var profileDropzone = null;

        // Initialize dropzone when modal is shown
        $('#edit_account').on('shown.bs.modal', function() {
            console.log('Modal shown, initializing dropzone...');
            
            // Destroy existing dropzone if it exists
            if (profileDropzone !== null) {
                profileDropzone.destroy();
                profileDropzone = null;
            }

            // Wait a bit for the modal to fully render
            setTimeout(function() {
                try {
                    // Check if dropzone element exists
                    if ($('#profileDropzone').length === 0) {
                        console.error('Dropzone element not found!');
                        return;
                    }
                    
                    console.log('Creating dropzone on element:', $('#profileDropzone')[0]);
                    
                    profileDropzone = new Dropzone("#profileDropzone", {
                        url: "{{ route('saveProfile') }}",
                        method: "POST",
                        paramName: "imageUrl",
                        maxFiles: 1,
                        maxFilesize: 5, // 5MB
                        acceptedFiles: ".jpeg,.jpg,.png,.gif",
                        addRemoveLinks: true,
                        autoProcessQueue: false, // Don't auto-upload
                        clickable: true, // Make sure it's clickable
                        dictDefaultMessage: "Drop your profile image here or click to browse",
                        dictRemoveFile: "Remove",
                        dictCancelUpload: "Cancel",
                        dictUploadCanceled: "Upload canceled",
                        dictInvalidFileType: "Invalid file type. Only JPG, PNG, and GIF files are allowed.",
                        dictFileTooBig: "File is too big (@{{filesize}}MB). Max filesize: @{{maxFilesize}}MB.",
                        dictMaxFilesExceeded: "You can only upload @{{maxFiles}} file.",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        init: function() {
                            var myDropzone = this;
                            console.log('Dropzone initialized successfully');
                            
                            // When file is added
                            this.on("addedfile", function(file) {
                                console.log('File added:', file.name);
                                // Hide error message
                                $('#imageError').hide();
                                $('.dropzone').removeClass('is-invalid');
                                
                                // Show preview
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    $('#currentProfileImage').attr('src', e.target.result);
                                    $('#currentImageContainer').show();
                                    $('#noImageContainer').hide();
                                };
                                reader.readAsDataURL(file);
                            });
                            
                            // When file is removed
                            this.on("removedfile", function(file) {
                                console.log('File removed');
                                // Show default avatar
                                $('#currentImageContainer').hide();
                                $('#noImageContainer').show();
                            });
                            
                            // When upload is successful
                            this.on("success", function(file, response) {
                                console.log("Profile image uploaded successfully");
                                // Show success message
                                alert('Profile image uploaded successfully!');
                            });
                            
                            // When upload fails
                            this.on("error", function(file, errorMessage) {
                                console.error("Upload failed:", errorMessage);
                                $('#imageError').show();
                                $('.dropzone').addClass('is-invalid');
                                alert('Upload failed: ' + errorMessage);
                            });
                        }
                    });
                    
                    console.log('Dropzone created:', profileDropzone);
                    
                    // Add fallback click handler
                    $('#profileDropzone').on('click', function(e) {
                        console.log('Dropzone clicked');
                        if (profileDropzone === null) {
                            console.log('Dropzone not initialized, using fallback');
                            $('#fallbackFileInput').click();
                        }
                    });
                    
                } catch (error) {
                    console.error('Error creating dropzone:', error);
                    // Fallback: use regular file input
                    console.log('Using fallback file input');
                    $('#profileDropzone').on('click', function() {
                        $('#fallbackFileInput').click();
                    });
                }
            }, 100);
        });
        
        // Handle fallback file input change
        $('#fallbackFileInput').on('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                console.log('File selected via fallback:', file.name);
                // Show preview
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#currentProfileImage').attr('src', e.target.result);
                    $('#currentImageContainer').show();
                    $('#noImageContainer').hide();
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle form submission
        $('#profileForm').on('submit', function(e) {
            e.preventDefault();
            console.log('Form submitted');
            
            // Show loading state
            showLoadingState();
            
            // Get form data
            var formData = new FormData(this);
            
            // Check for files from dropzone or fallback input
            var hasFile = false;
            
            // If dropzone has files, add them to form data
            if (profileDropzone !== null && profileDropzone.getQueuedFiles().length > 0) {
                var file = profileDropzone.getQueuedFiles()[0];
                formData.append('imageUrl', file);
                hasFile = true;
                console.log('Using dropzone file:', file.name);
            }
            // If fallback input has files, add them to form data
            else if ($('#fallbackFileInput')[0].files.length > 0) {
                var file = $('#fallbackFileInput')[0].files[0];
                formData.append('imageUrl', file);
                hasFile = true;
                console.log('Using fallback file:', file.name);
            }
            
            console.log('Submitting form with file:', hasFile);
            
            // Submit form with AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Profile updated successfully');
                    hideLoadingState();
                    showSuccessMessage('Profile updated successfully!');
                    
                    // Close modal and reload after a short delay
                    setTimeout(function() {
                        $('#edit_account').modal('hide');
                        location.reload();
                    }, 1500);
                },
                error: function(xhr, status, error) {
                    console.error('Error updating profile:', error);
                    hideLoadingState();
                    showErrorMessage('Error updating profile. Please try again.');
                }
            });
        });
        
        // Function to show loading state
        function showLoadingState() {
            // Show loading overlay
            $('#loadingOverlay').fadeIn(300);
            
            // Disable form elements
            $('#profileForm input, #profileForm select, #profileForm textarea').prop('disabled', true);
            $('#profileDropzone').addClass('disabled');
            
            // Update save button
            $('#saveText').hide();
            $('#saveSpinner').show();
            $('#saveBtn').prop('disabled', true).css('opacity', '0.7');
            
            // Disable cancel button
            $('#cancelBtn').prop('disabled', true).css('opacity', '0.7');
        }
        
        // Function to hide loading state
        function hideLoadingState() {
            // Hide loading overlay
            $('#loadingOverlay').fadeOut(300);
            
            // Re-enable form elements
            $('#profileForm input, #profileForm select, #profileForm textarea').prop('disabled', false);
            $('#profileDropzone').removeClass('disabled');
            
            // Reset save button
            $('#saveText').show();
            $('#saveSpinner').hide();
            $('#saveBtn').prop('disabled', false).css('opacity', '1');
            
            // Re-enable cancel button
            $('#cancelBtn').prop('disabled', false).css('opacity', '1');
        }
        
        // Function to show success message
        function showSuccessMessage(message) {
            // Create success alert
            var alertHtml = `
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                    <i class="fas fa-check-circle me-2"></i>${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            $('body').append(alertHtml);
            
            // Auto-remove after 3 seconds
            setTimeout(function() {
                $('.alert-success').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
        
        // Function to show error message
        function showErrorMessage(message) {
            // Create error alert
            var alertHtml = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                    <i class="fas fa-exclamation-circle me-2"></i>${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            $('body').append(alertHtml);
            
            // Auto-remove after 5 seconds
            setTimeout(function() {
                $('.alert-danger').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);
        }

    });
</script>

<!-- Clare Chat Component -->
<script src="{{ asset('js/clare-component.js') }}"></script>
@endsection