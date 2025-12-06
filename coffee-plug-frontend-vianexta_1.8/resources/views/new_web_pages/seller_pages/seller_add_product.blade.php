@extends('layouts.new_home_layout')
@section('title', 'Add Products')
@push('css')
<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">
<link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<link href="https://playground.anychart.com/gallery/src/Sunburst_Charts/Coffee_Flavour_Wheel/iframe" rel="canonical">
<link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" rel="stylesheet" type="text/css">
<style>
    #container {
    width: 100%;
        height: 600px; /* Increased from default */
    margin: 0;
    padding: 0;
        min-height: 600px;
    }

    /* Enlarge flavor wheel container */
    .flavor-wheel-container {
        width: 100%;
        height: 600px;
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        border: 2px solid #e9ecef;
        margin: 1rem 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .form-switch .form-check-input:checked {
        background-position: right center;
        background-color: #D8501C;
    }
    
    .form-check-input {
        background-position: right center;
        color: #07382F;
        border-color: #07382F;
        outline: 0;
        box-shadow: #07382F;
        height: 22px;
        width: 30px;
    }

    /* Modern Form Styling */
    .modern-form-container {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
        max-width: none;
        width: 100%;
        margin-left: 0;
        margin-right: 0;
    }

    /* Standard layout like seller_product_page */
    .wrapper {
        display: flex;
        align-items: stretch;
    }

    #content {
        width: 100%;
        padding: 20px;
        min-height: 100vh;
        transition: all 0.3s;
    }

    .form-section {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .form-section h5 {
        color: #07382F;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background-color: #ffffff;
    }

    .form-control:focus, .form-select:focus {
        border-color: #07382F;
        box-shadow: 0 0 0 0.2rem rgba(7, 56, 47, 0.15);
        background-color: #ffffff;
    }

    .form-control:hover, .form-select:hover {
        border-color: #07382F;
    }

    /* Ensure select text is visible */
    .form-select {
        color: #495057 !important;
    }

    /* Force text visibility in selects */
    select.form-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    select.form-select option {
        color: #495057;
        background-color: white;
    }

    /* Progress Steps */
    .progress-steps {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
        padding: 1rem 0;
        width: 100%;
        max-width: none;
    }

    .step {
        display: flex;
        align-items: center;
        margin: 0 1rem;
    }

    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 0.5rem;
        transition: all 0.3s ease;
    }

    .step.active .step-number {
        background: #07382F;
        color: white;
    }

    .step.completed .step-number {
        background: #D8501C;
        color: white;
    }

    .step-label {
        font-weight: 500;
        color: #6c757d;
    }

    .step.active .step-label {
        color: #07382F;
    }

    .step.completed .step-label {
        color: #D8501C;
    }

    .step-connector {
        width: 60px;
        height: 2px;
        background: #e9ecef;
        margin: 0 0.5rem;
    }

    .step.completed + .step-connector {
        background: #D8501C;
    }

    /* Enhanced Scale Visualization */
    .scale-container {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1rem 0;
        border: 2px solid #e9ecef;
        position: relative;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .scale-title {
        text-align: center;
        color: #07382F;
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1.1rem;
        letter-spacing: 0.3px;
    }

    .scale-description {
        text-align: center;
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        font-weight: 500;
    }

    .scale-visual {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin: 1.5rem 0;
        padding: 0 0.5rem;
        position: relative;
        min-height: 80px;
    }

    .scale-line {
        position: absolute;
        top: 25px;
        left: 0.5rem;
        right: 0.5rem;
        height: 6px;
        background: linear-gradient(90deg, #D8501C 0%, #ff6b35 20%, #ffa726 40%, #66bb6a 60%, #4caf50 80%, #07382F 100%);
        border-radius: 3px;
        z-index: 1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .scale-point {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0.25rem;
        border-radius: 8px;
        min-width: 60px;
    }

    .scale-point:hover {
        transform: translateY(-3px);
        background: rgba(7, 56, 47, 0.05);
    }

    .scale-point.selected {
        transform: translateY(-5px);
        background: rgba(7, 56, 47, 0.1);
    }

    .scale-dot {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #ffffff;
        border: 3px solid #07382F;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        z-index: 3;
        position: relative;
        transition: all 0.3s ease;
        margin-bottom: 0.25rem;
    }

    .scale-dot::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #07382F;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .scale-point:hover .scale-dot {
        background: #07382F;
        transform: scale(1.2);
        border-color: #0a4a3a;
    }

    .scale-point:hover .scale-dot::before {
        opacity: 1;
        background: #ffffff;
    }

    .scale-point.selected .scale-dot {
        background: #07382F;
        transform: scale(1.3);
        box-shadow: 0 6px 20px rgba(7, 56, 47, 0.4);
        border-color: #0a4a3a;
    }

    .scale-point.selected .scale-dot::before {
        opacity: 1;
        background: #ffffff;
    }

    /* Enhanced visual feedback for selected scale point */
    .scale-point.selected {
        transform: translateY(-8px);
        background: rgba(7, 56, 47, 0.15);
        border: 2px solid #07382F;
        border-radius: 12px;
    }

    .scale-point.selected .scale-label {
        color: #07382F;
        font-weight: 800;
        transform: scale(1.1);
    }

    .scale-point.selected .scale-description-text {
        color: #07382F;
        font-weight: 700;
    }

    .scale-label {
        font-size: 0.9rem;
        color: #07382F;
        margin-top: 0.25rem;
        font-weight: 700;
        text-align: center;
        background: #ffffff;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        min-width: 40px;
    }

    .scale-description-text {
        font-size: 0.7rem;
        color: #6c757d;
        margin-top: 0.25rem;
        text-align: center;
        max-width: 70px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        background: #ffffff;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .scale-quality-indicators {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
        margin-top: 1rem;
        padding: 1rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }

    .quality-indicator {
        text-align: center;
        font-size: 0.75rem;
        color: #ffffff;
        font-weight: 700;
        padding: 0.5rem 0.25rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .quality-indicator:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .quality-indicator.poor {
        background: linear-gradient(135deg, #D8501C 0%, #ff6b35 100%);
    }

    .quality-indicator.fair {
        background: linear-gradient(135deg, #ff6b35 0%, #ffa726 100%);
    }

    .quality-indicator.good {
        background: linear-gradient(135deg, #ffa726 0%, #66bb6a 100%);
    }

    .quality-indicator.excellent {
        background: linear-gradient(135deg, #66bb6a 0%, #07382F 100%);
    }


    /* Flavor Selection */
    .flavor-selection-container {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        border: 2px solid #e9ecef;
        margin: 1rem 0;
    }

    .selected-flavors {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .flavor-badge {
        background: #07382F;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .flavor-remove {
        background: #D8501C;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.8rem;
    }

    /* Button Styling */
    .btn-modern {
        background: #07382F;
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-modern:hover {
        background: #0a4a3f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(7, 56, 47, 0.3);
    }

    .btn-modern:active {
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .modern-form-container {
            padding: 1rem;
            margin: 0.5rem;
        }
        
        .progress-steps {
            flex-direction: column;
            gap: 1rem;
        }
        
        .step-connector {
            display: none;
        }
        
        .scale-visual {
            flex-direction: column;
            gap: 1rem;
        }
        
        .scale-point::after {
            display: none;
        }
    }

    /* Form Step Transitions */
    .form-step {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    .form-step.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Compact Certification Cards */
    .certification-card {
        background: #ffffff;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .certification-card:hover {
        border-color: #07382F;
        box-shadow: 0 2px 8px rgba(7, 56, 47, 0.1);
        transform: translateY(-2px);
    }

    .certification-card .form-check {
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .certification-card .form-check-input {
        margin: 0;
        margin-right: 0.5rem;
        width: 18px;
        height: 18px;
        border: 2px solid #07382F;
        border-radius: 4px;
        background-color: transparent;
    }

    .certification-card .form-check-input:checked {
        background-color: #07382F;
        border-color: #07382F;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
    }

    .certification-card .form-check-input:focus {
        border-color: #07382F;
        box-shadow: 0 0 0 0.2rem rgba(7, 56, 47, 0.25);
    }

    .certification-card .form-check-label {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 500;
        color: #07382F;
        flex: 1;
    }

    .certification-info-btn {
        background: #07382F;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: bold;
        cursor: pointer;
        margin-left: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(7, 56, 47, 0.2);
    }

    .certification-info-btn:hover {
        background: #0a4a3a;
        transform: scale(1.15);
        box-shadow: 0 4px 8px rgba(7, 56, 47, 0.3);
    }

    .certification-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 0.75rem;
        margin-top: 1rem;
        max-height: 400px;
        overflow-y: auto;
    }

    /* Specialty certifications grid - more compact */
    #specialty_div .certification-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 0.75rem;
        max-height: 400px;
        overflow-y: auto;
    }

    /* Compact certification cards for specialty */
    #specialty_div .certification-card {
        padding: 0.5rem;
        margin-bottom: 0.5rem;
    }

    #specialty_div .certification-card .form-check-label {
        font-size: 0.85rem;
    }

    /* Modal styling */
    .certification-modal .modal-header {
        background: #07382F;
        color: white;
    }

    .certification-modal .modal-title {
        font-weight: 600;
    }

    .certification-modal .modal-body {
        padding: 1.5rem;
    }

    .certification-description {
        font-size: 1rem;
        line-height: 1.6;
        color: #495057;
    }

    /* Tasting Score Cards */
    .tasting-card {
        background: #ffffff;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .tasting-card:hover {
        border-color: #07382F;
        box-shadow: 0 4px 12px rgba(7, 56, 47, 0.1);
    }

    .tasting-card .form-select {
        border: none;
        background: transparent;
        text-align: center;
        font-weight: 600;
        color: #07382F;
    }

    .tasting-card .form-select:focus {
        box-shadow: none;
    }

    /* Standard page adjustments */
    .modern-form-container {
        max-width: none;
        width: 100%;
    }

    /* Scale interaction styles */
    .scale-point.selected .scale-dot {
        background: #D8501C;
        transform: scale(1.3);
        box-shadow: 0 8px 16px rgba(216, 80, 28, 0.3);
    }

    .scale-point.selected .scale-label {
        color: #D8501C;
        font-weight: 700;
    }

    /* Dropzone Styling */
    .dropzone {
        border: 2px dashed #07382F;
        border-radius: 12px;
        background: #f8f9fa;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .dropzone .dz-message {
        cursor: pointer;
        pointer-events: all;
    }

    .dropzone:hover {
        border-color: #D8501C;
        background: #fff5f2;
    }

    .dropzone.dz-drag-hover {
        border-color: #D8501C;
        background: #fff5f2;
        transform: scale(1.02);
    }

    .dropzone .dz-message {
        margin: 0;
    }

    .dropzone .dz-preview {
        margin: 10px;
        display: inline-block;
    }

    .dropzone .dz-preview .dz-image {
        border-radius: 8px;
        overflow: hidden;
    }

    .dropzone .dz-preview .dz-remove {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #D8501C;
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        font-size: 12px;
        cursor: pointer;
        z-index: 10;
    }

    /* Compact form layout - 4 columns */
    .form-row-compact {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-group-compact {
        margin-bottom: 0.5rem;
    }

     /* Required field indicator */
     .form-label.required::after {
         content: " *";
         color: #D8501C;
         font-weight: bold;
     }

     /* Tooltip styling */
     .tooltip-icon {
         color: #07382F;
         cursor: help;
         margin-left: 5px;
         font-size: 0.9em;
     }

     .tooltip-icon:hover {
         color: #D8501C;
     }

     .form-label-with-tooltip {
         display: flex;
         align-items: center;
     }

    /* Responsive breakpoints for 4-column layout */
    @media (max-width: 1200px) {
        .form-row-compact {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .form-row-compact {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .form-row-compact {
            grid-template-columns: 1fr;
        }
    }

    /* Mobile responsiveness for full width */
    @media (max-width: 768px) {
        .modern-form-container {
            margin: 0.5rem;
            padding: 1rem;
        }
        
        .flavor-wheel-container {
            height: 400px;
        }
        
        #container {
            height: 400px;
            min-height: 400px;
        }

        .form-row-compact {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="wrapper">
@include('includes.new_home.new_sidebar')
<!-- Page Content  -->
    <div id="content">
         @include('includes.new_home.seller_nav')
         
         <div class="row gx-2 gx-lg-3 gy-5 gy-lg-0 mt-3">
             <div class="col-sm-12">
                 <div class="card mb-3 shadow p-3 bg-body-tertiary rounded">
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-8">
                                 <h1 class="display-6 fw-bolder" style="color: #07382F;">Add New Product</h1>
                                 <p class="fs-5" style="color: #07382F;">Create and manage your coffee products</p>
                             </div>
                         </div>
                         
                         <!-- Progress Steps -->
                         <div class="progress-steps">
                             <div class="step active" data-step="1">
                                 <div class="step-number">1</div>
                                 <div class="step-label">Basic Info</div>
                             </div>
                             <div class="step-connector"></div>
                             <div class="step" data-step="2">
                                 <div class="step-number">2</div>
                                 <div class="step-label">Quality & Certifications</div>
                             </div>
                             <div class="step-connector"></div>
                             <div class="step" data-step="3">
                                 <div class="step-number">3</div>
                                 <div class="step-label">Tasting Profile</div>
                             </div>
                             <div class="step-connector"></div>
                             <div class="step" data-step="4">
                                 <div class="step-number">4</div>
                                 <div class="step-label">Flavors & Description</div>
                             </div>
                         </div>

                         <div class="modern-form-container">
                          <form action="{{ route('sellersSaveProduct') }}" method="POST" enctype="multipart/form-data" id="productForm">
                         @csrf
            <input type="hidden" name="save_type" value="add"/>
            
            <!-- Step 1: Basic Information -->
            <div class="form-step active" id="step1">
                <div class="form-section">
                    <h5><i class="fas fa-coffee me-2"></i>Basic Product Information</h5>
                    <div class="form-row-compact">
                         <div class="form-group-compact">
                             <label for="isSpecialty" class="form-label required form-label-with-tooltip">
                                 Coffee Category
                                 <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Commercial: Standard coffee for general consumption. Specialty: High-quality coffee scoring 80+ points with unique characteristics."></i>
                             </label>
                             <select name="isSpecialty" id="isSpecialty" onchange="showHideGrade()" class="form-select {{ $errors->has('isSpecialty') ? 'is-invalid' : '' }}" aria-label="is specialty" required>
                                 <option value="">Select Category</option>
                                 <option value="Commercial" {{ old('isSpecialty') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                 <option value="Specialty" {{ old('isSpecialty') == 'Specialty' ? 'selected' : '' }}>Specialty</option>
                                </select>
                                @if($errors->has('isSpecialty'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('isSpecialty') }}
                                    </div>
                                @endif
                            </div>
                        <div class="form-group-compact">
                            <label for="coffeeType" class="form-label required form-label-with-tooltip">
                                Coffee Type
                                <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Arabica: Higher quality, milder taste, grown at higher altitudes. Robusta: Stronger, more bitter taste, higher caffeine content."></i>
                            </label>
                            <select name="coffeeType" id="coffeeType" class="form-select {{ $errors->has('coffeeType') ? 'is-invalid' : '' }}" aria-label="Coffee Type" required>
                                <option value="">Select Type</option>
                                <option value="Arabica" {{ old('coffeeType') == 'Arabica' ? 'selected' : '' }}>Arabica</option>
                                <option value="Robusta" {{ old('coffeeType') == 'Robusta' ? 'selected' : '' }}>Robusta</option>
                                </select>
                                @if($errors->has('coffeeType'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('coffeeType') }}
                                    </div>
                                @endif
                            </div>
                        <div class="form-group-compact">
                            <label for="productType" class="form-label required">Product Type</label>
                            <select name="productType" id="productType" class="form-select {{ $errors->has('productType') ? 'is-invalid' : '' }}" aria-label="Product Type" required>
                                <option value="">Select Product Type</option>
                                @foreach($helper->getProductTypes() as $type)
                                    <option value="{{ $type['value'] }}" {{ old('productType') == $type['value'] ? 'selected' : '' }}>{{ $type['label'] }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('productType'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('productType') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group-compact">
                            <label for="variety" class="form-label required form-label-with-tooltip">
                                Variety
                                <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Coffee variety or cultivar (e.g., Bourbon, Typica, Caturra, SL28). This affects flavor characteristics."></i>
                            </label>
                            <input type="text" class="form-control {{ $errors->has('variety') ? 'is-invalid' : '' }}" value="{{ old('variety') }}" name="variety" placeholder="Enter coffee variety" required>
                                @if($errors->has('variety'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('variety') }}
                                    </div>
                                @endif
                            </div>
                    </div>
                    <div class="form-row-compact">
                        <div class="form-group-compact">
                            <label for="process" class="form-label required form-label-with-tooltip">
                                Processing Method
                                <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="How coffee cherries are processed: Washed (wet-processed), Natural (dry-processed), Honey (semi-washed), or other methods."></i>
                            </label>
                            <input type="text" class="form-control {{ $errors->has('process') ? 'is-invalid' : '' }}" value="{{ old('process') }}" name="process" placeholder="e.g., Washed, Natural, Honey" required>
                            @if($errors->has('process'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('process') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group-compact">
                            <label for="aroma" class="form-label required form-label-with-tooltip">
                                Aroma Profile
                                <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Describe the coffee's aroma characteristics (e.g., Floral, Fruity, Nutty, Chocolatey, Spicy)."></i>
                            </label>
                            <input type="text" class="form-control {{ $errors->has('aroma') ? 'is-invalid' : '' }}" value="{{ old('aroma') }}" name="aroma" placeholder="e.g., Floral, Fruity, Nutty" required>
                                @if($errors->has('aroma'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('aroma') }}
                                    </div>
                                @endif
                            </div>
                        <div class="form-group-compact">
                            <label for="quantityPosted" class="form-label required form-label-with-tooltip">
                                Available Quantity (bags)
                                <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Total number of coffee bags available for sale. Each bag typically weighs 60-70 lbs."></i>
                            </label>
                            <input type="number" class="form-control {{ $errors->has('quantityPosted') ? 'is-invalid' : '' }}" value="{{ old('quantityPosted') }}" name="quantityPosted" placeholder="Number of bags available" min="1" required>
                                @if($errors->has('quantityPosted'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('quantityPosted') }}
                                    </div>
                                @endif
                            </div>
                         <div class="form-group-compact">
                               <label for="bagPrice" class="form-label required form-label-with-tooltip">
                                   Price per lb ($)
                                   <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Price per pound of coffee in US dollars. Include all costs including shipping and handling."></i>
                               </label>
                             <div class="input-group">
                                 <span class="input-group-text">$</span>
                                 <input type="number" step="0.01" class="form-control {{ $errors->has('bagPrice') ? 'is-invalid' : '' }}" value="{{ empty(old('bagPrice')) ? '0.00' : old('bagPrice') }}" name="bagPrice" placeholder="0.00" required>
                                    </div>
                                @if($errors->has('bagPrice'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('bagPrice') }}
                                    </div>
                                @endif
                            </div>
                    </div>
                    <div class="form-row-compact">
                         <div class="form-group-compact">
                             <label for="bagWeight" class="form-label required form-label-with-tooltip">
                                 Bag Weight (lb)
                                 <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Weight of each coffee bag in pounds. Standard coffee bags are typically 60-70 lbs."></i>
                             </label>
                             <input type="number" step="0.1" class="form-control {{ $errors->has('bagWeight') ? 'is-invalid' : '' }}" value="{{ empty(old('bagWeight')) ? '0.0' : old('bagWeight') }}" name="bagWeight" placeholder="0.0" required>
                                @if($errors->has('bagWeight'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('bagWeight') }}
                                    </div>
                                @endif
                            </div>
                        <div class="form-group-compact">
                            <!-- Empty space for alignment -->
                        </div>
                        <div class="form-group-compact">
                            <!-- Empty space for alignment -->
                        </div>
                        <div class="form-group-compact">
                            <!-- Empty space for alignment -->
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Product Image</label>
                        <div id="image-dropzone" class="dropzone">
                            <div class="dz-message">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <h5>Drop your product image here or click to browse</h5>
                                <p class="text-muted">Supports: JPG, PNG, GIF (Max 2MB)</p>
                            </div>
                        </div>
                        <input type="hidden" name="imageUrl" id="imageUrl" value="{{ old('imageUrl') }}">
                        @if($errors->has('imageUrl'))
                            <div class="invalid-feedback d-block">
                                {{ $errors->first('imageUrl') }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-modern" onclick="nextStep(2)">Next: Quality & Certifications <i class="fas fa-arrow-right ms-2"></i></button>
                </div>
            </div>
            
            <!-- Step 2: Quality & Certifications -->
            <div class="form-step" id="step2">
                <div class="form-section">
                    <h5><i class="fas fa-award me-2"></i>Quality Standards & Certifications</h5>
                    <div class="row g-3">
                        <!-- Specialty Coffee Grade -->
                        <div class="col-md-6" id="grade_div" style="display:none">
                            <label for="quality" class="form-label form-label-with-tooltip">
                                Specialty Grade (80-100)
                                <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="SCAA cupping score (80-100). 80-84: Very Good, 85-89: Excellent, 90+: Outstanding. Only for specialty coffee."></i>
                            </label>
                            <select name="quality" class="form-select {{ $errors->has('quality') ? 'is-invalid' : '' }}" aria-label="Select quality">
                                <option value="">Select Grade</option>
                                    @for($i=80;$i<=100;$i++)
                                  <option value="{{$i}}" {{ old('quality') == $i ? 'selected' : '' }}>{{$i}}</option>
                                    @endfor
                                </select>
                                @if($errors->has('quality'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('quality') }}
                                    </div>
                                @endif
                            </div>
                        
                        <!-- Commercial Coffee Standards -->
                        <div class="col-md-6" id="marks_div" style="display:block">
                            <label for="marks" class="form-label form-label-with-tooltip">
                                Quality Marks
                                <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Coffee grade classification (e.g., AA, AB, PB, C). Based on bean size, density, and defect count."></i>
                            </label>
                            <input type="text" class="form-control {{ $errors->has('marks') ? 'is-invalid' : '' }}" value="{{ old('marks') }}" name="marks" placeholder="e.g., AA, AB, PB">
                                @if($errors->has('marks'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('marks') }}
                                    </div>
                                @endif
                            </div>
                        
                        <div class="col-md-6" id="screen_tolerance_div" style="display:block">
                            <label for="screen_tolerance" class="form-label form-label-with-tooltip">
                                Screen Tolerance
                                <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Percentage of beans that can be smaller than the specified screen size (e.g., 5% means 5% can be smaller)."></i>
                            </label>
                            <input type="text" class="form-control {{ $errors->has('screen_tolerance') ? 'is-invalid' : '' }}" value="{{ old('screen_tolerance') }}" name="screen_tolerance" placeholder="e.g., 5%">
                                @if($errors->has('screen_tolerance'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('screen_tolerance') }}
                                    </div>
                                @endif
                            </div>
                        
                        <div class="col-md-6" id="max_defect_count_div" style="display:block">
                            <label for="max_defect_count" class="form-label form-label-with-tooltip">
                                Max Defect Count
                                <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Maximum number of defects allowed per 300g sample. Includes broken beans, insect damage, mold, etc."></i>
                            </label>
                            <input type="number" class="form-control {{ $errors->has('max_defect_count') ? 'is-invalid' : '' }}" value="{{ old('max_defect_count') }}" name="max_defect_count" placeholder="Maximum allowed defects">
                                @if($errors->has('max_defect_count'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('max_defect_count') }}
                                    </div>
                                @endif
                            </div>
                        
                         <div class="col-md-6" id="max_humidity_div" style="display:block">
                             <label for="max_humidity" class="form-label form-label-with-tooltip">
                                 Max Humidity (%)
                                 <i class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Maximum moisture content percentage. Higher humidity can cause mold and quality degradation. Typically 10-12%."></i>
                             </label>
                             <div class="input-group">
                                 <input type="number" max="100" min="0" step="0.1" class="form-control {{ $errors->has('max_humidity') ? 'is-invalid' : '' }}" value="{{ old('max_humidity') }}" name="max_humidity" placeholder="Maximum humidity percentage">
                                 <span class="input-group-text">%</span>
                             </div>
                                @if($errors->has('max_humidity'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('max_humidity') }}
                                    </div>
                                @endif
                            </div>
                    </div>
                </div>
                
                <!-- Certifications Section -->
                <div class="form-section">
                    <h5><i class="fas fa-certificate me-2"></i>Certifications</h5>
                    <p class="text-muted mb-3">Select relevant certifications for your coffee product. Click the info button (i) for more details about each certification.</p>
                    
                    <!-- Commercial Certifications -->
                    <div id="commercial_certification">
                        <div class="certification-grid">
                                            @php $count=1; @endphp
                                            @foreach($helper->getCommercialCirtifications() as $certification)
                            <div class="certification-card">
                                <div class="form-check">
                                    <input class="form-check-input" name="certification[]" type="checkbox" value="{{$certification->name}}" id="commercial_{{$count}}" />
                                    <label class="form-check-label" for="commercial_{{$count}}">
                                                                {{$certification->name}}
                                                    </label>
                                    <button type="button" class="certification-info-btn" data-bs-toggle="modal" data-bs-target="#certModal_{{$count}}" title="Learn more about {{$certification->name}}">
                                        i
                                    </button>
                                </div>
                            </div>
                                            @php $count++; @endphp
                                            @endforeach
                                        </div>
                                    </div>
                        
                    <!-- Specialty Certifications -->
                    <div id="specialty_div" style="display:none">
                        <div class="certification-grid">
                                            @php $count=20; @endphp
                                            @foreach($helper->getCirtifications() as $certification)
                            <div class="certification-card">
                                <div class="form-check">
                                    <input class="form-check-input" name="certification[]" type="checkbox" value="{{$certification->name}}" id="specialty_{{$count}}" />
                                    <label class="form-check-label" for="specialty_{{$count}}">
                                                                {{$certification->name}}
                                                    </label>
                                    <button type="button" class="certification-info-btn" data-bs-toggle="modal" data-bs-target="#certModal_{{$count}}" title="Learn more about {{$certification->name}}">
                                        i
                                    </button>
                                </div>
                            </div>
                                            @php $count++; @endphp
                                            @endforeach
                                            </div>
                                        </div>
                                        </div>
                
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" onclick="prevStep(1)"><i class="fas fa-arrow-left me-2"></i>Previous</button>
                    <button type="button" class="btn btn-modern" onclick="nextStep(3)">Next: Tasting Profile <i class="fas fa-arrow-right ms-2"></i></button>
                                    </div>
                                    </div>
            
            <!-- Step 3: Tasting Profile -->
            <div class="form-step" id="step3">
                <div class="form-section">
                    <h5><i class="fas fa-wine-glass me-2"></i>Coffee Tasting Profile</h5>
                    
                    <!-- Enhanced Scale Visualization -->
                    <div class="scale-container">
                        <div class="scale-title">SCAA Cupping Score Scale</div>
                        <div class="scale-description">Rate each attribute from 6.0 (Poor) to 10.0 (Excellent)</div>
                        <div class="scale-visual">
                            <div class="scale-line"></div>
                            <div class="scale-point" data-score="6.0">
                                <div class="scale-dot"></div>
                                <div class="scale-label">6.0</div>
                                <div class="scale-description-text">Poor</div>
                                                </div>
                            <div class="scale-point" data-score="7.0">
                                <div class="scale-dot"></div>
                                <div class="scale-label">7.0</div>
                                <div class="scale-description-text">Fair</div>
                            </div>
                            <div class="scale-point" data-score="8.0">
                                <div class="scale-dot"></div>
                                <div class="scale-label">8.0</div>
                                <div class="scale-description-text">Good</div>
                            </div>
                            <div class="scale-point" data-score="9.0">
                                <div class="scale-dot"></div>
                                <div class="scale-label">9.0</div>
                                <div class="scale-description-text">Very Good</div>
                            </div>
                            <div class="scale-point" data-score="10.0">
                                <div class="scale-dot"></div>
                                <div class="scale-label">10.0</div>
                                <div class="scale-description-text">Excellent</div>
                            </div>
                        </div>
                        <div class="scale-quality-indicators">
                            <div class="quality-indicator poor">Poor (6.0-6.9)</div>
                            <div class="quality-indicator fair">Fair (7.0-7.9)</div>
                            <div class="quality-indicator good">Good (8.0-8.9)</div>
                            <div class="quality-indicator excellent">Excellent (9.0-10.0)</div>
                        </div>
                                                </div>
                    
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="tasting-card">
                                                    <label for="fragrance" class="form-label">Fragrance/Aroma</label>
                                <select name="fragrance" class="form-select {{ $errors->has('fragrance') ? 'is-invalid' : '' }}" aria-label="Select Fragrance Score">
                                    <option value="">Select Score</option>
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                    <option value="{{$i}}" {{ old('fragrance') == $i ? 'selected' : '' }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('fragrance'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('fragrance') }}
                                                        </div>
                                                    @endif
                                                </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="tasting-card">
                                                    <label for="flavor" class="form-label">Flavor</label>
                                <select name="flavor" class="form-select {{ $errors->has('flavor') ? 'is-invalid' : '' }}" aria-label="Select Flavor Score">
                                    <option value="">Select Score</option>
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                    <option value="{{$i}}" {{ old('flavor') == $i ? 'selected' : '' }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('flavor'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('flavor') }}
                                                        </div>
                                                    @endif
                                                </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="tasting-card">
                                <label for="aftertaste" class="form-label">Aftertaste</label>
                                <select name="aftertaste" class="form-select {{ $errors->has('aftertaste') ? 'is-invalid' : '' }}" aria-label="Select Aftertaste Score">
                                    <option value="">Select Score</option>
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                    <option value="{{$i}}" {{ old('aftertaste') == $i ? 'selected' : '' }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('aftertaste'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('aftertaste') }}
                                                        </div>
                                                    @endif
                                                </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="tasting-card">
                                                    <label for="acidity" class="form-label">Acidity</label>
                                <select name="acidity" class="form-select {{ $errors->has('acidity') ? 'is-invalid' : '' }}" aria-label="Select Acidity Score">
                                    <option value="">Select Score</option>
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                    <option value="{{$i}}" {{ old('acidity') == $i ? 'selected' : '' }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('acidity'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('acidity') }}
                                                        </div>
                                                    @endif
                                                </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="tasting-card">
                                                    <label for="body" class="form-label">Body</label>
                                <select name="body" class="form-select {{ $errors->has('body') ? 'is-invalid' : '' }}" aria-label="Select Body Score">
                                    <option value="">Select Score</option>
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                    <option value="{{$i}}" {{ old('body') == $i ? 'selected' : '' }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('body'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('body') }}
                                                        </div>
                                                    @endif
                                                </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="tasting-card">
                                                    <label for="balance" class="form-label">Balance</label>
                                <select name="balance" class="form-select {{ $errors->has('balance') ? 'is-invalid' : '' }}" aria-label="Select Balance Score">
                                    <option value="">Select Score</option>
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                    <option value="{{$i}}" {{ old('balance') == $i ? 'selected' : '' }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('balance'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('balance') }}
                                                        </div>
                                                    @endif
                                                </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="tasting-card">
                                                    <label for="sweetness" class="form-label">Sweetness</label>
                                <select name="sweetness" class="form-select {{ $errors->has('sweetness') ? 'is-invalid' : '' }}" aria-label="Select Sweetness Score">
                                    <option value="">Select Score</option>
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                    <option value="{{$i}}" {{ old('sweetness') == $i ? 'selected' : '' }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('sweetness'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('sweetness') }}
                                                        </div>
                                                    @endif
                                                </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="tasting-card">
                                                    <label for="uniformity" class="form-label">Uniformity</label>
                                <select name="uniformity" class="form-select {{ $errors->has('uniformity') ? 'is-invalid' : '' }}" aria-label="Select Uniformity Score">
                                    <option value="">Select Score</option>
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                    <option value="{{$i}}" {{ old('uniformity') == $i ? 'selected' : '' }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if($errors->has('uniformity'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('uniformity') }}
                                                        </div>
                                                    @endif
                            </div>
                                                </div>
                                                <div class="col-md-3 col-6">
                            <div class="tasting-card">
                                                    <label for="clean_cup" class="form-label">Clean Cup</label>
                                <select name="clean_cup" class="form-select {{ $errors->has('clean_cup') ? 'is-invalid' : '' }}" aria-label="Select Clean Cup Score">
                                    <option value="">Select Score</option>
                                                        @for($i=6;$i<=10;$i=$i+0.25)
                                    <option value="{{$i}}" {{ old('clean_cup') == $i ? 'selected' : '' }}>{{$i}}</option>
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
                                        </div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" onclick="prevStep(2)"><i class="fas fa-arrow-left me-2"></i>Previous</button>
                    <button type="button" class="btn btn-modern" onclick="nextStep(4)">Next: Flavors & Description <i class="fas fa-arrow-right ms-2"></i></button>
                </div>
                                        </div>

            <!-- Step 4: Flavors & Description -->
            <div class="form-step" id="step4">
                <div class="form-section">
                    <h5><i class="fas fa-leaf me-2"></i>Flavor Profile Selection</h5>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="flavor-wheel-container">
                                <div id="container"></div>
                                </div>
                                    </div>
                        <div class="col-md-3">
                            <div class="flavor-selection-container">
                                <h6><i class="fas fa-tags me-2"></i>Selected Flavors</h6>
                                <div class="selected-flavors" id="flavors_div">
                                    <p class="text-muted">Click on the flavor wheel to select flavors</p>
                                </div>
                              </div>
                        </div>
                                </div>
                                    </div>

                <div class="form-section">
                    <h5><i class="fas fa-file-text me-2"></i>Product Description</h5>
                     <div class="row">
                         <div class="col-md-12">
                                 <label for="description" class="form-label">Description <small class="text-muted">(Minimum 10 characters)</small></label>
                             <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="8" name="description" id="description" placeholder="Describe your coffee product, including tasting notes, origin story, processing details, and any other relevant information..." required>{{ old('description') }}</textarea>
                             <div class="form-text">
                                 <span id="description-counter">0</span> / 10 characters minimum
                             </div>
                                @if($errors->has('description'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('description') }}
                                    </div>
                                @endif
                            </div>
                                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" onclick="prevStep(3)"><i class="fas fa-arrow-left me-2"></i>Previous</button>
                    <button type="submit" class="btn btn-modern"><i class="fas fa-save me-2"></i>Save Product</button>
                                    </div>
                        </div>
                </form>
            </div>
</div>
                 </div>
             </div>
         </div>
    </div>
</div>

<!-- Certification Modals -->
@php $count=1; @endphp
@foreach($helper->getCommercialCirtifications() as $certification)
<div class="modal fade certification-modal" id="certModal_{{$count}}" tabindex="-1" aria-labelledby="certModalLabel_{{$count}}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="certModalLabel_{{$count}}">{{$certification->name}}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="certification-description">
                    <h6 class="text-primary mb-3">About {{$certification->name}}</h6>
                    <p>{{$certification->description ?? 'This certification ensures quality standards and compliance with industry requirements for commercial coffee products.'}}</p>
                    
                    <h6 class="text-primary mb-3 mt-4">Benefits:</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Quality assurance and compliance</li>
                        <li><i class="fas fa-check text-success me-2"></i>Market credibility and trust</li>
                        <li><i class="fas fa-check text-success me-2"></i>Access to premium markets</li>
                        <li><i class="fas fa-check text-success me-2"></i>Competitive advantage</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@php $count++; @endphp
@endforeach

@php $count=20; @endphp
@foreach($helper->getCirtifications() as $certification)
<div class="modal fade certification-modal" id="certModal_{{$count}}" tabindex="-1" aria-labelledby="certModalLabel_{{$count}}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="certModalLabel_{{$count}}">{{$certification->name}}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="certification-description">
                    <h6 class="text-primary mb-3">About {{$certification->name}}</h6>
                    <p>{{$certification->description ?? 'This specialty certification ensures premium quality standards and sustainable practices for specialty coffee products.'}}</p>
                    
                    <h6 class="text-primary mb-3 mt-4">Benefits:</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Premium quality assurance</li>
                        <li><i class="fas fa-check text-success me-2"></i>Sustainable practices</li>
                        <li><i class="fas fa-check text-success me-2"></i>Access to specialty markets</li>
                        <li><i class="fas fa-check text-success me-2"></i>Higher market value</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@php $count++; @endphp
@endforeach

@endsection

@section('scripts')
          @include('new_web_pages.seller_pages.flavour_wheel');
        <!-- Dropzone JS -->
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <script>
        // Initialize Dropzone
        Dropzone.autoDiscover = false;
        
        function initializeDropzone() {
            // Check if Dropzone is available
            if (typeof Dropzone === 'undefined') {
                console.error('Dropzone library not loaded');
                return;
            }
            
            // Initialize dropzone for image upload
            var imageDropzone = new Dropzone("#image-dropzone", {
                url: "#", // We'll handle upload manually
                paramName: "imageUrl",
                maxFiles: 1,
                maxFilesize: 2, // MB
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                dictDefaultMessage: "",
                dictRemoveFile: "Remove",
                dictCancelUpload: "Cancel",
                dictUploadCanceled: "Upload canceled",
                dictInvalidFileType: "Invalid file type. Only images are allowed.",
                dictFileTooBig: "File is too big (2MB). Max filesize: 2MB.",
                dictMaxFilesExceeded: "You can only upload one image.",
                autoProcessQueue: false,
                clickable: true,
                init: function() {
                    var myDropzone = this;
                    
                    // Make the entire dropzone clickable
                    this.element.addEventListener("click", function(e) {
                        if (e.target === this || e.target.closest('.dz-message')) {
                            myDropzone.hiddenFileInput.click();
                        }
                    });
                    
                    // Handle file addition
                    this.on("addedfile", function(file) {
                        // Remove previous file if exists
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                        
                        // Create a FileReader to convert file to base64
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('imageUrl').value = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    });
                    
                    // Handle file removal
                    this.on("removedfile", function(file) {
                        document.getElementById('imageUrl').value = '';
                    });
                    
                    // Handle errors
                    this.on("error", function(file, errorMessage) {
                        console.error("Dropzone error:", errorMessage);
                        alert("Error with image: " + errorMessage);
                    });
                }
            });
        }
        
        // Initialize when DOM is ready
        if (typeof $ !== 'undefined') {
            $(document).ready(function() {
                initializeDropzone();
            });
        } else {
            // Fallback if jQuery is not available
            document.addEventListener('DOMContentLoaded', function() {
                initializeDropzone();
            });
        }
    let currentStep = 1;
    let selectedFlavors = [];

    function nextStep(step) {
        // Validate current step before proceeding
        if (!validateCurrentStep()) {
            return false;
        }

        // Hide current step
        document.getElementById('step' + currentStep).classList.remove('active');
        document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
        
        // Show next step
        currentStep = step;
        document.getElementById('step' + currentStep).classList.add('active');
        document.querySelector(`[data-step="${currentStep}"]`).classList.add('active');
        
        // Mark previous step as completed
        document.querySelector(`[data-step="${currentStep - 1}"]`).classList.add('completed');
    }

    function validateCurrentStep() {
        const currentStepElement = document.getElementById('step' + currentStep);
        const requiredFields = currentStepElement.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        let firstInvalidField = null;

        requiredFields.forEach(function(field) {
            if (!field.value.trim()) {
                isValid = false;
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid && firstInvalidField) {
            firstInvalidField.focus();
            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            alert('Please fill in all required fields before proceeding to the next step.');
        }

        return isValid;
    }

    function prevStep(step) {
        // Hide current step
        document.getElementById('step' + currentStep).classList.remove('active');
        document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
        
        // Show previous step
        currentStep = step;
        document.getElementById('step' + currentStep).classList.add('active');
        document.querySelector(`[data-step="${currentStep}"]`).classList.add('active');
        
        // Remove completed status from current step
        document.querySelector(`[data-step="${currentStep}"]`).classList.remove('completed');
    }

             function showHideGrade() {
        var isSpecialty = document.getElementById("isSpecialty").value;
        var grade_div = document.getElementById("grade_div");
        var marks_div = document.getElementById("marks_div");
        var max_defect_count_div = document.getElementById("max_defect_count_div");
        var screen_tolerance_div = document.getElementById("screen_tolerance_div");
        var max_humidity_div = document.getElementById("max_humidity_div");
        var specialty_div = document.getElementById("specialty_div");
        var commercial_cert_div = document.getElementById("commercial_certification");

         if(isSpecialty == "Specialty"){
            grade_div.style.display = "block";
            specialty_div.style.display = "block";
            marks_div.style.display = "none";
            max_defect_count_div.style.display = "none";
            screen_tolerance_div.style.display = "none";
            max_humidity_div.style.display = "none";
            commercial_cert_div.style.display = "none";
         }else{
            grade_div.style.display = "none";
            specialty_div.style.display = "none";
            marks_div.style.display = "block";
            max_defect_count_div.style.display = "block";
            screen_tolerance_div.style.display = "block";
            max_humidity_div.style.display = "block";
            commercial_cert_div.style.display = "block";
         }
    }

    // Enhanced flavor selection with duplicate prevention
    function setFlaovor(flavor){
        const flavorDiv = document.getElementById('flavors_div');
        
        // Check if flavor is already selected
        if(selectedFlavors.includes(flavor)) {
            // Remove flavor if already selected
            selectedFlavors = selectedFlavors.filter(f => f !== flavor);
            updateFlavorDisplay();
            return;
        }
        
        // Add new flavor
        selectedFlavors.push(flavor);
        updateFlavorDisplay();
    }

    function updateFlavorDisplay() {
        const flavorDiv = document.getElementById('flavors_div');
        
        if(selectedFlavors.length === 0) {
            flavorDiv.innerHTML = '<p class="text-muted">Click on the flavor wheel to select flavors</p>';
            return;
        }
        
        flavorDiv.innerHTML = selectedFlavors.map(flavor => 
            `<span class="flavor-badge">
                ${flavor}
                <button type="button" class="flavor-remove" onclick="removeFlavor('${flavor}')">&times;</button>
            </span>`
        ).join('');
    }

    function removeFlavor(flavor) {
        selectedFlavors = selectedFlavors.filter(f => f !== flavor);
        updateFlavorDisplay();
    }

    // Form validation
    document.getElementById('productForm').addEventListener('submit', function(e) {
        // Validate all steps before submission
        if (!validateAllSteps()) {
            e.preventDefault();
            return false;
        }
        console.log('Form submitted with flavors:', selectedFlavors);
    });

     function validateAllSteps() {
         let isValid = true;
         let firstInvalidField = null;

         // Get all required fields from all steps
         const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
         
         requiredFields.forEach(function(field) {
             // Check if field is visible (not in hidden step)
             const step = field.closest('.form-step');
             if (step && !step.classList.contains('active')) {
                 return; // Skip validation for hidden fields
             }

             // Special validation for description field
             if (field.name === 'description') {
                 const descriptionValue = field.value.trim();
                 if (!descriptionValue) {
                     isValid = false;
                     if (!firstInvalidField) {
                         firstInvalidField = field;
                     }
                     field.classList.add('is-invalid');
                 } else if (descriptionValue.length < 10) {
                     isValid = false;
                     if (!firstInvalidField) {
                         firstInvalidField = field;
                     }
                     field.classList.add('is-invalid');
                     
                     // Show specific error message for description length
                     const errorDiv = field.parentNode.querySelector('.invalid-feedback');
                     if (errorDiv) {
                         errorDiv.textContent = 'Description must be at least 10 characters long. Current length: ' + descriptionValue.length + ' characters.';
                     }
                 } else {
                     field.classList.remove('is-invalid');
                 }
             } else {
                 // Regular validation for other fields
                 if (!field.value.trim()) {
                     isValid = false;
                     if (!firstInvalidField) {
                         firstInvalidField = field;
                     }
                     field.classList.add('is-invalid');
                 } else {
                     field.classList.remove('is-invalid');
                 }
             }
         });

         if (!isValid && firstInvalidField) {
             // Show the step containing the first invalid field
             const step = firstInvalidField.closest('.form-step');
             if (step) {
                 const stepNumber = step.id.replace('step', '');
                 nextStep(parseInt(stepNumber));
             }
             
             // Focus on the first invalid field
             firstInvalidField.focus();
             firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
             
             // Show specific error message based on field type
             if (firstInvalidField.name === 'description') {
                 const descriptionValue = firstInvalidField.value.trim();
                 if (!descriptionValue) {
                     alert('Please provide a description for your coffee product.');
                 } else if (descriptionValue.length < 10) {
                     alert('Description must be at least 10 characters long. Current length: ' + descriptionValue.length + ' characters. Please provide more details about your coffee product.');
                 }
             } else {
                 alert('Please fill in all required fields before submitting.');
             }
         }

         return isValid;
     }

     // Add real-time validation
     function addRealTimeValidation() {
         const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
         
         requiredFields.forEach(function(field) {
             // Special handling for description field
             if (field.name === 'description') {
                 field.addEventListener('blur', function() {
                     const value = this.value.trim();
                     if (!value) {
                         this.classList.add('is-invalid');
                         showDescriptionError(this, 'Description is required.');
                     } else if (value.length < 10) {
                         this.classList.add('is-invalid');
                         showDescriptionError(this, 'Description must be at least 10 characters long. Current length: ' + value.length + ' characters.');
                     } else {
                         this.classList.remove('is-invalid');
                         hideDescriptionError(this);
                     }
                 });

                 field.addEventListener('input', function() {
                     const value = this.value.trim();
                     if (value.length >= 10) {
                         this.classList.remove('is-invalid');
                         hideDescriptionError(this);
                     } else if (value.length > 0) {
                         this.classList.add('is-invalid');
                         showDescriptionError(this, 'Description must be at least 10 characters long. Current length: ' + value.length + ' characters.');
                     }
                 });
             } else {
                 // Regular validation for other fields
                 field.addEventListener('blur', function() {
                     if (!this.value.trim()) {
                         this.classList.add('is-invalid');
                     } else {
                         this.classList.remove('is-invalid');
                     }
                 });

                 field.addEventListener('input', function() {
                     if (this.value.trim()) {
                         this.classList.remove('is-invalid');
                     }
                 });
             }
         });
     }

     // Helper function to show description error
     function showDescriptionError(field, message) {
         let errorDiv = field.parentNode.querySelector('.invalid-feedback');
         if (!errorDiv) {
             errorDiv = document.createElement('div');
             errorDiv.className = 'invalid-feedback';
             field.parentNode.appendChild(errorDiv);
         }
         errorDiv.textContent = message;
         errorDiv.style.display = 'block';
     }

     // Helper function to hide description error
     function hideDescriptionError(field) {
         const errorDiv = field.parentNode.querySelector('.invalid-feedback');
         if (errorDiv) {
             errorDiv.style.display = 'none';
         }
     }

     // Initialize real-time validation when DOM is ready
     if (typeof $ !== 'undefined') {
         $(document).ready(function() {
             addRealTimeValidation();
             initializeDescriptionCounter();
             initializeTooltips();
         });
     } else {
         document.addEventListener('DOMContentLoaded', function() {
             addRealTimeValidation();
             initializeDescriptionCounter();
             initializeTooltips();
         });
     }

     // Initialize Bootstrap tooltips
     function initializeTooltips() {
         // Check if Bootstrap is available
         if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
             var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
             var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                 return new bootstrap.Tooltip(tooltipTriggerEl);
             });
         }
     }

     // Initialize description character counter
     function initializeDescriptionCounter() {
         const descriptionField = document.getElementById('description');
         const counter = document.getElementById('description-counter');
         
         if (descriptionField && counter) {
             // Update counter on page load
             updateDescriptionCounter();
             
             // Update counter on input
             descriptionField.addEventListener('input', updateDescriptionCounter);
             
             function updateDescriptionCounter() {
                 const length = descriptionField.value.length;
                 counter.textContent = length;
                 
                 // Change color based on length
                 if (length < 10) {
                     counter.style.color = '#D8501C'; // Red for insufficient
                 } else {
                     counter.style.color = '#07382F'; // Green for sufficient
                 }
             }
         }
     }

        // Interactive scale functionality
        document.addEventListener('DOMContentLoaded', function() {
            const scalePoints = document.querySelectorAll('.scale-point');
            
            scalePoints.forEach(point => {
                point.addEventListener('click', function() {
                    const score = this.getAttribute('data-score');
                    
                    // Normalize the score to match select option values
                    const normalizedScore = parseFloat(score).toString();
                    
                    // Auto-select the same score for all flavor attributes
                    const flavorSelects = document.querySelectorAll('select[name="fragrance"], select[name="flavor"], select[name="aftertaste"], select[name="acidity"], select[name="body"], select[name="balance"], select[name="sweetness"], select[name="uniformity"], select[name="clean_cup"]');
                    
                    flavorSelects.forEach((select, index) => {
                        // Clear any existing selection first
                        select.selectedIndex = 0;
                        
                        // Find the correct option index using normalized score
                        const optionIndex = Array.from(select.options).findIndex(option => option.value == normalizedScore);
                        
                        if (optionIndex > 0) {
                            // Set the selected index
                            select.selectedIndex = optionIndex;
                            
                            // Force the select to update by triggering focus and blur
                            select.focus();
                            select.blur();
                            
                            // Trigger events
                            const changeEvent = new Event('change', { bubbles: true });
                            const inputEvent = new Event('input', { bubbles: true });
                            select.dispatchEvent(changeEvent);
                            select.dispatchEvent(inputEvent);
                        } else {
                            // Let's also try to find the option with the original score as fallback
                            const fallbackIndex = Array.from(select.options).findIndex(option => option.value == score);
                            if (fallbackIndex > 0) {
                                select.selectedIndex = fallbackIndex;
                                select.focus();
                                select.blur();
                                select.dispatchEvent(new Event('change', { bubbles: true }));
                                select.dispatchEvent(new Event('input', { bubbles: true }));
                            }
                        }
                    });
                    
                    // Visual feedback for scale points
                    scalePoints.forEach(p => p.classList.remove('selected'));
                    this.classList.add('selected');
                    
                    // Show visual feedback to user
                    const feedback = document.createElement('div');
                    feedback.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #07382F; color: white; padding: 10px 20px; border-radius: 8px; z-index: 9999; font-size: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);';
                    feedback.textContent = `All flavors have been set to ${score}`;
                    document.body.appendChild(feedback);
                    
                    // Force a second update after a short delay to ensure display updates
                    setTimeout(() => {
                        flavorSelects.forEach(select => {
                            const currentValue = select.value;
                            if (currentValue == normalizedScore || currentValue == score) {
                                // Force re-selection to ensure display updates
                                const optionIndex = Array.from(select.options).findIndex(option => option.value == normalizedScore || option.value == score);
                                if (optionIndex > 0) {
                                    select.selectedIndex = optionIndex;
                                }
                            }
                        });
                    }, 100);
                    
                    // Remove feedback after 3 seconds
                    setTimeout(() => {
                        if (feedback.parentNode) {
                            feedback.parentNode.removeChild(feedback);
                        }
                    }, 3000);
                });
            });

        // Certification card click handling
        const certificationCards = document.querySelectorAll('.certification-card');
        certificationCards.forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking the info button
                if (e.target.classList.contains('certification-info-btn')) {
                    return;
                }
                
                const checkbox = this.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
        });

        // Certification checkbox change handling
        const certificationCheckboxes = document.querySelectorAll('input[name="certification[]"]');
        certificationCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const card = this.closest('.certification-card');
                if (this.checked) {
                    card.style.borderColor = '#07382F';
                    card.style.backgroundColor = '#f8f9fa';
                } else {
                    card.style.borderColor = '#e9ecef';
                    card.style.backgroundColor = '#ffffff';
                }
            });
        });
        });
        </script>

<!-- Clare Chat Component -->
<script src="{{ asset('js/clare-component.js') }}"></script>
@endsection
