@extends('layouts.new_home_layout')
@section('title', 'Coffee Suppliers')
@push('css')
<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">
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
    #suppliersTable {
        border-collapse: separate;
        border-spacing: 0;
    }

    #suppliersTable thead th {
        background: #1A4D3A;
        color: white;
        border: none;
        padding: 1rem 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
    }

    #suppliersTable tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    #suppliersTable tbody tr:hover {
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

        #suppliersTable thead th,
        #suppliersTable tbody td {
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

    /* Table header improvements */
    #suppliersTable thead th {
        position: relative;
        overflow: hidden;
    }

    #suppliersTable thead th::after {
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

    /* Category badge styling */
    .category-badge {
        background: linear-gradient(135deg, #1A4D3A, #2d7a5f);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Contact info styling */
    .contact-info {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .contact-info a {
        color: #1A4D3A;
        text-decoration: none;
    }

    .contact-info a:hover {
        text-decoration: underline;
    }

    /* Modal styling */
    .modal-content {
        border-radius: 1rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        border-radius: 1rem 1rem 0 0;
        border-bottom: none;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-body {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .modal-body .card {
        border-radius: 0.75rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .modal-body .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-footer {
        border-radius: 0 0 1rem 1rem;
        border-top: none;
    }

    .modal-footer .btn {
        border-radius: 0.5rem;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
    }

    /* Badge styling for modal */
    .badge.bg-primary {
        background: linear-gradient(135deg, #1A4D3A, #2d7a5f) !important;
        border: none;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Text styling for modal */
    .modal-body .text-muted {
        color: #6c757d !important;
        font-size: 0.95rem;
    }

    .modal-body strong {
        color: #495057;
        font-weight: 600;
    }

    /* Enhanced table styling */
    .table-row-hover:hover {
        background-color: #f8f9fa !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
    }

    .table-info {
        background: linear-gradient(135deg, #1A4D3A, #2d7a5f) !important;
        color: white !important;
    }

    .table-light {
        background-color: #f8f9fa !important;
        border-top: 2px solid #1A4D3A;
    }

    .btn-group .btn {
        margin: 0 1px;
    }

    .form-select-sm {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
    }

    .input-group-sm .form-control {
        font-size: 0.875rem;
    }

    /* Pagination button styling */
    .btn-outline-primary {
        border-color: #1A4D3A;
        color: #1A4D3A;
    }

    .btn-outline-primary:hover {
        background-color: #1A4D3A;
        border-color: #1A4D3A;
        color: white;
    }

    .btn-primary {
        background-color: #1A4D3A;
        border-color: #1A4D3A;
    }

    .btn-primary:hover {
        background-color: #0f2d1f;
        border-color: #0f2d1f;
    }

    /* Search input styling */
    #searchInput:focus {
        border-color: #1A4D3A;
        box-shadow: 0 0 0 0.2rem rgba(26, 77, 58, 0.25);
    }
</style>
@endpush

@section('content')
<div class="wrapper">
    @include('includes.new_home.new_sidebar')
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
            <div class="col-12">
                <div class="card shadow p-3 bg-body-tertiary rounded">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title fw-bolder mb-0" style="color: #1A4D3A !important;">Coffee Suppliers Directory</h3>
                        <p class="text-muted mb-0">Manage and view all coffee suppliers in the system</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="suppliersTable" class="table table-striped table-hover" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Company</th>
                                        <th>Category</th>
                                        <th>Location</th>
                                        <th>Contact</th>
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

<!-- View Supplier Modal -->
<div class="modal fade" id="viewSupplierModal" tabindex="-1" aria-labelledby="viewSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-gradient text-white" style="background: linear-gradient(135deg, #1A4D3A, #2d7a5f);">
                <h5 class="modal-title fw-bold" id="viewSupplierModalLabel">
                    <i class="fa fa-building me-2"></i>Supplier Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <!-- Company Information -->
                    <div class="col-12 mb-4">
                        <div class="card border-0 bg-light">
                            <div class="card-body p-3">
                                <h6 class="card-title fw-bold text-primary mb-3">
                                    <i class="fa fa-building me-2"></i>Company Information
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Company Name:</strong></p>
                                        <p class="text-muted" id="modal-company">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Category:</strong></p>
                                        <span class="badge bg-primary" id="modal-category">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="col-12 mb-4">
                        <div class="card border-0 bg-light">
                            <div class="card-body p-3">
                                <h6 class="card-title fw-bold text-success mb-3">
                                    <i class="fa fa-map-marker me-2"></i>Location
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Street Address:</strong></p>
                                        <p class="text-muted" id="modal-street">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>City:</strong></p>
                                        <p class="text-muted" id="modal-city">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>State:</strong></p>
                                        <p class="text-muted" id="modal-state">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>ZIP Code:</strong></p>
                                        <p class="text-muted" id="modal-zip">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-12 mb-4">
                        <div class="card border-0 bg-light">
                            <div class="card-body p-3">
                                <h6 class="card-title fw-bold text-info mb-3">
                                    <i class="fa fa-address-book me-2"></i>Contact Information
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Phone:</strong></p>
                                        <p class="text-muted" id="modal-phone">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Email:</strong></p>
                                        <p class="text-muted" id="modal-email">-</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="mb-2"><strong>Website:</strong></p>
                                        <p class="text-muted" id="modal-website">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-2"></i>Close
                </button>
                <button type="button" class="btn btn-primary" onclick="contactSupplierFromModal()">
                    <i class="fa fa-envelope me-2"></i>Contact Supplier
                </button>
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

            // Initialize DataTable with server-side processing for proper pagination
            var suppliersTable;
            
            console.log('Starting DataTable initialization...');
            console.log('Table element found:', $('#suppliersTable').length > 0);
            console.log('jQuery version:', $.fn.jquery);
            console.log('DataTables available:', typeof $.fn.DataTable !== 'undefined');
            
            // Check if table already has DataTable initialized
            if ($.fn.DataTable.isDataTable('#suppliersTable')) {
                console.log('DataTable already initialized, destroying first...');
                $('#suppliersTable').DataTable().destroy();
            }
            
            // Use enhanced mode as primary solution
            console.log('Loading suppliers with enhanced mode...');
            loadSuppliersSimple();
            
            // Skip DataTable initialization to avoid conflicts
            console.log('Enhanced mode loaded successfully - DataTable initialization skipped');
        });
    });
    
    // Enhanced function to load suppliers with pagination, search, and sorting
    var currentPage = 1;
    var pageSize = 10;
    var totalRecords = 0;
    var currentSearch = '';
    var currentSort = { column: 1, direction: 'asc' }; // Default sort by company name

    function loadSuppliersSimple(page = 1, search = '', sortColumn = 1, sortDirection = 'asc') {
        console.log('Loading suppliers with enhanced approach...', { page, search, sortColumn, sortDirection });
        
        var start = (page - 1) * pageSize;
        
        $.ajax({
            url: '{{ route("api.coffee-suppliers.datatable") }}',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Session-Token': '{{ session("auth_user_tokin") }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                draw: page,
                start: start,
                length: pageSize,
                'search[value]': search,
                'order[0][column]': sortColumn,
                'order[0][dir]': sortDirection,
                session_token: '{{ session("auth_user_tokin") }}',
                session_id: '{{ session()->getId() }}'
            },
            success: function(response) {
                console.log('Enhanced load successful:', response);
                
                if (response && response.data && Array.isArray(response.data)) {
                    totalRecords = response.recordsTotal || 0;
                    currentPage = page;
                    currentSearch = search;
                    currentSort = { column: sortColumn, direction: sortDirection };
                    
                    var tbody = $('#suppliersTable tbody');
                    tbody.empty();
                    
                    // Add header row with search
                    var headerRow = '<tr class="table-info">' +
                        '<td colspan="7" class="text-center">' +
                            '<div class="row align-items-center">' +
                                '<div class="col-md-6">' +
                                    '<strong>Suppliers List (Enhanced Mode)</strong>' +
                                '</div>' +
                                '<div class="col-md-6">' +
                                    '<div class="input-group input-group-sm">' +
                                        '<input type="text" id="searchInput" class="form-control" placeholder="Search suppliers..." value="' + search + '">' +
                                        '<button class="btn btn-outline-secondary" type="button" onclick="performSearch()">' +
                                            '<i class="fa fa-search"></i>' +
                                        '</button>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</td>' +
                    '</tr>';
                    tbody.append(headerRow);
                    
                    // Add data rows
                    response.data.forEach(function(supplier, index) {
                        var row = '<tr class="table-row-hover">' +
                            '<td class="text-center"><strong>#' + (supplier.id || 'N/A') + '</strong></td>' +
                            '<td><span style="color: #1A4D3A; font-weight: bold;">' + (supplier.company || 'N/A') + '</span></td>' +
                            '<td><span class="badge bg-primary">' + (supplier.category || 'N/A') + '</span></td>' +
                            '<td><i class="fa fa-map-marker-alt me-1"></i>' + (supplier.city || 'N/A') + '</td>' +
                            '<td><a href="mailto:' + (supplier.email || '') + '" class="text-decoration-none"><i class="fa fa-envelope me-1"></i>' + (supplier.email || 'N/A') + '</a></td>' +
                            '<td><i class="fa fa-phone me-1"></i>' + (supplier.phone || 'N/A') + '</td>' +
                            '<td class="text-center">' +
                                '<button class="btn btn-sm btn-outline-primary" onclick="viewSupplier(' + (supplier.id || 0) + ')" title="View Details">' +
                                    '<i class="fa fa-eye me-1"></i>View' +
                                '</button>' +
                            '</td>' +
                        '</tr>';
                        tbody.append(row);
                    });
                    
                    // Add pagination controls
                    addPaginationControls(response.recordsTotal, response.recordsFiltered, page, pageSize);
                    
                    console.log('Enhanced data load completed - ' + response.data.length + ' rows added');
                }
            },
            error: function(xhr, status, error) {
                console.error('Enhanced load failed:', xhr.responseText);
            }
        });
    }

    function addPaginationControls(totalRecords, filteredRecords, currentPage, pageSize) {
        var totalPages = Math.ceil(filteredRecords / pageSize);
        var startRecord = (currentPage - 1) * pageSize + 1;
        var endRecord = Math.min(currentPage * pageSize, filteredRecords);
        
        var paginationHtml = '<tr class="table-light">' +
            '<td colspan="7" class="text-center">' +
                '<div class="row align-items-center">' +
                    '<div class="col-md-4">' +
                        '<small class="text-muted">' +
                            'Showing ' + startRecord + ' to ' + endRecord + ' of ' + filteredRecords + ' entries' +
                            (filteredRecords < totalRecords ? ' (filtered from ' + totalRecords + ' total)' : '') +
                        '</small>' +
                    '</div>' +
                    '<div class="col-md-4">' +
                        '<div class="btn-group" role="group">';
        
        // Previous button
        if (currentPage > 1) {
            paginationHtml += '<button class="btn btn-outline-primary btn-sm" onclick="loadSuppliersSimple(' + (currentPage - 1) + ', \'' + currentSearch + '\', ' + currentSort.column + ', \'' + currentSort.direction + '\')">' +
                '<i class="fa fa-chevron-left"></i> Previous' +
            '</button>';
        }
        
        // Page numbers
        var startPage = Math.max(1, currentPage - 2);
        var endPage = Math.min(totalPages, currentPage + 2);
        
        for (var i = startPage; i <= endPage; i++) {
            var activeClass = i === currentPage ? 'btn-primary' : 'btn-outline-primary';
            paginationHtml += '<button class="btn ' + activeClass + ' btn-sm" onclick="loadSuppliersSimple(' + i + ', \'' + currentSearch + '\', ' + currentSort.column + ', \'' + currentSort.direction + '\')">' + i + '</button>';
        }
        
        // Next button
        if (currentPage < totalPages) {
            paginationHtml += '<button class="btn btn-outline-primary btn-sm" onclick="loadSuppliersSimple(' + (currentPage + 1) + ', \'' + currentSearch + '\', ' + currentSort.column + ', \'' + currentSort.direction + '\')">' +
                'Next <i class="fa fa-chevron-right"></i>' +
            '</button>';
        }
        
        paginationHtml += '</div>' +
                    '</div>' +
                    '<div class="col-md-4">' +
                        '<div class="row">' +
                            '<div class="col-6">' +
                                '<div class="btn-group" role="group">' +
                                    '<button class="btn btn-outline-secondary btn-sm" onclick="loadSuppliersSimple(1, \'' + currentSearch + '\', 1, \'asc\')" title="Sort by ID">' +
                                        'ID <i class="fa fa-sort"></i>' +
                                    '</button>' +
                                    '<button class="btn btn-outline-secondary btn-sm" onclick="toggleSort(1)" title="Sort by Company">' +
                                        'Company <i class="fa fa-sort"></i>' +
                                    '</button>' +
                                    '<button class="btn btn-outline-secondary btn-sm" onclick="toggleSort(2)" title="Sort by Category">' +
                                        'Category <i class="fa fa-sort"></i>' +
                                    '</button>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-6">' +
                                '<select class="form-select form-select-sm" onchange="changePageSize(this.value)">' +
                                    '<option value="10"' + (pageSize === 10 ? ' selected' : '') + '>10 per page</option>' +
                                    '<option value="25"' + (pageSize === 25 ? ' selected' : '') + '>25 per page</option>' +
                                    '<option value="50"' + (pageSize === 50 ? ' selected' : '') + '>50 per page</option>' +
                                    '<option value="100"' + (pageSize === 100 ? ' selected' : '') + '>100 per page</option>' +
                                '</select>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</td>' +
        '</tr>';
        
        $('#suppliersTable tbody').append(paginationHtml);
    }

    function performSearch() {
        var searchTerm = $('#searchInput').val();
        loadSuppliersSimple(1, searchTerm, currentSort.column, currentSort.direction);
    }

    function toggleSort(column) {
        var newDirection = 'asc';
        if (currentSort.column === column && currentSort.direction === 'asc') {
            newDirection = 'desc';
        }
        loadSuppliersSimple(currentPage, currentSearch, column, newDirection);
    }

    function changePageSize(newSize) {
        pageSize = parseInt(newSize);
        loadSuppliersSimple(1, currentSearch, currentSort.column, currentSort.direction);
    }

    // Allow Enter key to trigger search
    $(document).on('keypress', '#searchInput', function(e) {
        if (e.which === 13) { // Enter key
            performSearch();
        }
    });

    // Enhanced mode is now the primary solution - no fallback needed

    // Action functions for supplier management
    function viewSupplier(id) {
        console.log('Viewing supplier with ID:', id);
        
        // First, try to find the supplier in the currently displayed data
        var foundSupplier = null;
        $('#suppliersTable tbody tr').each(function() {
            var $row = $(this);
            var rowId = $row.find('td:first strong').text().replace('#', '');
            
            if (rowId == id) {
                // Extract data from the current row
                foundSupplier = {
                    id: id,
                    company: $row.find('td:nth-child(2) span').text(),
                    category: $row.find('td:nth-child(3) span').text(),
                    city: $row.find('td:nth-child(4)').text().replace('📍', '').trim(),
                    email: $row.find('td:nth-child(5) a').text(),
                    phone: $row.find('td:nth-child(6)').text().replace('📞', '').trim(),
                    street: 'N/A', // Not displayed in current view
                    state: 'N/A',  // Not displayed in current view
                    zip: 'N/A',    // Not displayed in current view
                    website: 'N/A' // Not displayed in current view
                };
                console.log('Found supplier in current view:', foundSupplier);
                return false; // Break the loop
            }
        });
        
        if (foundSupplier) {
            // Use the data from the current row
            populateModal(foundSupplier);
        } else {
            // If not found in current view, search through multiple pages
            searchSupplierById(id);
        }
    }
    
    function searchSupplierById(id) {
        console.log('Searching for supplier ID:', id, 'across multiple pages...');
        
        // Show loading message
        alert('Searching for supplier details... Please wait.');
        
        // Search through pages to find the supplier
        var searchPage = 1;
        var maxPages = 50; // Limit search to prevent infinite loops
        var pageSize = 100; // Larger page size for searching
        
        function searchNextPage() {
            if (searchPage > maxPages) {
                console.error('Supplier not found after searching', maxPages, 'pages');
                alert('Supplier not found. The supplier may have been removed or the ID is invalid.');
                return;
            }
            
            var start = (searchPage - 1) * pageSize;
            
            $.ajax({
                url: '{{ route("api.coffee-suppliers.datatable") }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Session-Token': '{{ session("auth_user_tokin") }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: {
                    draw: searchPage,
                    start: start,
                    length: pageSize,
                    session_token: '{{ session("auth_user_tokin") }}',
                    session_id: '{{ session()->getId() }}'
                },
                success: function(response) {
                    if (response && response.data && Array.isArray(response.data)) {
                        // Find the supplier with the matching ID
                        var supplier = response.data.find(function(s) {
                            return s.id == id;
                        });
                        
                        if (supplier) {
                            console.log('Found supplier on page', searchPage);
                            populateModal(supplier);
                        } else {
                            // Check if we've reached the end of data
                            if (response.data.length < pageSize) {
                                console.error('Supplier not found - reached end of data');
                                alert('Supplier not found. The supplier may have been removed or the ID is invalid.');
                            } else {
                                // Continue searching on next page
                                searchPage++;
                                searchNextPage();
                            }
                        }
                    } else {
                        console.error('Invalid response format while searching for supplier');
                        alert('Error loading supplier details. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error searching for supplier:', xhr.responseText);
                    alert('Error loading supplier details. Please try again.');
                }
            });
        }
        
        searchNextPage();
    }
    
    function populateModal(supplier) {
        // Populate the modal with supplier data
        $('#modal-company').text(supplier.company || 'N/A');
        $('#modal-category').text(supplier.category || 'N/A');
        $('#modal-street').text(supplier.street || 'N/A');
        $('#modal-city').text(supplier.city || 'N/A');
        $('#modal-state').text(supplier.state || 'N/A');
        $('#modal-zip').text(supplier.zip || 'N/A');
        $('#modal-phone').text(supplier.phone || 'N/A');
        $('#modal-email').text(supplier.email || 'N/A');
        $('#modal-website').text(supplier.website || 'N/A');
        
        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById('viewSupplierModal'));
        modal.show();
    }

    function editSupplier(id) {
        // Implement edit supplier functionality
        console.log('Edit supplier with ID:', id);
        // You can redirect to an edit page or show an edit modal
        alert('Edit supplier for ID: ' + id + ' (functionality to be implemented)');
    }

    function contactSupplier(id) {
        // Implement contact supplier functionality
        console.log('Contact supplier with ID:', id);
        // You can show contact information or open a contact form
        alert('Contact supplier for ID: ' + id + ' (functionality to be implemented)');
    }

    function contactSupplierFromModal() {
        // Get supplier details from modal and implement contact functionality
        var company = $('#modal-company').text();
        var email = $('#modal-email').text();
        var phone = $('#modal-phone').text();
        
        if (email && email !== 'N/A') {
            // Open email client
            window.open('mailto:' + email + '?subject=Inquiry about ' + company, '_blank');
        } else if (phone && phone !== 'N/A') {
            // Show phone number
            alert('Contact ' + company + ' at: ' + phone);
        } else {
            alert('No contact information available for ' + company);
        }
    }
</script>
@endsection