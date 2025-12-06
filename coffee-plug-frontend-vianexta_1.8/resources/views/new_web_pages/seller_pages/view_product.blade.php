@extends('layouts.new_home_layout')
@section('title', 'View Product')
@push('css')
<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<link href="https://playground.anychart.com/gallery/src/Sunburst_Charts/Coffee_Flavour_Wheel/iframe" rel="canonical">
<link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" rel="stylesheet" type="text/css">
<style>
#container {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}</style>
@endpush

@section('content')
<div class="wrapper">
@include('includes.new_home.new_sidebar')
<!-- Page Content  -->
    <div id="content">
         @include('includes.new_home.seller_nav')
          <form action="{{ route('sellersSaveProduct') }}" method="POST" enctype="multipart/form-data">
                         @csrf
                   <input type="hidden" name="save_type" value="edit"/>
                  <input type="hidden" name="stock_id" value="{{$product->id}}"/>
                  <div class="row gx-2 gx-md-5 gy-5 mb-4">
                            <div class="col-md-4">
                                        {{-- Specialty/Commercial --}}
                                <label for="isSpecialty" class="form-label">Specialty/Commercial </label>
                                <select name="isSpecialty" id="isSpecialty" onchange="showHideGrade()" class="form-select border border-dark" disabled aria-label="is specialty">
                                    <option value="Commercial" {{ $product->isSpecialty ? 'selected' : (old('isSpecialty') == 'Commercial' ? 'selected' : '')}}>Commercial</option>
                                    <option value="Specialty" {{ $product->isSpecialty ? 'selected' : (old('isSpecialty') == 'Specialty' ? 'selected' : '') }}>Specialty</option>
                                </select>
                                @if($errors->has('isSpecialty'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('isSpecialty') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                        {{-- Coffee Type --}}
                                <label for="coffeeType" class="form-label">Coffee Type </label>
                                <select name="coffeeType" disabled id="coffeeType"  class="form-select border border-dark" aria-label="Coffee Type">
                                    <option value="Arabica" {{(!empty($product->coffeeType) && $product->coffeeType=="Arabica") ? 'selected' : (old('coffeeType') == 'Arabica' ? 'selected' : '') }}>Arabica</option>
                                    <option value="Robusta" {{(!empty($product->coffeeType) && $product->coffeeType=="Robusta") ? 'selected' : (old('coffeeType') == 'Robusta' ? 'selected' : '') }}>Robusta</option>
                                </select>
                                @if($errors->has('coffeeType'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('coffeeType') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                        {{-- Variety --}}
                                <label for="variety" class="form-label">Variety</label>
                                <input type="text" disabled class="form-control {{ $errors->has('variety') ? 'is-invalid' : '' }} border border-dark" value="{{ !empty($product->variety) ? $product->variety : (empty(old('variety')) ? '' : old('variety')) }}"  name="variety"
                                            placeholder="Variety" required>
                                @if($errors->has('variety'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('variety') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                        {{-- Aroma --}}
                                <label for="aroma" class="form-label">Aroma</label>
                                <input type="text" disabled class="form-control {{ $errors->has('aroma') ? 'is-invalid' : '' }} border border-dark" value="{{ !empty($product->variety) ? $product->variety : (empty(old('variety')) ? '' : old('variety')) }}"  name="aroma"
                                            placeholder="Aroma" required>
                                @if($errors->has('aroma'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('aroma') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-4">
                                        {{-- Quantity --}}
                                <label for="quantityPosted" class="form-label">Quantity Available (bags)</label>
                                <input type="number" disabled class="form-control {{ $errors->has('quantityPosted') ? 'is-invalid' : '' }} border border-dark"  value="{{ !empty($product->variety) ? $product->variety : (empty(old('variety')) ? '' : old('variety')) }}" name="quantityPosted"
                                            placeholder="quantity" min="1" max-lenght="6" required>
                                @if($errors->has('quantityPosted'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('quantityPosted') }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="col-md-4">
                                        {{-- Process --}}
                                <label for="Process" class="form-label">Process</label>
                                <input type="text" disabled class="form-control {{ $errors->has('process') ? 'is-invalid' : '' }} border border-dark" value="{{ !empty($product->variety) ? $product->variety : (empty(old('variety')) ? '' : old('variety')) }}"  name="process"
                                            placeholder="Enter process" required>
                                @if($errors->has('process'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('process') }}
                                    </div>
                                @endif
                            </div>
                        
                            <div class="col-md-4">
                                        {{-- price --}}
                                <label for="bagPrice" class="form-label">Price</label>
                                <input type="number" disabled step="any"  class=" border border-dark form-control {{ $errors->has('bagPrice') ? 'is-invalid' : '' }}" value="{{ !empty($product->bagPrice) ? $product->bagPrice : (empty(old('bagPrice')) ? '0.0' : old('bagPrice')) }}"  name="bagPrice"
                                            placeholder="bagPrice">
                                @if($errors->has('bagPrice'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('bagPrice') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                        {{-- Bag Weight --}}
                                <label for="bagWeight" class="form-label">Bag Weight</label>
                                <input type="number" disabled step="any"  class=" border border-dark form-control {{ $errors->has('bagWeight') ? 'is-invalid' : '' }}" value="{{ !empty($product->bagWeight) ? $product->bagWeight : (empty(old('bagWeight')) ? '0.0' : old('bagWeight')) }}"  name="bagWeight"
                                            placeholder="Bag Weight">
                                @if($errors->has('bagWeight'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('bagWeight') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4" id="grade_div" style="display:none">
                                        {{-- Quality --}}
                                <label for="quality" class="form-label">Grade</label>
                                <select name="quality" disabled class="form-select {{ $errors->has('quality') ? 'is-invalid' : '' }} border border-dark" aria-label="Select quality">
                                    @for($i=80;$i<=100;$i++)
                                      <option value="{{$i}}" {{(!empty($product->quality) && $product->quality==$i) ? 'selected' : (old('quality') ==$i ? 'selected' : '') }}>{{$i}}</option>
                                    @endfor
                                </select>
                                @if($errors->has('quality'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('quality') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-4" id="marks_div" style="display:block">
                                        {{-- Marks --}}
                                <label for="marks" class="form-label">Marks</label>
                                <input type="text" disabled class=" border border-dark form-control {{ $errors->has('marks') ? 'is-invalid' : '' }}" value="{{ !empty($product->marks) ? $product->marks : (empty(old('marks')) ? '' : old('marks')) }}"  name="marks"
                                            placeholder="Marks">
                                @if($errors->has('marks'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('marks') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-4" id="screen_tolerance_div" style="display:block">
                                        {{-- Screen Tolerance --}}
                                <label for="screen_tolerance" class="form-label">Screen Tolerance </label>
                                <input type="text" disabled class=" border border-dark form-control {{ $errors->has('screen_tolerance') ? 'is-invalid' : '' }}" value="{{ !empty($product->screen_tolerance) ? $product->screen_tolerance : (empty(old('screen_tolerance')) ? '' : old('screen_tolerance')) }}"  name="screen_tolerance"
                                            placeholder="screen_tolerance">
                                @if($errors->has('screen_tolerance'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('screen_tolerance') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-4" id="max_defect_count_div" style="display:block">
                                        {{-- Max Defect Count --}}
                                <label for="max_defect_count" class="form-label">Max Defect Count </label>
                                <input type="number" disabled class=" border border-dark form-control {{ $errors->has('max_defect_count') ? 'is-invalid' : '' }} " value="{{ !empty($product->max_defect_count) ? $product->max_defect_count : (empty(old('max_defect_count')) ? '' : old('max_defect_count')) }}"  name="max_defect_count"
                                            placeholder="max defect count">
                                @if($errors->has('max_defect_count'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('max_defect_count') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-4" id="max_humidity_div" style="display:block" >
                                        {{-- Max Humidity --}}
                                <label for="max_humidity" class="form-label">Max Humidity </label>
                                <input type="number" disabled max="100" min="0"  class=" border border-dark form-control {{ $errors->has('max_humidity') ? 'is-invalid' : '' }} " value="{{ !empty($product->max_humidity) ? $product->max_humidity : (empty(old('max_humidity')) ? '' : old('max_humidity')) }}"  name="max_humidity"
                                            placeholder="Max Humidity">
                                @if($errors->has('max_humidity'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('max_humidity') }}
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-12" id="specialty_div" style="display:none">
                                <div class="col-md-12" id="certification" style="display:block">
                                        <div class="card">
                                        <h5 class="card-header">Certification</h5>
                                        <div class="card-body">
                                            <div class="row">
                                            @php $count=20; @endphp
                                            @foreach($helper->getCirtifications() as $certification)
                                            <div class="col-md-2 form-check">
                                                    <input class="form-check-input" type="checkbox" value="" name="{{$certification->name}}" id="{{$certification->name}}" >
                                                    <label class="form-check-label" for="{{$certification->name}}">
                                                        <b>
                                                            <button class="badge rounded-pill bg-secondary" type="button" data-bs-toggle="modal" data-bs-target="#modal_{{$count}}">
                                                                {{$certification->name}}
                                                            </button> 
                                                        </b>
                                                    </label>
                                            </div>
                                            @include('new_web_pages.buyer_pages.certification_modal')
                                            @php $count++; @endphp
                                            @endforeach
                                            </div>
                                        </div>
                                        </div>
                                </div>
                                
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
                                                    <select name="fragrance" disabled class="form-select {{ $errors->has('fragrance') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Fragrance Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{(!empty($product->fragrance) && $product->fragrance==$i) ? 'selected' : (old('fragrance') ==$i ? 'selected' : '') }}>{{$i}}</option>
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
                                                    <select name="flavor" disabled class="form-select {{ $errors->has('flavor') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Flovor Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{(!empty($product->flavor) && $product->flavor==$i) ? 'selected' : (old('flavor') ==$i ? 'selected' : '') }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('flavor'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('flavor') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                            {{-- After Taste --}}
                                                    <label for="aftertaste" class="form-label">After Taste</label>
                                                    <select name="acidity" disabled class="form-select {{ $errors->has('aftertaste') ? 'is-invalid' : '' }} border border-dark" aria-label="Select After Taste Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{(!empty($product->aftertaste) && $product->aftertaste==$i) ? 'selected' : (old('aftertaste') ==$i ? 'selected' : '') }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('aftertaste'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('aftertaste') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                            {{-- Acidity --}}
                                                    <label for="acidity" class="form-label">Acidity</label>
                                                    <select name="acidity" disabled class="form-select {{ $errors->has('acidity') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Acidity Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{(!empty($product->acidity) && $product->acidity==$i) ? 'selected' : (old('acidity') ==$i ? 'selected' : '') }}>{{$i}}</option>
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
                                                    <select name="body" disabled class="form-select {{ $errors->has('body') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Body Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{(!empty($product->body) && $product->body==$i) ? 'selected' : (old('body') ==$i ? 'selected' : '') }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('body'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('body') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                            {{-- Balance --}}
                                                    <label for="balance" class="form-label">Balance</label>
                                                    <select name="balance" disabled class="form-select {{ $errors->has('balance') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Balance Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{(!empty($product->balance) && $product->balance==$i) ? 'selected' : (old('balance') ==$i ? 'selected' : '') }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('balance'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('balance') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                            {{-- Sweetness --}}
                                                    <label for="sweetness" class="form-label">Sweetness</label>
                                                    <select name="sweetness" disabled class="form-select {{ $errors->has('sweetness') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Sweetness Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{(!empty($product->sweetness) && $product->sweetness==$i) ? 'selected' : (old('sweetness') ==$i ? 'selected' : '') }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('sweetness'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('sweetness') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                            {{-- Uniformity --}}
                                                    <label for="uniformity" class="form-label">Uniformity</label>
                                                    <select name="uniformity" disabled class="form-select {{ $errors->has('uniformity') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Uniformity Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{(!empty($product->uniformity) && $product->uniformity==$i) ? 'selected' : (old('uniformity') ==$i ? 'selected' : '') }}>{{$i}}</option>
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
                                                    <select name="clean_cup" disabled class="form-select {{ $errors->has('clean_cup') ? 'is-invalid' : '' }} border border-dark" aria-label="Select Clean Cup Score">
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                                        <option value="{{$i}}" {{(!empty($product->clean_cup) && $product->clean_cup==$i) ? 'selected' : (old('clean_cup') ==$i ? 'selected' : '') }}>{{$i}}</option>
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
                                            <div id="container"></div>
                                        </div>

                                        <div class="col-md-12 ">
                                            {{-- Flavors --}}
                                            <div class="alert alert-secondary" role="alert" id="flavors_div"></div>
                                        </div>
                                </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                        {{-- Notes --}}
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control border border-dark {{ $errors->has('description') ? 'is-invalid' : '' }}" disabled rows="8" name="description" placeholder="Type in some description of the product" required>{{ !empty($product->description) ? $product->description : (empty(old('description')) ? '' : old('description')) }}</textarea>
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
                            <!-- <div class="col-md-12 text-center"><button type="submit" class="btn btn-secondary ">Save product</button></div> -->
                        </div>
                </form>
            </div>
</div>
@endsection
@section('scripts')
        <!-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> -->
        <!-- file-upload Js -->
    @include('new_web_pages.seller_pages.flavour_wheel');
        <script>
            Window.onload = showHideGrade();

        function showHideGrade() {
        var isSpecialty = document.getElementById("isSpecialty").value;
        var grade_div = document.getElementById("grade_div");
        var marks_div = document.getElementById("marks_div");
        var max_defect_count_div = document.getElementById("max_defect_count_div");
        var screen_tolerance_div = document.getElementById("screen_tolerance_div");
        var max_humidity_div = document.getElementById("max_humidity_div");
        var specialty_div = document.getElementById("specialty_div");

         if(isSpecialty == "Specialty"){
            // alert('Sepecialty');
            grade_div.style.display = "block";
            specialty_div.style.display = "block";

            marks_div.style.display = "none";
            max_defect_count_div.style.display = "none";
            screen_tolerance_div.style.display = "none";
            max_humidity_div.style.display = "none";
         }else{
            grade_div.style.display = "none";
            specialty_div.style.display = "none";
            
            marks_div.style.display = "block";
            max_defect_count_div.style.display = "block";
            screen_tolerance_div.style.display = "block";
            max_humidity_div.style.display = "block";
         }
       
    }
        </script>
@endsection