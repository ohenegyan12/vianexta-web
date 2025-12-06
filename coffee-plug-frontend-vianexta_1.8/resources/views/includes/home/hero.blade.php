@section('header-scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection


<div class="bg-accent relative flex flex-col h-3/4 md:h-screen bg-cover bg-no-repeat bg-[center_bottom_5rem] sm:bg-center "
    style="background-image: url({{ asset('images/hero_md-2.webp') }})">

    <div class="flex flex-row justify-between items-center p-4">
        <a href="{{ route('home_page') }}">
            <div class="flex flex-row items-center gap-x-2" data-aos="fade-right" data-aos-duration="900">
                <h2 class="text-2xl md:text-3xl font-semibold text-white">ViaNexta</h2>
                <img src="{{ asset('images/logo_new.png') }}" alt="logo" class="w-12 h-12" />
            </div>
        </a>
        <div class="flex items-center gap-x-4 text-white">
            @php if(session('auth_user_tokin') ==null){ @endphp
                <a href="{{ route('login_page') }}">
                <div class="text-lg font-semibold text-white hidden sm:block">Log in</div>
                </a>
             @php } else { @endphp
                 <a href="{{ route('account_dashboard') }}">
                <div class="text-lg font-semibold text-white hidden sm:block">Welcome {{session('auth_user_name')}}</div>
                </a>
            @php } @endphp
           
            <a href="{{route('buyer_cart')}}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-10 h-10  hidden sm:block">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>

            </a>
            <div x-data="{ open: false }">
                <button @click=" open = !open ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>

                </button>

                @include('includes.flyout_menu')

            </div>

        </div>
    </div>
    <div class=" flex flex-col items-center flex-grow mx-auto  xl:max-w-5xl text-center">
        <h1 class="hidden md:block sm:text-4xl mx-auto max-w-2xl xl:max-w-5xl md:text-5xl 2xl:text-6xl font-bold text-white mt-20 md:mt-2 mb-10"
            data-aos="fade-in" data-aos-duration="900" data-aos-delay="650">
            We connect coffee farmers directly to buyers.</h1>
        <a href="{{ route('login') }}">
            <button class="hidden md:block btn btn-secondary " data-aos="fade-in" data-aos-duration="1000"
                data-aos-delay="750">
                <span class="text-white font-sora">Let's get started</span>

            </button>
        </a>
    </div>
    <div class="sm:hidden p-5">
        <h1 class="text-3xl  font-bold mb-10 text-secondary font-sora " data-aos="fade-up" data-aos-duration="300"
            data-aos-delay="500">
            We connect coffee farmers directly to buyers.</h1>
        <button class="btn btn-secondary " data-aos="fade-down" data-aos-duration="500" data-aos-delay="700">
            <span class="text-white font-sora">Let's get started</span>
        </button>
    </div>

    <div class="hidden md:flex flex-row justify-between items-center bg-accent">
        <a href="#who" class="flex flex-col items-center border-y-2 border-r-2 border-secondary w-1/4 p-4">
            <h1 class="fade-in-left text-xl font-semibold text-secondary">Who we are</h1>
        </a>
        <a href="#what" class="flex flex-col items-center border-y-2 border-r-2 border-secondary w-1/4 p-4">
            <h1 class="transition duration-500 fade-in-left text-xl font-semibold text-secondary">What we do
            </h1>
        </a>
        <a href="#how" class="flex flex-col items-center border-y-2 border-r-2 border-secondary w-1/4 p-4">
            <h1 class="transition duration-900 fade-in-left  text-xl font-semibold text-secondary">How we do
                it</h1>
        </a>
        <a href="#why" class="flex flex-col items-center border-y-2 border-secondary w-1/4 p-4">
            <h1 class="transition duration-1000 fade-in-left text-xl font-semibold text-secondary">Why we
                do it</h1>
        </a>
    </div>
</div>
