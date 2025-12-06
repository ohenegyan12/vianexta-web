@extends('layouts.auth_layout ')
@section('title', 'Login ')

@push('css')
<link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">
@endpush

@section('content')

<div id="login_section">
    <form action="{{ route('manualLogin') }}" method="POST" aria-label="{{ __('Login') }}" class="align-middle">
        @csrf
        <div class="relative mx-auto max-w-xl xl:max-w-2xl px-4 py-8 pt-lg-5">
            <h1 class="text-3xl md:text-4xl font-semibold text-primary mt-5 mb-10">Log In</h1>
            <div class="mb-4 sm:mb-8">
                <input type="email" name="email" id="email"
                    class="input input-bordered input-accent bg-white w-full input-md placeholder:text-center"
                    placeholder="email or phone" required value="{{ old('email') }}">
                @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red;">{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <div class="mb-4 sm:mb-8">
                <div class="flex items-center input">
                    <input type="password" name="password" id="password"
                        class=" input-bordered input-accent bg-white w-full input-md placeholder:text-center" style="height: 40px;"
                        placeholder="password" required value="{{ old('password') }}">
                    <button type="button" id="togglePassword"
                        class="focus:outline-none -ml-8">
                        <svg class="flex-shrink-0 size-3.5 text-gray-400 dark:text-neutral-600" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path class="hs-password-active:hidden" d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                            <path class="hs-password-active:hidden" d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                            <path class="hs-password-active:hidden" d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                            <line class="hs-password-active:hidden" x1="2" x2="22" y1="2" y2="22"></line>
                            <path class="hidden hs-password-active:block" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                            <circle class="hidden hs-password-active:block" cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
                @if ($errors->has('password') || !empty(session('error')))
                <span class="invalid-feedback" role="alert">
                    <strong
                        style="color: red;">{{ !empty(session('error')) ? session('error') : $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <p class="body-1">
                <a href="#" onclick="showPasswordReset()" class="text-lg text-primary">Forgot password?</a>
            </p>
            <div class="mt-10">
                <a href="{{ route('languages') }}">
                    <button type="submit" class="btn btn-primary border-0 w-full btn-md  ">Log In</button>
                </a>
            </div>
            <div class="flex justify-between items-center gap-x-4 my-4">
                <hr class="border-secondary w-2/5">
                <p class="text-xs sm:text-lg text-center">Or with</p>
                <hr class="border-secondary w-2/5">
            </div>
            <div class="flex items-center gap-x-4 justify-between mb-8">
                <!-- <button type="button" class="btn btn-outline text-xs w-1/2  capitalize">
                        <img src="{{ asset('images/Facebook.svg') }}" alt="">
                        Facebook
                    </button>
                    <button type="button" class="btn btn-outline text-xs w-1/2 capitalize">
                        <img src="{{ asset('images/Google_logo.svg') }}" alt="">

                        Google
                    </button> -->
            </div>
            <h3 class="text-lg md:text-xl  font-normal text-center mb-8">
                Don't have an account? <a href="{{ route('languages') }}" class="text-secondary font-bold no-underline">Sign
                    Up</a>
            </h3>

            <!-- <div class="flex flex-col sm:flex-row  sm:items-center sm:justify-center gap-y-5 gap-x-10 ">
                    <div class="flex items-center">
                        <button type="button" class="btn-toggle" role="switch" aria-checked="false"
                            aria-labelledby="annual-billing-label">
                            <span aria-hidden="true"
                                class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                        <span class="ml-3 text-sm flex flex-col" id="annual-billing-label">
                            <span class="font-semibold text-gray-900">Daily reports</span>
                            <span class="text-gray-500">Get daily coffee news via email.</span>
                        </span>
                    </div>
                    <div class="flex items-center">
                        <button type="button" class="btn-toggle" role="switch" aria-checked="false"
                            aria-labelledby="annual-billing-label">
                            <span aria-hidden="true"
                                class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                        <span class="ml-3 text-sm flex flex-col" id="annual-billing-label">
                            <span class="font-semibold text-gray-900">Weekly summary</span>
                            <span class="text-gray-500">Get weekly coffee news via email.</span>
                        </span>
                    </div>
                </div>  -->
        </div>
    </form>
</div>

<div id="forgot_password_section" style="display:none">
    <form action="{{ route('passwordResetEmail') }}" method="POST" aria-label="{{ __('Login') }}" class="align-middle">
        @csrf
        <div class="relative mx-auto max-w-xl xl:max-w-2xl px-4 py-8">
            <h1 class="text-3xl md:text-4xl font-semibold text-secondary mb-10">Reset Password</h1>
            <div class="mb-4 sm:mb-8">
                <input type="email" name="email" id="email"
                    class="input input-bordered input-accent bg-white w-full input-md placeholder:text-center"
                    placeholder="Enter your email" required value="{{ old('email') }}">
                @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red;">{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <p class="body-1">
                <a href="#" onclick="hidePasswordReset()" class="text-lg text-secondary">Back to Login</a>
            </p>
            <div class="mt-10">
                <button type="submit" class="btn btn-primary border-0 w-full btn-md  ">Reset Password</button>
            </div>

        </div>
    </form>
</div>

@include('includes.alerts.error_alert');
@include('includes.alerts.reg_success_alert');
@endsection
@section('scripts')

<script>
    function showPasswordReset() {
        var forgot_password_section = document.getElementById("forgot_password_section");
        var login_section = document.getElementById("login_section");

        forgot_password_section.style.display = "block";
        login_section.style.display = "none";
    }

    function hidePasswordReset() {
        var forgot_password_section = document.getElementById("forgot_password_section");
        var login_section = document.getElementById("login_section");

        forgot_password_section.style.display = "none";
        login_section.style.display = "block";
    }

    // Add the missing closeAlertModal function
    function closeAlertModal() {
        var modal = document.getElementById("alert-modal");
        if (modal) {
            modal.classList.add("hidden");
        }
    }


    document.addEventListener('DOMContentLoaded', function() {
        const passIn = document.getElementById('password');
        const btn = document.getElementById('togglePassword');
        btn.addEventListener('click', function() {
            const type =
                passIn.getAttribute('type') ===
                'password' ? 'text' : 'password';
            passIn.setAttribute('type', type);
        });
    });

    // function showAlertModal() {
    //     var modal = document.getElementById("alert-modal");
    //     modal.classList.remove("hidden");
    //     setTimeout(function() {
    //         modal.classList.add("hidden");
    //     }, 3000);
    // }
    // function showRegSuccessModal() {
    //     var modal = document.getElementById("reg_success_alert");
    //     modal.classList.remove("hidden");
    //     setTimeout(function() {
    //         modal.classList.add("hidden");
    //     }, 4000);
    // }
    document.addEventListener("DOMContentLoaded", function() {

    });
</script>
<!-- @if (!empty(session('error')))
        @php echo '<script>
            showAlertModal();
        </script>'@endphp
    @endif
    @if (!empty(session('registration_successful')))
        @php echo '<script>
            showRegSuccessModal();
        </script>'@endphp
    @endif -->

<!-- Clare Chat Component -->
<script src="{{ asset('js/clare-component.js') }}"></script>

@endsection