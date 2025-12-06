 <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0" x-description=" mega menu, show/hide"
     class="z-50 absolute inset-x-0  text-gray-500 sm:text-sm" x-ref="panel">

     <div class="relative px-2 sm:px-4 py-8 bg-white m-5 sm:m-0 border-b-2 rounded-md shadow-sm top-8">
         <div class="mx-auto max-w-screen-2xl px-8">
             <div class="mt-2 flex rounded-md shadow-sm">
                 <div class="relative flex flex-grow items-stretch focus-within:z-10">
                     <input type="email" name="email" id="email"
                         class="input bg-white w-full rounded-none rounded-l-xl border-0 text-sm sm:text-base text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:outline-none focus:border-secondary focus:ring-secondary ">
                 </div>
                 <button type="button"
                     class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-xl px-8 py-2 text-sm font-semibold text-secondary ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                     Search
                 </button>
             </div>
             <div class=" grid grid-cols-2 sm:grid-cols-4  items-start gap-x-8 gap-y-10 pb-12 pt-10">
                 <div>
                     <p class="text-lg sm:text-2xl font-semibold text-secondary">Marketplace
                     </p>
                     <ul role="list" aria-labelledby="desktop-featured-heading-0" class="mt-6 sm:mt-4 space-y-1">
                         <li class="flex">
                             <a href="{{ route('marketplace_buyer') }}"
                                 class="text-sm text-secondary hover:text-gray-800">I am
                                 a buyer</a>
                         </li>
                         <li class="flex">
                             <a href="{{ route('login_page') }}"
                                 class="text-sm text-secondary hover:text-gray-800">I
                                 am
                                 a seller</a>
                         </li>
                         <li class="flex">
                             <a href="{{ route('new_home') }}"
                                 class="text-sm text-secondary hover:text-gray-800">New Home Page</a>
                         </li>

                     </ul>
                 </div>
                 <div>
                     <p id="desktop-categories-heading" class="text-lg sm:text-2xl font-semibold text-secondary">
                         Vendors</p>
                     <ul role="list" aria-labelledby="desktwork_with_usop-categories-heading"
                         class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                         <li class="flex">
                             <a href="{{ route('work_with_us') }}"
                                 class="text-sm text-secondary hover:text-gray-800">Work
                                 with us</a>
                         </li>
                         <li class="flex">
                             <a href="{{ route('join_team') }}" class="text-sm text-secondary hover:text-gray-800">Our
                                 team</a>
                         </li>
                         <li class="flex">
                             <a href="{{route('recommend')}}" class="text-sm text-secondary hover:text-gray-800">Recommend</a>
                         </li>

                     </ul>
                 </div>

                 <div>
                     <p id="desktop-categories-heading" class="text-lg sm:text-2xl font-semibold text-secondary">
                         Account</p>
                     <div class="flex items-center gap-x-10">
                         <ul role="list" aria-labelledby="desktop-categories-heading"
                             class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                             @php if(session('auth_user_tokin') ==null){ @endphp
                             <li class="flex">
                                 <a href="{{ route('login_page') }}"
                                     class="text-sm text-secondary hover:text-gray-800">Log
                                     in</a>
                             </li>
                             @php } else { @endphp
                            <li class="flex">
                                 <a href="{{ route('account_dashboard') }}"
                                     class="text-sm text-secondary hover:text-gray-800">Welcome {{session('auth_user_name')}} 
                                 </a>
                             </li>
                            @php } @endphp
                             <li class="flex">
                                 <a href="#" class="text-sm text-secondary hover:text-gray-800">Settings</a>
                             </li>
                             <li class="flex">
                                 <a href="{{route('account_dashboard')}}" class="text-sm text-secondary hover:text-gray-800">Dashboard</a>
                             </li>


                         </ul>
                         <ul role="list" aria-labelledby="desktop-categories-heading"
                             class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                             <li class="flex">
                                 <a href="{{ route('help') }}"
                                     class="text-sm text-secondary hover:text-gray-800">Help</a>
                             </li>
                             <li class="flex">
                                 <a href="{{route('order_history')}}" class="text-sm text-secondary hover:text-gray-800">Order tracking</a>
                             </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                                 @csrf  
                             <li class="flex">
                                 <button type='submit'  class="text-sm text-secondary hover:text-gray-800">Log out</button>
                             </li>
                             </form>
                         </ul>
                     </div>
                 </div>
                 <div>
                     <p class="text-lg sm:text-2xl font-semibold text-secondary">Our Story
                     </p>
                     <ul role="list" aria-labelledby="desktop-featured-heading-0" class="mt-6 sm:mt-4 space-y-1">
                         <li class="flex">
                             <a href="{{route('home_page')}}#who" class="text-sm text-secondary hover:text-gray-800">Who we
                                 are</a>
                         </li>
                         <li class="flex">
                             <a href="{{route('home_page')}}#how" class="text-sm text-secondary hover:text-gray-800">How we do
                                 it</a>
                         </li>

                     </ul>
                 </div>

             </div>
             <div class="grid grid-cols-5 items-start gap-x-8 gap-y-10 pb-12 pt-10">
                 <p class="col-span-5 text-lg sm:text-2xl font-semibold text-secondary">Request a quote
                 </p>

             </div>

         </div>
     </div>
 </div>
