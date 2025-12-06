@extends('layouts.auth_layout ')
@section('title', 'Account Type ')

<style>
    /* Password reveal functionality */
    .password-field-container {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        color: #6b7280;
        transition: color 0.2s ease;
        z-index: 10;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .password-toggle:hover {
        color: #374151;
    }

    .password-toggle:focus {
        outline: none;
        color: #1f2937;
    }

    .password-toggle svg {
        width: 20px;
        height: 20px;
        display: block;
    }

    /* Ensure input has proper padding for the icon */
    .password-field-container input[type="password"],
    .password-field-container input[type="text"] {
        padding-right: 40px;
    }

    /* Hide the eye icon when input is focused to avoid overlap */
    .password-field-container input:focus + .password-toggle {
        opacity: 0.7;
    }
</style>

@section('content')
<section class="py-4 sm:py-8 pb-40 h-5/6">
    <div class="mx-auto max-w-screen-2xl p-3 p-lg-5 pt-5">
        <div class="flex flex-col xl:flex-row items-center justify-between mb-5 sm:mb-10">
            <h1 class="text-2xl md:text-4xl font-semibold text-primary text-start mb-8 md:mb-10 xl:mb-0">Register</h1>
            <div class="max-w-2xl w-100 sm:max-w-full sm:mx-0 flex bg-gray-100 p-1 gap-2 items-center rounded-md">
                <button
                    class="
                            btn font-sora text-sm font-semibold w-50 capitalize register_tab active 
                        ">Your
                    Profile</button>
                <button class=" btn bg-transparent border-0 text-sm capitalize w-50 register_tab">Business
                    Information</button>
            </div>
        </div>

        <form action="{{ route('savePersonalData') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div class="">
                    <label for="first_name" class="block text-sm md:text-md font-semibold text-primary">First
                        Name<sup>*</sup></label>
                    <div class="mt-1">
                        <input type="text" id="first_name" name="first_name" autocomplete="first_name"
                            value="{{ empty(session('first_name')) ? old('first_name') : session('first_name') }}"
                            class="input w-full border sm:border-2 border-primary">
                        @if ($errors->has('first_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('first_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label for="last_name" class="block text-sm md:text-md font-semibold text-primary">Last
                        Name <sup>*</sup></label>
                    <div class="mt-1">
                        <input type="text" id="last_name" name="last_name" autocomplete="last_name"
                            value="{{ empty(session('last_name')) ? old('last_name') : session('last_name') }}"
                            class="input w-full border sm:border-2  border-primary">
                        @if ($errors->has('last_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('last_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label for="email"
                        class="block text-sm md:text-md font-semibold text-primary">Email<sup>*</sup></label>
                    <div class="mt-1">
                        <input type="text" id="email" name="email" autocomplete="email"
                            value="{{ empty(session('email')) ? old('email') : session('email') }}"
                            class="input w-full border sm:border-2  border-primary">
                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label for="phone_number" class="block text-sm md:text-md font-semibold text-primary">Phone
                        Number<sup>*</sup></label>
                    <div class="mt-1">
                        <input type="tel" id="phone_number" required maxlength="15" name="phone_number"
                            autocomplete="phone_number"
                            value="{{ empty(session('phone_number')) ? old('phone_number') : session('phone_number') }}"
                            class="input w-full border sm:border-2  border-primary">
                        @if ($errors->has('phone_number'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('phone_number') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label for="password"
                        class="block text-sm md:text-md font-semibold text-primary">Password<sup>*</sup></label>
                    <div class="mt-1 password-field-container">
                        <input type="password" id="password" name="password" autocomplete="password"
                            value="{{ empty(session('password')) ? old('password') : session('password') }}"
                            class="input w-full border sm:border-2  border-primary" style="padding-right: 40px;">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')" 
                                aria-label="Toggle password visibility" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 4px; color: #6b7280; z-index: 10; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                            <svg id="password-eye" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px; display: block;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg id="password-eye-slash" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none; width: 20px; height: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 11-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label for="password_confirmation"
                        class="block text-sm md:text-md font-semibold text-primary">Confirm
                        Password<sup>*</sup></label>
                    <div class="mt-1 password-field-container">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            autocomplete="confirm_password" class="input w-full border sm:border-2  border-primary" style="padding-right: 40px;">
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')" 
                                aria-label="Toggle password visibility" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 4px; color: #6b7280; z-index: 10; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                            <svg id="password_confirmation-eye" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px; display: block;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg id="password_confirmation-eye-slash" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none; width: 20px; height: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 11-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                        @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Newsletter Opt-in Section -->
            <div class="mt-8">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="newsletter_optin" name="newsletter_optin" type="checkbox" 
                               value="1" 
                               {{ old('newsletter_optin') || session('newsletter_optin') ? 'checked' : '' }}
                               class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="newsletter_optin" class="font-medium text-primary">
                            Subscribe to our newsletter
                        </label>
                        <p class="text-gray-600 text-xs mt-1">
                            Get weekly updates about coffee stories from our farmers and their stock
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-20">
                <div class="flex items-center justify-between">
                    <a href="{{ route('account_type') }}"
                        class="btn btn-outline-secondary mb-md-3 mt-6 m-2 text-primary capitalize btn-md  md:w-max px-20" style="border-width: medium;">
                        <i class="fa fa-angle-left" style="margin-right:15px;margin-left:15px;"></i>Previous Step
                    </a>
                    <button type="submit" class="mt-6 btn btn-primary btn-md m-2 md:w-max px-20 text-white capitalize ">
                        Next Step
                    </button>
                </div>
            </div>
        </form>
    </div>



</section>
@endsection

@section('scripts')
<script>
    // Password reveal functionality
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(fieldId + '-eye');
        const eyeSlashIcon = document.getElementById(fieldId + '-eye-slash');
        
        if (passwordField.type === 'password') {
            // Show password
            passwordField.type = 'text';
            eyeIcon.style.display = 'none';
            eyeSlashIcon.style.display = 'block';
        } else {
            // Hide password
            passwordField.type = 'password';
            eyeIcon.style.display = 'block';
            eyeSlashIcon.style.display = 'none';
        }
    }

    // Password confirmation validation
    document.addEventListener('DOMContentLoaded', function() {
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('password_confirmation');
        const submitButton = document.querySelector('button[type="submit"]');
        const form = document.querySelector('form');

        // Function to validate password confirmation
        function validatePasswordConfirmation() {
            const password = passwordField.value;
            const confirmPassword = confirmPasswordField.value;

            // Check if passwords match
            if (password !== confirmPassword) {
                confirmPasswordField.style.borderColor = '#dc3545';
                submitButton.disabled = true;
                submitButton.style.opacity = '0.6';
                submitButton.style.cursor = 'not-allowed';

                // Show error message if not already present
                let errorMessage = confirmPasswordField.parentNode.querySelector('.password-error');
                if (!errorMessage) {
                    errorMessage = document.createElement('span');
                    errorMessage.className = 'password-error';
                    errorMessage.style.color = '#dc3545';
                    errorMessage.style.fontSize = '0.875rem';
                    errorMessage.style.marginTop = '0.25rem';
                    errorMessage.style.display = 'block';
                    errorMessage.textContent = 'Passwords do not match';
                    confirmPasswordField.parentNode.appendChild(errorMessage);
                }
                return false;
            } else {
                confirmPasswordField.style.borderColor = '#28a745';
                submitButton.disabled = false;
                submitButton.style.opacity = '1';
                submitButton.style.cursor = 'pointer';

                // Remove error message if present
                const errorMessage = confirmPasswordField.parentNode.querySelector('.password-error');
                if (errorMessage) {
                    errorMessage.remove();
                }
                return true;
            }
        }

        // Add event listeners for real-time validation
        passwordField.addEventListener('input', validatePasswordConfirmation);
        confirmPasswordField.addEventListener('input', validatePasswordConfirmation);

        // Form submission validation
        form.addEventListener('submit', function(e) {
            if (!validatePasswordConfirmation()) {
                e.preventDefault();
                alert('Please ensure both passwords match before proceeding.');
                return false;
            }
        });

        // Initial validation state
        validatePasswordConfirmation();
    });
</script>

{{-- <script>
        const buyerButton = document.getElementById('buyerButton');
        const sellerButton = document.getElementById('sellerButton');
        const buyerForm = document.getElementById('buyerForm');
        const sellerForm = document.getElementById('sellerForm');

        buyerButton.addEventListener('click', () => {
            buyerForm.style.display = 'block';
            sellerForm.style.display = 'none';
        });

        sellerButton.addEventListener('click', () => {
            buyerForm.style.display = 'block';
            sellerForm.style.display = 'none';
        });
    </script> --}}

@endsection