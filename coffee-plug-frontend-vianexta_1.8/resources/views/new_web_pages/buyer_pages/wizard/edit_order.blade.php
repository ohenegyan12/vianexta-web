@extends('layouts.new_home_layout')
@section('title', 'Edit Order')
@push('css')
<link rel="stylesheet" href="{{ asset('css/dropzone_css.css') }}">
<style>
    body {
        background-color: #ECECEC;
    }

    .edit-order-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .edit-header {
        background: linear-gradient(135deg, #FFF5F2 0%, #FFE8E0 100%);
        padding: 30px;
        border-radius: 16px;
        border-left: 4px solid #D8501C;
        margin-bottom: 30px;
        text-align: center;
    }

    .edit-header h1 {
        color: #D8501C;
        margin-bottom: 10px;
        font-size: 2.5rem;
        font-weight: bold;
    }

    .edit-header p {
        color: #666;
        font-size: 1.1rem;
        margin: 0;
    }

    .product-detail-section {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    }

    .product-detail-flex {
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }

    .product-detail-img-col {
        flex: 0 0 300px;
    }

    .product-detail-img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .product-detail-info-col {
        flex: 1;
    }

    .product-detail-title {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .product-detail-availability {
        color: #28a745;
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    .product-detail-meta {
        margin-bottom: 25px;
    }

    .product-detail-meta>div {
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }

    .meta-label {
        font-weight: 600;
        color: #666;
        min-width: 120px;
    }

    .meta-value {
        color: #333;
        font-weight: 500;
    }

    .product-detail-cert-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .product-detail-cert-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #28a745;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 25px;
    }

    .cert-green {
        color: #28a745;
        font-weight: 600;
    }

    .product-detail-sca-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }

    .product-detail-sca-table-wrap {
        overflow-x: auto;
    }

    .product-detail-sca-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .product-detail-sca-table th,
    .product-detail-sca-table td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #eee;
    }

    .product-detail-sca-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
    }

    .sca-total {
        font-weight: bold;
        color: #D8501C;
        background: #FFF5F2;
    }

    .edit-options-section {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    }

    .edit-options-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 25px;
        text-align: center;
    }

    .option-group {
        margin-bottom: 30px;
    }

    .option-group-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .option-group-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: #D8501C;
        margin-right: 10px;
        border-radius: 2px;
    }

    /* Roast Type Grid Styles - Similar to new_buyer_wizard */
    .roast-type-grid {
        display: flex;
        gap: 48px;
        justify-content: center;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

    .roast-type-card {
        background: #F7FAF9;
        border: 5px solid #fff;
        border-radius: 16px;
        width: 220px;
        height: 260px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: border 0.2s, box-shadow 0.2s;
    }

    .roast-type-card:hover,
    .roast-type-card.active {
        border: 5px solid #D8501C;
        box-shadow: 0 4px 24px rgba(216, 80, 28, 0.15);
    }

    .roast-type-icon {
        width: 72px;
        height: 72px;
        margin-bottom: 24px;
    }

    .roast-type-label {
        font-size: 1.2rem;
        font-weight: 500;
        color: #222;
    }

    /* Grind Type Grid Styles - Similar to new_buyer_wizard */
    .grind-type-grid {
        display: flex;
        gap: 40px;
        justify-content: center;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

    .grind-type-card {
        background: #F7FAF9;
        border: 5px solid #fff;
        border-radius: 16px;
        width: 200px;
        height: 220px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: border 0.2s, box-shadow 0.2s;
    }

    .grind-type-card:hover,
    .grind-type-card.active {
        border: 5px solid #D8501C;
        box-shadow: 0 4px 24px rgba(216, 80, 28, 0.15);
    }

    .grind-type-icon {
        width: 60px;
        height: 60px;
        margin-bottom: 20px;
    }

    .grind-type-label {
        font-size: 1.1rem;
        font-weight: 500;
        color: #222;
    }

    /* Package Size Grid Styles - Similar to new_buyer_wizard */
    .package-size-grid {
        display: flex;
        gap: 40px;
        justify-content: center;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

    .package-size-card {
        background: #F7FAF9;
        border: 5px solid #fff;
        border-radius: 16px;
        width: 200px;
        height: 220px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: border 0.2s, box-shadow 0.2s;
    }

    .package-size-card:hover,
    .package-size-card.active {
        border: 5px solid #D8501C;
        box-shadow: 0 4px 24px rgba(216, 80, 28, 0.15);
    }

    .package-size-icon {
        width: 60px;
        height: 60px;
        margin-bottom: 20px;
    }

    .package-size-label {
        font-size: 1.1rem;
        font-weight: 500;
        color: #222;
        margin-bottom: 8px;
    }

    .package-size-description {
        font-size: 0.9rem;
        color: #666;
        text-align: center;
        line-height: 1.3;
    }

    /* Package Section Styles - Similar to new_buyer_wizard */
    .package-section {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    }

    .package-flex {
        display: flex;
        gap: 48px;
        justify-content: center;
        align-items: flex-start;
        margin: 40px 0 32px 0;
    }

    .package-left {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .package-upload {
        background: #fff;
        border-radius: 16px;
        padding: 0 0;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        color: #888;
        font-size: 1.2rem;
        font-weight: 500;
        border: 2px dashed #E5EAE8;
        margin-top: 16px;
        gap: 28px;
        width: 100%;
        min-width: 420px;
        max-width: 800px;
        height: 120px;
        box-sizing: border-box;
        box-shadow: none;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .package-upload:hover {
        border-color: #D8501C;
        background: #FFF5F2;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(216, 80, 28, 0.1);
    }

    .package-upload.drag-over {
        border-color: #D8501C;
        background: #FFE8E0;
        transform: scale(1.02);
    }

    .upload-icon {
        font-size: 2.8rem;
        margin-bottom: 0;
        margin-right: 0;
    }

    .upload-text {
        text-align: left;
        font-size: 1.25rem;
        color: #888;
        font-weight: 500;
        letter-spacing: 2px;
        text-transform: none;
    }

    .package-preview {
        background: none;
        border-radius: 16px;
        padding: 0;
        display: flex;
        align-items: stretch;
        justify-content: center;
        min-width: 340px;
        min-height: 340px;
        width: 340px;
        height: 340px;
        overflow: hidden;
    }

    .preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 16px;
        display: block;
    }

    .package-details {
        display: flex;
        flex-direction: column;
        gap: 24px;
        min-width: 220px;
    }

    .package-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .package-product-details {
        margin-bottom: 8px;
    }

    .product-details-label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #222;
        margin-bottom: 4px;
    }

    .product-details-info {
        font-size: 1rem;
        color: #444;
        line-height: 1.5;
    }

    .package-quantity {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .quantity-label {
        font-size: 1rem;
        color: #222;
        font-weight: 500;
    }

    .quantity-select {
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #bbb;
        font-size: 1rem;
        color: #444;
        min-width: 140px;
    }

    .quantity-select:focus {
        outline: none;
        border-color: #D8501C;
        box-shadow: 0 0 0 2px rgba(216, 80, 28, 0.1);
    }

    /* Design overlay styles for logo positioning */
    .design-overlay-12oz,
    .design-overlay-5lb,
    .design-overlay-16oz {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 5;
    }

    .design-image {
        max-width: 180px;
        max-height: 90px;
        width: auto;
        height: auto;
        pointer-events: auto;
        cursor: move;
        position: absolute;
        object-fit: contain;
    }

    /* Logo positioning for different bag types */
    .design-overlay-5lb .design-image {
        top: 42%;
        left: 50%;
        transform: translateX(-50%);
        max-width: 480px;
        max-height: 210px;
    }

    .design-overlay-12oz .design-image {
        top: 48%;
        left: 50%;
        transform: translateX(-50%);
        max-width: 280px;
        max-height: 150px;
    }

    .design-overlay-16oz .design-image {
        top: 48%;
        left: 50%;
        transform: translateX(-50%);
        max-width: 280px;
        max-height: 150px;
    }

    .quantity-section {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    }

    .quantity-input-group {
        display: flex;
        align-items: center;
        gap: 15px;
        max-width: 300px;
        margin: 0 auto;
    }

    .quantity-btn {
        width: 40px;
        height: 40px;
        border: 2px solid #D8501C;
        background: white;
        color: #D8501C;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .quantity-btn:hover {
        background: #D8501C;
        color: white;
    }

    .quantity-input {
        flex: 1;
        height: 40px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        text-align: center;
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .quantity-input:focus {
        outline: none;
        border-color: #D8501C;
        box-shadow: 0 0 0 3px rgba(216, 80, 28, 0.1);
    }

    .bag-preview-section {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    }

    .bag-preview-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .bag-preview-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .bag-preview-img {
        width: 200px;
        height: 200px;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        background: white;
        padding: 20px;
    }

    .bag-preview-info {
        text-align: center;
    }

    .bag-preview-size {
        font-size: 1.3rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .bag-preview-description {
        color: #666;
        line-height: 1.5;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 30px;
    }

    .btn-save {
        background: #D8501C;
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        background: #b73d15;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(216, 80, 28, 0.3);
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(108, 117, 125, 0.3);
    }

    .price-summary {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
        text-align: center;
    }

    .price-label {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 5px;
    }

    .price-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: #D8501C;
    }

    @media (max-width: 768px) {
        .product-detail-flex {
            flex-direction: column;
        }

        .product-detail-img-col {
            flex: none;
        }

        .roast-type-grid,
        .grind-type-grid,
        .package-size-grid {
            gap: 20px;
        }

        .roast-type-card,
        .grind-type-card,
        .package-size-card {
            width: 160px;
            height: 200px;
        }

        .roast-type-card {
            height: 220px;
        }

        /* Package section mobile adjustments */
        .package-flex {
            flex-direction: column;
            gap: 20px;
        }

        .package-left {
            order: 1;
        }

        .package-upload {
            min-width: auto;
            width: 100%;
            max-width: none;
        }

        .package-preview {
            order: 2;
            width: 100%;
            max-width: 250px;
            margin: 0 auto;
        }

        .package-details {
            order: 3;
            padding: 0;
        }

        .package-title h4 {
            font-size: 1.1rem;
            text-align: center;
        }

        .product-details-label {
            font-size: 13px;
        }

        .product-details-info {
            font-size: 12px;
            line-height: 1.3;
        }

        .quantity-label {
            font-size: 13px;
        }

        .quantity-select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
        }
    }
</style>
@endpush

@section('content')
@include('includes.new_home.new_home_header')

<div class="edit-order-container">
    <!-- Edit Header -->
    <!-- <div class="edit-header">
        <h1>Edit Your Order</h1>
        <p>Modify your coffee selection and preferences</p>
    </div> -->

    <!-- Product Detail Section -->
    <div class="product-detail-section">
        <div class="product-detail-flex">
            <div class="product-detail-img-col">
                <img src="{{ $product_details->imageUrl ?? asset('images/market_place/prod_sub.png') }}" alt="{{ $product_details->description ?? 'Coffee Product' }}" class="product-detail-img" />
            </div>
            <div class="product-detail-info-col">
                <div class="product-detail-title">{{ $product_details->description ?? 'Coffee Product' }}</div>
                <div class="product-detail-availability">{{ $product_details->availableBags ?? 'Available' }} bags available</div>
                <div class="product-detail-meta">
                    <div><span class="meta-label">Vendor:</span> <span class="meta-value">{{ $product_details->supplierInfo->companyName ?? 'N/A' }}</span></div>
                    <div><span class="meta-label">Variety:</span> <span class="meta-value">{{ $product_details->coffeeType ?? 'N/A' }}</span></div>
                    <div><span class="meta-label">Coffee type:</span> <span class="meta-value">{{ $product_details->productType ?? 'N/A' }}</span></div>
                    <div><span class="meta-label">Location:</span> <span class="meta-value">{{ $product_details->supplierInfo->billingCountry ?? 'N/A' }}</span></div>
                    @if($edit_data->is_roast)
                    <div><span class="meta-label">Roast Type:</span> <span class="meta-value">{{ $edit_data->roast_type ?? 'N/A' }}</span></div>
                    <div><span class="meta-label">Grind Type:</span> <span class="meta-value">{{ $edit_data->grind_type ?? 'N/A' }}</span></div>
                    @endif
                </div>
                @if(isset($product_details->certifications) && !empty($product_details->certifications))
                <div class="product-detail-cert-title">Certification(s)</div>
                <div class="product-detail-cert-box">
                    {{ implode(' | ', $product_details->certifications) }}
                </div>
                @endif
                @if(isset($product_details->scaScore))
                <div class="product-detail-sca-title">SCA Score</div>
                <div class="product-detail-sca-table-wrap">
                    <table class="product-detail-sca-table">
                        <thead>
                            <tr>
                                <th>Fragrance</th>
                                <th>Flavor</th>
                                <th>Acidity</th>
                                <th>Body</th>
                                <th>Uniformity</th>
                                <th>Balance</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $product_details->scaScore->fragrance ?? 'N/A' }}</td>
                                <td>{{ $product_details->scaScore->flavor ?? 'N/A' }}</td>
                                <td>{{ $product_details->scaScore->acidity ?? 'N/A' }}</td>
                                <td>{{ $product_details->scaScore->body ?? 'N/A' }}</td>
                                <td>{{ $product_details->scaScore->uniformity ?? 'N/A' }}</td>
                                <td>{{ $product_details->scaScore->balance ?? 'N/A' }}</td>
                                <td class="sca-total">{{ $product_details->scaScore->total ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Options Section -->
    <div class="edit-options-section">
        <h2 class="edit-options-title">Customize Your Order</h2>

        @if($edit_data->is_roast)
        <!-- Roast Type Selection -->
        <div class="option-group">
            <h3 class="option-group-title">Roast Type</h3>
            <div class="roast-type-grid" id="roast-type-options">
                <div class="roast-type-card" data-value="light" onclick="selectOption(this, 'roast_type')">
                    <img src="{{ asset('new_buyer_wizard/images/light.svg') }}" alt="Light Roast" class="roast-type-icon">
                    <div class="roast-type-label">Light</div>
                </div>
                <div class="roast-type-card" data-value="medium" onclick="selectOption(this, 'roast_type')">
                    <img src="{{ asset('new_buyer_wizard/images/medium.svg') }}" alt="Medium Roast" class="roast-type-icon">
                    <div class="roast-type-label">Medium</div>
                </div>
                <div class="roast-type-card" data-value="medium-dark" onclick="selectOption(this, 'roast_type')">
                    <img src="{{ asset('new_buyer_wizard/images/medium-dark.svg') }}" alt="Medium-Dark Roast" class="roast-type-icon">
                    <div class="roast-type-label">Medium-Dark</div>
                </div>
                <div class="roast-type-card" data-value="dark" onclick="selectOption(this, 'roast_type')">
                    <img src="{{ asset('new_buyer_wizard/images/dark.svg') }}" alt="Dark Roast" class="roast-type-icon">
                    <div class="roast-type-label">Dark</div>
                </div>
            </div>
        </div>

        <!-- Grind Type Selection -->
        <div class="option-group">
            <h3 class="option-group-title">Grind Type</h3>
            <div class="grind-type-grid" id="grind-type-options">
                <div class="grind-type-card" data-value="whole_bean" onclick="selectOption(this, 'grind_type')">
                    <img src="{{ asset('new_buyer_wizard/images/whole-bean.svg') }}" alt="Whole Bean" class="grind-type-icon">
                    <div class="grind-type-label">Whole Bean</div>
                </div>
                <div class="grind-type-card" data-value="coarse" onclick="selectOption(this, 'grind_type')">
                    <img src="{{ asset('new_buyer_wizard/images/coarse.svg') }}" alt="Coarse" class="grind-type-icon">
                    <div class="grind-type-label">Coarse</div>
                </div>
                <div class="grind-type-card" data-value="medium" onclick="selectOption(this, 'grind_type')">
                    <img src="{{ asset('new_buyer_wizard/images/grind-medium.svg') }}" alt="Medium" class="grind-type-icon">
                    <div class="grind-type-label">Medium</div>
                </div>
                <div class="grind-type-card" data-value="fine" onclick="selectOption(this, 'grind_type')">
                    <img src="{{ asset('new_buyer_wizard/images/fine.svg') }}" alt="Fine" class="grind-type-icon">
                    <div class="grind-type-label">Fine</div>
                </div>
                <div class="grind-type-card" data-value="extra-fine" onclick="selectOption(this, 'grind_type')">
                    <img src="{{ asset('new_buyer_wizard/images/extra-fine.svg') }}" alt="Extra Fine" class="grind-type-icon">
                    <div class="grind-type-label">Extra Fine</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Bag Size Selection -->
        <div class="option-group">
            <h3 class="option-group-title">Package Size</h3>
            <div class="package-size-grid" id="bag-size-options">
                <div class="package-size-card" data-value="12oz" onclick="selectOption(this, 'bag_size')">
                    <img src="{{ asset('new_buyer_wizard/images/package-12oz.svg') }}" alt="12oz Bag" class="package-size-icon">
                    <div class="package-size-label">12 oz</div>
                    <div class="package-size-description">Perfect for sampling</div>
                </div>
                <div class="package-size-card" data-value="16oz" onclick="selectOption(this, 'bag_size')">
                    <img src="{{ asset('new_buyer_wizard/images/package-16oz.svg') }}" alt="16oz Bag" class="package-size-icon">
                    <div class="package-size-label">16 oz</div>
                    <div class="package-size-description">Most popular size</div>
                </div>
                <div class="package-size-card" data-value="5lb" onclick="selectOption(this, 'bag_size')">
                    <img src="{{ asset('new_buyer_wizard/images/package-5lb.svg') }}" alt="5lb Bag" class="package-size-icon">
                    <div class="package-size-label">5 lb</div>
                    <div class="package-size-description">Great value for bulk</div>
                </div>
            </div>
        </div>
    </div>



    <!-- Package Section -->
    <div class="package-section">
        <h2 class="edit-options-title">Package Preview & Customization</h2>
        <div class="package-flex">
            <div class="package-left">
                <div class="package-upload" id="logo-upload-card">
                    <form id="formDropzone" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <input type="file" id="logo-upload-input" accept="image/*" style="display:none;" />
                        <div class="dropzone-drag-area" id="previews">
                            <div class="dz-message" data-dz-message>
                                <div class="upload-icon" id="upload-icon">&#8682;</div>
                                <div class="upload-text" id="upload-text">Upload your logo</div>
                            </div>
                            <div class="d-none" id="dzPreviewContainer">
                                <div class="dz-preview dz-file-preview">
                                    <div class="dz-photo">
                                        <img class="dz-thumbnail" data-dz-thumbnail>
                                    </div>
                                    <button class="dz-delete border-0 p-0" type="button" data-dz-remove>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="times">
                                            <path fill="#FFFFFF" d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="package-preview" data-bag-size="{{ $edit_data->bag_size ?? '12oz' }}">
                <div class="main-preview">
                    <img src="{{ asset('images/buyer/' . ($edit_data->bag_image ?? '10oz_1.png')) }}" alt="Preview" class="preview-img" id="mainImage">
                    <div class="design-overlay-{{ $edit_data->bag_size ?? '12oz' }}" id="designOverlay">
                        <img class="design-image" id="logoOverlay" style="display: none;">
                    </div>
                </div>
            </div>
            <div class="package-details">
                <div class="package-title" id="productDetails">
                    <h4 class="mb-3"><b>{{ $helper->getBagDetails($edit_data->bag_size ?? '12oz')['title'] ?? '12 oz' }} Bag</b></h4>
                </div>
                <div class="package-product-details">
                    <div class="product-details-label">Bag details</div>
                    <div class="product-details-info" id="productDetailsInfo">
                        @php
                        $bagDetails = $helper->getBagDetails($edit_data->bag_size ?? '12oz');
                        @endphp
                        Size: {{ $bagDetails['size'] ?? '~4" W x 3" D x 12" H' }}<br>
                        Color: {{ $bagDetails['color'] ?? 'Matte black' }}<br>
                        {{ $bagDetails['origin'] ?? 'Roasted in the USA' }}<br>
                        @if(isset($bagDetails['note']))
                        <span class="small text-muted">{{ $bagDetails['note'] }}</span>
                        @endif
                    </div>
                </div>
                <div class="package-quantity" id="quantity_section">
                    <div class="quantity-label">Quantity (# of Bags)</div>
                    <input type="number" class="quantity-select" id="numBags" value="{{ $edit_data->num_of_bags ?? 1 }}" name="numBags"
                        placeholder="Enter quantity" oninput="updatePrice()" min="1" max="1000" required>
                </div>
                <div class="price-summary">
                    <div class="price-label">Total Price</div>
                    <div class="price-value" id="total-price">${{ number_format(($product_details->bagPrice ?? 0) * ($edit_data->num_of_bags ?? 1), 2) }}</div>
                </div>
            </div>
        </div>
    </div>



    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn-cancel" onclick="window.history.back()">Cancel</button>
        <button class="btn-save" onclick="saveChanges()">Save Changes</button>
    </div>
</div>

@endsection

@push('js')
<script>
    // Initialize edit data
    const editData = {
        roast_type: '{{ $edit_data->roast_type ?? "" }}',
        grind_type: '{{ $edit_data->grind_type ?? "" }}',
        bag_size: '{{ $edit_data->bag_size ?? "" }}',
        bag_image: '{{ $edit_data->bag_image ?? "" }}',
        num_of_bags: parseInt('{{ $edit_data->num_of_bags ?? 1 }}'),
        product_id: '{{ $edit_data->product ?? "" }}'
    };

    const productPrice = parseFloat('{{ $product_details->bagPrice ?? 0 }}');

    // Function to select options
    function selectOption(element, type) {
        // Remove selected class from all cards in the same group
        const parent = element.parentElement;
        parent.querySelectorAll('.roast-type-card, .grind-type-card, .package-size-card').forEach(card => {
            card.classList.remove('active');
        });

        // Add selected class to clicked card
        element.classList.add('active');

        // Update edit data
        editData[type] = element.getAttribute('data-value');

        // Update bag preview if bag size changed
        if (type === 'bag_size') {
            updateBagPreview();
        }

        // Update price
        updatePrice();
    }

    // Function to update bag preview and package details
    function updateBagPreview() {
        const bagSize = editData.bag_size;
        const mainImage = document.getElementById('mainImage');
        const packagePreview = document.querySelector('.package-preview');
        const productDetails = document.getElementById('productDetails');
        const productDetailsInfo = document.getElementById('productDetailsInfo');
        const designOverlay = document.getElementById('designOverlay');

        // Update bag image based on size
        const bagImages = {
            '12oz': '10oz_1.png',
            '16oz': '10oz_2.jpg',
            '5lb': '10oz_1_old.png'
        };

        if (bagImages[bagSize] && mainImage) {
            mainImage.src = '{{ asset("images/buyer/") }}/' + bagImages[bagSize];
        }

        // Update package preview data attribute
        if (packagePreview) {
            packagePreview.setAttribute('data-bag-size', bagSize);
        }

        // Update design overlay class
        if (designOverlay) {
            designOverlay.className = `design-overlay-${bagSize}`;
        }

        // Update bag details
        const bagDetails = {
            '12oz': {
                title: '12 oz',
                size: '~4" W x 3" D x 12" H',
                color: 'Matte black',
                origin: 'Roasted in the USA',
                note: 'Label size: 1.75 in (H) x 3.75 in (L)'
            },
            '16oz': {
                title: '16 oz',
                size: '~4.5" W x 3.5" D x 14" H',
                color: 'Matte black',
                origin: 'Roasted in the USA',
                note: 'Label size: 2 in (H) x 4 in (L)'
            },
            '5lb': {
                title: '5 lb',
                size: '~8" W x 5" D x 19" H',
                color: 'Matte black',
                origin: 'Roasted in the USA',
                note: 'Label size: 5.50 in (H) x 4 in (L)'
            }
        };

        if (bagDetails[bagSize]) {
            const details = bagDetails[bagSize];

            // Update package title
            if (productDetails) {
                const titleElement = productDetails.querySelector('h4');
                if (titleElement) {
                    titleElement.innerHTML = `<b>${details.title} Bag</b>`;
                }
            }

            // Update product details info
            if (productDetailsInfo) {
                let detailsHTML = `Size: ${details.size}<br>`;
                detailsHTML += `Color: ${details.color}<br>`;
                detailsHTML += `${details.origin}<br>`;
                if (details.note) {
                    detailsHTML += `<span class="small text-muted">${details.note}</span>`;
                }
                productDetailsInfo.innerHTML = detailsHTML;
            }
        }
    }

    // Function to update price
    function updatePrice() {
        const quantityInput = document.getElementById('numBags');
        if (quantityInput) {
            editData.num_of_bags = parseInt(quantityInput.value) || 1;
        }
        const totalPrice = productPrice * editData.num_of_bags;
        document.getElementById('total-price').textContent = '$' + totalPrice.toFixed(2);
    }

    // Function to save changes
    function saveChanges() {
        // Show loading state
        const saveBtn = document.querySelector('.btn-save');
        const originalText = saveBtn.textContent;
        saveBtn.textContent = 'Saving...';
        saveBtn.disabled = true;

        // Prepare data for saving
        const saveData = {
            product_id: editData.product_id,
            roast_type: editData.roast_type,
            grind_type: editData.grind_type,
            bag_size: editData.bag_size,
            bag_image: editData.bag_image,
            num_of_bags: editData.num_of_bags,
            _token: '{{ csrf_token() }}'
        };

        // Send AJAX request to save changes
        fetch('{{ route("updateOrder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(saveData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message and redirect
                    alert('Order updated successfully!');
                    window.location.href = '{{ route("shoppingCart") }}';
                } else {
                    alert('Error updating order: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating order. Please try again.');
            })
            .finally(() => {
                // Restore button state
                saveBtn.textContent = originalText;
                saveBtn.disabled = false;
            });
    }

    // Initialize page with current selections
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial selections based on edit data
        if (editData.roast_type) {
            const roastCard = document.querySelector(`[data-value="${editData.roast_type}"]`);
            if (roastCard) roastCard.classList.add('active');
        }

        if (editData.grind_type) {
            const grindCard = document.querySelector(`[data-value="${editData.grind_type}"]`);
            if (grindCard) grindCard.classList.add('active');
        }

        if (editData.bag_size) {
            const bagCard = document.querySelector(`[data-value="${editData.bag_size}"]`);
            if (bagCard) bagCard.classList.add('active');
        }

        // Update bag preview
        updateBagPreview();

        // Initialize dropzone functionality
        initializeDropzone();
    });

    // Initialize dropzone functionality
    function initializeDropzone() {
        const dropzoneArea = document.getElementById('previews');
        const fileInput = document.getElementById('logo-upload-input');
        const logoOverlay = document.getElementById('logoOverlay');
        const uploadIcon = document.getElementById('upload-icon');
        const uploadText = document.getElementById('upload-text');
        const dzPreviewContainer = document.getElementById('dzPreviewContainer');

        if (dropzoneArea && fileInput) {
            // Handle click on dropzone area
            dropzoneArea.addEventListener('click', function() {
                fileInput.click();
            });

            // Handle drag and drop events
            dropzoneArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                dropzoneArea.classList.add('drag-over');
            });

            dropzoneArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                dropzoneArea.classList.remove('drag-over');
            });

            dropzoneArea.addEventListener('drop', function(e) {
                e.preventDefault();
                dropzoneArea.classList.remove('drag-over');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleFileUpload(files[0]);
                }
            });

            // Handle file input change
            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    handleFileUpload(e.target.files[0]);
                }
            });
        }

        function handleFileUpload(file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Hide upload elements
                    if (uploadIcon) uploadIcon.style.display = 'none';
                    if (uploadText) uploadText.style.display = 'none';

                    // Show logo overlay
                    if (logoOverlay) {
                        logoOverlay.src = e.target.result;
                        logoOverlay.style.display = 'block';
                    }

                    // Show preview container
                    if (dzPreviewContainer) {
                        dzPreviewContainer.classList.remove('d-none');
                        const thumbnail = dzPreviewContainer.querySelector('.dz-thumbnail');
                        if (thumbnail) {
                            thumbnail.src = e.target.result;
                        }
                    }

                    // Save logo to edit data
                    editData.logo = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                alert('Please select an image file.');
            }
        }

        // Handle logo deletion
        const deleteButtons = document.querySelectorAll('.dz-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();

                // Show upload elements
                if (uploadIcon) uploadIcon.style.display = 'block';
                if (uploadText) uploadText.style.display = 'block';

                // Hide logo overlay
                if (logoOverlay) {
                    logoOverlay.style.display = 'none';
                }

                // Hide preview container
                if (dzPreviewContainer) {
                    dzPreviewContainer.classList.add('d-none');
                }

                // Clear file input
                if (fileInput) {
                    fileInput.value = '';
                }

                // Remove logo from edit data
                delete editData.logo;
            });
        });
    }
</script>
@endpush