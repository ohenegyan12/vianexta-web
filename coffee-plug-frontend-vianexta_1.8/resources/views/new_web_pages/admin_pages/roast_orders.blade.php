@extends('layouts.new_home_layout')
@section('title', 'Seller Dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">
@endpush

@section('content')
<div class="wrapper">
    @include('includes.new_home.new_sidebar')
    <!-- Page Content  -->
    <div id="content">
        @include('includes.new_home.seller_nav')


        <div class="row gx-2 gx-lg-3 gy-5 gy-lg-0 mt-3 row-gap-3">
            <h3 class="mb-5" style="color: #07382F">Orders</h3>

            <div class="col-12 pb-5">
                <div class="col-md-12">
                    <div class="card mb-3 shadow p-3 bg-body-tertiary rounded">
                        <div class="card-body overflow-x-auto">
                            <div class="table-responsive overflow-x-hidden py-5 w-100" style="min-width: 700px;">
                                <table class="table table-striped table-striped table-hover" id="dt_trans">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order No.</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">State</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($supplier_orders as $order)
                                        <tr>
                                            <th scope="row">#{{$order->id}}</th>
                                            <td>{{$order->name}}</td>
                                            <td>{{$order->date}}</td>
                                            <td>${{$helper->formatMoney($order->amount)}}</td>
                                            <td>{{$order->state}}</td>
                                            <td>
                                                <a href="{{ route('sellersOrderDetails',$helper->encode($order->id)) }}" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Details"><span class="fa fa-eye"></span></a>
                                                <button class="btn btn-primary ms-1" data-bs-toggle="modal" data-bs-target="#deliveryQuoteModal" data-order-id="{{$order->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Get Delivery Quote"><span class="fa fa-truck"></span></button>
                                                <!-- <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#change_state_{{$order->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Status"><span class="fa fa-info"></span></a> -->
                                            </td>
                                        </tr>
                                        @include('new_web_pages.admin_pages.seller_change_state_modal')
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
</div>

<!-- Delivery Quote Modal -->
<div class="modal fade" id="deliveryQuoteModal" tabindex="-1" aria-labelledby="deliveryQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deliveryQuoteModalLabel">Get Delivery Quote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deliveryQuoteForm">
                    <div class="mb-3">
                        <label for="orderId" class="form-label">Order ID</label>
                        <input type="text" class="form-control" id="orderId" readonly>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="totalWeight" class="form-label">Total Weight (lbs) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="totalWeight" step="0.1" min="0.1" required placeholder="Enter package weight">
                            <div class="form-text">Package weight in pounds</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="insuranceAmount" class="form-label">Insurance Amount ($) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="insuranceAmount" step="0.01" min="0" required placeholder="Enter insurance amount">
                            <div class="form-text">Package insurance value</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="length" class="form-label">Length (inches) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="length" step="0.1" min="0.1" required placeholder="Enter package length">
                            <div class="form-text">Package length in inches</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="height" class="form-label">Height (inches) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="height" step="0.1" min="0.1" required placeholder="Enter package height">
                            <div class="form-text">Package height in inches</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="getQuoteBtn">Get Quote</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });

        // Handle delivery quote modal
        $('#deliveryQuoteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var orderId = button.data('order-id');
            var modal = $(this);
            modal.find('#orderId').val(orderId);
            modal.find('#totalWeight').val('');
            modal.find('#length').val('');
            modal.find('#height').val('');
            modal.find('#insuranceAmount').val('');
        });

        // Handle get quote button click
        $('#getQuoteBtn').on('click', function() {
            var orderId = $('#orderId').val();
            var totalWeight = $('#totalWeight').val();
            var length = $('#length').val();
            var height = $('#height').val();
            var insuranceAmount = $('#insuranceAmount').val();
            
            // Validate all required fields
            if (!totalWeight || totalWeight <= 0) {
                alert('Please enter a valid weight');
                return;
            }
            if (!length || length <= 0) {
                alert('Please enter a valid length');
                return;
            }
            if (!height || height <= 0) {
                alert('Please enter a valid height');
                return;
            }
            if (!insuranceAmount || insuranceAmount < 0) {
                alert('Please enter a valid insurance amount');
                return;
            }

            // Show loading state
            $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Getting Quote...');

            // Redirect to delivery quotes page with all parameters
            window.location.href = "{{ route('deliveryQuotes') }}?orderId=" + orderId + 
                "&weight=" + totalWeight + 
                "&length=" + length + 
                "&height=" + height + 
                "&insuranceAmount=" + insuranceAmount;
        });

    });
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
@endsection