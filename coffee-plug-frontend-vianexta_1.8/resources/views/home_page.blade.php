@extends('layouts.home_layout ')
<!-- yeild title -->
@section('title', 'Home')
<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/24342903.js"></script>
<!-- End of HubSpot Embed Code -->

@section('content')

    {{-- HERO SECTION --}}
    @include('includes.home.hero')

    <!-- WHO WE ARE SECTION -->
    @include('includes.home.who_we_are')

    <!-- WHAT WE DO SECTION -->
    @include('includes.home.what_we_do')

    <!-- HOW WE DO IT SECTION -->
    @include('includes.home.how_we_do_it')

    <!-- WHY WE DO IT SECTION -->
    @include('includes.home.why_we_do_it')

    <!-- testimonial section  -->
<section class="py-4 bg-gray sm:py-8 ">
        <div class="container px-4 mx-auto sm:px-6 lg:px-8">
            <div class="grid items-center gap-8 grid-col-12 sm:grid-cols-2 md:gap-16">
      <h2 class="max-w-xl text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
        Read trusted reviews from our customers
      </h2>

      <div class="mt-8 flex gap-4 lg:mt-0">
        <button
          aria-label="Previous slide"
          id="keen-slider-previous"
          class="rounded-full border border-rose-600 p-3 text-rose-600 transition hover:bg-rose-600 hover:text-white"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-5 w-5 rtl:rotate-180"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15.75 19.5L8.25 12l7.5-7.5"
            />
          </svg>
        </button>

        <button
          aria-label="Next slide"
          id="keen-slider-next"
          class="rounded-full border border-rose-600 p-3 text-rose-600 transition hover:bg-rose-600 hover:text-white"
        >
          <svg
            class="h-5 w-5 rtl:rotate-180"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M9 5l7 7-7 7"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
            />
          </svg>
        </button>
      </div>
    </div>

    <div class="-mx-6 mt-8 lg:col-span-2 lg:mx-0">
      <div id="keen-slider" class="keen-slider">
        <div class="keen-slider__slide">
          <blockquote
            class="flex h-full flex-col justify-between bg-white p-6 shadow-sm sm:p-8 lg:p-12"
          >
            <div>
              <div class="flex items-center gap-4">
          <img
            alt="Man"
            src="https://images.unsplash.com/photo-1595152772835-219674b2a8a6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1180&q=80"
            class="h-14 w-14 rounded-full object-cover"
          />

          <div>
            <div class="flex justify-center gap-0.5 text-green-500">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
            </div>

            <p class="mt-0.5 text-lg font-medium text-gray-900">Matt Star</p>
          </div>
        </div>

              <div class="mt-4">
                <p class="text-2xl font-bold text-rose-600 sm:text-3xl">
                  Stayin' Alive
                </p>

                <p class="mt-4 leading-relaxed text-gray-700">
                  No, Rose, they are not breathing. And they have no arms or
                  legs … Where are they? You know what? If we come across
                  somebody with no arms or legs, do we bother resuscitating
                  them? I mean, what quality of life do we have there?
                </p>
              </div>
            </div>

            <footer class="mt-4 text-sm font-medium text-gray-700 sm:mt-6">
              &mdash; Michael Scott
            </footer>
          </blockquote>
        </div>

        <div class="keen-slider__slide">
          <blockquote
            class="flex h-full flex-col justify-between bg-white p-6 shadow-sm sm:p-8 lg:p-12"
          >
            <div>
            <div class="flex items-center gap-4">
          <img
            alt="Man"
            src="https://images.unsplash.com/photo-1595152772835-219674b2a8a6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1180&q=80"
            class="h-14 w-14 rounded-full object-cover"
          />

          <div>
            <div class="flex justify-center gap-0.5 text-green-500">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
            </div>

            <p class="mt-0.5 text-lg font-medium text-gray-900">Chuyan Starr</p>
          </div>
        </div>

              <div class="mt-4">
                <p class="text-2xl font-bold text-rose-600 sm:text-3xl">
                  Stayin' Alive
                </p>

                <p class="mt-4 leading-relaxed text-gray-700">
                  No, Rose, they are not breathing. And they have no arms or
                  legs … Where are they? You know what? If we come across
                  somebody with no arms or legs, do we bother resuscitating
                  them? I mean, what quality of life do we have there?
                </p>
              </div>
            </div>

            <footer class="mt-4 text-sm font-medium text-gray-700 sm:mt-6">
              &mdash; Michael Scott
            </footer>
          </blockquote>
        </div>

        <div class="keen-slider__slide">
          <blockquote
            class="flex h-full flex-col justify-between bg-white p-6 shadow-sm sm:p-8 lg:p-12"
          >
            <div>
              <div class="flex items-center gap-4">
          <img
            alt="Man"
            src="https://images.unsplash.com/photo-1595152772835-219674b2a8a6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1180&q=80"
            class="h-14 w-14 rounded-full object-cover"
          />

          <div>
            <div class="flex justify-center gap-0.5 text-green-500">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
            </div>

            <p class="mt-0.5 text-lg font-medium text-gray-900">Nikisha Starr</p>
          </div>
        </div>

              <div class="mt-4">
                <p class="text-2xl font-bold text-rose-600 sm:text-3xl">
                  Stayin' Alive
                </p>

                <p class="mt-4 leading-relaxed text-gray-700">
                  No, Rose, they are not breathing. And they have no arms or
                  legs … Where are they? You know what? If we come across
                  somebody with no arms or legs, do we bother resuscitating
                  them? I mean, what quality of life do we have there?
                </p>
              </div>
            </div>

            <footer class="mt-4 text-sm font-medium text-gray-700 sm:mt-6">
              &mdash; Michael Scott
            </footer>
          </blockquote>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- NEWSLETTER FOOTER SECTION -->
    <section class="py-4 bg-accent sm:py-8 ">
        <div class="container px-4 mx-auto sm:px-6 lg:px-8">
            <div class="grid items-center gap-8 grid-col-12 sm:grid-cols-2 md:gap-16">

                <div class="flex flex-col md:flex-row gap-x-4" data-aos="fade-in" data-aos-duration="900" data-aos-delay="700">
                    <p class="mb-0 text-2xl font-bold md:text-3xl text-secondary"> Let's Stay<br>
                        Connected
                    </p>
                    <p class="text-xs md:self-end text-secondary md:text-lg"> Sign up for our weekly newsletter for
                        stories from
                        our farmers and their stock
                    </p>

                </div>

                <div class="" data-aos="fade-in" data-aos-duration="900" data-aos-delay="700">
                    <form class="flex flex-col gap-2 mb-3" action="{{ route('saveNewLetter') }}" method="POST">
                        @csrf
                        <input placeholder="Email Address" name="email"
                            class="w-full bg-transparent input input-bordered placeholder:text-center placeholder:font-semibold placeholder:text-black border-secondary input-md " />
                        <button class="w-full border-0 btn btn-primary btn-md" type='submit'>
                            <span class="text-white font-sora"> Sign
                                Up</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </section>
    <section class="py-2 bg-primary sm:py-4">
        <div class="container px-4 mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-8 md:gap-16">

                <h2 class="text-xl font-bold text-white md:text-3xl sm:text-3xl ">
                    Learn more from our agent</h2>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="#ffffff" class="w-16 h-16 sm:w-32 sm:h-20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                </svg>

            </div>
        </div>

    </section>

    <footer class="bg-secondary ">
        <div class="px-10 py-4 mx-auto max-w-screen-2xl md:py-6">
            <div class="flex flex-col items-center justify-between md:flex-row">
                <div class="flex justify-center space-x-16 md:order-2">
                    <div class="text-xs text-white ">
                        Privacy Policy
                    </div>
                    <div class="text-xs text-white ">
                        Terms and Conditions
                    </div>
                    <div class="text-xs text-white ">
                        Get Help
                    </div>

                </div>
                <div class="mt-8 md:order-1 md:mt-0">
                    <p class="text-xs text-center text-white"> {{ date('Y') }} © ViaNexta | All Rights Reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
 @include('includes.alerts.error_alert');
 @include('includes.alerts.success_alert');
@endsection
@section('scripts')
<script type="module">
  import KeenSlider from 'https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/+esm'

  const keenSlider = new KeenSlider(
    '#keen-slider',
    {
      loop: true,
      slides: {
        origin: 'center',
        perView: 1.25,
        spacing: 16,
      },
      breakpoints: {
        '(min-width: 1024px)': {
          slides: {
            origin: 'auto',
            perView: 2.5,
            spacing: 32,
          },
        },
      },
    },
    []
  )

  const keenSliderPrevious = document.getElementById('keen-slider-previous')
  const keenSliderNext = document.getElementById('keen-slider-next')

  keenSliderPrevious.addEventListener('click', () => keenSlider.prev())
  keenSliderNext.addEventListener('click', () => keenSlider.next())
</script>

@endsection