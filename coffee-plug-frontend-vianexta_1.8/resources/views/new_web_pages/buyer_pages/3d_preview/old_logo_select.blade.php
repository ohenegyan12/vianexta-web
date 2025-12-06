   <div class="row ">
       <div class="col-6 col-lg-6">
           <h4 class="text-center">Select your package size?</h4>
           <div class="row mt-4 mt-lg-5 ">
               <div class="col-6 col-md-6 col-lg-6">
                   <button class="option-button">
                       <div class="flipcard">
                           <div class="flipcard-wrap" onclick="setPressedOption('bag_size','lb','lb_bag_size')">

                               <div id="bag_size" class="card card-front lb_bag_size selectable-card-two h-100 roast-card w-100 p-3 border-0 text-white">
                                   <img src="{{ asset('images/market_place/blackbags/5lb.jpg') }}" class="card-img-top" style="height:50%" alt="...">
                                   <div class="card-body p-0 mt-3 text-black">
                                       <h5 class="card-title text-center">5lb Bag</h5>
                                   </div>
                               </div>
                               <div id="bag_size" class="card card-back lb_bag_size selectable-card-two h-100 roast-card w-100 p-3 border-0 text-white">
                                   <img src="{{ asset('images/market_place/blackbags/5lb.jpg') }}" class="card-img-top" style="height:50%" alt="...">
                                   <div class="card-body p-0 mt-3 text-black">
                                       <h5 class="card-title text-center">5lb Bag</h5>
                                   </div>
                               </div>

                           </div>
                       </div>

                   </button>
               </div>
               <div class="col-6 col-md-6 col-lg-6">
                   <button class="option-button">
                       <div class="flipcard">
                           <div class="flipcard-wrap" onclick="setPressedOption('bag_size','oz_bag','oz_bag_size')">

                               <div id="bag_size" class="card card-front oz_bag_size selectable-card-two h-80 roast-card w-80 p-3 border-0 text-white">
                                   <img src="{{ asset('images/market_place/blackbags/10oz.jpg') }}" style="width:50%" class="card-img-top" alt="...">
                                   <div class="card-body p-0 mt-3 text-black">
                                       <h5 class="card-title text-center">10oz Bag</h5>
                                   </div>
                               </div>
                               <div id="bag_size" class="card card-back oz_bag_size selectable-card-two h-80 roast-card w-80 p-3 border-0 text-white">
                                   <img src="{{ asset('images/market_place/blackbags/10oz.jpg') }}" style="width:50%" class="card-img-top" alt="...">
                                   <div class="card-body p-0 mt-3 text-black">
                                       <h5 class="card-title text-center">10oz Bag</h5>
                                   </div>
                               </div>

                           </div>
                       </div>

                   </button>
               </div>

               <div class="col-6 col-md-6 col-lg-6">
                   <button class="option-button">
                       <div class="flipcard">
                           <div class="flipcard-wrap" onclick="setPressedOption('bag_size','oz_frac_pack','oz_frac_pack_bag_size')">

                               <div id="bag_size" class="card card-front oz_frac_pack_bag_size selectable-card-two h-100 roast-card w-100 p-3 border-0 text-white">
                                   <img src="{{ asset('images/market_place/blackbags/12oz.jpg') }}" height="90" class="card-img-top" alt="...">
                                   <div class="card-body p-0 mt-3 text-black">
                                       <h5 class="card-title text-center">3oz Frac Pack</h5>
                                   </div>
                               </div>
                               <div id="bag_size" class="card card-back oz_frac_pack_bag_size selectable-card-two h-100 roast-card w-100 p-3 border-0 text-white">
                                   <img src="{{ asset('images/market_place/blackbags/12oz.jpg') }}" height="90" class="card-img-top" alt="...">
                                   <div class="card-body p-0 mt-3 text-black">
                                       <h5 class="card-title text-center">3oz Frac Pack</h5>
                                   </div>
                               </div>

                           </div>
                       </div>

                   </button>
               </div>

               <div class="col-6 col-md-6 col-lg-6">
                   <button class="option-button">
                       <div class="flipcard">
                           <div class="flipcard-wrap" onclick="setPressedOption('bag_size','k_cup','k_cup_bag_size')">

                               <div id="bag_size" class="card card-front k_cup_bag_size selectable-card-two h-100 roast-card w-100 p-3 border-0 text-white">
                                   <img src="{{ asset('images/market_place/blackbags/kcups.jpg') }}" height="90" class="card-img-top" alt="...">
                                   <div class="card-body p-0 mt-3 text-black">
                                       <h5 class="card-title text-center">K Cup</h5>
                                   </div>
                               </div>
                               <div id="bag_size" class="card card-back k_cup_bag_size selectable-card-two h-100 roast-card w-100 p-3 border-0 text-white">
                                   <img src="{{ asset('images/market_place/blackbags/kcups.jpg') }}" height="90" class="card-img-top" alt="...">
                                   <div class="card-body p-0 mt-3 text-black">
                                       <h5 class="card-title text-center">K Cup</h5>
                                   </div>
                               </div>

                           </div>
                       </div>

                   </button>
               </div>
           </div>
           <h4 class="text-center">Would you like to add your logo to your package?</h4>
           <form action="/uploadBagLogo" class="dropzone mt-4 mt-lg-5 " id="awesomeDropzone"></form>
       </div>

       <div class="col-6 col-lg-6">
           @include('new_web_pages.buyer_pages.3d_preview.bag_preview')
       </div>
   </div>