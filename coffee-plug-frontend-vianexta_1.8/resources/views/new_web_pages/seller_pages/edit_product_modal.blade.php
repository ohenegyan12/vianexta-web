<!-- Modal -->
<div class="modal modal-xl fade" id="edit_product{{$product->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form action="{{ route('sellersSaveProduct') }}" method="POST" enctype="multipart/form-data">
                         @csrf
                         <input type="hidden" name="save_type" value="edit"/>
                         <input type="hidden" name="stock_id" value="{{$product->id}}"/>
      <div class="modal-body">
                       <div class="row gx-2 gx-md-5 gy-5 mb-4">
                            <div class="col-md-6">
                                        {{-- Species --}}
                                <label for="coffeeType" class="form-label">Species</label>
                                <select name="coffeeType" id="coffeeType" onchange="showHideGrade()" class="form-select border border-dark" aria-label="Select species">
                                    <option value="Commercial" {{ old('coffeeType') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                    <option value="Specialty"  {{ old('coffeeType') == 'Specialty' ? 'selected' : '' }}>Specialty</option>
                                </select>
                                @if($errors->has('coffeeType'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('coffeeType') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                        {{-- Variety --}}
                                <label for="variety" class="form-label">Variety</label>
                                <input type="text" class="form-control {{ $errors->has('variety') ? 'is-invalid' : '' }} border border-dark" value="{{ !empty($product->variety) ? $product->variety : (empty(old('variety')) ? '' : old('variety')) }}"  name="variety"
                                            placeholder="Variety" required>
                                @if($errors->has('variety'))
                                    <div class="invalid-feedback"> 
                                        {{ $errors->first('variety') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                        {{-- Aroma --}}
                                <label for="aroma" class="form-label">Aroma</label>
                                <input type="text" class="form-control {{ $errors->has('aroma') ? 'is-invalid' : '' }} border border-dark" value="{{ !empty($product->aroma) ? $product->aroma : (empty(old('aroma')) ? '' : old('aroma')) }}"  name="aroma"
                                            placeholder="Aroma" required>
                                @if($errors->has('aroma'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('aroma') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-6">
                                        {{-- Quantity --}}
                                <label for="quantityPosted" class="form-label">Quantity Available (bags)</label>
                                <input type="number" class="form-control {{ $errors->has('quantityPosted') ? 'is-invalid' : '' }} border border-dark"  value="{{ !empty($product->quantityPosted) ? $product->quantityPosted : (empty(old('quantityPosted')) ? '' : old('quantityPosted')) }}" name="quantityPosted"
                                            placeholder="quantity" min="1" max-lenght="6" required>
                                @if($errors->has('quantityPosted'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('quantityPosted') }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="col-md-6">
                                        {{-- Process --}}
                                <label for="Process" class="form-label">Process</label>
                                <input type="text" class="form-control {{ $errors->has('process') ? 'is-invalid' : '' }} border border-dark" value="{{ !empty($product->process) ? $product->process : (empty(old('process')) ? '' : old('process')) }}"  name="process"
                                            placeholder="Enter process" required>
                                @if($errors->has('process'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('process') }}
                                    </div>
                                @endif
                            </div>
                        
                             <div class="col-md-6 ">
                                        {{-- price --}}
                                <label for="price" class="form-label">Price</label>
                                <input type="number"  step="any" style="background-color: #ffff" class=" border border-dark form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" value="{{ !empty($product->bagPrice) ? $product->bagPrice : (empty(old('price')) ? '0.0' : old('price')) }}"  name="price"
                                            placeholder="Price">
                                @if($errors->has('price'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('price') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6" id="grade_div" style="display:none">
                                        {{-- Quality --}}
                                <label for="quality" class="form-label">Grade</label>
                                <select name="quality" class="form-select {{ $errors->has('quality') ? 'is-invalid' : '' }} border border-dark" aria-label="Select quality">
                                    @for($i=80;$i<=100;$i++)
                                      <option value="{{$i}}" {{ !empty($product->quality) ? $product->quality : (old('quality') == $i ? 'selected' : '') }}>{{$i}}</option>
                                    @endfor
                                </select>
                                @if($errors->has('quality'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('quality') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-6 " id="marks_div" style="display:block">
                                        {{-- Marks --}}
                                <label for="marks" class="form-label">Marks</label>
                                <input type="text"  class=" border border-dark form-control {{ $errors->has('marks') ? 'is-invalid' : '' }}" value="{{ !empty($product->marks) ? $product->marks : (empty(old('marks')) ? '' : old('marks')) }}"  name="marks"
                                            placeholder="Marks">
                                @if($errors->has('marks'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('marks') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-6 " id="screen_tolerance_div" style="display:block">
                                        {{-- Screen Tolerance --}}
                                <label for="screen_tolerance" class="form-label">Screen Tolerance </label>
                                <input type="text"  class=" border border-dark form-control {{ $errors->has('screen_tolerance') ? 'is-invalid' : '' }}" value="{{ !empty($product->screen_tolerance) ? $product->screen_tolerance : (empty(old('screen_tolerance')) ? '' : old('screen_tolerance')) }}"  name="screen_tolerance"
                                            placeholder="screen_tolerance">
                                @if($errors->has('screen_tolerance'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('screen_tolerance') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-6 " id="max_defect_count_div" style="display:block">
                                        {{-- Max Defect Count --}}
                                <label for="max_defect_count" class="form-label">Max Defect Count </label>
                                <input type="number"  class=" border border-dark form-control {{ $errors->has('max_defect_count') ? 'is-invalid' : '' }} " value="{{ !empty($product->max_defect_count) ? $product->max_defect_count : (empty(old('max_defect_count')) ? '' : old('max_defect_count')) }}"  name="max_defect_count"
                                            placeholder="max defect count">
                                @if($errors->has('max_defect_count'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('max_defect_count') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-6 " id="max_humidity_div" style="display:block" >
                                        {{-- Max Humidity --}}
                                <label for="max_humidity" class="form-label">Max Humidity </label>
                                <input type="number" max="100" min="0"  class=" border border-dark form-control {{ $errors->has('max_humidity') ? 'is-invalid' : '' }} " value="{{ !empty($product->max_humidity) ? $product->max_humidity : (empty(old('max_humidity')) ? '' : old('max_humidity')) }}"  name="max_humidity"
                                            placeholder="Max Humidity">
                                @if($errors->has('max_humidity'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('max_humidity') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-12" id="specialty_div" style="display:none">
                                <div class="card">
                                    <div class="card-body">
                                      <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <img class="card-img-top img-fluid"
                                                        src="{{asset('images/seller/scale.png')}}" style="max-width:100%;" alt="flavors">
                                                <div class="col-md-6">
                                                            {{-- Fragrance --}}
                                                    <label for="fragrance" class="form-label">Fragrance/Aroma</label>
                                                    <select name="fragrance" class="form-select {{ $errors->has('fragrance') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Fragrance Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{ !empty($product->fragrance) ? $product->fragrance : (old('fragrance') == $i ? 'selected' : '') }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('fragrance'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('fragrance') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                            {{-- Flovor --}}
                                                    <label for="flavor" class="form-label">Flavor</label>
                                                    <select name="flavor" class="form-select {{ $errors->has('flavor') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Flovor Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{ !empty($product->flavor) ? $product->flavor : (old('flavor') == $i ? 'selected' : '') }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('flavor'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('flavor') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                            {{-- Acidity --}}
                                                    <label for="acidity" class="form-label">Acidity</label>
                                                    <select name="acidity" class="form-select {{ $errors->has('acidity') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Acidity Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{ !empty($product->acidity) ? $product->acidity : (old('acidity') == $i ? 'selected' : '' )}}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('acidity'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('acidity') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                            {{-- Body --}}
                                                    <label for="body" class="form-label">Body</label>
                                                    <select name="body" class="form-select {{ $errors->has('body') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Body Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{ !empty($product->body) ? $product->body : (old('body') == $i ? 'selected' : '') }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('body'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('body') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                            {{-- Uniformity --}}
                                                    <label for="uniformity" class="form-label">Uniformity</label>
                                                    <select name="uniformity" class="form-select {{ $errors->has('uniformity') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Uniformity Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{ !empty($product->uniformity) ? $product->uniformity : (old('uniformity') == $i ? 'selected' : '') }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('uniformity'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('uniformity') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                            {{-- Clean Cup --}}
                                                    <label for="clean_cup" class="form-label">Clean Cup</label>
                                                    <select name="clean_cup" class="form-select {{ $errors->has('clean_cup') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Clean Cup Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{ !empty($product->clean_cup) ? $product->clean_cup : (old('clean_cup') == $i ? 'selected' : '') }} >{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('clean_cup'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('clean_cup') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                

                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <img class="card-img-top img-fluid"
                                                src="{{asset('images/seller/flavor_wheel.png')}}" style="max-width:100%;" alt="flavors">
                                        </div>
                                </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                        {{-- Notes --}}
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control border border-dark {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="8" name="description" placeholder="Type in some description of the product" required>{{ !empty($product->description) ? $product->description : (empty(old('description')) ? '' : old('description')) }}</textarea>
                                @if($errors->has('description'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('description') }}
                                    </div>
                                @endif
                            </div>
                             <!-- <div class="col-md-6">
                                        {{-- Image --}}
                                <label for="Image" class="form-label">Upload Product Image</label>
                                <input type="file" class="form-control {{ $errors->has('imagefile') ? 'is-invalid' : '' }} border border-dark"  name="imagefile"
                                           required>
                                @if($errors->has('imagefile'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('imagefile') }}
                                    </div>
                                @endif
                            </div> -->
                           
                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>