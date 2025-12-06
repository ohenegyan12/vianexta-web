@extends('layouts.new_home_layout')
@section('title', 'Order History')
@push('css')
<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">
<link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<style>
    /* Custom DataTable styling */
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
        min-width: 80px;
        padding-right: 2rem;
        background-position: right 0.5rem center;
        background-size: 16px 12px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
        margin-left: 0.5rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: 1px solid #dee2e6 !important;
        background: white !important;
        color: #6c757d !important;
        padding: 0.375rem 0.75rem !important;
        margin: 0 0.125rem !important;
        border-radius: 0.375rem !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e9ecef !important;
        color: #495057 !important;
        border-color: #adb5bd !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #1A4D3A !important;
        color: white !important;
        border-color: #1A4D3A !important;
    }

    .dataTables_wrapper .dataTables_info {
        padding-top: 0.5rem;
        color: #6c757d;
    }

    .dataTables_wrapper .dataTables_processing {
        background: rgba(255, 255, 255, 0.9);
        color: #1A4D3A;
        font-weight: 500;
    }

    /* Table styling */
    #ordersTable {
        border-collapse: separate;
        border-spacing: 0;
    }

    #ordersTable thead th {
        background: #1A4D3A;
        color: white;
        border: none;
        padding: 1rem 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
    }

    #ordersTable tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    #ordersTable tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
    }

    /* Badge styling */
    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        font-weight: 500;
    }

    /* Button styling */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            text-align: left;
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate {
            text-align: center;
            margin-top: 1rem;
        }

        #ordersTable thead th,
        #ordersTable tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.875rem;
        }
    }

    /* Additional length selector improvements */
    .dataTables_wrapper .dataTables_length {
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0;
    }

    .dataTables_wrapper .dataTables_length select {
        flex-shrink: 0;
    }

    /* Additional styling for new features */
    .table-hover {
        background-color: #f8f9fa !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Loading spinner styling */
    .spinner-border {
        width: 1rem;
        height: 1rem;
    }

    /* Export buttons styling */
    .dt-buttons .btn {
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        color: #fff !important;
        background-color: #1A4D3A !important;
        border-color: #1A4D3A !important;
    }

    .dt-buttons .btn:hover {
        background-color: #0f2d1f !important;
        border-color: #0f2d1f !important;
    }

    .dt-buttons .btn:focus {
        box-shadow: 0 0 0 0.2rem rgba(26, 77, 58, 0.25) !important;
    }

    /* Refresh button styling */
    #refreshTable {
        transition: transform 0.2s ease;
    }

    #refreshTable:hover {
        transform: rotate(180deg);
    }

    #refreshTable:active {
        transform: rotate(360deg);
    }

    /* Error message styling */
    .text-danger {
        color: #dc3545 !important;
    }

    /* Status badge improvements */
    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #000 !important;
    }

    .badge.bg-success {
        background-color: #198754 !important;
        color: #fff !important;
    }

    /* Table header improvements */
    #ordersTable thead th {
        position: relative;
        overflow: hidden;
    }

    #ordersTable thead th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #1A4D3A, #2d7a5f);
    }

    /* Search input focus effect */
    .dataTables_filter input:focus {
        border-color: #1A4D3A;
        box-shadow: 0 0 0 0.2rem rgba(26, 77, 58, 0.25);
        outline: 0;
    }

    /* Length select focus effect */
    .dataTables_length select:focus {
        border-color: #1A4D3A;
        box-shadow: 0 0 0 0.2rem rgba(26, 77, 58, 0.25);
        outline: 0;
    }

    /* User name styling */
    .user-greeting {
        color: #1A4D3A !important;
        font-weight: bold;
    }

    /* Payment status badge styling */
    .badge-payment-pending {
        background-color: #ffc107 !important;
        color: #000 !important;
    }

    .badge-payment-completed {
        background-color: #198754 !important;
        color: #fff !important;
    }

    .badge-payment-failed {
        background-color: #dc3545 !important;
        color: #fff !important;
    }

    .badge-payment-cancelled {
        background-color: #6c757d !important;
        color: #fff !important;
    }

    /* Complete payment button styling */
    .btn-complete-payment {
        background-color: #1A4D3A !important;
        border-color: #1A4D3A !important;
        color: #fff !important;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    .btn-complete-payment:hover {
        background-color: #0f2d1f !important;
        border-color: #0f2d1f !important;
        color: #fff !important;
    }

    .btn-complete-payment:focus {
        box-shadow: 0 0 0 0.2rem rgba(26, 77, 58, 0.25) !important;
    }

    /* Payment modal styling */
    .payment-modal .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .payment-modal .modal-header {
        background: linear-gradient(135deg, #1A4D3A 0%, #2d7a5f 100%);
        color: white;
        border-radius: 12px 12px 0 0;
        border: none;
        padding: 1.5rem;
    }

    .payment-modal .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .payment-modal .modal-body {
        padding: 2rem;
    }

    .payment-modal .checkout-buttons {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 1rem;
    }

    .payment-modal .checkout-btn {
        width: 100%;
        height: 80px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .payment-modal .btn-paypal {
        background: linear-gradient(135deg, #ffc439 0%, #f4b31d 100%);
        color: #000;
        border: 2px solid #f4b31d;
        position: relative;
        overflow: hidden;
    }

    .payment-modal .btn-paypal:hover {
        background: linear-gradient(135deg, #f4b31d 0%, #e6a800 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(244, 179, 29, 0.4);
        border-color: #e6a800;
    }

    .payment-modal .btn-paypal img {
        width: 120px !important;
        height: 120px !important;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.15));
        transition: all 0.3s ease;
    }

    .payment-modal .btn-paypal:hover img {
        transform: scale(1.1);
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    }

    .payment-modal .btn-paypal-crypto {
        background: linear-gradient(135deg, #6c5ce7 0%, #5a4fcf 100%);
        color: #fff;
        border: 2px solid #5a4fcf;
        position: relative;
        overflow: hidden;
    }

    .payment-modal .btn-paypal-crypto:hover {
        background: linear-gradient(135deg, #5a4fcf 0%, #4c3fb8 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4);
        border-color: #4c3fb8;
    }

    .payment-modal .btn-paypal-crypto img {
        width: 40px !important;
        height: 40px !important;
        filter: brightness(0) invert(1);
        transition: all 0.3s ease;
    }

    .payment-modal .btn-paypal-crypto:hover img {
        transform: scale(1.1);
    }

    .payment-modal .checkout-btn span {
        font-size: 1.1rem;
        font-weight: 600;
        margin-left: 10px;
    }
</style>
@endpush

@section('content')
<div class="wrapper">
    @include('includes.new_home.buyer_sidebar')
    <!-- Page Content  -->
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-secondary">
                    <i class="fa fa-align-left"></i>

                </button>
                <h1 class="display-6 fw-bolder user-greeting">Hi {{session('auth_user_name')}}!</h1>
                <img class="card-img-top img-fluid rounded"
                    src="{{ asset('images/seller/male_farmer.jpg') }}" style="height:40px; width:40px" alt="farmer">
            </div>
        </nav>


        <div class="row gx-2 gx-lg-3 gy-5 gy-lg-0 mt-3 row-gap-3">
            <div class="col-sm-12 col-xl-4">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4 text-center">
                            <img src="{{ asset('images/seller/dash_two.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">Total number of purchases</p>
                                <h5 class="card-title">Quantity: <span class="fw-bolder">{{$total_order_details->totalPurchases->quantity}} bags</span></h5>
                                <h5 class="card-title">Amount: <span class="fw-bolder">USD {{$helper->formatMoney($total_order_details->totalPurchases->totalPrice)}}</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-xl-4">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4 text-center">
                            <img src="{{ asset('images/seller/dash_one.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">Total pending orders</p>
                                <h5 class="card-title">Quantity: <span class="fw-bolder">{{$total_order_details->pendingOrders->quantity}} bags</span></h5>
                                <h5 class="card-title">Amount: <span class="fw-bolder">USD {{$helper->formatMoney($total_order_details->pendingOrders->totalPrice)}}</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" col-sm-12 col-xl-4">
                <div class="card mb-3 h-100 shadow p-3 bg-body-tertiary rounded">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4 text-center">
                            <img src="{{ asset('images/seller/dash_three.svg') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">Total completed Orders</p>
                                <h5 class="card-title">Quantity: <span class="fw-bolder">{{$total_order_details->completedOrders->quantity}} bags</span></h5>
                                <h5 class="card-title">Amount: <span class="fw-bolder">USD {{$helper->formatMoney($total_order_details->completedOrders->totalPrice)}}</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="card shadow p-3 bg-body-tertiary rounded">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title fw-bolder mb-0" style="color: #1A4D3A !important;">Order History</h3>
                        <p class="text-muted mb-0">All your orders with detailed information</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ordersTable" class="table table-striped table-hover" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Status</th>
                                        <th>Payment Status</th>
                                        <th>Payment Date</th>
                                        <th>Payment Method</th>
                                        <th>Date Purchased</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th>Delivery Status</th>
                                        <th>Delivery Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Options Modal -->
<div class="modal fade payment-modal" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">
                    <i class="fa fa-credit-card me-2"></i>Complete Payment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center mb-4">Choose your preferred payment method to complete the order payment.</p>
                
                <!-- Payment Options -->
                <div class="checkout-buttons">
                    <h6 class="text-center mb-3">Choose Payment Method</h6>
                    
                    <!-- PayPal Payment Button -->
                    <button type="button" class="checkout-btn btn-paypal payment-option-btn mb-3" data-payment-type="PAYPAL_CHECKOUT">
                        <img src="{{asset('images/market_place/paypal.svg')}}" alt="PayPal">
                        <span>Pay with PayPal</span>
                    </button>

                    <!-- PayPal Crypto Payment Button -->
                    <button type="button" class="checkout-btn btn-paypal-crypto payment-option-btn mb-3" data-payment-type="PAYPAL_CRYPTO">
                        <img src="{{asset('images/market_place/paypal.svg')}}" alt="PayPal">
                        <span>Pay with Crypto</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- jQuery CDN - Full version for DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<!-- Additional libraries for export functionality -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script>
    // Wait for jQuery to be fully loaded before running DataTable code
    function waitForJQuery(callback) {
        if (typeof $ !== 'undefined' && typeof $.fn !== 'undefined') {
            callback();
        } else {
            setTimeout(function() {
                waitForJQuery(callback);
            }, 100);
        }
    }

    waitForJQuery(function() {
        $(document).ready(function() {
            // Check if jQuery is available
            if (typeof $ === 'undefined') {
                console.error('jQuery is not loaded');
                return;
            }

            // Check if Bootstrap is available
            if (typeof bootstrap === 'undefined') {
                console.error('Bootstrap is not loaded');
                return;
            }

            // Check if DataTables is available
            if (typeof $.fn.DataTable === 'undefined') {
                console.error('DataTables is not loaded');
                return;
            }

            console.log('All required libraries loaded successfully');
            console.log('Bootstrap version:', bootstrap.VERSION || 'unknown');
            console.log('jQuery version:', $.fn.jquery);
            console.log('DataTables available:', typeof $.fn.DataTable !== 'undefined');

            // Sidebar toggle
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

            // Initialize DataTable with server-side processing
            var ordersTable = $('#ordersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("api.orders.datatable") }}',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Session-Token': '{{ session("auth_user_tokin") }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    beforeSend: function(xhr) {
                        // Log the request details for debugging
                        console.log('AJAX Request Details:', {
                            url: '{{ route("api.orders.datatable") }}',
                            csrfToken: $('meta[name="csrf-token"]').attr('content'),
                            sessionToken: '{{ session("auth_user_tokin") }}',
                            sessionId: '{{ session()->getId() }}',
                            cookies: document.cookie
                        });
                    },
                    data: function(d) {
                        // Add session information to the request
                        d.session_token = '{{ session("auth_user_tokin") }}';
                        d.session_id = '{{ session()->getId() }}';
                        return d;
                    },
                    error: function(xhr, error, thrown) {
                        console.error('DataTables error:', error);
                        console.error('XHR status:', xhr.status);
                        console.error('XHR response:', xhr.responseText);

                        let errorMessage = 'Error loading orders. ';

                        if (xhr.status === 0) {
                            errorMessage += 'Network error - please check your internet connection.';
                        } else if (xhr.status === 500) {
                            errorMessage += 'Server error - please try again later.';
                        } else if (xhr.status === 404) {
                            errorMessage += 'API endpoint not found.';
                        } else if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage += xhr.responseJSON.error;
                        } else if (xhr.responseJSON && xhr.responseJSON.warning) {
                            // Show warning but still display data
                            console.warn('API Warning:', xhr.responseJSON.warning);
                            return; // Don't show error for warnings
                        } else {
                            errorMessage += 'Please refresh the page or try again later.';
                        }

                        // Show user-friendly error message
                        $('#ordersTable tbody').html(
                            '<tr><td colspan="11" class="text-center text-danger">' +
                            '<i class="fa fa-exclamation-triangle me-2"></i>' +
                            errorMessage +
                            '<br><small class="text-muted">Status: ' + xhr.status + '</small>' +
                            '</td></tr>'
                        );

                        // Show error in console for debugging
                        console.error('Full error details:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText,
                            error: error,
                            thrown: thrown
                        });
                    }
                },
                columns: [{
                        data: 'id',
                        title: 'Order ID',
                        render: function(data) {
                            return '<strong>#' + data + '</strong>';
                        }
                    },
                    {
                        data: 'status',
                        title: 'Status',
                        render: function(data, type, row) {
                            var statusClass = data === 'Processing' ? 'warning' : 'success';
                            var statusIcon = data === 'Processing' ? 'fa-clock' : 'fa-check-circle';
                            return '<span class="badge bg-' + statusClass + '">' +
                                '<i class="fa ' + statusIcon + ' me-1"></i>' + data + '</span>';
                        }
                    },
                    {
                        data: 'paymentStatus',
                        title: 'Payment Status',
                        render: function(data, type, row) {
                            if (!data) return '<span class="text-muted">-</span>';
                            
                            var statusClass = '';
                            var statusIcon = '';
                            
                            switch(data.toUpperCase()) {
                                case 'PENDING':
                                    statusClass = 'badge-payment-pending';
                                    statusIcon = 'fa-clock';
                                    break;
                                case 'COMPLETED':
                                    statusClass = 'badge-payment-completed';
                                    statusIcon = 'fa-check-circle';
                                    break;
                                case 'FAILED':
                                    statusClass = 'badge-payment-failed';
                                    statusIcon = 'fa-times-circle';
                                    break;
                                case 'CANCELLED':
                                    statusClass = 'badge-payment-cancelled';
                                    statusIcon = 'fa-ban';
                                    break;
                                default:
                                    statusClass = 'badge bg-secondary';
                                    statusIcon = 'fa-question-circle';
                            }
                            
                            return '<span class="badge ' + statusClass + '">' +
                                '<i class="fa ' + statusIcon + ' me-1"></i>' + data + '</span>';
                        }
                    },
                    {
                        data: 'paymentDate',
                        title: 'Payment Date',
                        render: function(data) {
                            if (!data) return '<span class="text-muted">-</span>';
                            
                            var date = new Date(data);
                            var options = {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            };
                            return '<span class="text-muted" title="' + data + '">' +
                                date.toLocaleDateString('en-US', options) + '</span>';
                        }
                    },
                    {
                        data: 'paymentMethod',
                        title: 'Payment Method',
                        render: function(data) {
                            if (!data) return '<span class="text-muted">-</span>';
                            
                            var methodIcon = '';
                            switch(data) {
                                case 'PAYPAL_CHECKOUT':
                                    methodIcon = 'fa-cc-paypal';
                                    break;
                                case 'PAYPAL_CRYPTO':
                                    methodIcon = 'fa-bitcoin';
                                    break;
                                default:
                                    methodIcon = 'fa-credit-card';
                            }
                            
                            return '<span class="fw-medium">' +
                                '<i class="fa ' + methodIcon + ' me-1"></i>' + data + '</span>';
                        }
                    },
                    {
                        data: 'createdDate',
                        title: 'Date Purchased',
                        render: function(data) {
                            // Format date for better display
                            var date = new Date(data);
                            var options = {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            };
                            return '<span class="text-muted" title="' + data + '">' +
                                date.toLocaleDateString('en-US', options) + '</span>';
                        }
                    },
                    {
                        data: 'numBags',
                        title: 'Quantity',
                        render: function(data) {
                            return '<span class="fw-medium">' + data + ' bags</span>';
                        }
                    },
                    {
                        data: 'formattedPrice',
                        title: 'Amount',
                        render: function(data) {
                            return '<span class="fw-bold" style="color: #1A4D3A !important;">USD ' + data + '</span>';
                        }
                    },
                    {
                        data: 'delivery',
                        title: 'Delivery Status',
                        render: function(data, type, row) {
                            // Check if delivery is true (handle boolean, string, or number)
                            var isDelivery = data === true || data === 'true' || data === 1 || data === '1';
                            
                            if (!isDelivery) {
                                return '<span class="badge bg-secondary">No Delivery</span>';
                            }
                            
                            // Check if delivery amount exists
                            if (row.deliveryAmount && row.deliveryAmount !== null && row.deliveryAmount !== '' && row.deliveryAmount !== 0) {
                                return '<span class="badge bg-success"><i class="fa fa-check-circle me-1"></i>Delivery Set</span>';
                            } else {
                                return '<span class="badge bg-warning"><i class="fa fa-clock me-1"></i>Pending Quote</span>';
                            }
                        }
                    },
                    {
                        data: 'formattedDeliveryAmount',
                        title: 'Delivery Amount',
                        render: function(data, type, row) {
                            // Check if delivery is true (handle boolean, string, or number)
                            var isDelivery = row.delivery === true || row.delivery === 'true' || row.delivery === 1 || row.delivery === '1';
                            
                            if (!isDelivery) {
                                return '<span class="text-muted">-</span>';
                            }
                            
                            if (data && data !== null && data !== '') {
                                return '<span class="fw-bold" style="color: #1A4D3A !important;">USD ' + data + '</span>';
                            } else {
                                return '<span class="text-muted">Not Set</span>';
                            }
                        }
                    },
                    {
                        data: 'actions',
                        title: 'Actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            var buttons = '<div class="btn-group" role="group">';
                            
                            // Check delivery status
                            var isDelivery = row.delivery === true || row.delivery === 'true' || row.delivery === 1 || row.delivery === '1';
                            var hasDeliveryAmount = row.deliveryAmount && row.deliveryAmount !== null && row.deliveryAmount !== '' && row.deliveryAmount !== 0;
                            
                            // Show track button only when: delivery is true AND no delivery amount is set
                            // In this case, the track button should trigger delivery quote request
                            if (isDelivery && !hasDeliveryAmount) {
                                buttons += '<a href="' + data.deliveryQuote + '" class="btn btn-sm me-1" title="Request Delivery Quote" style="background-color: #1A4D3A; border-color: #1A4D3A; color: white;">' +
                                    '<i class="fa fa-truck me-1"></i>Track</a>';
                            }
                            // Hide track button when: no delivery OR delivery is true AND deliveryAmount exists
                            
                            buttons += '<a href="' + data.details + '" class="btn btn-sm btn-outline-secondary" title="View Details">' +
                                '<i class="fa fa-eye me-1"></i>Details</a>';
                            
                            // Add complete payment button for pending payments
                            if (row.paymentStatus && row.paymentStatus.toUpperCase() === 'PENDING') {
                                buttons += '<button class="btn btn-sm btn-complete-payment ms-1" title="Complete Payment" data-order-id="' + row.id + '">' +
                                    '<i class="fa fa-credit-card me-1"></i>Complete Payment</button>';
                            }
                            
                            buttons += '</div>';
                            return buttons;
                        }
                    }
                ],
                order: [
                    [2, 'desc']
                ], // Sort by date column (index 2) in descending order
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                language: {
                    search: "Search orders:",
                    lengthMenu: "Show _MENU_ orders per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ orders",
                    infoEmpty: "Showing 0 to 0 of 0 orders",
                    infoFiltered: "(filtered from _MAX_ total orders)",
                    processing: '<div class="spinner-border" style="color: #1A4D3A !important;" role="status"><span class="visually-hidden">Loading...</span></div> Loading orders...',
                    emptyTable: '<div class="text-center text-muted py-4"><i class="fa fa-inbox fa-3x mb-3"></i><br>No orders found</div>',
                    zeroRecords: '<div class="text-center text-muted py-4"><i class="fa fa-search fa-3x mb-3"></i><br>No orders match your search criteria</div>'
                },
                responsive: true,
                autoWidth: false,
                drawCallback: function(settings) {
                    // Add custom styling after each draw
                    $('.dataTables_paginate .paginate_button').addClass('btn btn-sm btn-outline-success mx-1');
                    $('.dataTables_paginate .paginate_button.current').removeClass('btn-outline-success').addClass('btn-success').css('background-color', '#1A4D3A').css('border-color', '#1A4D3A');

                    // Add tooltips to action buttons if Bootstrap tooltip is available
                    if (typeof bootstrap !== 'undefined' && typeof bootstrap.Tooltip !== 'undefined') {
                        // Initialize tooltips for elements with title attribute
                        $('[title]').each(function() {
                            try {
                                new bootstrap.Tooltip(this);
                            } catch (error) {
                                console.warn('Tooltip initialization failed for element:', this, error.message);
                            }
                        });
                    } else if (typeof $.fn.tooltip !== 'undefined') {
                        // Fallback to jQuery tooltip if available
                        try {
                            $('[title]').tooltip();
                        } catch (error) {
                            console.warn('jQuery tooltip initialization failed:', error.message);
                        }
                    } else {
                        console.warn('No tooltip library available - tooltips disabled');
                    }

                    // Add row hover effects
                    $('#ordersTable tbody tr').hover(
                        function() {
                            $(this).addClass('table-hover');
                        },
                        function() {
                            $(this).removeClass('table-hover');
                        }
                    );
                },
                initComplete: function() {
                    // Add export buttons after table initialization
                    if (typeof this.api !== 'undefined' && typeof this.api().buttons !== 'undefined') {
                        this.api().buttons().container().appendTo('#ordersTable_wrapper .col-md-6:eq(0)');
                    }

                    // Add refresh button
                    $('<button class="btn btn-outline-success btn-sm ms-2" id="refreshTable" title="Refresh Orders" style="border-color: #1A4D3A; color: #1A4D3A;">' +
                        '<i class="fa fa-refresh"></i></button>').appendTo('#ordersTable_wrapper .col-md-6:eq(0)');

                    // Bind refresh button
                    $('#refreshTable').on('click', function() {
                        if (typeof ordersTable !== 'undefined' && typeof ordersTable.ajax !== 'undefined') {
                            ordersTable.ajax.reload();
                        }
                    });
                }
            });

            // Add export buttons
            if (typeof $.fn.dataTable !== 'undefined' && typeof $.fn.dataTable.Buttons !== 'undefined') {
                new $.fn.dataTable.Buttons(ordersTable, {
                    buttons: [{
                            extend: 'copy',
                            text: '<i class="fa fa-copy me-1"></i>Copy',
                            className: 'btn btn-sm me-2',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] // Exclude actions column (10)
                            }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="fa fa-file-csv me-1"></i>CSV',
                            className: 'btn btn-sm me-2',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                            }
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fa fa-file-excel me-1"></i>Excel',
                            className: 'btn btn-sm me-2',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fa fa-file-pdf me-1"></i>PDF',
                            className: 'btn btn-sm me-2',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                            }
                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print me-1"></i>Print',
                            className: 'btn btn-sm',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                            }
                        }
                    ]
                });
            } else {
                console.warn('DataTables Buttons plugin not available - export functionality disabled');
            }

            // Refresh table every 30 seconds to show latest orders
            if (typeof ordersTable !== 'undefined' && typeof ordersTable.ajax !== 'undefined') {
                setInterval(function() {
                    try {
                        ordersTable.ajax.reload(null, false);
                    } catch (error) {
                        console.warn('Auto-refresh failed:', error);
                    }
                }, 30000);
            }

            // Handle complete payment button clicks
            $(document).on('click', '.btn-complete-payment', function(e) {
                e.preventDefault();
                
                var orderId = $(this).data('order-id');
                
                // Set the order ID in the modal
                $('#paymentModal').data('order-id', orderId);
                
                // Reset payment buttons state
                $('.payment-option-btn').prop('disabled', false);
                $('.payment-option-btn').each(function() {
                    var originalHtml = $(this).data('original-html');
                    if (!originalHtml) {
                        $(this).data('original-html', $(this).html());
                    }
                });
                
                // Show the payment modal
                if (typeof bootstrap !== 'undefined' && typeof bootstrap.Modal !== 'undefined') {
                    var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
                    paymentModal.show();
                } else {
                    // Fallback if Bootstrap modal is not available
                    $('#paymentModal').modal('show');
                }
            });

            // Reset modal state when it's hidden
            $('#paymentModal').on('hidden.bs.modal', function() {
                $('.payment-option-btn').prop('disabled', false);
                $('.payment-option-btn').each(function() {
                    var originalHtml = $(this).data('original-html');
                    if (originalHtml) {
                        $(this).html(originalHtml);
                    }
                });
                $(this).removeData('order-id');
            });

            // Handle payment option selection
            $(document).on('click', '.payment-option-btn', function(e) {
                e.preventDefault();
                
                var paymentType = $(this).data('payment-type');
                var orderId = $('#paymentModal').data('order-id');
                var button = $(this);
                var originalHtml = button.html();
                
                // Disable all payment buttons and show loading state
                $('.payment-option-btn').prop('disabled', true);
                button.html('<i class="fa fa-spinner fa-spin me-1"></i>Processing...');
                
                // Make AJAX request to initiate payment
                $.ajax({
                    url: '/api/payment/regenerate-link/' + orderId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Session-Token': '{{ session("auth_user_tokin") }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        paymentType: paymentType
                    },
                    success: function(response) {
                        if (response.success) {
                            // Close the modal
                            if (typeof bootstrap !== 'undefined' && typeof bootstrap.Modal !== 'undefined') {
                                var paymentModal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
                                if (paymentModal) {
                                    paymentModal.hide();
                                }
                            } else {
                                $('#paymentModal').modal('hide');
                            }
                            
                            // Check if we have an approval URL to redirect to
                            if (response.data && response.data.approvalUrl) {
                                // Redirect to PayPal payment page
                                window.location.href = response.data.approvalUrl;
                            } else {
                                // Show success message and reload table
                                if (typeof bootstrap !== 'undefined' && typeof bootstrap.Toast !== 'undefined') {
                                    var toastHtml = '<div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">' +
                                        '<div class="d-flex">' +
                                        '<div class="toast-body">' +
                                        '<i class="fa fa-check-circle me-2"></i>Payment initiated successfully!' +
                                        '</div>' +
                                        '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>' +
                                        '</div>' +
                                        '</div>';
                                    
                                    var toastElement = $(toastHtml).appendTo('body');
                                    var toast = new bootstrap.Toast(toastElement[0]);
                                    toast.show();
                                    
                                    toastElement.on('hidden.bs.toast', function() {
                                        $(this).remove();
                                    });
                                } else {
                                    alert('Payment initiated successfully!');
                                }
                                
                                // Reload the table to show updated data
                                if (typeof ordersTable !== 'undefined' && typeof ordersTable.ajax !== 'undefined') {
                                    ordersTable.ajax.reload();
                                }
                            }
                        } else {
                            throw new Error(response.message || 'Failed to initiate payment');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error initiating payment:', error);
                        
                        var errorMessage = 'Failed to initiate payment. ';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage += xhr.responseJSON.message;
                        } else if (xhr.status === 0) {
                            errorMessage += 'Network error - please check your internet connection.';
                        } else if (xhr.status === 500) {
                            errorMessage += 'Server error - please try again later.';
                        } else {
                            errorMessage += 'Please try again later.';
                        }
                        
                        // Show error message
                        if (typeof bootstrap !== 'undefined' && typeof bootstrap.Toast !== 'undefined') {
                            var toastHtml = '<div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">' +
                                '<div class="d-flex">' +
                                '<div class="toast-body">' +
                                '<i class="fa fa-exclamation-triangle me-2"></i>' + errorMessage +
                                '</div>' +
                                '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>' +
                                '</div>' +
                                '</div>';
                            
                            var toastElement = $(toastHtml).appendTo('body');
                            var toast = new bootstrap.Toast(toastElement[0]);
                            toast.show();
                            
                            toastElement.on('hidden.bs.toast', function() {
                                $(this).remove();
                            });
                        } else {
                            alert(errorMessage);
                        }
                    },
                    complete: function() {
                        // Re-enable all payment buttons and restore original text
                        $('.payment-option-btn').prop('disabled', false);
                        button.html(originalHtml);
                    }
                });
            });
        });
    });
</script>

<!-- Clare Chat Component -->
<script src="{{ asset('js/clare-component.js') }}"></script>
@endsection