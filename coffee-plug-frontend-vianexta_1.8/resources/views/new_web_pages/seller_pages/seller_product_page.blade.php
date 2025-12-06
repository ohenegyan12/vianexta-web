@extends('layouts.new_home_layout')
@section('title', 'Seller Products')
@push('css')
<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">
<link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@section('content')
<div class="wrapper">
@include('includes.new_home.new_sidebar')
<!-- Page Content  -->
    <div id="content">
         @include('includes.new_home.seller_nav')
    
        
        <div class="row gx-2 gx-lg-3 gy-5 gy-lg-0 mt-3">
                <div class="col-sm-12 col-md-6">
                    <div class="card mb-3 shadow p-3 bg-body-tertiary rounded h-100" >
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4 text-center">
                            <img src="{{ asset('images/seller/dash_two.svg') }}" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="card-text" style="color:#999">{{$helper->isweekend() ? "Last Friday's " : "Today's"}} Coffee Prices (As at: {{$helper->formatDateToTimeOnly($prices->arabica->dateTime)}})</p>
                                    <h6 class="card-title">Arabica: {{$prices->arabica->currency}} {{$prices->arabica->price}} ({{$prices->arabica->unit}})</h6>
                                    <h6 class="card-title">Robusta: {{$prices->robusta->currency}} {{$prices->robusta->price}} ({{$prices->robusta->unit}})</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  

                <div class=" col-sm-12 col-md-6">
                    <div class="card mb-3 shadow p-3 bg-body-tertiary rounded h-100" >
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4 text-center">
                            <img src="{{ asset('images/seller/dash_three.svg') }}" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text" style="color:#999">Previous day's prices </p>
                                    <h6 class="card-title">Arabica: {{$prices->arabica->currency}} {{$prices->arabica->closingPrice}} ({{$prices->arabica->unit}})</h6>
                                    <h6 class="card-title">Robusta: {{$prices->robusta->currency}} {{$prices->robusta->closingPrice}} ({{$prices->robusta->unit}})</h6>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 py-5">
                       <div class="card mb-3 shadow p-3 bg-body-tertiary rounded" >
                            <div class="card-body overflow-x-auto">
                                <div class="row">
                                     <div class="col-md-8">
                                         <h1 class="display-6 fw-bolder" style="color: #07382F;">Products</h1>
                                         <p class="fs-5" style="color: #07382F;">Add, Delete and Manage Products</p>
                                    </div>
                                     <div class="col-md-4 text-md-end">
                                        <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_product">Add New Product</button> -->
                                        <a href="{{route('sellers_add_product')}}" class="btn btn-secondary" >Add New Product</a>
                                    </div>
                                </div>

                                <div class="table-responsive py-5 overflow-x-hidden" style="min-width: 700px;">
                                    <table class="table table-striped table-striped table-hover" id="dt_trans">
                                        <thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">NAME</th>
                                            <th scope="col">STATUS</th>
                                            <th scope="col">BAG PRICE</th>
                                            <th scope="col">QUANTITY</th>
                                            <th scope="col">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $count=1;@endphp
                                            @foreach($products as $product)
                                            <tr>
                                                <td scope="row">{{$count}}</td>
                                                <td>{{isset($product->name)? $product->name: ($product->description != null? $product->description:'Product Name')}}</td>
                                                <td>
                                                    @if($product->active)
                                                        <span class="badge rounded-pill text-bg-success">Active</span>
                                                    @else
                                                        <span class="badge rounded-pill text-bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>${{$product->bagPrice}}</td>
                                                <td>{{$product->bagWeight}}kg</td>
                                                <td>
                                                    <a href="{{ route('viewProduct',$helper->encode($product->id)) }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View product details"><span class="fa fa-eye"></span></a>
                                                    <a href="{{ route('editProduct',$helper->encode($product->id)) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit product details"><span class="fa fa-edit"></span></a>
                                                    @if($product->active)
                                                        <a href="{{route('deactivateProduct',$helper->encode($product->id))}}" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Disable product"><span class="fa fa-ban"></span></a>
                                                    @else
                                                        <a href="{{route('reactivateProduct',$helper->encode($product->id))}}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Activate product"><span class="fa fa-check "></span></a>
                                                    @endif
                                                    
                                                    @if($product->inUse==false)
                                                       <a href="{{ route('deleteProduct',$helper->encode($product->id))}}" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete product"><span class="fa fa-trash"></span></a>
                                                    @else
                                                    <!-- <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Product in use cannont be deleted">
                                                            <button disabled class="btn btn-danger"><span class="fa fa-trash"></span></button>
                                                        </span> -->
                                                       <a href="#" disabled class="btn btn-light" style="background-color:#BBBBBB;" data-bs-toggle="tooltip" data-bs-placement="top" title="Product in use cannont be deleted"><span class="fa fa-trash"></span></a>
                                                    @endif
                                                </td>
                                            </tr>
                                             @php $count++;@endphp
                                          @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>  
                </div>

                         
        </div>
    </div>
</div>
@include('new_web_pages.seller_pages.add_product_modal')
@endsection
@section('scripts')


<script>
    $(document).ready(function () {

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

    });

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
 <!-- Data Table JS - data_tables.js -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    
    <script src="{{ asset('dashboard_assets/js/datatables.js') }}"></script>

<!-- Clare Chat Component -->
<script src="{{ asset('js/clare-component.js') }}"></script>
@endsection