<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ViaNexta Wizard</title>
    <link rel="stylesheet" href="{{ asset('new_buyer_wizard/styles.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dropzone_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">

    <style>
        /* Package Selection Styles from buyer_order_wizard */
        .package-btn {
            border: 2px solid #e0e0e0;
            background: #ffffff;
            color: #333;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .package-btn:hover {
            border-color: #D8501C;
            background-color: #FFF5F2;
        }

        .package-btn.active {
            border-color: #D8501C;
            background-color: #D8501C;
            color: white;
        }

        .dropzone-drag-area {
            border: 2px dashed #ccc;
            background: #EAE9E9;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            min-height: 100px;
            transition: all 0.3s ease;
        }

        .dropzone-drag-area:hover {
            border-color: #D8501C;
            background-color: #FFF5F2;
        }

        .dz-message {
            color: #666;
            font-size: 14px;
        }

        .dz-preview {
            position: relative;
            display: inline-block;
            margin: 10px;
        }

        .dz-photo {
            position: relative;
        }

        .dz-thumbnail {
            max-width: 100px;
            max-height: 100px;
            border-radius: 4px;
        }

        .dz-delete {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #D8501C;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .dz-delete svg {
            width: 12px;
            height: 12px;
        }

        .main-preview {
            position: relative;
            display: inline-block;
        }

        /* Logo placeholder styles removed - logo will be shown directly without guidelines */

        /* Logo placeholder positioning styles removed - not needed anymore */

        /* Resize handle styles removed - no guidelines needed */

        .design-overlay-12oz,
        .design-overlay-5lb,
        .design-overlay-10oz,
        .design-overlay-kcup,
        .design-overlay-frac_pack {
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
            max-width: 450px;
            max-height: 210px;
        }

        .design-overlay-12oz .design-image {
            top: 48%;
            left: 50%;
            transform: translateX(-50%);
            max-width: 280px;
            max-height: 150px;
        }

        .design-overlay-10oz .design-image {
            top: 65%;
            left: 50%;
            transform: translateX(-50%);
            max-width: 250px;
            max-height: 150px;
        }

        .design-overlay-kcup .design-image {
            top: 70%;
            left: 50%;
            transform: translateX(-50%);
            max-width: 180px;
            max-height: 90px;
        }

        .design-overlay-frac_pack .design-image {
            top: 40%;
            left: 50%;
            transform: translateX(-50%);
            max-width: 130px;
            max-height: 120px;
        }

        .top_space {
            margin-top: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-preview img {
                height: 300px !important;
            }
        }

        /* Roast and Grind Type Card Styles */
        .roast-type-card,
        .grind-type-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .roast-type-card:hover,
        .grind-type-card:hover {
            border-color: #D8501C;
            background-color: #FFF5F2;
        }

        .roast-type-card.active,
        .grind-type-card.active {
            border-color: #D8501C;
            background-color: #FFF5F2;
        }

        .roast-type-card.active .roast-type-label,
        .grind-type-card.active .grind-type-label {
            color: #333;
        }

        /* Bean Card Active State */
        .bean-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .bean-card:hover {
            border-color: #D8501C;
            background-color: #FFF5F2;
        }

        .bean-card.active {
            border-color: #D8501C;
            background-color: #FFF5F2;
        }

        .bean-card.active .bean-card-title,
        .bean-card.active .bean-region,
        .bean-card.active .bean-type {
            color: #333;
        }

        /* Bean card image styling */
        .bean-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }

        .bean-flag {
            width: 20px;
            height: 15px;
            object-fit: cover;
            border-radius: 2px;
        }

        /* Pagination Styles */
        .pagination-controls {
            margin-top: 30px;
            text-align: center;
        }

        .pagination-info {
            margin-bottom: 15px;
            font-size: 14px;
            color: #666;
        }

        .pagination-tabs {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .pagination-tab {
            min-width: 40px;
            height: 40px;
            border: 2px solid #e0e0e0;
            background: #ffffff;
            color: #333;
            font-weight: 500;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .pagination-tab:hover {
            border-color: #D8501C;
            background-color: #FFF5F2;
        }

        .pagination-tab.active {
            border-color: #D8501C;
            background-color: #D8501C;
            color: white;
        }

        .pagination-tab.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .pagination-navigation {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .pagination-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination-btn:hover:not(:disabled) {
            border-color: #D8501C;
            background-color: #FFF5F2;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-btn svg {
            transition: transform 0.3s ease;
        }

        .pagination-btn:hover:not(:disabled) svg {
            transform: scale(1.1);
        }

        /* Responsive pagination */
        @media (max-width: 768px) {
            .pagination-tabs {
                gap: 5px;
            }

            .pagination-tab {
                min-width: 35px;
                height: 35px;
                font-size: 12px;
            }

            .pagination-navigation {
                gap: 10px;
            }

            .pagination-btn {
                padding: 8px 15px;
                font-size: 14px;
            }
        }

        /* Loading Spinner Styles */
        .loading-spinner {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .loading-spinner.show {
            display: flex;
        }

        .spinner-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            max-width: 300px;
            width: 90%;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #D8501C;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        .spinner-text {
            color: #333;
            font-size: 16px;
            font-weight: 500;
            margin: 0;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Loading state for pagination buttons */
        .pagination-btn.loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .pagination-btn.loading svg {
            animation: spin 1s linear infinite;
        }

        .pagination-tab.loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Loading state for bean card grid */
        .bean-card-grid.loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .bean-card-grid.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30px;
            height: 30px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #D8501C;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 10;
        }

        /* Loading state for wholesale card grid */
        #wholesale-card-grid.loading {
            opacity: 0.6;
            pointer-events: none;
            position: relative;
        }

        #wholesale-card-grid.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30px;
            height: 30px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #D8501C;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 10;
        }

        /* Loading placeholder styles */
        .loading-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: #666;
        }

        .loading-placeholder .spinner {
            width: 30px;
            height: 30px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #D8501C;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
        }

        .loading-placeholder p {
            margin: 0;
            font-size: 14px;
        }

        /* Package section specific styles for blade file */
        .package-upload {
            position: relative;
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ccc;
            border-radius: 8px;
            background: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .package-upload:hover {
            border-color: #007bff;
            background: #f0f8ff;
        }

        .package-upload.drag-over {
            border-color: #007bff;
            background: #e3f2fd;
        }

        .package-upload .dropzone-drag-area {
            border: none;
            background: transparent;
            padding: 0;
            min-height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .package-upload .dz-message {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            width: 100%;
            height: 100%;
        }

        .package-upload .upload-icon {
            font-size: 2.8rem;
            color: #888;
        }

        .package-upload .upload-text {
            font-size: 1.25rem;
            color: #888;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: none;
        }

        /* Remove initial dropzone overlay */
        .package-upload .dz-preview {
            display: none !important;
        }

        /* Increase dropzone preview size */
        .dropzone-drag-area .dz-preview .dz-image {
            width: 200px !important;
            height: 120px !important;
        }

        .dropzone-drag-area .dz-preview .dz-image img {
            width: 100% !important;
            height: 100% !important;
            object-fit: contain !important;
        }

        .package-upload .dz-preview.dz-file-preview {
            display: none !important;
        }

        /* Logo preview styles */
        .logo-preview {
            max-height: 48px !important;
            max-width: 120px !important;
            object-fit: contain !important;
            display: block !important;
            margin: 0 auto !important;
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            z-index: 10 !important;
        }

        /* Ensure logo overlay is properly positioned */
        .design-image[style*="display: none"] {
            display: none !important;
        }

        .package-preview .main-preview {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .package-preview .preview-img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 16px;
        }

        /* Adjust preview container for different bag sizes */
        .package-preview {
            min-width: 400px;
            min-height: 500px;
            width: 400px;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
        }

        /* Specific adjustments for different bag types */
        .package-preview[data-bag-size="5lb"] {
            min-height: 600px;
            height: 600px;
        }

        .package-preview[data-bag-size="12oz"] {
            min-height: 500px;
            height: 500px;
        }

        .package-preview[data-bag-size="10oz"] {
            min-height: 450px;
            height: 450px;
        }

        .package-preview[data-bag-size="kcup"] {
            min-height: 400px;
            height: 400px;
        }

        .package-preview[data-bag-size="frac_pack"] {
            min-height: 480px;
            height: 480px;
        }

        .package-option.package-btn {
            background: #fff;
            border-radius: 12px;
            padding: 24px 32px;
            font-size: 1.25rem;
            font-weight: 500;
            color: #1A4D3A;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            border: none;
            transition: background 0.2s, color 0.2s;
        }

        .package-option.package-btn.active {
            background: #FFF5F2;
            color: #D8501C;
            border: 2px solid #D8501C;
        }

        .package-option.package-btn:hover {
            background: #F2F6F5;
        }

        .package-option.package-btn.active:hover {
            background: #114235;
        }

        /* Wizard option card active state - Override external CSS */
        .wizard-option-card.active {
            border: 3px solid #D8501C !important;
            background-color: #FFF5F2 !important;
            box-shadow: 0 4px 24px rgba(216, 80, 28, 0.12) !important;
        }

        .wizard-option-card.active .option-label {
            color: #D8501C !important;
        }

        /* Ensure no blue backgrounds are applied */
        .wizard-option-card.active,
        .wizard-option-card:hover {
            background-color: #FFF5F2 !important;
            border-color: #D8501C !important;
        }

        /* Override any external CSS that might be adding blue backgrounds */
        .wizard-option-card.active {
            background: #FFF5F2 !important;
            background-color: #FFF5F2 !important;
        }

        /* Comprehensive override to prevent any blue backgrounds */
        .wizard-option-card {
            background-color: #F7FAF9 !important;
            border-color: #E5EAE8 !important;
        }

        .wizard-option-card:hover {
            background-color: #FFF5F2 !important;
            border-color: #D8501C !important;
        }

        .wizard-option-card.active {
            background-color: #FFF5F2 !important;
            border-color: #D8501C !important;
        }

        /* Remove any inline styles that might be applied */
        .wizard-option-card[style*="border-color"] {
            border-color: #E5EAE8 !important;
        }

        .wizard-option-card[style*="background-color"] {
            background-color: #F7FAF9 !important;
        }

        .wizard-option-card.active[style*="border-color"] {
            border-color: #D8501C !important;
        }

        .wizard-option-card.active[style*="background-color"] {
            background-color: #FFF5F2 !important;
        }



        /* Blend product card active state */
        .blend-product-card.active {
            border: 2px solid #D8501C;
            transform: scale(1.05);
        }

        /* No products message styling */
        .no-products-message {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            text-align: center;
            background: #f8f9fa;
            border-radius: 12px;
            border: 2px dashed #dee2e6;
            margin: 20px 0;
        }

        .no-products-icon {
            font-size: 3rem;
            margin-bottom: 16px;
            opacity: 0.6;
        }

        .no-products-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .no-products-description {
            font-size: 1rem;
            color: #6c757d;
            max-width: 400px;
            line-height: 1.5;
        }

        /* Wholesale detail section styles */
        .wholesale-detail-flex {
            display: flex;
            gap: 40px;
            margin-top: 20px;
        }

        .wholesale-detail-img-col {
            flex: 0 0 400px;
        }

        .wholesale-detail-img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 12px;
        }

        .wholesale-detail-thumbs {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .wholesale-detail-thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s ease;
        }

        .wholesale-detail-thumb:hover {
            border-color: #D8501C;
        }

        .wholesale-detail-thumb.active-thumb {
            border-color: #D8501C;
            border-width: 3px;
            transform: scale(1.05);
        }

        .wholesale-detail-info-col {
            flex: 1;
        }

        .wholesale-detail-title {
            font-size: 24px;
            font-weight: bold;
            color: #07382F;
            margin-bottom: 20px;
        }

        .wholesale-detail-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
        }

        .wholesale-form-row {
            display: flex;
            gap: 15px;
        }

        .wholesale-form-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .wholesale-form-row {
                flex-direction: column;
                gap: 15px;
            }
        }

        .wholesale-detail-label {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .wholesale-detail-input {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background-color: #fff;
        }

        .wholesale-detail-input:focus {
            outline: none;
            border-color: #D8501C;
            box-shadow: 0 0 0 2px rgba(216, 80, 28, 0.1);
        }

        .wholesale-detail-input[readonly] {
            background-color: #f8f9fa;
            color: #6c757d;
        }

        .wholesale-detail-input-group {
            position: relative;
        }

        .wholesale-detail-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background-color: #fff;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .wholesale-detail-select:focus {
            outline: none;
            border-color: #D8501C;
            box-shadow: 0 0 0 2px rgba(216, 80, 28, 0.1);
        }

        .wholesale-detail-availability {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .wholesale-detail-proceed {
            background-color: #D8501C;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }

        .wholesale-detail-proceed:hover {
            background-color: #b73d1a;
        }

        .wholesale-detail-product-table-wrap {
            margin-top: 20px;
        }

        .wholesale-detail-product-table-title {
            font-size: 18px;
            font-weight: bold;
            color: #07382F;
            margin-bottom: 15px;
        }

        .wholesale-detail-product-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .wholesale-detail-product-table th,
        .wholesale-detail-product-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .wholesale-detail-product-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .wholesale-detail-product-table td:first-child {
            font-weight: 600;
            color: #333;
        }

        .wholesale-detail-product-table .highlight {
            color: #D8501C;
            font-weight: 600;
        }

        /* Cart Icon Styles */
        .cart-icon-container {
            position: relative;
            display: inline-block;
            margin-right: 15px;
        }

        .cart-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f8f9fa;
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .cart-icon:hover {
            background-color: #e9ecef;
            color: #495057;
            transform: translateY(-2px);
        }

        .cart-icon svg {
            width: 20px;
            height: 20px;
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            min-width: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Update user menu layout */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Profile name styling */
        .profile-name {
            padding: 8px 16px;
        }

        .profile-name .user-name {
            color: #07382F;
            font-weight: 600;
            font-size: 14px;
        }

        /* Navigation icons container */
        .nav-icons {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Navigation icon styling */
        .nav-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #ffffff;
            color: #07382F;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-icon:hover {
            background-color: #ffffff;
            color: #D8501C;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .nav-icon svg {
            width: 18px;
            height: 18px;
        }

        /* Update cart icon to match nav icons */
        .cart-icon {
            width: 36px;
            height: 36px;
            background-color: #ffffff;
            color: #07382F;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-icon:hover {
            background-color: #ffffff;
            color: #D8501C;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .cart-icon svg {
            width: 18px;
            height: 18px;
        }

        /* Navbar background to match body */
        .navbar {
            background: #F2F6F5;
            box-shadow: none;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {

            /* Navbar mobile adjustments */
            .navbar {
                padding: 16px 20px 12px 20px;
            }

            .navbar-left .logo {
                height: 36px;
            }

            .logo-link {
                text-decoration: none;
                display: flex;
                align-items: center;
            }

            .logo-link:hover {
                opacity: 0.8;
                transition: opacity 0.3s ease;
            }

            .user-menu {
                gap: 8px;
            }

            .profile-name {
                padding: 6px 12px;
            }

            .profile-name .user-name {
                font-size: 12px;
            }

            .nav-icons {
                gap: 8px;
            }

            .nav-icon,
            .cart-icon {
                width: 32px;
                height: 32px;
            }

            .nav-icon svg,
            .cart-icon svg {
                width: 16px;
                height: 16px;
            }

            /* Wizard main mobile adjustments */
            .wizard-main {
                margin-top: 32px;
                padding: 0 20px;
            }

            .wizard-question {
                font-size: 1.5rem;
                margin-bottom: 32px;
                padding: 0 10px;
            }

            /* Wizard options mobile */
            .wizard-options {
                flex-direction: column;
                gap: 24px;
                width: 100%;
                max-width: 280px;
            }

            .wizard-option-card {
                width: 100%;
                height: 180px;
                max-width: 280px;
            }

            /* Bean card grid mobile - maintain grid layout */
            .bean-card-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                padding: 0 10px;
            }

            .bean-card {
                min-height: 180px;
            }

            .bean-img {
                height: 80px;
            }

            .bean-card-title {
                font-size: 12px;
                line-height: 1.2;
            }

            .bean-card-meta {
                font-size: 10px;
            }

            .bean-flag {
                width: 20px;
                height: 14px;
            }

            .bean-type {
                font-size: 10px;
            }

            .score-box {
                font-size: 10px;
                padding: 3px 6px;
            }

            .score-label {
                font-size: 8px;
            }

            /* Blend product grid mobile - maintain grid layout */
            .blend-product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                padding: 0 10px;
            }

            /* Pagination mobile */
            .pagination-controls {
                padding: 20px 10px;
                flex-direction: column;
                gap: 16px;
            }

            .pagination-info {
                text-align: center;
                font-size: 14px;
            }

            .pagination-tabs {
                justify-content: center;
                flex-wrap: wrap;
                gap: 8px;
            }

            .pagination-tab {
                min-width: 36px;
                height: 36px;
                font-size: 12px;
            }

            .pagination-navigation {
                flex-direction: column;
                gap: 12px;
            }

            .pagination-btn {
                width: 100%;
                max-width: 200px;
                justify-content: center;
            }

            /* Package section mobile - improved layout */
            .package-flex {
                flex-direction: column;
                gap: 20px;
                padding: 0 10px;
            }

            .package-left {
                order: 1;
            }

            .package-options {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .package-option {
                padding: 12px 16px;
                font-size: 14px;
                text-align: center;
                min-height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .package-upload {
                margin-top: 20px;
                position: relative;
                min-height: 120px;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 2px dashed #ccc;
                border-radius: 8px;
                background: #f8f9fa;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .package-upload:hover {
                border-color: #007bff;
                background: #f0f8ff;
            }

            .package-upload.drag-over {
                border-color: #007bff;
                background: #e3f2fd;
            }

            /* Logo preview styles for mobile */
            .logo-preview {
                max-height: 40px !important;
                max-width: 100px !important;
                object-fit: contain !important;
                display: block !important;
                margin: 0 auto !important;
                position: absolute !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                z-index: 10 !important;
            }

            .dropzone-drag-area {
                min-height: 100px;
                padding: 12px;
            }

            .upload-icon {
                font-size: 20px;
            }

            .upload-text {
                font-size: 12px;
            }

            .package-preview {
                order: 2;
                width: 100%;
                max-width: 250px;
                margin: 0 auto;
            }

            .preview-img {
                height: 200px;
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

            /* Roast and grind type sections mobile - maintain grid layout */
            .roast-type-grid,
            .grind-type-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                padding: 0 10px;
            }

            .roast-type-card,
            .grind-type-card {
                padding: 12px 8px;
                min-height: 100px;
            }

            .roast-type-icon,
            .grind-type-icon {
                width: 28px;
                height: 28px;
            }

            .roast-type-label,
            .grind-type-label {
                font-size: 12px;
            }

            /* Wholesale section mobile - maintain grid layout */
            .wholesale-product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                padding: 0 10px;
            }

            .wholesale-product-card {
                min-height: 160px;
            }

            .wholesale-product-img {
                height: 80px;
            }

            .wholesale-product-name {
                font-size: 12px;
            }

            .wholesale-product-price {
                font-size: 14px;
            }

            .wholesale-detail-flex {
                flex-direction: column;
                gap: 20px;
                padding: 0 10px;
            }

            .wholesale-detail-img-col {
                flex: none;
                width: 100%;
            }

            .wholesale-detail-img {
                height: 200px;
            }

            .wholesale-detail-thumbs {
                justify-content: center;
                gap: 6px;
            }

            .wholesale-detail-thumb {
                width: 50px;
                height: 50px;
            }

            .wholesale-detail-title {
                font-size: 18px;
                text-align: center;
            }

            .wholesale-form-row {
                flex-direction: column;
                gap: 12px;
            }

            .wholesale-detail-proceed {
                width: 100%;
                text-align: center;
            }

            /* Done section mobile */
            .order-summary-card {
                margin: 20px 10px;
                padding: 20px 16px;
            }

            .done-checkmark {
                width: 40px;
                height: 40px;
            }

            .done-title {
                font-size: 1.25rem;
            }

            .done-desc {
                font-size: 13px;
            }

            .order-summary-btn {
                width: 100%;
                padding: 14px;
                font-size: 14px;
            }
        }

        /* Small mobile devices */
        @media (max-width: 480px) {
            .wizard-question {
                font-size: 1.25rem;
                margin-bottom: 24px;
            }

            .wizard-option-card {
                height: 160px;
            }

            /* Maintain 2-column grid for products */
            .bean-card-grid,
            .blend-product-grid,
            .wholesale-product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .bean-card,
            .wholesale-product-card {
                min-height: 140px;
            }

            .bean-img,
            .wholesale-product-img {
                height: 60px;
            }

            .bean-card-title,
            .wholesale-product-name {
                font-size: 10px;
            }

            .bean-card-meta {
                font-size: 8px;
            }

            .bean-flag {
                width: 16px;
                height: 12px;
            }

            .bean-type {
                font-size: 8px;
            }

            .score-box {
                font-size: 8px;
                padding: 2px 4px;
            }

            .score-label {
                font-size: 6px;
            }

            /* Maintain 2-column grid for roast/grind types */
            .roast-type-grid,
            .grind-type-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .roast-type-card,
            .grind-type-card {
                padding: 8px 6px;
                min-height: 80px;
            }

            .roast-type-icon,
            .grind-type-icon {
                width: 24px;
                height: 24px;
            }

            .roast-type-label,
            .grind-type-label {
                font-size: 10px;
            }

            /* Package section improvements for small mobile */
            .package-options {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .package-option {
                padding: 10px 12px;
                font-size: 12px;
                min-height: 50px;
            }

            .preview-img {
                height: 180px;
            }

            .wholesale-detail-img {
                height: 180px;
            }

            .navbar {
                padding: 12px 16px 8px 16px;
            }

            .nav-icon,
            .cart-icon {
                width: 28px;
                height: 28px;
            }

            .nav-icon svg,
            .cart-icon svg {
                width: 14px;
                height: 14px;
            }
        }

        /* Edit mode specific styles */
        .edit-mode-question {
            background: linear-gradient(135deg, #FFF5F2 0%, #FFE8E0 100%);
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #D8501C;
            margin-bottom: 30px !important;
        }

        .edit-mode-message {
            margin: 20px 0;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
        }

        /* Enhanced active states for edit mode */
        .wizard-option-card.active {
            transform: scale(1.02);
            transition: all 0.3s ease;
        }

        .wizard-option-card.active .option-icon {
            filter: brightness(1.1);
        }

        /* Frac Pack Radio Button Styles */
        .package-frac-pack-options {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .frac-pack-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .frac-pack-radio-group {
            display: flex;
            gap: 20px;
        }

        .frac-pack-radio {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 14px;
            color: #333;
            position: relative;
        }

        .frac-pack-radio input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .radio-custom {
            position: relative;
            display: inline-block;
            width: 18px;
            height: 18px;
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 50%;
            margin-right: 8px;
            transition: all 0.3s ease;
        }

        .frac-pack-radio input[type="radio"]:checked+.radio-custom {
            border-color: #D8501C;
            background: #D8501C;
        }

        .frac-pack-radio input[type="radio"]:checked+.radio-custom::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 6px;
            height: 6px;
            background: #fff;
            border-radius: 50%;
        }

        .frac-pack-radio:hover .radio-custom {
            border-color: #D8501C;
        }
    </style>

</head>

<body>
    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner-container">
            <div class="spinner"></div>
            <p class="spinner-text">Loading products...</p>
        </div>
    </div>

    <header class="navbar">
        <div class="navbar-left">
            <a href="{{ route('new_home') }}" class="logo-link">
                <img src="{{ asset('new_buyer_wizard/images/vianexta-logo.png') }}" alt="ViaNexta Logo" class="logo">
            </a>
        </div>
        <div class="navbar-right">
            @if(session('auth_user_tokin') == null)
            <a href="{{ route('login_page') }}" class="btn btn-outline">Sign In</a>
            <a href="{{ route('register_step_1') }}" class="btn btn-primary">Sign Up</a>
            @else
            <div class="user-menu">
                <div class="profile-name">
                    <span class="user-name">{{ session('auth_user_name') }}</span>
                </div>
                <div class="nav-icons">
                    <a href="{{ route('buyerDashboard') }}" class="nav-icon" title="Dashboard">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <a href="{{ route('buyerOrderHistory') }}" class="nav-icon" title="Orders">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 20.5304 3 20V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <div class="cart-icon-container">
                        <a href="{{ route('buyer_cart') }}" class="cart-icon" title="Cart">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            @if($cart_items_count > 0)
                            <span class="cart-count">{{ $cart_items_count }}</span>
                            @endif
                        </a>
                    </div>
                    <a href="{{ route('login_page') }}" class="nav-icon" title="Logout">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </header>
    <main class="wizard-main">
        <h1 class="wizard-question">What type of coffee bean are you looking for?</h1>
        <div class="wizard-options" id="step1-options">
            <div class="wizard-option-card" id="roasted-card">
                <img src="{{ asset('new_buyer_wizard/images/roasted.svg') }}" alt="Roasted" class="option-icon">
                <div class="option-label">Roasted</div>
            </div>
            <div class="wizard-option-card" id="wholesale-card">
                <img src="{{ asset('new_buyer_wizard/images/wholesale-brands.svg') }}" alt="Wholesale Brands" class="option-icon">
                <div class="option-label">Wholesale Brands</div>
            </div>
        </div>

        <div id="step2" class="wizard-step" style="display: none;">
            <h2 class="wizard-question">How do you want your coffee?</h2>
            <div class="wizard-options">
                <div class="wizard-option-card" id="single-origin-card">
                    <img src="{{ asset('new_buyer_wizard/images/single-origin.svg') }}" alt="Single Origin" class="option-icon">
                    <div class="option-label">Single Origin</div>
                </div>
                <div class="wizard-option-card" id="blend-card">
                    <img src="{{ asset('new_buyer_wizard/images/blend.svg') }}" alt="Blend" class="option-icon">
                    <div class="option-label">Blend</div>
                </div>
            </div>
        </div>
        <div id="single-origin-section" class="wizard-step" style="display: none;">
            <h2 class="wizard-question">Single origin</h2>
            <div class="bean-card-grid" id="bean-card-grid">
                @if(isset($products) && is_array($products) && count($products) > 0)
                @foreach(array_slice($products, 0, 12) as $product)
                <div class="bean-card" data-product-id="{{ $product->id ?? '' }}" data-product-name="{{ $product->description ?? '' }}" data-product-type="single_origin">
                    <img src="{{ $product->imageUrl ?? asset('new_buyer_wizard/images/green-been.png') }}" alt="Coffee Bean" class="bean-img">
                    <div class="bean-card-info">
                        <div class="bean-card-main">
                            <div class="bean-card-title">{{ strtoupper($product->description ?? 'Unknown') }}</div>
                            <div class="bean-card-meta">
                                @php
                                if($product->supplierInfo->firstName == 'Win'){
                                $countryFromDesc = explode(' ', $product->description);
                                // Handle multi-word country names like "Costa Rica", "United States", etc.
                                $prodCountry = '';
                                $words = $countryFromDesc;
                                for($i = 0; $i < count($words); $i++){
                                    $testCountry = implode(' ', array_slice($words, 0, $i + 1));
                                    $testCode = $helper->getCountryCode($testCountry);
                                    if($testCode != 'US' || $i == 0){
                                        $prodCountry = $testCountry;
                                        if($testCode != 'US'){
                                            break;
                                        }
                                    }
                                }
                                }else{
                                $prodCountry = $product->supplierInfo->billingCountry;
                                }

                                $countImg = $helper->getCountryCode($prodCountry);
                                $countImg = strtolower($countImg).".png";
                                @endphp
                                <img src="https://flagcdn.com/w40/{{$countImg}}" alt="{{$prodCountry}}" class="bean-flag">
                                <span class="bean-region">{{$prodCountry}}</span>
                            </div>
                            <div class="bean-type">{{ $product->coffeeType ?? 'Arabica' }}</div>
                        </div>
                        <div class="bean-card-score">
                            <div class="score-box">{{ $product->quality ?? 'N/A' }}</div>
                            <div class="score-label">Score</div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="no-products-message">
                    <div class="no-products-icon">☕</div>
                    <div class="no-products-title">No Single Origin Products Available</div>
                    <div class="no-products-description">There are currently no single origin products available. Please check back later or try selecting a different option.</div>
                </div>
                @endif
            </div>
            <div class="pagination-controls" id="single-origin-pagination" style="display: none;">
                <div class="pagination-info">
                    <span id="single-origin-page-info">Page 1 of 1</span>
                </div>
                <div class="pagination-tabs" id="pagination-tabs">
                    <!-- Pagination tabs will be dynamically generated here -->
                </div>
                <div class="pagination-navigation">
                    <button class="btn btn-outline pagination-btn" id="prev-page" disabled>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Previous
                    </button>
                    <button class="btn btn-outline pagination-btn" id="next-page">
                        Next
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Roast type and grind type sections moved below blend product section -->
        <div id="blend-product-section" class="wizard-step" style="display: none;">
            <h2 class="wizard-question">Select Product</h2>
            <div class="bean-card-grid" id="blend-card-grid">
                <!-- Blend products will be loaded dynamically here -->
                <div class="loading-placeholder">
                    <div class="loading-spinner"></div>
                    <div>Loading blend products...</div>
                </div>
            </div>
            <div class="pagination-controls" id="blend-pagination" style="display: none;">
                <div class="pagination-info">
                    <span id="blend-page-info">Page 1 of 1</span>
                </div>
                <div class="pagination-tabs" id="blend-pagination-tabs">
                    <!-- Pagination tabs will be dynamically generated here -->
                </div>
                <div class="pagination-navigation">
                    <button class="btn btn-outline pagination-btn" id="blend-prev-page" disabled>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Previous
                    </button>
                    <button class="btn btn-outline pagination-btn" id="blend-next-page">
                        Next
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="blend-detail-section" class="wizard-step" style="display: none;">
            <div class="product-detail-flex">
                <div class="product-detail-img-col">
                    <img src="{{ asset('new_buyer_wizard/images/green-search.png') }}" alt="Blend Coffee" class="product-detail-img" id="blend-detail-img" />
                </div>
                <div class="product-detail-info-col">
                    <div class="product-detail-title" id="blend-detail-title">Blend Product</div>
                    <div class="product-detail-availability" id="blend-detail-availability">Loading availability...</div>
                    <div class="product-detail-meta">
                        <div><span class="meta-label">Vendor:</span> <span class="meta-value" id="blend-detail-vendor">Loading...</span></div>
                        <div><span class="meta-label">Variety:</span> <span class="meta-value" id="blend-detail-variety">Loading...</span></div>
                        <div><span class="meta-label">Coffee type:</span> <span class="meta-value" id="blend-detail-coffee-type">Loading...</span></div>
                        <div><span class="meta-label">Notes:</span> <span class="meta-value" id="blend-detail-notes">Loading...</span></div>
                        <div><span class="meta-label">Process:</span> <span class="meta-value" id="blend-detail-process">Loading...</span></div>
                    </div>
                    <div class="product-detail-cert-title">Certification(s)</div>
                    <div class="product-detail-cert-box" id="blend-detail-certifications">
                        Loading certifications...
                    </div>
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
                                    <td id="blend-sca-fragrance">-</td>
                                    <td id="blend-sca-flavor">-</td>
                                    <td id="blend-sca-acidity">-</td>
                                    <td id="blend-sca-body">-</td>
                                    <td id="blend-sca-uniformity">-</td>
                                    <td id="blend-sca-balance">-</td>
                                    <td class="sca-total" id="blend-sca-total">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Proceed to Package button removed - blend now uses same flow as single origin -->
        </div>

        <!-- Roast type and grind type sections moved here to appear after blend products -->
        <div id="roast-type-section" class="wizard-step" style="display: none;">
            <h2 class="wizard-question">Select your roast type</h2>
            <div class="roast-type-grid">
                <div class="roast-type-card">
                    <img src="{{ asset('new_buyer_wizard/images/light.svg') }}" alt="Light Roast" class="roast-type-icon">
                    <div class="roast-type-label">Light</div>
                </div>
                <div class="roast-type-card">
                    <img src="{{ asset('new_buyer_wizard/images/medium.svg') }}" alt="Medium Roast" class="roast-type-icon">
                    <div class="roast-type-label">Medium</div>
                </div>
                <div class="roast-type-card">
                    <img src="{{ asset('new_buyer_wizard/images/medium-dark.svg') }}" alt="Medium-Dark Roast" class="roast-type-icon">
                    <div class="roast-type-label">Medium-Dark</div>
                </div>
                <div class="roast-type-card">
                    <img src="{{ asset('new_buyer_wizard/images/dark.svg') }}" alt="Dark Roast" class="roast-type-icon">
                    <div class="roast-type-label">Dark</div>
                </div>
            </div>
        </div>
        <div id="grind-type-section" class="wizard-step" style="display: none;">
            <h2 class="wizard-question">Select your grind type</h2>
            <div class="grind-type-grid">
                <div class="grind-type-card">
                    <img src="{{ asset('new_buyer_wizard/images/whole-bean.svg') }}" alt="Whole bean" class="grind-type-icon">
                    <div class="grind-type-label">Whole bean</div>
                </div>
                <div class="grind-type-card">
                    <img src="{{ asset('new_buyer_wizard/images/coarse.svg') }}" alt="Coarse" class="grind-type-icon">
                    <div class="grind-type-label">Coarse</div>
                </div>
                <div class="grind-type-card">
                    <img src="{{ asset('new_buyer_wizard/images/grind-medium.svg') }}" alt="Medium" class="grind-type-icon">
                    <div class="grind-type-label">Medium</div>
                </div>
                <div class="grind-type-card">
                    <img src="{{ asset('new_buyer_wizard/images/fine.svg') }}" alt="Fine" class="grind-type-icon">
                    <div class="grind-type-label">Fine</div>
                </div>
                <div class="grind-type-card">
                    <img src="{{ asset('new_buyer_wizard/images/extra-fine.svg') }}" alt="Extra fine" class="grind-type-icon">
                    <div class="grind-type-label">Extra fine</div>
                </div>
            </div>
        </div>

        <div id="package-section" class="wizard-step" style="display: none;">
            <h2 class="wizard-question">Select your package size and customize it</h2>
            <div class="package-flex">
                <div class="package-left">
                    <div class="package-options" id="packageButtons">
                        <div class="package-option package-btn" id="5lb_bag" data-size="5lb">5lb Bag <span class="package-arrow">&gt;</span></div>
                        <div class="package-option package-btn active" id="12oz_frac_pack" data-size="12oz">12oz Bag <span class="package-arrow">&gt;</span></div>
                        <div class="package-option package-btn" id="10oz_bag" data-size="10oz">10oz Bag <span class="package-arrow">&gt;</span></div>
                        <div class="package-option package-btn" id="frac_pack" data-size="frac_pack">Frac Packs <span class="package-arrow">&gt;</span></div>
                        <div class="package-option package-btn" id="k_cup" data-size="kcup">K Cup <span class="package-arrow">&gt;</span></div>
                    </div>
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
                <div class="package-preview" data-bag-size="12oz">
                    <div class="main-preview">
                        <img src="{{ asset('images/buyer/12oz_1.png')}}" alt="Preview" class="preview-img" id="mainImage">
                        <!-- Logo placeholder removed - logo will be shown directly on the bag -->
                        <div class="design-overlay-12oz" id="designOverlay">
                            <img class="design-image" id="logoOverlay" style="display: none;">
                        </div>
                    </div>
                </div>
                <div class="package-details">
                    <div class="package-title" id="productDetails">
                        <h4 class="mb-3"><b>12oz Bag</b></h4>
                    </div>
                    <div class="package-product-details">
                        <div class="product-details-label">Bag details</div>
                        <div class="product-details-info" id="productDetailsInfo">
                            Size: ~4" W x 3" D x 12" H<br>
                            Color: Matte black<br>
                            Roasted in the USA<br>
                            <span class="small text-muted">Label size: 1.75 in (H) x 3.75 in (L)</span>
                        </div>
                    </div>
                    <div class="package-frac-pack-options" id="fracPackOptions" style="display: none;">
                        <div class="frac-pack-label">Select size:</div>
                        <div class="frac-pack-radio-group">
                            <label class="frac-pack-radio">
                                <input type="radio" name="fracPackSize" value="3oz" checked>
                                <span class="radio-custom"></span>
                                3oz
                            </label>
                            <label class="frac-pack-radio">
                                <input type="radio" name="fracPackSize" value="4oz">
                                <span class="radio-custom"></span>
                                4oz
                            </label>
                        </div>
                    </div>
                    <div class="package-quantity" id="quantity_section">
                        <div class="quantity-label">Quantity (# of Bags) <span class="required-indicator">*</span></div>
                        <div class="quantity-hint">Enter the number of bags you'd like to order</div>
                        <input type="number" class="quantity-select {{ $errors->has('numBags') ? 'is-invalid' : '' }}" id="numBags" value="{{session('num_of_bags') ?? ''}}" name="numBags"
                            placeholder="Enter quantity" oninput="getAmount()" min="1" max="1000" required>
                        @if($errors->has('numBags'))
                        <div class="invalid-feedback">
                            {{ $errors->first('numBags') }}
                        </div>
                        @endif
                    </div>
                    <input id="bag_quantity" value="" type="hidden" />
                    <input id="session_num_of_bags" value="{{session('num_of_bags') ?? ''}}" type="hidden" />
                    <input id="selected_bag" value="" type="hidden" />
                    <input id="session_bag_size" value="{{session('bag_size') ?? ''}}" type="hidden" />


                </div>
            </div>
        </div>
        <div id="done-section" class="wizard-step" style="display: none;">

            <div class="order-summary-card">
                <img src="{{ asset('new_buyer_wizard/images/checkmark.svg') }}" alt="Checkmark" class="done-checkmark" />
                <div class="done-title">All Done</div>
                <div class="done-desc">We will send you an email to proceed to make payment</div>
                <div class="order-summary-btn-row">
                    <button class="btn btn-primary order-summary-btn" onclick="proceedToPayment()">Proceed to payment</button>
                </div>
                <!-- <div class="order-summary-title">Order Summary</div> -->
                <!-- <hr class="order-summary-divider" /> -->
                <!-- <div class="order-summary-table">
                    <div class="order-summary-row">
                        <div>Type of Coffee with details ($16.99/bag)</div>
                        <div>$33.98</div>
                    </div>
                    <div class="order-summary-row">
                        <div>Discount available</div>
                        <div>-$16.99</div>
                    </div>
                    <div class="order-summary-row">
                        <div>Shipping</div>
                        <div>Free</div>
                    </div>
                    <div class="order-summary-row order-summary-total">
                        <div>Total</div>
                        <div>$16.99</div>
                    </div>
                </div> -->

            </div>
        </div>
        <div id="wholesale-product-section" class="wizard-step" style="display: none;">
            <h2 class="wizard-question">Wholesale Brands</h2>
            <div class="bean-card-grid" id="wholesale-card-grid">
                <!-- Products will be loaded dynamically via JavaScript -->
                <div class="loading-placeholder">
                    <div class="spinner"></div>
                    <p>Loading wholesale products...</p>
                </div>
            </div>
            <div class="pagination-controls" id="wholesale-pagination" style="display: none;">
                <div class="pagination-info">
                    <span id="wholesale-page-info">Page 1 of 1</span>
                </div>
                <div class="pagination-tabs" id="wholesale-pagination-tabs">
                    <!-- Pagination tabs will be dynamically generated here -->
                </div>
                <div class="pagination-navigation">
                    <button class="btn btn-outline pagination-btn" id="wholesale-prev-page" disabled>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Previous
                    </button>
                    <button class="btn btn-outline pagination-btn" id="wholesale-next-page">
                        Next
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="wholesale-detail-section" class="wizard-step" style="display: none;">
            <div class="wholesale-detail-flex">
                <div class="wholesale-detail-img-col">
                    <img src="{{ asset('new_buyer_wizard/images/wholesale-preview.png') }}" alt="Wholesale Preview" class="wholesale-detail-img" id="wholesale-product-image" />
                    <div style="height: 18px;"></div>
                    <div class="wholesale-detail-thumbs">
                        <img src="{{ asset('new_buyer_wizard/images/wholesale-preview.png') }}" class="wholesale-detail-thumb" id="wholesale-thumb-1" />
                        <img src="{{ asset('new_buyer_wizard/images/wholesale-preview.png') }}" class="wholesale-detail-thumb" id="wholesale-thumb-2" />
                        <img src="{{ asset('new_buyer_wizard/images/wholesale-preview.png') }}" class="wholesale-detail-thumb" id="wholesale-thumb-3" />
                        <img src="{{ asset('new_buyer_wizard/images/wholesale-preview.png') }}" class="wholesale-detail-thumb" id="wholesale-thumb-4" />
                    </div>
                </div>
                <div class="wholesale-detail-info-col">
                    <div class="wholesale-detail-title" id="wholesale-product-title">LUPARA ESPRESSO</div>
                    <div class="wholesale-detail-form">
                        <div class="wholesale-form-row">
                            <div class="wholesale-form-col">
                                <div class="wholesale-detail-label">Bag Size</div>
                                <div class="wholesale-detail-input-group">
                                    <select class="wholesale-detail-select" id="wholesale-bag-size" name="bag_size" onchange="updateWholesaleBagSize()">
                                        <option value="oz_bag">12oz Retail Bag</option>
                                        <!-- <option value="lb">5lb Bulk Bag</option>
                                        <option value="oz_frac_pack">2 Pound</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="wholesale-form-col">
                                <div class="wholesale-detail-label">Bag Price($)</div>
                                <input class="wholesale-detail-input" id="wholesale-spot-price" value="00.00" readonly placeholder="Will be set from product data" />
                            </div>
                        </div>
                        <div class="wholesale-form-row">
                            <div class="wholesale-form-col">
                                <div class="wholesale-detail-label">Case Quantity(8 units)</div>
                                <input type="number" class="wholesale-detail-input" id="wholesale-num-bags" value="1" min="1" oninput="getWholesaleAmount()" />
                            </div>
                            <div class="wholesale-form-col">
                                <div class="wholesale-detail-label">Amount </div>
                                <input class="wholesale-detail-input" id="wholesale-amount" value="$0.00" readonly placeholder="Will be calculated from product price" />
                            </div>
                        </div>
                    </div>
                    <div class="wholesale-detail-availability" id="wholesale-product-availability">000 bags available</div>
                    <button class="wholesale-detail-proceed" onclick="proceedToWholesalePayment()">Proceed</button>
                    <div class="wholesale-detail-product-table-wrap">
                        <div class="wholesale-detail-product-table-title">Product Details</div>
                        <table class="wholesale-detail-product-table">
                            <thead>
                                <tr>
                                    <th style="text-align:left; font-weight:700;">Info</th>
                                    <th style="text-align:left; font-weight:700;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Vendor</td>
                                    <td class="highlight" id="wholesale-vendor">Greenstreet</td>
                                </tr>
                                <tr>
                                    <td>Variety</td>
                                    <td class="highlight" id="wholesale-variety">Latin America, Central America, Africa</td>
                                </tr>
                                <tr>
                                    <td>Coffee Type</td>
                                    <td class="highlight" id="wholesale-coffee-type">Arabica</td>
                                </tr>
                                <tr>
                                    <td>Quality</td>
                                    <td class="highlight" id="wholesale-quality">Premium</td>
                                </tr>
                                <tr>
                                    <td>Notes</td>
                                    <td class="highlight" id="wholesale-notes">Balanced, slightly sweet and acidic</td>
                                </tr>
                                <tr>
                                    <td>Process</td>
                                    <td class="highlight" id="wholesale-process">Pupled Natural and Fully Washed Beans</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/interact.js/1.10.17/interact.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
    <script src="{{ asset('new_buyer_wizard/script.js') }}"></script>

    <script>
        // Loading spinner functions
        function showLoadingSpinner() {
            const spinner = document.getElementById('loadingSpinner');
            const beanCardGrid = document.getElementById('bean-card-grid');
            const prevBtn = document.getElementById('prev-page');
            const nextBtn = document.getElementById('next-page');

            if (spinner) spinner.classList.add('show');
            if (beanCardGrid) beanCardGrid.classList.add('loading');
            if (prevBtn) prevBtn.classList.add('loading');
            if (nextBtn) nextBtn.classList.add('loading');
        }

        function hideLoadingSpinner() {
            const spinner = document.getElementById('loadingSpinner');
            const beanCardGrid = document.getElementById('bean-card-grid');
            const prevBtn = document.getElementById('prev-page');
            const nextBtn = document.getElementById('next-page');
            const paginationTabs = document.querySelectorAll('.pagination-tab');

            if (spinner) spinner.classList.remove('show');
            if (beanCardGrid) beanCardGrid.classList.remove('loading');
            if (prevBtn) prevBtn.classList.remove('loading');
            if (nextBtn) nextBtn.classList.remove('loading');
            paginationTabs.forEach(tab => tab.classList.remove('loading'));
        }

        // Product data object for different package types
        const productData = {
            '5lb': {
                title: '5lb Bag',
                size: '~8" W x 5" D x 19" H',
                roast: 'Color: Matte black',
                origin: 'Roasted in the USA',
                note: 'Label size: 5.50 in (H) x 4 in (L)',
                mainImage: '5lb_1.jpg',
                previewImages: ['5lb_1.jpg', '5lb.jpg', '5lb.jpg', '5lb.jpg']
            },
            '12oz': {
                title: '12oz Bag',
                size: '~4" W x 3" D x 12" H',
                roast: 'Color: Matte black',
                origin: 'Roasted in the USA',
                note: 'Label size: 1.75 in (H) x 3.75 in (L)',
                mainImage: '12oz_1.png',
                previewImages: ['12oz_1.png', '12oz_2.png', '12oz_3.png', '12oz_4.jpg']
            },
            'frac_pack': {
                title: 'Frac Packs',
                size: '~6.5" W x 2.5" D x 8" H',
                roast: 'Color: Silver foil',
                origin: 'Roasted in the USA',
                note: 'Label size: 3.5 in (H) x 2.75 in (L)',
                mainImage: 'frac_pack.png',
                previewImages: ['frac_pack.png', 'frac_pack.png', 'frac_pack.png', 'frac_pack.png']
            },
            '10oz': {
                title: '10oz Bag',
                size: '~3.5" W x 2.5" D x 10" H',
                roast: 'Color: Matte black',
                origin: 'Roasted in the USA',
                note: 'Label size: 1.75 in (H) x 3.75 in (L)',
                mainImage: '10oz_1.png',
                previewImages: ['10oz_1.png', '10oz_2.jpg', '10oz_3.jpg', '10oz_4.jpg']
            },
            'kcup': {
                title: 'K Cup',
                size: '12 Count Box',
                roast: 'Color: Matte black',
                origin: 'Roasted in the USA',
                note: '',
                mainImage: 'kcup.jpg',
                previewImages: ['kcup.jpg', 'kcup_2.jpg', 'kcup_3.jpg', 'kcup_4.jpg']
            }
        };

        // Helper function for session management
        function setPressedOption(option, content, elementId) {
            fetch('/buyerOrderOptions/' + option + '/' + content, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                }
            }).then(response => {
                console.log('Option saved:', option, content);
            }).catch(error => {
                console.error('Error saving option:', error);
            });
        }

        let currentMainImage = '';

        // Get all package buttons
        const packageButtons = document.querySelectorAll('.package-btn');
        console.log('🔍 Blade template: Found', packageButtons.length, 'package-btn elements');
        const mainImage = document.getElementById('mainImage');

        // Function to handle preview image interactions
        function setupPreviewImages(size) {
            const product = productData[size];
            currentMainImage = `../images/buyer/${product.mainImage}`;

            if (mainImage) {
                mainImage.src = currentMainImage;
                console.log('✅ Main image updated:', currentMainImage);
            }

            // Update design overlay class for proper logo positioning
            const designOverlay = document.getElementById('designOverlay');
            if (designOverlay) {
                // Remove all existing design-overlay classes
                designOverlay.classList.remove('design-overlay-5lb', 'design-overlay-12oz', 'design-overlay-10oz', 'design-overlay-kcup', 'design-overlay-frac_pack');
                // Add the appropriate class based on size
                designOverlay.classList.add(`design-overlay-${size}`);
                console.log('✅ Design overlay class updated to:', `design-overlay-${size}`);
            }

            // Update package preview container data attribute
            const packagePreview = document.querySelector('.package-preview');
            if (packagePreview) {
                packagePreview.setAttribute('data-bag-size', size);
                console.log('✅ Package preview data-bag-size updated to:', size);
            }

            // Update bag description
            if (product) {
                console.log('✅ Updating bag description for:', product.title);

                // Update the package title
                const productDetails = document.getElementById('productDetails');
                if (productDetails) {
                    const titleElement = productDetails.querySelector('h4');
                    if (titleElement) {
                        titleElement.innerHTML = `<b>${product.title}</b>`;
                        console.log('✅ Package title updated to:', product.title);
                    }
                }

                // Update the product details info
                const productDetailsInfo = document.getElementById('productDetailsInfo');
                if (productDetailsInfo) {
                    let detailsHTML = `Size: ${product.size}<br>`;
                    detailsHTML += `${product.roast}<br>`;
                    detailsHTML += `${product.origin}<br>`;
                    if (product.note) {
                        detailsHTML += `<span class="small text-muted">${product.note}</span>`;
                    }
                    productDetailsInfo.innerHTML = detailsHTML;
                    console.log('✅ Product details updated');
                }
            }

            // Update preview thumbnails
            const previewContainer = document.getElementById('preview-images');
            if (previewContainer && product.previewImages) {
                previewContainer.innerHTML = '';
                product.previewImages.forEach((image, index) => {
                    const thumb = document.createElement('img');
                    thumb.src = `../images/buyer/${image}`;
                    thumb.alt = `Preview ${index + 1}`;
                    thumb.className = 'preview-thumb';
                    thumb.onclick = () => {
                        if (mainImage) {
                            mainImage.src = `../images/buyer/${image}`;
                            currentMainImage = `../images/buyer/${image}`;
                        }
                        // Update active thumbnail
                        document.querySelectorAll('.preview-thumb').forEach(t => t.classList.remove('active'));
                        thumb.classList.add('active');
                    };
                    if (index === 0) thumb.classList.add('active');
                    previewContainer.appendChild(thumb);
                });
            }
        }

        // Add click handlers for package buttons
        packageButtons.forEach(button => {
            button.addEventListener('click', function() {
                const size = this.getAttribute('data-size');
                console.log('Package button clicked:', size);

                // Remove active class from all buttons
                packageButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                // Update images and bag description
                setupPreviewImages(size);

                // Show/hide frac pack radio buttons
                const fracPackOptions = document.getElementById('fracPackOptions');
                if (fracPackOptions) {
                    if (size === 'frac_pack') {
                        fracPackOptions.style.display = 'block';
                        // Set default value to 3oz
                        const selectedBag = document.getElementById('selected_bag');
                        if (selectedBag) {
                            selectedBag.value = 'frac_pack_3oz';
                        }
                        setPressedOption('bag_size', 'frac_pack_3oz');
                    } else {
                        fracPackOptions.style.display = 'none';
                        // Save selection for non-frac pack options
                        setPressedOption('bag_size', size);
                    }
                }
            });
        });

        // Initialize with default package (12oz)
        if (packageButtons.length > 0) {
            const defaultButton = document.querySelector('[data-size="12oz"]');
            if (defaultButton) {
                defaultButton.click();
            }
        }

        // Add event listeners for frac pack radio buttons
        document.addEventListener('DOMContentLoaded', function() {
            const fracPackRadios = document.querySelectorAll('input[name="fracPackSize"]');
            fracPackRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        const selectedSize = this.value;
                        const selectedBag = document.getElementById('selected_bag');
                        if (selectedBag) {
                            selectedBag.value = `frac_pack_${selectedSize}`;
                        }
                        setPressedOption('bag_size', `frac_pack_${selectedSize}`);
                        console.log('Frac pack size selected:', selectedSize);
                    }
                });
            });
        });

        // Add package button click handlers for done-section logic
        document.addEventListener('DOMContentLoaded', function() {
            const packageButtons = document.querySelectorAll('.package-btn');

            packageButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    packageButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');

                    // Hide done section for K Cup bags
                    const packageText = this.textContent.trim();
                    const doneSection = document.getElementById('done-section');

                    if (packageText.includes('K Cup')) {
                        if (doneSection) {
                            doneSection.style.display = 'none';
                        }
                        // Hide logo for K-cup bags using the new function
                        if (window.hideLogoForKCup) {
                            window.hideLogoForKCup();
                        }
                    } else {
                        // For other bags, restore logo if available
                        if (window.restoreLogoIfAvailable) {
                            window.restoreLogoIfAvailable();
                        }
                        // For other bags, check if quantity is entered
                        const quantity = document.getElementById('numBags');
                        if (quantity && quantity.value && quantity.value > 0) {
                            if (doneSection) {
                                doneSection.style.display = 'block';
                                doneSection.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }
                        } else {
                            if (doneSection) {
                                doneSection.style.display = 'none';
                            }
                        }
                    }
                });
            });
        });

        // Document ready function
        document.addEventListener('DOMContentLoaded', function() {
            console.log('📝 Normal mode - wizard initialized');

            // Initialize selected_bag field with session value
            const sessionBagSize = document.getElementById('session_bag_size');
            const selectedBag = document.getElementById('selected_bag');
            if (sessionBagSize && selectedBag && sessionBagSize.value) {
                selectedBag.value = sessionBagSize.value;

                // If it's a frac pack, also initialize the radio buttons
                if (sessionBagSize.value === 'frac_pack_3oz' || sessionBagSize.value === 'frac_pack_4oz') {
                    const size = sessionBagSize.value.replace('frac_pack_', '');
                    const radioButton = document.querySelector(`input[name="fracPackSize"][value="${size}"]`);
                    if (radioButton) {
                        radioButton.checked = true;
                    }
                }
            }

            // Initialize logo upload functionality
            initializeLogoUpload();

            // Note: Click handlers for wizard option cards are now handled by the external script.js file
            // This prevents conflicts and ensures consistent behavior
            console.log('✅ Wizard option card click handlers are managed by external script');

            // Note: Step 2 click handlers are now handled by the external script.js file
            // This prevents conflicts and ensures step2 section remains visible
            console.log('✅ Step 2 click handlers are managed by external script');

            // Add click handlers for bean cards
            document.querySelectorAll('#single-origin-section .bean-card').forEach(function(card) {
                card.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    const productType = this.getAttribute('data-product-type');

                    // Remove active class from all bean cards
                    document.querySelectorAll('.bean-card').forEach(c => c.classList.remove('active'));
                    // Add active class to clicked card
                    this.classList.add('active');

                    // Update session via AJAX
                    fetch('/buyerOrderOptions/product/' + productId, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        }
                    }).then(response => {
                        console.log('Product selected:', productName);
                    }).catch(error => {
                        console.error('Error saving product selection:', error);
                    });

                    // Show roast type section
                    const roastTypeSection = document.getElementById('roast-type-section');
                    if (roastTypeSection) {
                        roastTypeSection.style.display = 'block';
                        roastTypeSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add click handlers for wholesale cards
            document.querySelectorAll('#wholesale-product-section .bean-card').forEach(function(card) {
                card.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    const productType = this.getAttribute('data-product-type');

                    // Remove active class from all wholesale cards
                    document.querySelectorAll('#wholesale-product-section .bean-card').forEach(c => c.classList.remove('active'));
                    // Add active class to clicked card
                    this.classList.add('active');

                    // Update session via AJAX
                    fetch('/buyerOrderOptions/product/' + productId, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        }
                    }).then(response => {
                        console.log('Wholesale product selected:', productName);
                    }).catch(error => {
                        console.error('Error saving wholesale product selection:', error);
                    });

                    // Hide all sections first
                    const singleOriginSection = document.getElementById('single-origin-section');
                    const blendProductSection = document.getElementById('blend-product-section');
                    const roastTypeSection = document.getElementById('roast-type-section');
                    const grindTypeSection = document.getElementById('grind-type-section');
                    const packageSection = document.getElementById('package-section');
                    const doneSection = document.getElementById('done-section');

                    if (singleOriginSection) singleOriginSection.style.display = 'none';
                    if (blendProductSection) blendProductSection.style.display = 'none';
                    if (roastTypeSection) roastTypeSection.style.display = 'none';
                    if (grindTypeSection) grindTypeSection.style.display = 'none';
                    if (packageSection) packageSection.style.display = 'none';
                    if (doneSection) doneSection.style.display = 'none';

                    // Show wholesale detail section
                    const wholesaleDetailSection = document.getElementById('wholesale-detail-section');
                    if (wholesaleDetailSection) {
                        wholesaleDetailSection.style.display = 'block';
                        wholesaleDetailSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Ensure done-section is hidden on page load
            const doneSection = document.getElementById('done-section');
            if (doneSection) {
                doneSection.style.display = 'none';
            }

            // Calculate initial amount with correct formula
            window.getWholesaleAmount();

            // Initialize wholesale pricing
            const spotPriceInput = document.getElementById("wholesale-spot-price");
            if (spotPriceInput && !spotPriceInput.value) {
                spotPriceInput.value = "12.99"; // Default price for oz_bag
                console.log('Default spot price set to:', spotPriceInput.value);
                getWholesaleAmount();
            }
        });

        // Amount calculation functions
        function getAmount() {
            var quantity = document.getElementById("numBags");
            var spot_price = document.getElementById("spot_price");
            var package_size = document.getElementById("package");
            var amount = document.getElementById("amount");

            if (quantity && spot_price && quantity.value && spot_price.value) {
                var total_price;
                // For wholesale brand, calculate based on bag price
                if (document.getElementById("bag_size")) {
                    total_price = quantity.value * parseFloat(spot_price.value);
                } else {
                    // For regular products, calculate based on weight
                    total_price = quantity.value * (parseFloat(spot_price.value) * (package_size ? parseFloat(package_size.value) : 1));
                }

                if (amount) {
                    amount.value = "$ " + new Intl.NumberFormat().format(total_price.toFixed(2));
                }
            }

            // Show/hide done section based on quantity for non-K-cup bags
            if (quantity) {
                const activePackageBtn = document.querySelector('.package-btn.active');
                const doneSection = document.getElementById('done-section');

                if (activePackageBtn && !activePackageBtn.textContent.includes('K Cup')) {
                    if (quantity.value && quantity.value > 0) {
                        // Show done section when quantity is entered
                        if (doneSection) {
                            doneSection.style.display = 'block';
                            doneSection.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    } else {
                        // Hide done section when quantity is cleared or 0
                        if (doneSection) {
                            doneSection.style.display = 'none';
                        }
                    }
                } else {
                    // Hide done section for K Cup bags
                    if (doneSection) {
                        doneSection.style.display = 'none';
                    }
                }
            }
        }

        function getWholesaleAmount() {
            var quantity = document.getElementById("wholesale-num-bags");
            var spot_price = document.getElementById("wholesale-spot-price");
            var amount = document.getElementById("wholesale-amount");

            console.log('getWholesaleAmount called');
            console.log('Quantity:', quantity ? quantity.value : 'not found');
            console.log('Spot price:', spot_price ? spot_price.value : 'not found');
            console.log('Amount element:', amount ? 'found' : 'not found');

            if (quantity && spot_price && amount && quantity.value && spot_price.value) {
                var total_price = quantity.value * parseFloat(spot_price.value);
                amount.value = "$ " + new Intl.NumberFormat().format(total_price.toFixed(2));
                console.log('Total price calculated:', total_price);
                console.log('Amount updated to:', amount.value);
            } else {
                console.log('Missing required elements or values for wholesale amount calculation');
            }
        }

        // Make functions globally accessible
        window.getAmount = getAmount;
        window.getWholesaleAmount = getWholesaleAmount;

        // Payment functions
        function proceedToPayment() {
            // Get the selected quantity
            const quantity = document.getElementById('numBags');
            const bagImage = document.getElementById('logoOverlay');

            if (quantity && quantity.value) {
                // Save quantity to session
                fetch(`/buyerOrderOptions/num_of_bags/${encodeURIComponent(quantity.value)}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    }
                }).then(response => {
                    console.log('Quantity saved to session:', quantity.value);
                }).catch(error => {
                    console.error('Error saving quantity:', error);
                });

                // Save bag image to session if available
                if (bagImage && bagImage.src && bagImage.style.display !== 'none') {
                    fetch(`/buyerOrderOptions/bag_image/${encodeURIComponent(bagImage.src)}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        }
                    }).then(response => {
                        console.log('Bag image saved to session:', bagImage.src);
                    }).catch(error => {
                        console.error('Error saving bag image:', error);
                    });
                }

                // Redirect to buyerWizardSuccess route with quantity and default stockpostingid
                window.location.href = `/buyerWizardSuccess/${encodeURIComponent(quantity.value)}/${encodeURIComponent(3)}`;
            } else {
                alert('Please enter a valid quantity before proceeding to payment.');
            }
        }

        function proceedToWholesalePayment() {
            // Get the selected wholesale product quantity
            const quantity = document.getElementById('wholesale-num-bags');
            const bagImage = document.getElementById('logoOverlay');

            if (quantity && quantity.value) {
                // Save quantity to session
                fetch(`/buyerOrderOptions/num_of_bags/${encodeURIComponent(quantity.value)}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    }
                }).then(response => {
                    console.log('Quantity saved to session:', quantity.value);
                }).catch(error => {
                    console.error('Error saving quantity:', error);
                });

                // Save bag image to session if available
                if (bagImage && bagImage.src && bagImage.style.display !== 'none') {
                    fetch(`/buyerOrderOptions/bag_image/${encodeURIComponent(bagImage.src)}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        }
                    }).then(response => {
                        console.log('Bag image saved to session:', bagImage.src);
                    }).catch(error => {
                        console.error('Error saving bag image:', error);
                    });
                }

                // Redirect to buyerWizardSuccess route with quantity and default stockpostingid
                window.location.href = `/buyerWizardSuccess/${encodeURIComponent(quantity.value)}/${encodeURIComponent(3)}`;
            } else {
                alert('Please enter a valid quantity before proceeding to payment.');
            }
        }

        // Make payment functions globally accessible
        window.proceedToPayment = proceedToPayment;
        window.proceedToWholesalePayment = proceedToWholesalePayment;

        // Wholesale bag size update function
        function updateWholesaleBagSize() {
            const bagSizeSelect = document.getElementById("wholesale-bag-size");
            const quantityInput = document.getElementById("wholesale-num-bags");
            const spotPriceInput = document.getElementById("wholesale-spot-price");

            console.log('updateWholesaleBagSize called');
            console.log('Bag size select:', bagSizeSelect ? bagSizeSelect.value : 'not found');

            // Define bag size configurations for wholesale
            const wholesaleBagConfigs = {
                "oz_bag": {
                    price: 12.99,
                    minQuantity: 1
                }
                // Add more configurations as needed
            };

            if (bagSizeSelect && quantityInput && spotPriceInput) {
                const selectedConfig = wholesaleBagConfigs[bagSizeSelect.value];
                console.log('Selected config:', selectedConfig);

                if (selectedConfig) {
                    spotPriceInput.value = selectedConfig.price;
                    quantityInput.min = selectedConfig.minQuantity;
                    quantityInput.value = selectedConfig.minQuantity;
                    console.log('Spot price set to:', spotPriceInput.value);
                    console.log('Quantity set to:', quantityInput.value);
                    getWholesaleAmount();
                }
            }
        }

        // Make wholesale functions globally accessible
        window.updateWholesaleBagSize = updateWholesaleBagSize;

        // Function to update wholesale product details
        function updateWholesaleProductDetails(product) {
            console.log('Updating wholesale product details for:', product);

            // Update product title
            const productTitle = document.getElementById('wholesale-product-title');
            if (productTitle) {
                productTitle.textContent = (product.description || 'Unknown').toUpperCase();
            }

            // Update product image
            const productImage = document.getElementById('wholesale-product-image');
            if (productImage) {
                productImage.src = product.imageUrl || '/new_buyer_wizard/images/wholesale-preview.png';
            }

            // Update thumbnail images
            for (let i = 1; i <= 4; i++) {
                const thumb = document.getElementById(`wholesale-thumb-${i}`);
                if (thumb) {
                    thumb.src = product.imageUrl || '/new_buyer_wizard/images/wholesale-preview.png';
                }
            }

            // Update product details table
            const vendor = document.getElementById('wholesale-vendor');
            if (vendor) {
                vendor.textContent = product.supplierInfo?.firstName || 'Unknown';
            }

            const variety = document.getElementById('wholesale-variety');
            if (variety) {
                variety.textContent = product.description || 'Unknown';
            }

            const coffeeType = document.getElementById('wholesale-coffee-type');
            if (coffeeType) {
                coffeeType.textContent = product.coffeeType || 'Arabica';
            }

            const quality = document.getElementById('wholesale-quality');
            if (quality) {
                quality.textContent = product.quality || 'Premium';
            }

            const notes = document.getElementById('wholesale-notes');
            if (notes) {
                notes.textContent = product.notes || 'Balanced, slightly sweet and acidic';
            }

            const process = document.getElementById('wholesale-process');
            if (process) {
                process.textContent = product.process || 'Pupled Natural and Fully Washed Beans';
            }

            // Update availability
            const availability = document.getElementById('wholesale-product-availability');
            if (availability) {
                availability.textContent = `${product.availableQuantity || 1000} bags available`;
            }

            // Update spot price if available
            const spotPriceInput = document.getElementById('wholesale-spot-price');
            if (spotPriceInput && product.bagPrice) {
                spotPriceInput.value = product.bagPrice;
                // Recalculate amount
                getWholesaleAmount();
            }

            // Save product to session
            if (product.id) {
                fetch(`/buyerOrderOptions/product/${encodeURIComponent(product.id)}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    }
                }).then(response => {
                    console.log('Product saved to session:', product.id);
                }).catch(error => {
                    console.error('Error saving product to session:', error);
                });
            }
        }

        // Make the function globally accessible
        window.updateWholesaleProductDetails = updateWholesaleProductDetails;

        // Logo upload functionality - completely rewritten for better reliability
        function initializeLogoUpload() {
            const uploadCard = document.getElementById('logo-upload-card');
            const uploadInput = document.getElementById('logo-upload-input');

            if (uploadCard && uploadInput) {
                // Create a new hidden file input for better control
                const newFileInput = document.createElement('input');
                newFileInput.type = 'file';
                newFileInput.accept = 'image/*';
                newFileInput.style.display = 'none';
                newFileInput.id = 'logo-upload-input-new';
                document.body.appendChild(newFileInput);

                console.log('New file input created:', newFileInput);
                console.log('New file input in DOM:', document.getElementById('logo-upload-input-new'));

                // Get references to elements
                const uploadIcon = document.getElementById('upload-icon');
                const uploadText = document.getElementById('upload-text');

                // Click to upload - using the new file input
                uploadCard.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Upload card clicked');
                    console.log('Triggering new file input');
                    newFileInput.click();
                });

                // Also add click handlers to the icon and text for better UX
                if (uploadIcon) {
                    uploadIcon.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        console.log('Upload icon clicked');
                        newFileInput.click();
                    });
                }

                if (uploadText) {
                    uploadText.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        console.log('Upload text clicked');
                        newFileInput.click();
                    });
                }

                // Drag and drop functionality
                uploadCard.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    uploadCard.classList.add('drag-over');
                });

                uploadCard.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    uploadCard.classList.remove('drag-over');
                });

                uploadCard.addEventListener('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    uploadCard.classList.remove('drag-over');

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        handleLogoUpload(files[0], uploadCard, uploadIcon, uploadText);
                    }
                });

                // File input change event handler
                newFileInput.addEventListener('change', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('New file input change event triggered');
                    const file = e.target.files[0];
                    if (file) {
                        console.log('File selected:', file.name);
                        handleLogoUpload(file, uploadCard, uploadIcon, uploadText);
                    } else {
                        console.log('No file selected');
                    }
                });

                // Store uploaded logo data for preservation
                let uploadedLogoData = null;
                let uploadedLogoFileName = null;

                // Clear file input when switching packages (but preserve logo data)
                const packageButtons = document.querySelectorAll('.package-btn');
                packageButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        // Clear the new file input value
                        newFileInput.value = '';
                    });
                });

                function handleLogoUpload(file, cardElement, iconElement, textElement) {
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            // Store the logo data for preservation
                            uploadedLogoData = evt.target.result;
                            uploadedLogoFileName = file.name;

                            // Remove icon and text, show image preview
                            if (iconElement) iconElement.style.display = 'none';
                            if (textElement) textElement.style.display = 'none';

                            let img = cardElement.querySelector('.logo-preview');
                            if (!img) {
                                img = document.createElement('img');
                                img.className = 'logo-preview';
                                img.style.maxHeight = '48px';
                                img.style.maxWidth = '120px';
                                img.style.objectFit = 'contain';
                                img.style.display = 'block';
                                img.style.margin = '0 auto';
                                img.style.position = 'absolute';
                                img.style.top = '50%';
                                img.style.left = '50%';
                                img.style.transform = 'translate(-50%, -50%)';
                                img.style.zIndex = '10';
                                cardElement.appendChild(img);
                            }
                            img.src = evt.target.result;

                            // Display logo on bag preview (only for non-K-cup bags)
                            const activePackageBtn = document.querySelector('.package-btn.active');
                            if (activePackageBtn && !activePackageBtn.textContent.includes('K Cup')) {
                                const logoOverlay = document.getElementById('logoOverlay');
                                if (logoOverlay) {
                                    logoOverlay.src = evt.target.result;
                                    logoOverlay.style.display = 'block';
                                }
                            } else {
                                // Hide logo overlay for K-cup bags
                                const logoOverlay = document.getElementById('logoOverlay');
                                if (logoOverlay) {
                                    logoOverlay.style.display = 'none';
                                }
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                }

                // Function to restore logo when switching from K-cup to other bags
                function restoreLogoIfAvailable() {
                    console.log('Restoring logo if available, uploadedLogoData:', uploadedLogoData ? 'exists' : 'null');
                    if (uploadedLogoData) {
                        const uploadCard = document.getElementById('logo-upload-card');
                        const uploadIcon = document.getElementById('upload-icon');
                        const uploadText = document.getElementById('upload-text');

                        if (uploadCard && uploadIcon && uploadText) {
                            console.log('Restoring logo to upload card');
                            // Hide icon and text
                            uploadIcon.style.display = 'none';
                            uploadText.style.display = 'none';

                            // Show logo preview
                            let img = uploadCard.querySelector('.logo-preview');
                            if (!img) {
                                img = document.createElement('img');
                                img.className = 'logo-preview';
                                img.style.maxHeight = '48px';
                                img.style.maxWidth = '120px';
                                img.style.objectFit = 'contain';
                                img.style.display = 'block';
                                img.style.margin = '0 auto';
                                img.style.position = 'absolute';
                                img.style.top = '50%';
                                img.style.left = '50%';
                                img.style.transform = 'translate(-50%, -50%)';
                                img.style.zIndex = '10';
                                uploadCard.appendChild(img);
                            }
                            img.src = uploadedLogoData;
                            img.style.display = 'block';

                            // Show logo on bag preview
                            const logoOverlay = document.getElementById('logoOverlay');
                            if (logoOverlay) {
                                logoOverlay.src = uploadedLogoData;
                                logoOverlay.style.display = 'block';

                                // Ensure the design overlay has the correct class for positioning
                                const designOverlay = document.getElementById('designOverlay');
                                const activePackageBtn = document.querySelector('.package-btn.active');
                                if (designOverlay && activePackageBtn) {
                                    const size = activePackageBtn.getAttribute('data-size');
                                    designOverlay.classList.remove('design-overlay-5lb', 'design-overlay-12oz', 'design-overlay-10oz', 'design-overlay-kcup', 'design-overlay-frac_pack');
                                    designOverlay.classList.add(`design-overlay-${size}`);
                                }
                            }
                        }
                    } else {
                        console.log('No logo data available to restore');
                    }
                }

                // Function to hide logo for K-cup bags
                function hideLogoForKCup() {
                    console.log('Hiding logo for K-cup');
                    const uploadCard = document.getElementById('logo-upload-card');
                    const uploadIcon = document.getElementById('upload-icon');
                    const uploadText = document.getElementById('upload-text');
                    const logoPreview = uploadCard ? uploadCard.querySelector('.logo-preview') : null;

                    if (uploadCard && uploadIcon && uploadText) {
                        uploadIcon.style.display = 'block';
                        uploadText.style.display = 'block';
                        if (logoPreview) {
                            logoPreview.style.display = 'none';
                        }
                    }

                    // Hide logo on bag preview
                    const logoOverlay = document.getElementById('logoOverlay');
                    if (logoOverlay) {
                        logoOverlay.style.display = 'none';
                    }
                }

                // Make these functions globally accessible for package button handlers
                window.restoreLogoIfAvailable = restoreLogoIfAvailable;
                window.hideLogoForKCup = hideLogoForKCup;

                // Cleanup function to remove the new file input
                window.addEventListener('beforeunload', function() {
                    const newFileInput = document.getElementById('logo-upload-input-new');
                    if (newFileInput) {
                        newFileInput.remove();
                    }
                });
            }
        }
    </script>

    <!-- Clare Chat Component -->
    <script src="{{ asset('js/clare-component.js') }}"></script>
</body>

</html>