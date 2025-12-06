<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>ViaNexta</title>
           <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
           <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>

    <body>
        <div class="flex flex-col h-screen bg-cover bg-center" style="background-image: url({{asset('images/hero_img.png')}});">
            <div class="flex flex-row justify-between items-center p-4">
              <a href="{{route('welcome')}}">
                <div class="flex flex-row items-center gap-x-5">
                    <img src="{{asset('images/logo_new.png')}}" alt="logo" class="w-12 h-12" />
                </div>
              </a>
            </div>
            <div class="flex flex-col items-center flex-grow mx-auto max-w-6xl text-center">
                <h1 class="animate-jump-in animate-once animate-delay-700 animate-ease-in  text-7xl font-bold mb-10 text-white">We connect coffee farmers directly to buyers</h1>
                <button class="bg-[#003F33] hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-md">
                    Learn more from our agents
                </button>
            </div>
            <div class="flex flex-row justify-between items-center">
                <a href="#who" class="flex flex-col items-center border-y-2 border-r-2 border-[#003F33] w-1/4 p-4">
                    <h1 class="animate-fade-right animate-delay-400 text-2xl font-bold text-[#003F33]">Who we are</h1>
                </a>
                <a href="#what" class="flex flex-col items-center border-y-2 border-r-2 border-[#003F33] w-1/4 p-4">
                    <h1 class="animate-fade-right animate-delay-700 text-2xl font-bold text-[#003F33]">What we do</h1>
                </a>
                <a href="how" class="flex flex-col items-center border-y-2 border-r-2 border-[#003F33] w-1/4 p-4">
                    <h1 class="animate-fade-right animate-delay-1000 text-2xl font-bold text-[#003F33]">How we do it</h1>
                </a>
                <a href="#why" class="flex flex-col items-center border-y-2 border-[#003F33] w-1/4 p-4">
                    <h1 class="animate-fade-right animate-delay-6000 text-2xl font-bold text-[#003F33]">Why we do it</h1>
                </a>
            </div>
        </div>

       <!-- WHO WE ARE SECTION -->

    <div class="py-16 bg-[#07382F]">
      <section id="who" 
        class="mx-auto max-w-screen-2xl flex flex-col justify-between gap-6 sm:gap-10 md:gap-16 lg:flex-row"
      >
        <!-- image - start -->
        <div class="animate-fade animate-once animate-delay-1000 animate-ease-in h-48 overflow-hidden lg:h-auto xl:w-6/12">
          <img
            src="{{asset('images/who_we_are.svg')}}"
            loading="lazy"
            alt="Photo by Fakurian Design"
            class="h-full w-full object-cover object-center"
          />
        </div>
        <!-- image - end -->

        <!-- content - start -->
        <div
          class="flex flex-col justify-center sm:text-center lg:py-12 lg:text-left xl:w-5/12 xl:py-24"
        >
          <p
            class="animate-fade-up animate-once animate-delay-300 animate-ease-in animate-normal animate-fill-forwards mb-4 font-semibold text-white md:mb-6 md:text-lg xl:text-2xl"
          >
            Who we are
          </p>

          <h1
            class="animate-fade-up animate-once animate-delay-500 animate-ease-in animate-normal animate-fill-forwards mb-8 text-4xl font-bold text-white sm:text-5xl md:mb-12 md:text-7xl"
          >
            Stewards<br />
            of change
          </h1>

          <p
            class="animate-fade-up animate-once animate-delay-700 animate-ease-in animate-normal animate-fill-forwards mb-8 leading-relaxed text-white md:mb-12 lg:w-4/5 md:text-2xl"
          >
            We are problem solvers who love people, the environment, and coffee
          </p>
        </div>
        <!-- content - end -->
      </section>
    </div>

    <!-- WHAT WE DO SECTION -->
    <div class="py-16 bg-[#D8501C]">
      <section id="what"
        class="mx-auto max-w-screen-2xl flex flex-col justify-between gap-6 sm:gap-10 md:gap-16 lg:flex-row"
      >
        <!-- content - start -->
        <div
          class="flex flex-col justify-center sm:text-center ml-4 lg:py-12 lg:text-left xl:w-5/12 xl:py-24"
        >
          <p
            class="animate-fade-up animate-once animate-delay-300 mb-4 font-semibold text-white md:mb-6 md:text-lg xl:text-2xl"
          >
            What we do
          </p>

          <h1
            class="animate-fade-up animate-once animate-delay-500 mb-8 text-4xl font-bold text-white sm:text-5xl md:mb-12 md:text-7xl"
          >
            Make the world more fair
          </h1>
          <p
            class="animate-fade-up animate-once animate-delay-700 mb-8 leading-relaxed text-white md:mb-12 lg:w-4/5 md:text-2xl"
          >
            We build technology that fills gaps in the supply chain by bringing
            the buyer and seller closer together. With ViaNexta, the coffee
            industry has its own marketplace where buyers can find competitively
            priced goods, and sellers can earn more money.
          </p>
        </div>
        <!-- content - end -->
        <!-- image - start -->
        <div class="animate-fade-left animate-once animate-delay-1000 overflow-hidden lg:h-auto xl:w-6/12">
          <img
            src="{{asset('images/what_we_do.svg')}}"
            loading="lazy"
            alt="scale"
            class=" object-cover object-center"

          />
        </div>
        <!-- image - end -->
      </section>
    </div>

    <!-- HOW WE DO IT SECTION -->
    <div class="bg-[#FEF0E3] pb-6 sm:pb-8 lg:pb-12">
      <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
        <section class="flex flex-col items-center" id="how">
          <div
            class="flex max-w-7xl flex-col items-center pb-0 pt-8 text-center sm:pb-16 lg:pb-32 lg:pt-32"
          >
            <p
              class="animate-fade-up animate-once animate-delay-700 mb-4 font-semibold text-black md:mb-6 md:text-lg xl:text-xl"
            >
              How we do it
            </p>

            <h1
              class="animate-fade-up animate-once animate-delay-1000 mb-8 text-4xl font-bold text-black sm:text-5xl md:mb-12 md:text-6xl"
            >
              We use cutting edge technology assisted by artificial intelligence
              and machine learning to remove bottle necks and waste from the
              coffee supply chain
            </h1>
          </div>
        </section>
      </div>
    </div>

    <!-- WHY WE DO IT SECTION -->
    <div class="bg-[#07382F] pb-6 sm:pb-8 lg:pb-12">
      <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
        <section class="flex flex-col items-center" id="what"> 
          <div
            class="flex max-w-7xl flex-col items-center pb-0 pt-8 text-center sm:pb-16 lg:pb-32 lg:pt-32"
          >
            <p
              class="animate-fade-up animate-once animate-delay-700 mb-4 font-semibold text-white md:mb-6 md:text-lg xl:text-xl"
            >
              Why we do it
            </p>

            <h1
              class="animate-fade-up animate-once animate-delay-1000 mb-8 text-4xl font-bold text-white sm:text-5xl md:mb-12 md:text-6xl"
            >
              We use cutting edge technology assisted by artificial intelligence
              and machine learning to remove bottle necks and waste from the
              coffee supply chain
            </h1>

            <div class="animate-jump animate-once animate-delay-300">
              <img src="{{asset('images/why_we_do_it.svg')}}" alt="" />
            </div>
          </div>
        </section>
      </div>
    </div>

    <!-- NEWSLETTER FOOTER SECTION -->
    <div class="bg-[#FEF0E3] animate-fade-up animate-once animate-delay-1000 ">
  <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
    <div class="flex flex-col items-center gap-10 p-4 sm:p-8 lg:flex-row ">
      <div class="flex mb-4 sm:mb-8 lg:mb-0 w-1/2">
        <h2 class="text-center text-xl font-bold text-black sm:text-2xl lg:text-left lg:text-4xl">Let's Stay Connected</h2>
        <p class="text-center text-gray-500 lg:text-left self-end text-xl">Sign up for our weekly newsletter for stories from our farmers and their stock</p>
      </div>

      <div class="flex flex-col w-1/2">
        <form class="mb-3 flex  gap-2 flex-col" action="#">
          <input placeholder="Email Address" class="bg-gray-white w-full flex-1  placeholder:text-center  placeholder:font-bold placeholder:text-black rounded border border-[#07382F] px-3 py-2 text-gray-800 placeholder-gray-400 outline-none ring-[#07382F] transition duration-100 focus:ring" />

          <a type="button" class="inline-block rounded bg-[#D8501C] px-8 py-2 text-center text-sm font-semibold text-white outline-none ring-indigo-300 transition duration-100 hover:bg-[#D8501C] focus-visible:ring active:bg-[#D8501C] md:text-base">Sign Up</a>
        </form>


      </div>
    </div>

  </div>

