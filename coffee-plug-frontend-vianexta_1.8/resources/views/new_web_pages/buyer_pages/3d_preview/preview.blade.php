 <div class="container mt-5">
     <!-- Grid Layout -->
     <div class="row">
         <!-- Left Column: Package Options -->
         <div class="col-md-6 col-12">
             <h4>Select your package size?</h4>
             <div class="row">
                 <!-- K-Cup -->
                 <div class="col-12 col-md-3">
                     <a href="#" class="option-button">
                         <div class="flipcard">
                             <div class="flipcard-wrap" onclick="setPressedOption('bag_size','k_cup','k_cup_bag_size')">

                                 <div id="bag_size" class="card card-front k_cup_bag_size selectable-card h-100 roast-card w-100 p-3 border-0 text-white product-image">
                                     <img src="{{ asset('images/market_place/blackbags/kcups.jpg') }}" data-model="{{ asset('images/models/kcup.fbx') }}" class="card-img-top" alt="...">
                                     <!-- <div class="card-body p-0 mt-3 text-black">
                                         <h5 class="card-title text-center">K Cup</h5>
                                     </div> -->
                                 </div>
                                 <div id="bag_size" class="card card-back k_cup_bag_size selectable-card h-100 roast-card w-100 p-3 border-0 text-white product-image" data-image="{{ asset('images/market_place/blackbags/Kcups.jpg') }}">
                                     <img src="{{ asset('images/market_place/blackbags/kcups.jpg') }}" class="card-img-top" alt="...">
                                     <!-- <div class="card-body p-0 mt-3 text-black">
                                         <h5 class="card-title text-center">K Cup</h5>
                                     </div> -->
                                 </div>

                             </div>
                         </div>

                     </a>
                 </div>

                 <!-- 10oz -->
                 <div class="col-12 col-md-3">
                     <!-- <a href="#" class="option-button"> -->
                     <div class="flipcard">
                         <div class="flipcard-wrap" onclick="setPressedOption('bag_size','oz_bag','oz_bag_size')">

                             <div id="bag_size" class="card card-front oz_bag_size selectable-card h-100 roast-card w-100 p-3 border-0 text-white product-image" data-image="{{ asset('images/market_place/blackbags/10oz.jpg') }}">
                                 <img src="{{ asset('images/market_place/blackbags/10oz.jpg') }}" data-model="{{ asset('images/models/10oz.fbx') }}" class="card-img-top" alt="...">
                                 <!-- <div class="card-body p-0 mt-3 text-black">
                                         <h5 class="card-title text-center">10oz Bag</h5>
                                     </div> -->
                             </div>
                             <div id="bag_size" class="card card-back oz_bag_size selectable-card h-100 roast-card w-100 p-3 border-0 text-white product-image" data-image="{{ asset('images/market_place/blackbags/10oz.jpg') }}">
                                 <img src="{{ asset('images/market_place/blackbags/10oz.jpg') }}" class="card-img-top" alt="...">
                                 <!-- <div class="card-body p-0 mt-3 text-black">
                                         <h5 class="card-title text-center">10oz Bag</h5>
                                     </div> -->
                             </div>

                         </div>
                     </div>

                     <!-- </a> -->
                 </div>
                 <!-- 12oz -->
                 <div class="col-12 col-md-3">
                     <!-- <a href="#" class="option-button"> -->
                     <div class="flipcard">
                         <div class="flipcard-wrap" onclick="setPressedOption('bag_size','oz_frac_pack','oz_frac_pack_bag_size')">

                             <div id="bag_size" class="card card-front oz_frac_pack_bag_size selectable-card-two h-100 roast-card w-100 p-3 border-0 text-white product-image" data-image="{{ asset('images/market_place/blackbags/12oz.jpg') }}">
                                 <img src="{{ asset('images/market_place/blackbags/12oz.jpg') }}" data-model="{{ asset('images/models/12oz.fbx') }}" class="card-img-top" alt="...">
                                 <!-- <div class="card-body p-0 mt-3 text-black">
                                         <h5 class="card-title text-center">3oz Frac Pack</h5>
                                     </div> -->
                             </div>
                             <div id="bag_size" class="card card-back oz_frac_pack_bag_size selectable-card-two h-100 roast-card w-100 p-3 border-0 text-white product-image" data-image="{{ asset('images/market_place/blackbags/12oz.jpg') }}">
                                 <img src="{{ asset('images/market_place/blackbags/12oz.jpg') }}" class="card-img-top" alt="...">
                                 <!-- <div class="card-body p-0 mt-3 text-black">
                                         <h5 class="card-title text-center">3oz Frac Pack</h5>
                                     </div> -->
                             </div>

                         </div>
                     </div>

                     <!-- </a> -->
                 </div>
                 <!-- 5lb -->
                 <div class="col-12 col-md-3">
                     <a href="#" class="option-button">
                         <div class="flipcard">
                             <div class="flipcard-wrap" onclick="setPressedOption('bag_size','lb','lb_bag_size')">

                                 <div id="bag_size" class="card card-front lb_bag_size selectable-card h-100 roast-card w-100 p-3 border-0 text-white product-image" data-image="{{ asset('images/market_place/blackbags/5lb.jpg') }}">
                                     <img src="{{ asset('images/market_place/blackbags/5lb.jpg') }}" data-model="{{ asset('images/models/5lb.fbx') }}" class="card-img-top" alt="...">
                                     <!-- <div class="card-body p-0 mt-3 text-black">
                                         <h5 class="card-title text-center">5lb Bag</h5>
                                     </div> -->
                                 </div>
                                 <div id="bag_size" class="card card-back lb_bag_size selectable-card h-100 roast-card w-100 p-3 border-0 text-white product-image" data-image="{{ asset('images/market_place/blackbags/5lb.jpg') }}">
                                     <img src="{{ asset('images/market_place/blackbags/5lb.jpg') }}" class="card-img-top" alt="...">
                                     <!-- <div class="card-body p-0 mt-3 text-black">
                                         <h5 class="card-title text-center">5lb Bag</h5>
                                     </div> -->
                                 </div>

                             </div>
                         </div>

                     </a>
                 </div>
             </div>
             <div class="row">
                 <div class="col-12 col-md-6 mt-4">
                     <h4>Would you like to add your logo to your package?</h4>
                     <ul class="list-unstyled mt-4">
                         <li>✔ Logo must not be any shade of black</li>
                         <li>✔ Size is between 500px - 5000px</li>
                         <li>✔ Image quality higher than 72 DPI</li>
                         <li>✔ Transparent background</li>
                         <li>✔ No padding on the image</li>
                         <li>✔ No shadows or gradients</li>
                         <li>✔ No thin lines to ensure legibility</li>
                         <li>✔ File size is &lt; 2 MB</li>
                     </ul>
                 </div>
                 <div class="col-12 col-md-6 mt-4">
                     <!-- <h4 class="text-center">Would you like to add your logo to your package?</h4> -->
                     @include('new_web_pages.buyer_pages.3d_preview.dropzone_page')
                 </div>
             </div>
         </div>

         <!-- Right Column: Preview Box -->
         <div class="col-12 col-md-6">
             @include('new_web_pages.buyer_pages.3d_preview.3d_model_preview')
         </div>
     </div>

 </div>