@extends('layouts.auth_layout ')
@section('title', 'Login ')


@section('content')
        <form action="{{ route('new-password') }}" method="POST" aria-label="{{ __('reset_password') }}" class="align-middle">
            @csrf
            <input  name="token" type="hidden" value="{{$token}}"/>
            <input  name="email" type="hidden" value="{{$encoded_email}}"/>
            <div class="relative mx-auto max-w-xl xl:max-w-2xl px-4 py-8">
                <h1 class="text-3xl md:text-4xl font-semibold text-secondary mb-10">Enter New Password</h1>
                <div class="mb-4 sm:mb-8">
                    <input type="password" name="password" id="password"
                        class="input input-bordered input-accent bg-white w-full input-md placeholder:text-center"
                        placeholder="Enter password" required value="{{ old('password') }}">
                    @if ($errors->has('password') || !empty(session('error')))
                        <span class="invalid-feedback" role="alert">
                            <strong
                                style="color: red;">{{ !empty(session('error')) ? session('error') : $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="mb-4 sm:mb-8">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="input input-bordered input-accent bg-white w-full input-md placeholder:text-center"
                        placeholder="Confirm password" required value="{{ old('password_confirmation') }}">
                    @if ($errors->has('password_confirmation') || !empty(session('error')))
                        <span class="invalid-feedback" role="alert">
                            <strong
                                style="color: red;">{{ !empty(session('error')) ? session('error') : $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="mt-10">
                    <button type="submit" class="btn btn-primary border-0 w-full btn-md ">Reset Password</button>
                </div>
        
            </div>
        </form>

    {{-- pop up alert --}}
    @include('includes.alerts.error_alert');
    @include('includes.alerts.reg_success_alert');
@endsection
@section('scripts')

    <script>
        function showAlertModal() {
            var modal = document.getElementById("alert-modal");
            modal.classList.remove("hidden");
            setTimeout(function() {
                modal.classList.add("hidden");
            }, 3000);
        }
        function showRegSuccessModal() {
            var modal = document.getElementById("reg_success_alert");
            modal.classList.remove("hidden");
            setTimeout(function() {
                modal.classList.add("hidden");
            }, 4000);
        }
        document.addEventListener("DOMContentLoaded", function() {

        });
    </script>
    @if (!empty(session('error')))
        @php echo '<script>
            showAlertModal();
        </script>'@endphp
    @endif
    @if (!empty(session('registration_successful')))
        @php echo '<script>
            showRegSuccessModal();
        </script>'@endphp
    @endif

    
@endsection
