<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoffeePlug</title>
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">

     <link rel="stylesheet" href="{{ asset('abel_assets/css/plugins/select2.min.css')}}">
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/css/flag-icon.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>

<body>

    <!-- validate email with js -->

    <script>
        // function to validate email when button is submitted
        function validate() {
            var passcode = document.getElementById("passcode").value;
            var text;

            // validate email
            var passcode_actual = "CFP@2023";

            if (passcode != passcode_actual) {
                text = "Please enter a valid passcode.";
            }

            document.getElementById("validate").innerHTML = text;
        }

        function hideWrongEntry() {
            document.getElementById("validate").innerHTML = "";
        }
    </script>


    <div class="grid grid-cols-1 grid-rows-2 sm:grid-rows-1 sm:grid-cols-2 2xl:grid-cols-3 h-screen ">
        <div class="row-span-1 sm:col-span-1 2xl:col-span-1 flex flex-col justify-between p-8 md:p-16" style="background-color: #07382F">
            <div class="flex flex-row justify-center md:justify-between items-center ">
                <div class="flex
                fade-in-left
                flex-row  items-center gap-x-4 sm:mb-10">
                    <img src="{{ asset('images/vienexta_white.png') }}" alt="logo"
                        class="h-10 sm:h-15 xl:h-20" />
                </div>
            </div>
            
            <div class="flex flex-col" id="invite_code_entry">
                <h1
                    class="text-2xl sm:text-5xl xl:text-6xl font-bold font-sora mb-10 sm:mt-0 text-accent fade-in-left-300 sm:text-start">
                    Enter Invite Code
                </h1>

                <div class="w-full sm:max-w-sm md:max-w-md 2xl:max-w-2xl">
                    <form action="{{ route('check_passcode') }}" class=" w-full max-w-md gap-2 sm:mb-5" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- validate emial -->
                        <div class="relative flex flex-col mb-2 sm:mb-6">
                            <input class="input input-bordered input-accent bg-white w-full input-md" type="text"
                                id="passcode" name="passcode" value="{{ old('passcode') }}" required
                                placeholder="Enter Passcode" onkeyup="hideWrongEntry()">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg xmlns="https://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                           
                        </div>
                         @if(session('error'))
                                <p id="validate" class="text-white font-sora">Invalid Passcode Entry!</p>
                            @else
                                <p  class="text-white font-sora ">Don't have an invite?    
                                <a href="#" style="padding-left: 20px;color:#ffff;font-style: italic;" onclick="showEmail()">
                                    <span class="text-decoration-underline" style="text-decoration-color: #D8501C !important"> Request one</span>
                                </a>
                                </p>
                            @endif

                        <!-- validate email -->
                        <button type="submit" class="btn btn-primary  border-0 w-full btn-md  ">
                            <span class="text-white font-sora">Let's Go</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="flex flex-col" id="send_invite_email" style="display: none">
                <h1
                    class="text-2xl sm:text-5xl xl:text-6xl font-bold font-sora mb-10 sm:mt-0 text-accent fade-in-left-300 text-center sm:text-start">
                    Request Invite Code
                </h1>

                <div class="w-full sm:max-w-sm md:max-w-md 2xl:max-w-2xl">
                    <form action="{{ route('send_invite_code') }}" class=" w-full max-w-md gap-2 sm:mb-5" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- validate emial -->
                        <div class="relative flex flex-col mb-2 sm:mb-6">
                              <input class="input input-bordered input-accent bg-white w-full input-md" type="email"
                                id="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter Email" onkeyup="hideWrongEntry()">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg xmlns="https://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                           
                        </div>
                         @if(session('error'))
                                <p id="validate" class="text-white font-sora">Invite sending failed!</p>
                            @else
                                <p class="text-white font-sora mt-2" >Click    
                                <a href="#" onclick="hideEmail()" style="padding-left: 2px;padding-right: 2px;color:#ffff;font-style: italic;" onclick="showEmail()">
                                    <span class="text-decoration-underline" style="text-decoration-color: #D8501C !important">here</span>
                                </a>
                                 if you already have an invite code
                                </p>
                            @endif

                        <!-- validate email -->
                        <button type="submit" class="btn btn-primary  border-0 w-full btn-md  ">
                                <span class="text-white font-sora">Request Invite code</span>
                        </button>
                        
                    </form>
                </div>
            </div>




            <div class="body-1 hidden md:flex flex-row justify-between text-md font-sora  text-white">
                {{ date('Y') }} © ViaNexta | All Rights Reserved.
            </div>
        </div>



        <div class="relative h-full row-span-1 sm:col-span-1  2xl:col-span-2">
            <video playsinline autoplay muted loop poster="{{ asset('images/coming_soon.png') }}"  class="absolute md:block inset-0 h-full w-full object-cover xl:object-left hidden object-center " loading="lazy">
                <source src="{{ asset('images/coming_soon.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <video playsinline autoplay muted loop poster="{{ asset('images/coming_soon.png') }}"  class="absolute block right-52 inset-0 h-full w-full object-cover object-left md:hidden" loading="lazy">
                <source src="{{ asset('images/coming_soon.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <!-- <img src="{{ asset('images/coming_soon.png') }}" loading="lazy" alt="Photo by mymind"
                class="absolute md:block inset-0 h-full w-full object-cover xl:object-left hidden object-center " />
            <img src="{{ asset('images/coming_soon_reverse.png') }}" loading="lazy" alt="Photo by mymind"
                class="absolute block right-52 inset-0 h-full w-full object-cover object-left md:hidden " /> -->
        </div>
    </div>

 <script src="{{ asset('vendor/js/bootstrap.min.js') }}"></script>
<!-- sweet alert Js -->
<script src="{{ asset('abel_assets/js/vendor-all.min.js')}}"></script>
<script src="{{ asset('abel_assets/js/plugins/sweetalert.min.js')}}"></script>

 @include('includes.alerts.sweet_alert_scripts')
    <script>
        AOS.init();

      

        function showEmail(){
              const inviteCodeDiv = document.getElementById('invite_code_entry');
              const emailDiv = document.getElementById('send_invite_email');

              inviteCodeDiv.style.display = 'none';
              emailDiv.style.display = 'block';
        }

        function hideEmail(){
            const inviteCodeDiv = document.getElementById('invite_code_entry');
            const emailDiv = document.getElementById('send_invite_email');

            inviteCodeDiv.style.display = 'block';
            emailDiv.style.display = 'none';
        }
            

    </script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('abel_assets/js/vendor-all.min.js')}}"></script>
    <script src="{{ asset('abel_assets/js/plugins/select2.full.min.js')}}"></script>
    <script src="{{ asset('abel_assets/js/pages/form-select-custom.js')}}"></script>

</body>

</html>