</div>
<div class="bg-[#D8501C] py-6 animate-fade-up animate-once animate-delay-1000">
  <div class="mx-auto max-w-screen-2xl px-4 md:px-8">

     <div class="flex flex-col items-center rounded-lg  px-4 sm:px-8 lg:flex-row lg:justify-between">
      <div class="mb-4 sm:mb-8 lg:mb-0">
        <h2 class="text-center text-xl font-bold text-white sm:text-2xl lg:text-left lg:text-3xl">Learn more from our agent</h2>

      </div>

      <div class="flex flex-col items-center lg:items-end">
         <img src="{{asset('images/arrow.svg')}}" alt="" />
      </div>
    </div>
  </div>
</div>
<div class="bg-[#07382F] py-2 animate-fade-up animate-once animate-delay-1000">
  <div class="mx-auto max-w-screen-2xl px-4 md:px-8">

     <div class="flex flex-col items-center rounded-lg  px-4 sm:px-8 lg:flex-row lg:justify-between">
      <div class="mb-4 sm:mb-8 lg:mb-0">
        <h6 class="text-center text-xl text-white sm:text-1xl lg:text-left lg:text-2xl"> {{date('Y')}} © ViaNexta | All Rights Reserved.</h6>
      </div>
    </div>
  </div>
</div>
    </body>
</html>

