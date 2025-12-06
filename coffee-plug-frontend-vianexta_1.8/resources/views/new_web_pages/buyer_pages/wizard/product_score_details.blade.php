 <div id="product_details" style="display: none;">
     <div class="col-md-12">
         <div class="fs-5 text-black py-2 pt-4"><b>Certification(s)</b></div>
         <table class="table table-striped table-hover">
             <tbody>
                 <tr>
                     <!-- <td class="fs-5 text-black py-2 pt-4"><b>Certification(s)</b></td> -->
                     <td class="fs-5 text-black py-2 pt-4">
                         @php $count=1; @endphp
                         @foreach($helper->getCirtifications() as $certification)
                         <b>
                             <button class="badge rounded-pill bg-secondary " type="button" data-bs-toggle="modal" data-bs-target="#modal_{{$count}}">
                                 {{$certification->name}}
                             </button>
                         </b>
                         @include('new_web_pages.buyer_pages.certification_modal')
                         @php $count++; @endphp
                         @endforeach
                     </td>

                 </tr>
             </tbody>
         </table>
     </div>

     <div class="col-12 col-md-6">
         <div class="col-md-12">
             <div class="fs-5 text-black py-2 pt-4"><b>SCA Score</b></div>
             <table class="table table-striped table-hover table-bordered table-success">
                 <thead>
                     <th>Fragrance</th>
                     <th>Flavor</th>
                     <th>Acidity</th>
                     <th>Body</th>
                     <th>Uniformity</th>
                     <th>Clean Cup</th>
                     <th>Overall</th>
                 </thead>
                 <tbody>
                     <tr>
                         <td class="fs-5 text-black py-2 pt-4">8</td>
                         <td class="fs-5 text-black py-2 pt-4">8.5</td>
                         <td class="fs-5 text-black py-2 pt-4">8</td>
                         <td class="fs-5 text-black py-2 pt-4">8</td>
                         <td class="fs-5 text-black py-2 pt-4">8.5</td>
                         <td class="fs-5 text-black py-2 pt-4">8</td>
                         <td class="fs-5 text-black py-2 pt-4"><b><span style="color: #07382F">{{number_format($total=49/6,2)}}</span></b></td>

                     </tr>
                 </tbody>
             </table>
         </div>
     </div>
 </div>