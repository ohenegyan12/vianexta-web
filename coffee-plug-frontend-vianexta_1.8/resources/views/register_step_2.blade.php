@extends('layouts.auth_layout ')
@section('title', 'Account Type ')

@push('css')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Clean Select2 Styling - Simplified and Fixed */
    .select2-container {
        width: 100% !important;
    }

    /* Base Select2 styling - match input fields exactly */
    .select2-container--default .select2-selection--single {
        width: 100% !important;
        height: 42px !important;
        /* border: 2px solid var(--primary-color, #07382f) !important; */
        border-radius: 0.375rem !important;
        background-color: #fff !important;
        box-shadow: none !important;
        outline: none !important;
        padding: 0 !important;
        font-size: 14px !important;
        line-height: 1.5 !important;
        display: flex !important;
        align-items: center !important;
        background-image: none !important;
        transition: border-color 0.15s ease-in-out !important;
    }

    /* Text rendering */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px !important;
        padding-left: 12px !important;
        padding-right: 30px !important;
        color: #495057 !important;
        font-size: 14px !important;
        width: 100% !important;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }

    /* Arrow container */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        width: 30px !important;
        right: 0 !important;
        position: absolute !important;
        top: 0 !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        background: transparent !important;
        z-index: 1 !important;
        pointer-events: auto !important;
    }

    /* Arrow icon */
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: var(--primary-color, #07382f) transparent transparent transparent !important;
        border-width: 6px 5px 0 5px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        position: absolute !important;
        left: 50% !important;
        margin-left: -5px !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }

    /* Arrow when open */
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
        border-color: transparent transparent var(--primary-color, #07382f) transparent !important;
        border-width: 0 5px 6px 5px !important;
    }

    /* Hover state */
    .select2-container--default .select2-selection--single:hover {
        border-color: var(--primary-color, #07382f) !important;
    }

    /* Focus state */
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--primary-color, #07382f) !important;
        box-shadow: none !important;
    }

    /* Open state */
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: var(--primary-color, #07382f) !important;
        box-shadow: none !important;
    }

    /* Dropdown styling */
    .select2-dropdown {
        border: 2px solid var(--primary-color, #07382f) !important;
        border-radius: 0.375rem !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        background-color: #fff !important;
        z-index: 1000 !important;
    }

    /* Search field */
    .select2-search--dropdown .select2-search__field {
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
        padding: 8px 12px !important;
        font-size: 14px !important;
    }

    /* Results options */
    .select2-results__option {
        padding: 8px 12px !important;
        font-size: 14px !important;
        color: #495057 !important;
    }

    .select2-results__option--highlighted[aria-selected] {
        background-color: var(--primary-color, #07382f) !important;
        color: white !important;
    }

    .select2-results__option[aria-selected=true] {
        background-color: #e9ecef !important;
        color: #495057 !important;
    }

    /* Z-index and hiding */
    .select2-container--default {
        z-index: 1000 !important;
    }

    /* Ensure Select2 dropdowns don't interfere with navigation */
    .select2-dropdown {
        z-index: 1000 !important;
    }

    .select2-container+select {
        display: none !important;
    }

    /* Override any Select2 default styling that creates extra outlines */
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--single .select2-selection__rendered,
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        outline: none !important;
        box-shadow: none !important;
        border: none !important;
        background: transparent !important;
    }

    /* Force remove any browser default focus styles */
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--single:focus-within {
        outline: none !important;
        box-shadow: none !important;
    }

    /* Override any Select2 dropdown styling that might add borders */
    .select2-dropdown {
        border: 2px solid var(--primary-color, #07382f) !important;
        outline: none !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        z-index: 1000 !important;
    }

    /* Prevent form containers from creating stacking contexts */
    .grid,
    .grid-cols-1,
    .sm\\:grid-cols-2 {
        position: static !important;
        z-index: auto !important;
    }

    /* Remove Bootstrap interference */
    .select2-container--default .select2-selection {
        background-image: none !important;
        background-color: #fff !important;
    }

    /* Remove all extra outlines and borders */
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--single:before,
    .select2-container--default .select2-selection--single:after {
        outline: none !important;
        box-shadow: none !important;
        border: none !important;
    }

    /* Ensure the rendered text doesn't have borders */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        outline: none !important;
        box-shadow: none !important;
        border: none !important;
    }

    /* Ensure only the main container has the border */
    .select2-container--default .select2-selection--single {
        border: 2px solid var(--primary-color, #07382f) !important;
    }

    /* Remove any focus rings or additional borders */
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single,
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--single:hover {
        outline: none !important;
        box-shadow: none !important;
        border: 2px solid var(--primary-color, #07382f) !important;
    }

    /* EULA and Privacy Policy Modal Styling - Fixed */
    #eulaModal,
    #privacyModal {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
        z-index: 10000 !important;
        display: none !important;
    }

    #eulaModal.show,
    #privacyModal.show {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    #eulaModal .modal-content,
    #privacyModal .modal-content {
        background: white !important;
        border-radius: 8px !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
        max-width: 800px !important;
        width: 90% !important;
        max-height: 80vh !important;
        overflow-y: auto !important;
        position: relative !important;
    }

    #eulaModal .modal-header,
    #privacyModal .modal-header {
        border-bottom: 1px solid #e9ecef !important;
        padding: 1rem 1.5rem !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
    }

    #eulaModal .modal-body,
    #privacyModal .modal-body {
        padding: 1.5rem !important;
        line-height: 1.6 !important;
    }

    #eulaModal .modal-footer,
    #privacyModal .modal-footer {
        border-top: 1px solid #e9ecef !important;
        padding: 1rem 1.5rem !important;
        display: flex !important;
        justify-content: flex-end !important;
        gap: 0.5rem !important;
    }

    #eulaModal .btn-close,
    #privacyModal .btn-close {
        background: none !important;
        border: none !important;
        font-size: 1.5rem !important;
        color: #6c757d !important;
        cursor: pointer !important;
        padding: 0 !important;
        width: auto !important;
        height: auto !important;
    }

    #eulaModal .btn-close:hover,
    #privacyModal .btn-close:hover {
        color: #495057 !important;
    }

    /* Body scroll lock when modal is open */
    body.modal-open {
        overflow: hidden !important;
    }

    /* Tax ID field styling */
    #tax_id.error {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    }

    #tax_id:focus {
        border-color: var(--primary-color, #07382f) !important;
        box-shadow: 0 0 0 3px rgba(7, 56, 47, 0.1) !important;
    }

    #tax_id.border-green-500 {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
    }

    /* Status icon styling */
    #tax_id_status {
        pointer-events: none;
        z-index: 10;
    }

    #tax_id_icon {
        font-family: monospace;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
    }

    /* Input field with status icon */
    .relative input[type="text"] {
        padding-right: 2.5rem;
    }

    /* Enhanced Modal Styling */
    #alert-modal,
    #success_alert {
        z-index: 9999 !important;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
    }

    #alert-modal .fixed,
    #success_alert .fixed {
        z-index: 10000 !important;
    }

    /* Ensure modals are above all other content */
    .modal-overlay {
        z-index: 9998 !important;
    }

    /* Prevent body scroll when modal is open */
    body.modal-open {
        overflow: hidden !important;
    }

    /* Modal backdrop */
    .modal-backdrop {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
        z-index: 9998 !important;
    }

    /* Enhanced modal animations and styling */
    #alert-modal .relative,
    #success_alert .relative {
        animation: modalSlideIn 0.3s ease-out;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }

        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @keyframes modalSlideOut {
        from {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        to {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }
    }

    /* Modal button hover effects */
    #alert-modal button,
    #success_alert button {
        transition: all 0.2s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    #alert-modal button:hover,
    #success_alert button:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    #alert-modal button:active,
    #success_alert button:active {
        transform: translateY(0);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    /* Button ripple effect */
    #alert-modal button::before,
    #success_alert button::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    #alert-modal button:hover::before,
    #success_alert button:hover::before {
        width: 300px;
        height: 300px;
    }

    /* Modal content spacing improvements */
    #alert-modal .px-4,
    #success_alert .px-4 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    #alert-modal .py-3,
    #success_alert .py-3 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    #alert-modal .py-4,
    #success_alert .py-4 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    /* Enhanced modal content styling - High specificity to override any conflicts */
    #alert-modal h3,
    #success_alert h3,
    #alert-modal .text-white,
    #success_alert .text-white {
        font-weight: 700 !important;
        letter-spacing: -0.025em !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) !important;
        color: #ffffff !important;
    }

    #alert-modal p,
    #success_alert p,
    #alert-modal .text-gray-800,
    #success_alert .text-gray-800 {
        line-height: 1.6 !important;
        color: #1f2937 !important;
        font-weight: 500 !important;
    }

    /* Force text colors for all text elements in modals */
    #alert-modal .text-sm,
    #success_alert .text-sm {
        color: #1f2937 !important;
    }

    #alert-modal .text-base,
    #success_alert .text-base {
        color: #ffffff !important;
    }

    /* Additional modal text color enforcement */
    #alert-modal *,
    #success_alert * {
        color: inherit;
    }

    #alert-modal .bg-gradient-to-r h3,
    #success_alert .bg-gradient-to-r h3 {
        color: #ffffff !important;
    }

    #alert-modal .px-4 p,
    #success_alert .px-4 p {
        color: #1f2937 !important;
    }

    /* Debug: Force specific text colors */
    #alert-modal #modal-title,
    #success_alert #modal-title {
        color: #ffffff !important;
    }

    #alert-modal #modal-message,
    #success_alert #success-message {
        color: #1f2937 !important;
    }

    /* Ultra-high specificity text color enforcement */
    body #alert-modal h3,
    body #success_alert h3,
    body #alert-modal .text-white,
    body #success_alert .text-white {
        color: #ffffff !important;
    }

    body #alert-modal p,
    body #success_alert p,
    body #alert-modal .text-gray-800,
    body #success_alert .text-gray-800 {
        color: #1f2937 !important;
    }

    /* Force colors on specific elements */
    body #alert-modal .bg-gradient-to-r h3,
    body #success_alert .bg-gradient-to-r h3 {
        color: #ffffff !important;
    }

    body #alert-modal .px-4 p,
    body #success_alert .px-4 p {
        color: #1f2937 !important;
    }

    /* Override any conflicting Tailwind classes */
    body #alert-modal .text-sm.text-gray-800,
    body #success_alert .text-sm.text-gray-800 {
        color: #1f2937 !important;
    }

    body #alert-modal .text-base.text-white,
    body #success_alert .text-base.text-white {
        color: #ffffff !important;
    }

    /* Final text color enforcement with maximum specificity */
    html body #alert-modal h3,
    html body #success_alert h3 {
        color: #ffffff !important;
    }

    html body #alert-modal p,
    html body #success_alert p {
        color: #1f2937 !important;
    }

    /* Force colors on all text elements in modals */
    html body #alert-modal *[class*="text-"],
    html body #success_alert *[class*="text-"] {
        color: inherit !important;
    }

    /* Specific color overrides for modal elements */
    html body #alert-modal .bg-gradient-to-r *,
    html body #success_alert .bg-gradient-to-r * {
        color: #ffffff !important;
    }

    html body #alert-modal .px-4 *,
    html body #success_alert .px-4 * {
        color: #1f2937 !important;
    }

    /* Modal icon enhancements */
    #alert-modal .bg-white\/20,
    #success_alert .bg-white\/20 {
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Enhanced color schemes for modals */
    #alert-modal {
        --error-primary: #ef4444;
        --error-secondary: #fca5a5;
        --error-accent: #dc2626;
    }

    #success_alert {
        --success-primary: #10b981;
        --success-secondary: #6ee7b7;
        --success-accent: #059669;
    }

    /* Error modal specific enhancements */
    #alert-modal .bg-red-500\/20 {
        background-color: rgba(239, 68, 68, 0.2);
    }

    #alert-modal .bg-red-400\/30 {
        background-color: rgba(248, 113, 113, 0.3);
    }

    #alert-modal .bg-red-400\/20 {
        background-color: rgba(248, 113, 113, 0.2);
    }

    /* Success modal specific enhancements */
    #success_alert .bg-green-500\/20 {
        background-color: rgba(16, 185, 129, 0.2);
    }

    #success_alert .bg-green-400\/30 {
        background-color: rgba(74, 222, 128, 0.3);
    }

    #success_alert .bg-green-400\/20 {
        background-color: rgba(74, 222, 128, 0.2);
    }

    /* Enhanced button styling */
    #alert-modal button,
    #success_alert button {
        position: relative;
        overflow: hidden;
    }

    #alert-modal button::after,
    #success_alert button::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    #alert-modal button:hover::after,
    #success_alert button:hover::after {
        left: 100%;
    }

    /* Responsive improvements */
    @media (max-width: 640px) {

        #alert-modal .max-w-sm,
        #success_alert .max-w-sm {
            margin: 1rem;
            max-width: calc(100% - 2rem);
        }

        #alert-modal .px-4,
        #success_alert .px-4 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        #alert-modal .py-3,
        #success_alert .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        #alert-modal .py-4,
        #success_alert .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
    }

    .tax-id-help {
        color: #6b7280;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .tax-id-error {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: none;
    }

    .tax-id-error.show {
        display: block;
    }

    /* Simple Notification System */
    .notification {
        min-width: 300px;
        max-width: 400px;
        padding: 16px;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        transform: translateX(100%);
        transition: all 0.3s ease-in-out;
        opacity: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 500;
        position: relative;
        overflow: hidden;
    }

    .notification.show {
        transform: translateX(0);
        opacity: 1;
    }

    .notification.hide {
        transform: translateX(100%);
        opacity: 0;
    }

    .notification-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-left: 4px solid #047857;
    }

    .notification-error {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border-left: 4px solid #b91c1c;
    }

    .notification-icon {
        flex-shrink: 0;
        width: 20px;
        height: 20px;
    }

    .notification-content {
        flex: 1;
        line-height: 1.4;
    }

    .notification-close {
        flex-shrink: 0;
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.8);
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: all 0.2s ease;
        font-size: 16px;
        line-height: 1;
    }

    .notification-close:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .notification-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: rgba(255, 255, 255, 0.3);
        transition: width linear;
    }

    @media (max-width: 640px) {
        #notification-container {
            top: 16px;
            right: 16px;
            left: 16px;
        }
        
        .notification {
            min-width: auto;
            max-width: none;
        }
    }
</style>
@endpush

@section('content')
<section class="py-4 sm:py-8 pb-40 h-5/6">
    <div class="mx-auto max-w-screen-2xl p-3 p-lg-5 pt-5">
        <div class="flex flex-col xl:flex-row items-center justify-between mb-5 sm:mb-10">
            <h1 class="text-2xl md:text-4xl font-semibold text-primary text-start mb-8 md:mb-10 xl:mb-0">Register</h1>
            <div class="max-w-2xl w-100 sm:max-w-full sm:mx-0 flex bg-gray-100 p-1 items-center rounded-md">
                <a href="{{ route('register_step_1') }}"
                    class="btn bg-transparent font-sora text-sm font-semibold w-50 capitalize register_tab">Your
                    Profile</a>
                <button class=" btn border-0 text-sm capitalize w-50 register_tab active px-0">Business
                    Information</button>
            </div>
        </div>
        <form action="{{ route('saveBusinessData') }}" method="POST" onsubmit="return validateForm()">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                <div class="">
                    <label for="business_name" class="block text-sm md:text-md font-semibold text-primary">Business
                        Name<sup>*</sup></label>
                    <div class="mt-1">
                        <input type="text" id="business_name" name="business_name"
                            value="{{ empty(session('business_name')) ? old('business_name') : session('business_name') }}"
                            autocomplete="business_name" class="input w-full border-2 border-primary">
                        @if ($errors->has('business_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('business_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label for="business_type" class="block text-sm md:text-md font-semibold text-primary">Business
                        Type<sup>*</sup></label>
                    <div class="mt-1">
                        <select id="business_type" name="business_type" class="input w-full border-2 border-primary" required>
                            <option value="">Select Business Type</option>
                        </select>
                        @if ($errors->has('business_type'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('business_type') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>


                <div class="">
                    <label for="billingAddressLine1" class="block text-sm md:text-md font-semibold text-primary">Billing Address Line1
                        <sup>*</sup></label>
                    <div class="mt-1">
                        <input type="text" id="billingAddressLine1" name="billingAddressLine1" autocomplete="billingAddressLine1"
                            value="{{ empty(session('billingAddressLine1')) ? old('billingAddressLine1') : session('billingAddressLine1') }}"
                            class="input w-full border-2 border-primary">
                        @if ($errors->has('billingAddressLine1'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('billingAddressLine1') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label for="billingAddressLine2" class="block text-sm md:text-md font-semibold text-primary">Billing Address Line 2
                    </label>
                    <div class="mt-1">
                        <input type="text" id="billingAddressLine2" name="billingAddressLine2" autocomplete="billingAddressLine2"
                            value="{{ empty(session('billingAddressLine2')) ? old('billingAddressLine2') : session('billingAddressLine2') }}"
                            class="input w-full border-2 border-primary">
                        @if ($errors->has('billingAddressLine2'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('billingAddressLine2') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label for="billingCountry"
                        class="block text-sm md:text-md font-semibold text-primary">Billing Country<sup>*</sup></label>
                    <div class="mt-1">
                        <select id="billingCountry" name="billingCountry" class="input w-full border-2 border-primary" required>
                            <option value="">Select Country</option>
                        </select>
                        @if ($errors->has('billingCountry'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('billingCountry') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="">
                    <label for="billingState"
                        class="block text-sm md:text-md font-semibold text-primary">State<sup>*</sup></label>
                    <div class="mt-1">
                        <select id="billingState" name="billingState" class="input w-full border-2 border-primary" required>
                            <option value="">Select State/Province</option>
                        </select>
                        @if ($errors->has('billingState'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('billingState') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="">
                    <label for="billingCity"
                        class="block text-sm md:text-md font-semibold text-primary">Billing City<sup>*</sup></label>
                    <div class="mt-1">
                        <select id="billingCity" name="billingCity" class="input w-full border-2 border-primary" required>
                            <option value="">Select City</option>
                        </select>
                        @if ($errors->has('billingCity'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('billingCity') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="">
                    <label for="billingZipCode" class="block text-sm md:text-md font-semibold text-primary">Billing Zip
                        Code<sup>*</sup></label>
                    <div class="mt-1">
                        <input type="text" id="billingZipCode" name="billingZipCode" autocomplete="billingZipCode"
                            value="{{ empty(session('billingZipCode')) ? old('billingZipCode') : session('billingZipCode') }}"
                            class="input w-full border-2 border-primary">
                        @if ($errors->has('billingZipCode'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('billingZipCode') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <!-- <div class="">
                    <label for="shippingAddressLine1" class="block text-sm md:text-md font-semibold text-secondary">Shipping Address Line1
                    </label>
                    <div class="mt-1">
                        <input type="text" id="shippingAddressLine1" name="shippingAddressLine1" autocomplete="shippingAddressLine1"
                            value="{{ empty(session('shippingAddressLine1')) ? old('shippingAddressLine1') : session('shippingAddressLine1') }}"
                class="input w-full border-2 border-primary">
                @if ($errors->has('shippingAddressLine1'))
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red;">{{ $errors->first('shippingAddressLine1') }}</strong>
                </span>
                @endif
            </div>
    </div>
    <div class="">
        <label for="shippingAddressLine2" class="block text-sm md:text-md font-semibold text-secondary">Shipping Address Line 2
        </label>
        <div class="mt-1">
            <input type="text" id="shippingAddressLine2" name="shippingAddressLine2" autocomplete="shippingAddressLine2"
                value="{{ empty(session('shippingAddressLine2')) ? old('shippingAddressLine2') : session('shippingAddressLine2') }}"
                class="input w-full border-2 border-primary">
            @if ($errors->has('shippingAddressLine2'))
            <span class="invalid-feedback" role="alert">
                <strong style="color: red;">{{ $errors->first('shippingAddressLine2') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="">
        <label for="shippingCountry"
            class="block text-sm md:text-md font-semibold text-secondary">Shipping Country</label>
        <div class="mt-1">
            {{-- Country js-example-basic-single  --}}
            <select type="text" class="input w-full border-2 border-primary"
                style="" id="shippingCountry" name="shippingCountry" placeholder="Shipping Country">
                @foreach($countries as $country)
                <option value="{{$country->name}}" {{ empty(session('shippingCountry')) ? (old('shippingCountry')==$country->name ? 'selected' : ''): (session('shippingCountry')==$country->name ? 'selected':'') }}>{{$country->name}}</option>
                @endforeach
            </select>
            @if ($errors->has('shippingCountry'))
            <span class="invalid-feedback" role="alert">
                <strong style="color: red;">{{ $errors->first('shippingCountry') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="">
        <label for="shippingState"
            class="block text-sm md:text-md font-semibold text-secondary">State</label>
        <div class="mt-1">
            <input type="text" id="shippingState" name="shippingState" autocomplete="State / Province"
                value="{{ empty(session('shippingState')) ? old('shippingState') : session('shippingState') }}"
                class="input w-full border-2 border-primary">
            @if ($errors->has('shippingState'))
            <span class="invalid-feedback" role="alert">
                <strong style="color: red;">{{ $errors->first('shippingState') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="">
        <label for="shippingCity"
            class="block text-sm md:text-md font-semibold text-secondary">Shipping City</label>
        <div class="mt-1">
            <input type="text" id="shippingCity" name="shippingCity" autocomplete="shippingCity"
                value="{{ empty(session('shippingCity')) ? old('shippingCity') : session('shippingCity') }}"
                class="input w-full border-2 border-primary">
            @if ($errors->has('shippingCity'))
            <span class="invalid-feedback" role="alert">
                <strong style="color: red;">{{ $errors->first('shippingCity') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="">
        <label for="shippingZipCode" class="block text-sm md:text-md font-semibold text-secondary">Shipping Zip
            Code</label>
        <div class="mt-1">
            <input type="text" id="shippingZipCode" name="shippingZipCode" autocomplete="shippingZipCode"
                value="{{ empty(session('shippingZipCode')) ? old('shippingZipCode') : session('shippingZipCode') }}"
                class="input w-full border-2 border-primary">
            @if ($errors->has('shippingZipCode'))
            <span class="invalid-feedback" role="alert">
                <strong style="color: red;">{{ $errors->first('shippingZipCode') }}</strong>
            </span>
            @endif
        </div>
    </div> -->

                <div class="">
                    <label for="tax_id" class="block text-sm md:text-md font-semibold text-primary">Tax
                        ID
                        Number</label>
                    <div class="mt-1">
                        <div class="relative">
                            <input type="text" id="tax_id" name="tax_id" autocomplete="tax_id"
                                value="{{ old('tax_id', session('tax_id', '')) }}"
                                class="input w-full border-2 border-primary pr-10"
                                placeholder="XX-XXXXXXX"
                                maxlength="10"
                                onkeyup="formatTaxId(this); validateTaxIdRealTime(this)"
                                onblur="validateTaxId(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                onpaste="handleTaxIdPaste(event)">
                            <div id="tax_id_status" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span id="tax_id_icon" class="text-gray-300 text-sm">●</span>
                            </div>
                        </div>
                        <div class="mt-1 text-xs text-gray-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Enter your 9-digit Tax ID (EIN) in format: XX-XXXXXXX (Optional)
                        </div>
                        @if ($errors->has('tax_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red;">{{ $errors->first('tax_id') }}</strong>
                        </span>
                        @endif
                        <span id="tax_id_error" class="hidden text-xs text-red-600 mt-1"></span>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="eula_agreement" name="eula_agreement" type="checkbox" required
                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary"
                            onchange="toggleNextButton()">
                    </div>
                    <label for="eula_agreement" class="ml-4 text-sm font-medium text-gray-900">
                        I have read and agree to the <button type="button" onclick="openEulaModal()" class="text-primary hover:text-primary-dark font-semibold cursor-pointer"><span class="underline">ViaNexta EULA</span> <i class="fas fa-external-link-alt ml-1"></i></button> and <button type="button" onclick="openPrivacyModal()" class="text-primary hover:text-primary-dark font-semibold cursor-pointer"><span class="underline">Privacy Policy</span> <i class="fas fa-external-link-alt ml-1"></i></button>
                    </label>
                </div>
                @if ($errors->has('eula_agreement'))
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red;">{{ $errors->first('eula_agreement') }}</strong>
                </span>
                @endif
            </div>

            <!-- EULA Modal -->
            <div id="eulaModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary">ViaNexta EULA</h5>
                        <button type="button" class="btn-close" onclick="closeEulaModal()" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-sm text-gray-600">
                            <p class="font-bold mb-2">END USER LICENSE AGREEMENT (EULA)</p>
                            <p class="mb-2">Effective Date: [01/01/2025]</p>
                            <p class="mb-4">PLEASE READ THIS END USER LICENSE AGREEMENT ("Agreement") CAREFULLY BEFORE USING THE VIANEXTA PLATFORM. BY ACCESSING OR USING THE PLATFORM, YOU AGREE TO BE BOUND BY THIS AGREEMENT.</p>

                            <p class="font-semibold mb-2">1. ACCEPTANCE OF TERMS</p>
                            <p class="mb-4">By using ViaNexta, you agree to abide by this Agreement and represent that you are authorized to bind your organization to its terms. If you do not agree, do not use the platform.</p>

                            <p class="font-semibold mb-2">2. LICENSE GRANT</p>
                            <p class="mb-4">ViaNexta grants you a limited, non-exclusive, non-transferable license to access and use the platform solely for lawful business purposes in accordance with this Agreement.</p>

                            <p class="font-semibold mb-2">3. USER RESPONSIBILITIES</p>
                            <p class="mb-4">You agree to:</p>
                            <ul class="list-disc pl-6 mb-4">
                                <li>Provide accurate and current information.</li>
                                <li>Maintain the security of your account.</li>
                                <li>Not misuse or interfere with the platform.</li>
                            </ul>

                            <p class="font-semibold mb-2">4. MANUFACTURING & FULFILLMENT</p>
                            <p class="mb-4">ViaNexta connects users with independent third-party manufacturers, roasters, co-packers, and logistics providers. ViaNexta does not produce goods directly and is not liable for manufacturing defects, delays, or delivery issues. All transactions and relationships are managed between buyers and suppliers, facilitated through our platform and AI agents.</p>

                            <p class="font-semibold mb-2">5. PAYMENTS</p>
                            <p class="mb-4">You agree to pay all fees and charges associated with your use of the platform. ViaNexta may process payments, retain a service fee, and remit funds to suppliers. Refunds and chargebacks will be handled in accordance with our Payment Policy.</p>

                            <p class="font-semibold mb-2">6. INTELLECTUAL PROPERTY</p>
                            <p class="mb-4">All ViaNexta technology, content, and branding are owned by ViaNexta and protected by intellectual property laws. You retain ownership of any product designs or content you upload, granting ViaNexta a license to use them for order fulfillment and platform operations.</p>

                            <p class="font-semibold mb-2">7. DATA & PRIVACY</p>
                            <p class="mb-4">Your use of ViaNexta is subject to our Privacy Policy. We collect and use data to operate, maintain, and improve our services. Aggregated and anonymized data may be used for analytics and insights.</p>

                            <p class="font-semibold mb-2">8. TERMINATION</p>
                            <p class="mb-4">We may suspend or terminate your access to ViaNexta at our discretion for violations of this Agreement. Upon termination, you remain responsible for outstanding obligations.</p>

                            <p class="font-semibold mb-2">9. DISCLAIMERS</p>
                            <p class="mb-4">ViaNexta provides the platform "as is" without warranties of any kind. We are not responsible for user-generated content, third-party manufacturers, or disruptions beyond our control.</p>

                            <p class="font-semibold mb-2">10. INDEMNIFICATION</p>
                            <p class="mb-4">You agree to indemnify and hold harmless ViaNexta, its affiliates, and employees from any claims, damages, or expenses arising from your use of the platform or violation of this Agreement.</p>

                            <p class="font-semibold mb-2">11. DISPUTE RESOLUTION & GOVERNING LAW</p>
                            <p class="mb-4">This Agreement shall be governed by the laws of the State of Delaware. Any disputes shall be resolved through binding arbitration in accordance with the rules of the American Arbitration Association.</p>

                            <p class="font-semibold mb-2">12. MODIFICATIONS</p>
                            <p class="mb-4">ViaNexta reserves the right to modify this Agreement at any time. Continued use of the platform constitutes acceptance of any changes.</p>

                            <p class="font-semibold mb-2">13. CONTACT</p>
                            <p class="mb-4">For questions regarding this Agreement, contact us at: [Legal@vianexta.com]</p>

                            <p class="mb-4">By using ViaNexta, you acknowledge that you have read, understood, and agree to be bound by this Agreement.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeEulaModal()">Close</button>
                        <button type="button" class="btn btn-primary" onclick="acceptEula()">I Accept</button>
                    </div>
                </div>
            </div>

            <!-- Privacy Policy Modal -->
            <div id="privacyModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary">ViaNexta Privacy Policy</h5>
                        <button type="button" class="btn-close" onclick="closePrivacyModal()" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-sm text-gray-600">
                            <p class="font-bold mb-2">PRIVACY POLICY</p>
                            <p class="mb-2">Effective Date: [01/01/2025]</p>
                            <p class="mb-4">This Privacy Policy describes how ViaNexta ("we," "our," or "us") collects, uses, and shares your personal information when you use our platform and services.</p>

                            <p class="font-semibold mb-2">1. INFORMATION WE COLLECT</p>
                            <p class="mb-4">We collect information you provide directly to us, such as:</p>
                            <ul class="list-disc pl-6 mb-4">
                                <li>Account information (name, email, business details)</li>
                                <li>Business information (company details, tax IDs, addresses)</li>
                                <li>Transaction and payment information</li>
                                <li>Communication preferences and support requests</li>
                            </ul>

                            <p class="font-semibold mb-2">2. AUTOMATICALLY COLLECTED INFORMATION</p>
                            <p class="mb-4">We automatically collect certain information when you use our platform:</p>
                            <ul class="list-disc pl-6 mb-4">
                                <li>Device and browser information</li>
                                <li>Usage data and analytics</li>
                                <li>IP address and location data</li>
                                <li>Cookies and similar technologies</li>
                            </ul>

                            <p class="font-semibold mb-2">3. HOW WE USE YOUR INFORMATION</p>
                            <p class="mb-4">We use the collected information to:</p>
                            <ul class="list-disc pl-6 mb-4">
                                <li>Provide and maintain our services</li>
                                <li>Process transactions and payments</li>
                                <li>Communicate with you about your account</li>
                                <li>Improve our platform and user experience</li>
                                <li>Comply with legal obligations</li>
                            </ul>

                            <p class="font-semibold mb-2">4. INFORMATION SHARING</p>
                            <p class="mb-4">We may share your information with:</p>
                            <ul class="list-disc pl-6 mb-4">
                                <li>Service providers and partners</li>
                                <li>Manufacturers and suppliers for order fulfillment</li>
                                <li>Legal authorities when required by law</li>
                                <li>Business partners with your consent</li>
                            </ul>

                            <p class="font-semibold mb-2">5. DATA SECURITY</p>
                            <p class="mb-4">We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet is 100% secure.</p>

                            <p class="font-semibold mb-2">6. YOUR RIGHTS AND CHOICES</p>
                            <p class="mb-4">You have the right to:</p>
                            <ul class="list-disc pl-6 mb-4">
                                <li>Access and update your personal information</li>
                                <li>Opt-out of marketing communications</li>
                                <li>Request deletion of your data</li>
                                <li>Control cookie preferences</li>
                            </ul>

                            <p class="font-semibold mb-2">7. DATA RETENTION</p>
                            <p class="mb-4">We retain your personal information for as long as necessary to provide our services, comply with legal obligations, resolve disputes, and enforce our agreements.</p>

                            <p class="font-semibold mb-2">8. INTERNATIONAL DATA TRANSFERS</p>
                            <p class="mb-4">Your information may be transferred to and processed in countries other than your own. We ensure appropriate safeguards are in place to protect your data during such transfers.</p>

                            <p class="font-semibold mb-2">9. CHILDREN'S PRIVACY</p>
                            <p class="mb-4">Our services are not intended for children under 18. We do not knowingly collect personal information from children under 18.</p>

                            <p class="font-semibold mb-2">10. CHANGES TO THIS POLICY</p>
                            <p class="mb-4">We may update this Privacy Policy from time to time. We will notify you of any material changes by posting the new policy on our platform.</p>

                            <p class="font-semibold mb-2">11. CONTACT US</p>
                            <p class="mb-4">If you have questions about this Privacy Policy, please contact us at: [Privacy@vianexta.com]</p>

                            <p class="mb-4">By using ViaNexta, you acknowledge that you have read and understood this Privacy Policy.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closePrivacyModal()">Close</button>
                        <button type="button" class="btn btn-primary" onclick="acceptPrivacy()">I Accept</button>
                    </div>
                </div>
            </div>
            <div class="mt-20">
                <div class="flex items-center justify-between">
                    <a href="{{ route('register_step_1') }}"
                        class="btn btn-outline-secondary mb-md-3 mt-6 m-2 text-primary capitalize btn-md  md:w-max px-20" style="border-width: medium;">
                        <i class="fa fa-angle-left" style="margin-right:15px;margin-left:15px;"></i>Previous Step
                    </a>
                    <button type="submit" id="nextStepButton" class="mt-6 btn btn-primary btn-md m-2 md:w-max px-20 text-white capitalize" style="display: none;">
                        Next Step
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>



<!-- Simple Notification System -->
<div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2">
    <!-- Notifications will be dynamically inserted here -->
</div>
@endsection
@section('scripts')

<!-- jQuery first, then Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Global Privacy Policy Modal Function
    // Usage: onclick="openPrivacyPolicyModal()" - Can be used anywhere on the site
    // Example: <a href="#" onclick="openPrivacyPolicyModal()">Privacy Policy</a>

    // Simple Notification System
    function showNotification(message, type = 'success', duration = 5000) {
        const container = document.getElementById('notification-container');
        if (!container) return;

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        
        // Create notification content
        const icon = type === 'success' 
            ? '<svg class="notification-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
            : '<svg class="notification-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>';
        
        notification.innerHTML = `
            ${icon}
            <div class="notification-content">${message}</div>
            <button class="notification-close" onclick="closeNotification(this.parentElement)">&times;</button>
            <div class="notification-progress" style="width: 100%;"></div>
        `;

        // Add to container
        container.appendChild(notification);

        // Show notification with animation
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);

        // Auto-hide after duration
        if (duration > 0) {
            const progressBar = notification.querySelector('.notification-progress');
            if (progressBar) {
                progressBar.style.transitionDuration = duration + 'ms';
                setTimeout(() => {
                    progressBar.style.width = '0%';
                }, 100);
            }

            setTimeout(() => {
                closeNotification(notification);
            }, duration);
        }

        return notification;
    }

    function closeNotification(notification) {
        if (!notification) return;
        
        notification.classList.remove('show');
        notification.classList.add('hide');
        
        setTimeout(() => {
            if (notification.parentElement) {
                notification.parentElement.removeChild(notification);
            }
        }, 300);
    }

    // Legacy function names for compatibility
    function showAlertModal() {
        const errorMessage = "{{ session('error', 'Registration failed. Please try again.') }}";
        showNotification(errorMessage, 'error', 6000);
    }

    function showSuccessModal() {
        const successMessage = "{{ session('success', 'Registration completed successfully!') }}";
        showSuccessNotification(successMessage);
    }

    function showSuccessNotification(message) {
        const container = document.getElementById('notification-container');
        if (!container) return;

        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'notification notification-success';
        
        // Create notification content with action button
        const icon = '<svg class="notification-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
        
        notification.innerHTML = `
            ${icon}
            <div class="notification-content">
                <div style="margin-bottom: 8px;">${message}</div>
                <button onclick="proceedToLogin()" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); color: white; padding: 4px 12px; border-radius: 4px; font-size: 12px; cursor: pointer; transition: all 0.2s ease;">
                    Proceed to Login
                </button>
            </div>
            <button class="notification-close" onclick="closeNotification(this.parentElement)">&times;</button>
        `;

        // Add to container
        container.appendChild(notification);

        // Show notification with animation
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);

        // Don't auto-hide success notifications - let user choose when to proceed
        return notification;
    }

    // Legacy close functions (no longer needed but kept for compatibility)
    function closeAlertModal() {
        // No longer needed - notifications auto-close
    }

    function closeSuccessModal() {
        // No longer needed - notifications auto-close
    }

    function proceedToLogin() {
        // Redirect to login page
        window.location.href = "{{ route('login_page') }}";
    }

    function openEulaModal() {
        const modal = document.getElementById('eulaModal');
        modal.classList.add('show');
        document.body.classList.add('modal-open');
    }

    function closeEulaModal() {
        const modal = document.getElementById('eulaModal');
        modal.classList.remove('show');
        document.body.classList.remove('modal-open');
    }

    function acceptEula() {
        document.getElementById('eula_agreement').checked = true;
        toggleNextButton();
        closeEulaModal();
    }

    function openPrivacyModal() {
        const modal = document.getElementById('privacyModal');
        modal.classList.add('show');
        document.body.classList.add('modal-open');
    }

    function closePrivacyModal() {
        const modal = document.getElementById('privacyModal');
        modal.classList.remove('show');
        document.body.classList.remove('modal-open');
    }

    function acceptPrivacy() {
        document.getElementById('eula_agreement').checked = true;
        toggleNextButton();
        closePrivacyModal();
    }

    function toggleNextButton() {
        const checkbox = document.getElementById('eula_agreement');
        const nextButton = document.getElementById('nextStepButton');
        nextButton.style.display = checkbox.checked ? 'block' : 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        var eulaModal = document.getElementById('eulaModal');
        var privacyModal = document.getElementById('privacyModal');

        if (event.target == eulaModal) {
            closeEulaModal();
        } else if (event.target == privacyModal) {
            closePrivacyModal();
        }
    }

    // Close modal when pressing Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const eulaModal = document.getElementById('eulaModal');
            const privacyModal = document.getElementById('privacyModal');

            if (eulaModal.classList.contains('show')) {
                closeEulaModal();
            } else if (privacyModal.classList.contains('show')) {
                closePrivacyModal();
            }
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Initialize the button state
        toggleNextButton();

        // Initialize Tax ID field based on default country
        const defaultCountry = document.getElementById('billingCountry').value;
        if (defaultCountry) {
            updateTaxIdField(defaultCountry);
        }

        // Initialize Tax ID field state
        const taxIdInput = document.getElementById('tax_id');
        if (taxIdInput) {
            if (taxIdInput.value) {
                // If there's existing input, validate it
                formatTaxId(taxIdInput);
                validateTaxIdRealTime(taxIdInput);
            } else {
                // If empty, show neutral state
                showTaxIdNeutral();
            }
        }

        // Check for success or error messages and show appropriate modals
        const successMessage = '{{ session("success") }}';
        const errorMessage = '{{ session("error") }}';

        if (successMessage) {
            setTimeout(function() {
                showSuccessModal();
            }, 100);
        }

        if (errorMessage) {
            setTimeout(function() {
                showAlertModal();
            }, 100);
        }
    });

    // Tax ID formatting and validation functions
    function formatTaxId(input) {
        const country = document.getElementById('billingCountry').value;
        let value = input.value.replace(/\D/g, ''); // Remove non-digits

        // Store cursor position
        const cursorPos = input.selectionStart;
        const originalLength = input.value.length;

        if (country === 'United States') {
            // US EIN/SSN format: XX-XXXXXXX (max 9 digits)
            if (value.length > 9) {
                value = value.substring(0, 9);
            }

            // Format with hyphen
            if (value.length >= 2) {
                value = value.substring(0, 2) + '-' + value.substring(2);
            }

            // Update maxlength for US format
            input.maxLength = 10;
        } else if (country === 'Canada') {
            // Canadian Business Number format: XXXXXXXX (max 9 digits)
            if (value.length > 9) {
                value = value.substring(0, 9);
            }

            // Update maxlength for Canadian format
            input.maxLength = 9;
        } else {
            // Generic format for other countries (max 15 characters)
            if (value.length > 15) {
                value = value.substring(0, 15);
            }

            // Update maxlength for generic format
            input.maxLength = 15;
        }

        // Set the formatted value
        input.value = value;

        // Restore cursor position intelligently
        if (country === 'United States' && value.includes('-')) {
            // For US format, calculate new cursor position accounting for hyphen
            let newPos = cursorPos;

            // If cursor was at position 2 or beyond, and we added a hyphen, adjust position
            if (cursorPos >= 2 && originalLength < value.length) {
                // A hyphen was added, so shift cursor position by 1
                newPos = cursorPos + 1;
            }

            // Ensure cursor position is within bounds
            newPos = Math.min(newPos, value.length);
            input.setSelectionRange(newPos, newPos);
        } else {
            // For other formats, maintain relative position
            const newPos = Math.min(cursorPos, value.length);
            input.setSelectionRange(newPos, newPos);
        }
    }

    function validateTaxId(input) {
        const country = document.getElementById('billingCountry').value;
        const value = input.value.replace(/\D/g, ''); // Remove non-digits
        const errorSpan = document.getElementById('tax_id_error');

        // Clear previous error
        errorSpan.classList.add('hidden');
        input.classList.remove('border-red-500');
        input.classList.add('border-primary');

        // Check if empty - now optional, so show neutral state for empty field
        if (value.length === 0) {
            showTaxIdNeutral(); // Show neutral state for empty optional field
            return true;
        }

        // Country-specific validation
        if (country === 'United States') {
            // US EIN/SSN validation
            if (value.length !== 9) {
                showTaxIdError('US Tax ID must be exactly 9 digits');
                return false;
            }

            if (!isValidUSEIN(value)) {
                showTaxIdError('Please enter a valid US Tax ID number');
                return false;
            }
        } else if (country === 'Canada') {
            // Canadian Business Number validation
            if (value.length !== 9) {
                showTaxIdError('Canadian Business Number must be exactly 9 digits');
                return false;
            }

            if (!isValidCanadianBN(value)) {
                showTaxIdError('Please enter a valid Canadian Business Number');
                return false;
            }
        } else {
            // Generic validation for other countries
            if (value.length < 5) {
                showTaxIdError('Tax ID must be at least 5 characters');
                return false;
            }

            if (value.length > 15) {
                showTaxIdError('Tax ID cannot exceed 15 characters');
                return false;
            }
        }

        // Show success state if validation passes
        showTaxIdSuccess();
        return true;
    }

    function showTaxIdError(message) {
        const errorSpan = document.getElementById('tax_id_error');
        const input = document.getElementById('tax_id');
        const statusIcon = document.getElementById('tax_id_icon');

        errorSpan.textContent = message;
        errorSpan.classList.remove('hidden');
        input.classList.remove('border-primary');
        input.classList.add('border-red-500');

        // Update status icon
        if (statusIcon) {
            statusIcon.textContent = '✗';
            statusIcon.className = 'text-red-500 text-sm font-bold';
        }
    }

    function showTaxIdSuccess() {
        const errorSpan = document.getElementById('tax_id_error');
        const input = document.getElementById('tax_id');
        const statusIcon = document.getElementById('tax_id_icon');

        errorSpan.classList.add('hidden');
        input.classList.remove('border-red-500');
        input.classList.add('border-green-500');

        // Update status icon
        if (statusIcon) {
            statusIcon.textContent = '✓';
            statusIcon.className = 'text-green-500 text-sm font-bold';
        }

        // Reset to primary border after a short delay
        setTimeout(() => {
            input.classList.remove('border-green-500');
            input.classList.add('border-primary');
            if (statusIcon) {
                statusIcon.textContent = '●';
                statusIcon.className = 'text-gray-300 text-sm';
            }
        }, 2000);
    }

    function showTaxIdNeutral() {
        const errorSpan = document.getElementById('tax_id_error');
        const input = document.getElementById('tax_id');
        const statusIcon = document.getElementById('tax_id_icon');

        errorSpan.classList.add('hidden');
        input.classList.remove('border-red-500', 'border-green-500');
        input.classList.add('border-primary');

        // Update status icon to neutral state
        if (statusIcon) {
            statusIcon.textContent = '●';
            statusIcon.className = 'text-gray-300 text-sm';
        }
    }

    function isValidUSEIN(ein) {
        // Remove any non-digits
        ein = ein.replace(/\D/g, '');

        // Must be exactly 9 digits
        if (ein.length !== 9) {
            return false;
        }

        // EIN cannot start with 0, 6, 7, 8, 9
        const firstDigit = parseInt(ein.charAt(0));
        if ([0, 6, 7, 8, 9].includes(firstDigit)) {
            return false;
        }

        // EIN cannot be all same digits
        if (/^(\d)\1{8}$/.test(ein)) {
            return false;
        }

        // Additional validation: Check for common invalid patterns
        const invalidPatterns = [
            '000000000', '111111111', '222222222', '333333333',
            '444444444', '555555555', '666666666', '777777777',
            '888888888', '999999999'
        ];

        if (invalidPatterns.includes(ein)) {
            return false;
        }

        return true;
    }

    function isValidCanadianBN(bn) {
        // Remove any non-digits
        bn = bn.replace(/\D/g, '');

        // Must be exactly 9 digits
        if (bn.length !== 9) {
            return false;
        }

        // Canadian BN cannot start with 0
        if (bn.charAt(0) === '0') {
            return false;
        }

        // BN cannot be all same digits
        if (/^(\d)\1{8}$/.test(bn)) {
            return false;
        }

        return true;
    }

    // Handle paste events for Tax ID field
    function handleTaxIdPaste(event) {
        event.preventDefault();
        const input = event.target;
        const pastedText = (event.clipboardData || window.clipboardData).getData('text');

        // Extract only digits from pasted content
        const digitsOnly = pastedText.replace(/\D/g, '');

        // Set the input value to digits only
        input.value = digitsOnly;

        // Format and validate the pasted content
        formatTaxId(input);
        validateTaxIdRealTime(input);

        // Focus the input
        input.focus();
    }

    // Real-time validation function
    function validateTaxIdRealTime(input) {
        const value = input.value.replace(/\D/g, '');
        const statusIcon = document.getElementById('tax_id_icon');

        // Clear previous styling
        input.classList.remove('border-red-500', 'border-green-500');
        input.classList.add('border-primary');

        if (value.length === 0) {
            // Show neutral state for empty optional field
            input.classList.remove('border-green-500', 'border-red-500');
            input.classList.add('border-primary');
            if (statusIcon) {
                statusIcon.textContent = '●';
                statusIcon.className = 'text-gray-300 text-sm';
            }
            return;
        }

        // Basic real-time validation
        const country = document.getElementById('billingCountry').value;
        let isValid = false;
        let isComplete = false;

        if (country === 'United States') {
            isComplete = value.length === 9;
            isValid = isComplete && isValidUSEIN(value);
        } else if (country === 'Canada') {
            isComplete = value.length === 9;
            isValid = isComplete && value.length === 9;
        } else {
            isComplete = value.length >= 5;
            isValid = isComplete && value.length <= 15;
        }

        // Update status icon in real-time
        if (statusIcon) {
            if (isValid) {
                statusIcon.textContent = '✓';
                statusIcon.className = 'text-green-500 text-sm font-bold';
            } else if (isComplete && !isValid) {
                statusIcon.textContent = '✗';
                statusIcon.className = 'text-red-500 text-sm font-bold';
            } else {
                // Still typing - show progress
                statusIcon.textContent = '●';
                statusIcon.className = 'text-blue-400 text-sm';
            }
        }
    }

    // Global function to open Privacy Policy modal (can be called from anywhere)
    function openPrivacyPolicyModal() {
        const modal = document.getElementById('privacyModal');
        if (modal) {
            modal.classList.add('show');
            document.body.classList.add('modal-open');
        }
    }

    // Function to update Tax ID field based on selected country
    function updateTaxIdField(country) {
        const taxIdInput = document.getElementById('tax_id');
        const helpText = taxIdInput.parentNode.querySelector('.text-xs.text-gray-600');

        if (country === 'United States') {
            taxIdInput.placeholder = 'XX-XXXXXXX';
            taxIdInput.maxLength = 10;
            if (helpText) {
                helpText.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Enter your 9-digit Tax ID (EIN/SSN) in format: XX-XXXXXXX (Optional)';
            }
        } else if (country === 'Canada') {
            taxIdInput.placeholder = 'XXXXXXXXX';
            taxIdInput.maxLength = 9;
            if (helpText) {
                helpText.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Enter your 9-digit Canadian Business Number (Optional)';
            }
        } else {
            taxIdInput.placeholder = 'Tax ID Number';
            taxIdInput.maxLength = 15;
            if (helpText) {
                helpText.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Enter your Tax ID number (5-15 characters) (Optional)';
            }
        }

        // Clear any existing errors
        const errorSpan = document.getElementById('tax_id_error');
        if (errorSpan) {
            errorSpan.classList.add('hidden');
        }
        taxIdInput.classList.remove('border-red-500', 'border-green-500');
        taxIdInput.classList.add('border-primary');

        // Reset status icon
        const statusIcon = document.getElementById('tax_id_icon');
        if (statusIcon) {
            statusIcon.textContent = '●';
            statusIcon.className = 'text-gray-300 text-sm';
        }
    }

    // Form validation function
    function validateForm() {
        const taxIdInput = document.getElementById('tax_id');
        const isValidTaxId = validateTaxId(taxIdInput);

        if (!isValidTaxId) {
            // Focus on the Tax ID field if validation fails
            taxIdInput.focus();
            return false;
        }

        return true;
    }
</script>

<!-- Location Dropdowns JavaScript -->
<script>
    // Wait for both DOM and jQuery to be ready
    $(document).ready(function() {
        console.log('DOM and jQuery loaded, initializing location dropdowns...');
        console.log('jQuery version:', $.fn.jquery);
        console.log('jQuery available:', typeof $ !== 'undefined');

        // Ensure jQuery is available
        if (typeof $ === 'undefined') {
            console.error('jQuery is not available! Cannot initialize Select2.');
            return;
        }

        // Ensure Select2 is available
        if (typeof $.fn.select2 === 'undefined') {
            console.error('Select2 is not available! Cannot initialize dropdowns.');
            return;
        }

        console.log('Select2 available:', typeof $.fn.select2 !== 'undefined');

        // Get session values for pre-selecting options
        const sessionBusinessType = '{{ session("business_type") }}';
        const sessionBillingCountry = '{{ session("billingCountry") }}';
        const sessionBillingState = '{{ session("billingState") }}';
        const sessionBillingCity = '{{ session("billingCity") }}';

        const countrySelect = document.getElementById('billingCountry');
        const stateSelect = document.getElementById('billingState');
        const citySelect = document.getElementById('billingCity');
        const businessTypeSelect = document.getElementById('business_type');

        // Check if elements exist
        if (!countrySelect) {
            console.error('Country select element not found!');
            return;
        }
        if (!stateSelect) {
            console.error('State select element not found!');
            return;
        }
        if (!citySelect) {
            console.error('City select element not found!');
            return;
        }
        if (!businessTypeSelect) {
            console.error('Business type select element not found!');
            return;
        }

        console.log('All select elements found, initializing Select2...');

        // Initialize Select2 for all dropdowns
        $(countrySelect).select2({
            placeholder: 'Select Country',
            allowClear: true,
            width: '100%',
            tags: false,
            minimumResultsForSearch: 0
        });

        $(stateSelect).select2({
            placeholder: 'Select State/Province',
            allowClear: true,
            width: '100%',
            tags: false,
            minimumResultsForSearch: 0
        });

        console.log('State Select2 initialized:', $(stateSelect).hasClass('select2-hidden-accessible'));

        $(citySelect).select2({
            placeholder: 'Select City',
            allowClear: true,
            width: '100%',
            tags: false,
            minimumResultsForSearch: 0
        });

        $(businessTypeSelect).select2({
            placeholder: 'Select Business Type',
            allowClear: true,
            width: '100%',
            tags: false,
            minimumResultsForSearch: 0
        });

        // Apply initial styling after Select2 initialization
        setTimeout(() => {
            $('.select2-container--default .select2-selection--single').css({
                'width': '100%',
                'height': '42px',
                'display': 'flex',
                'align-items': 'center',
                'outline': 'none',
                'box-shadow': 'none',
                'border': '2px solid var(--primary-color, #07382f)'
            });
        }, 200);

        // Load countries on page load with a small delay to ensure everything is ready
        setTimeout(() => {
            loadCountries();
            loadBusinessTypes();
        }, 100);

        // Debug: Check Select2 containers
        setTimeout(() => {
            console.log('State Select2 container:', $('.select2-container').length);
            console.log('State Select2 container for state:', $(stateSelect).next('.select2-container').length);
        }, 1000);

        // Function to reapply custom styling
        function reapplySelect2Styling() {
            $('.select2-container--default .select2-selection--single').css({
                'width': '100%',
                'height': '42px',
                'display': 'flex',
                'align-items': 'center',
                'outline': 'none',
                'box-shadow': 'none',
                'border': '2px solid var(--primary-color, #07382f)'
            });
        }

        // Event listeners
        $(countrySelect).on('change', function() {
            console.log('Country changed to:', this.value);

            // Reset state and city when country changes
            $(stateSelect).empty().append('<option value="">Select State/Province</option>');
            $(citySelect).empty().append('<option value="">Select City</option>');
            $(stateSelect).trigger('change');
            $(citySelect).trigger('change');

            // Load states after resetting
            if (this.value) {
                loadStates(this.value);
            }

            // Update Tax ID field based on country
            updateTaxIdField(this.value);

            // Clear Tax ID field when country changes to ensure proper validation
            const taxIdInput = document.getElementById('tax_id');
            if (taxIdInput) {
                taxIdInput.value = '';
                showTaxIdNeutral(); // Show neutral state when cleared
            }

            // Reapply styling after change
            setTimeout(reapplySelect2Styling, 100);
        });

        $(stateSelect).on('change', function() {
            console.log('State changed to:', this.value);

            if (this.value === 'no-state') {
                // If no state option is selected, load cities directly for the country
                loadCitiesForCountry(countrySelect.value);
            } else if (this.value) {
                loadCities(countrySelect.value, this.value);
            }
            // Reset city when state changes
            $(citySelect).empty().append('<option value="">Select City</option>');
            $(citySelect).trigger('change');

            // Reapply styling after change
            setTimeout(reapplySelect2Styling, 100);
        });

        $(businessTypeSelect).on('change', function() {
            console.log('Business type changed to:', this.value);
            // Reapply styling after change
            setTimeout(reapplySelect2Styling, 100);
        });

        // Function to load business types
        async function loadBusinessTypes() {
            console.log('Loading business types...');

            try {
                // Try to fetch from a business types API
                const response = await fetch('https://api.publicapis.org/entries?category=business&https=true');
                const data = await response.json();

                if (data.entries && data.entries.length > 0) {
                    // Extract business types from API entries
                    const businessTypes = data.entries
                        .map(entry => entry.API)
                        .filter((name, index, arr) => arr.indexOf(name) === index) // Remove duplicates
                        .slice(0, 50); // Limit to 50 entries

                    // Clear existing options
                    $(businessTypeSelect).empty();
                    $(businessTypeSelect).append('<option value="">Select Business Type</option>');

                    // Add business types
                    businessTypes.forEach(type => {
                        const option = new Option(type, type, false, false);
                        $(businessTypeSelect).append(option);
                    });

                    // Set session value if available
                    if (sessionBusinessType) {
                        $(businessTypeSelect).val(sessionBusinessType).trigger('change');
                    }

                    $(businessTypeSelect).trigger('change');
                    console.log('Business types loaded successfully from API');
                } else {
                    loadFallbackBusinessTypes();
                }
            } catch (error) {
                console.error('Error loading business types from API:', error);
                loadFallbackBusinessTypes();
            }
        }

        function loadFallbackBusinessTypes() {
            console.log('Loading fallback business types...');
            const fallbackBusinessTypes = [
                'Sole Proprietorship',
                'Partnership',
                'Limited Liability Company (LLC)',
                'Corporation (C-Corp)',
                'S-Corporation',
                'Non-Profit Organization',
                'Cooperative',
                'Franchise',
                'Joint Venture',
                'Professional Corporation',
                'Limited Partnership',
                'General Partnership',
                'Limited Liability Partnership (LLP)',
                'Business Trust',
                'Real Estate Investment Trust (REIT)',
                'Manufacturing',
                'Retail',
                'Wholesale',
                'Service',
                'Technology',
                'Healthcare',
                'Finance',
                'Consulting',
                'Construction',
                'Transportation',
                'Food & Beverage',
                'Entertainment',
                'Education',
                'Real Estate',
                'Insurance',
                'Legal Services',
                'Marketing & Advertising',
                'E-commerce',
                'Import/Export',
                'Agriculture',
                'Energy',
                'Telecommunications',
                'Media & Publishing',
                'Tourism & Hospitality',
                'Automotive',
                'Fashion & Apparel',
                'Sports & Recreation',
                'Non-Profit',
                'Government Contractor',
                'Startup',
                'Family Business',
                'Online Business',
                'Brick & Mortar',
                'Mobile Business',
                'Home-Based Business'
            ];

            // Clear existing options
            $(businessTypeSelect).empty();
            $(businessTypeSelect).append('<option value="">Select Business Type</option>');

            // Add business types
            fallbackBusinessTypes.forEach(type => {
                const option = new Option(type, type, false, false);
                $(businessTypeSelect).append(option);
            });

            // Set session value if available
            if (sessionBusinessType) {
                $(businessTypeSelect).val(sessionBusinessType).trigger('change');
            }

            $(businessTypeSelect).trigger('change');
            console.log('Fallback business types loaded');
        }

        // Function to get browser's country
        async function getBrowserCountry() {
            try {
                const response = await fetch('https://ipapi.co/json/');
                const data = await response.json();
                console.log('Browser location data:', data);
                return data.country_name || null;
            } catch (error) {
                console.log('Could not detect browser country:', error);
                return null;
            }
        }

        async function loadCountries() {
            console.log('Loading countries...');

            // Get browser country first
            const browserCountry = await getBrowserCountry();
            console.log('Browser country detected:', browserCountry);

            try {
                const response = await fetch('https://countriesnow.space/api/v0.1/countries');
                console.log('API response received');
                const data = await response.json();
                console.log('Countries data:', data);

                if (data.error === false && data.data) {
                    console.log('Loading', data.data.length, 'countries');

                    // Clear existing options
                    $(countrySelect).empty();

                    // Add browser country first if detected
                    if (browserCountry) {
                        const browserOption = new Option(browserCountry, browserCountry, false, false);
                        $(countrySelect).append(browserOption);
                    }

                    // Add all countries
                    data.data.forEach(country => {
                        if (!browserCountry || country.country !== browserCountry) {
                            const option = new Option(country.country, country.country, false, false);
                            $(countrySelect).append(option);
                        }
                    });

                    // Set session value if available
                    if (sessionBillingCountry) {
                        $(countrySelect).val(sessionBillingCountry).trigger('change');
                    } else if (browserCountry) {
                        $(countrySelect).val(browserCountry).trigger('change');
                    }

                    $(countrySelect).trigger('change');
                    console.log('Countries loaded successfully');
                } else {
                    console.error('API returned error:', data);
                    loadFallbackCountries(browserCountry);
                }
            } catch (error) {
                console.error('Error loading countries:', error);
                loadFallbackCountries(browserCountry);
            }
        }

        function loadFallbackCountries(browserCountry) {
            console.log('Loading fallback countries...');
            const fallbackCountries = ['United States', 'Canada', 'United Kingdom', 'Germany', 'France', 'Australia', 'Japan', 'Brazil', 'India', 'China', 'Singapore', 'Malta', 'Iceland', 'Luxembourg'];

            // Clear existing options
            $(countrySelect).empty();

            // Add browser country first if detected
            if (browserCountry && fallbackCountries.includes(browserCountry)) {
                const browserOption = new Option(browserCountry, browserCountry, false, true);
                $(countrySelect).append(browserOption);
            }

            // Add all countries
            fallbackCountries.forEach(country => {
                if (!browserCountry || country !== browserCountry) {
                    const option = new Option(country, country, false, false);
                    $(countrySelect).append(option);
                }
            });

            // Set session value if available
            if (sessionBillingCountry) {
                $(countrySelect).val(sessionBillingCountry).trigger('change');
            }

            $(countrySelect).trigger('change');
            console.log('Fallback countries loaded');
        }

        async function loadStates(country) {
            if (!country) return;

            console.log('Loading states for country:', country);
            console.log('State select element:', stateSelect);
            console.log('State select jQuery object:', $(stateSelect));

            $(stateSelect).prop('disabled', true);

            try {
                const response = await fetch(`https://countriesnow.space/api/v0.1/countries/states/q?country=${encodeURIComponent(country)}`);
                const data = await response.json();
                console.log('States data:', data);

                if (data.error === false && data.data && data.data.states && data.data.states.length > 0) {
                    console.log('Found', data.data.states.length, 'states for', country);
                    console.log('First few states:', data.data.states.slice(0, 3));

                    // Clear and add options
                    $(stateSelect).empty();
                    $(stateSelect).append('<option value="">Select State/Province</option>');

                    data.data.states.forEach((state, index) => {
                        console.log(`State ${index}:`, state);
                        console.log('State object keys:', Object.keys(state));
                        console.log('State name value:', state.name);
                        console.log('State name type:', typeof state.name);

                        // Use the correct property 'name' instead of 'state'
                        $(stateSelect).append(`<option value="${state.name}">${state.name}</option>`);
                    });

                    console.log('Options added to stateSelect. Current options:', $(stateSelect).find('option').length);
                    console.log('StateSelect HTML:', $(stateSelect).html());

                    // Set session value if available
                    if (sessionBillingState) {
                        $(stateSelect).val(sessionBillingState).trigger('change');
                    }

                    // Force Select2 to update with a small delay
                    setTimeout(() => {
                        $(stateSelect).trigger('change.select2');
                        console.log('Select2 change triggered');
                    }, 100);
                    console.log('States loaded successfully');
                } else {
                    console.log('No states found for this country, using no-state option');
                    loadNoStateOption();
                }
            } catch (error) {
                console.error('Error loading states:', error);
                loadFallbackStates(country);
            } finally {
                $(stateSelect).prop('disabled', false);
            }
        }

        function loadNoStateOption() {
            console.log('Loading no-state option for country without states');

            // Clear and add options
            $(stateSelect).empty();
            $(stateSelect).append('<option value="">Select State/Province</option>');

            // Use jQuery append with HTML string instead of Option constructor
            $(stateSelect).append('<option value="no-state">No State/Province (Direct to Cities)</option>');

            // Set session value if available
            if (sessionBillingState) {
                $(stateSelect).val(sessionBillingState).trigger('change');
            }

            // Force Select2 to update with a small delay
            setTimeout(() => {
                $(stateSelect).trigger('change.select2');
                console.log('Select2 change triggered for no-state option');
            }, 100);
        }

        function loadFallbackStates(country) {
            console.log('Loading fallback states for:', country);
            const fallbackStates = getFallbackStates(country);
            if (fallbackStates && fallbackStates.length > 0) {
                console.log('Loading', fallbackStates.length, 'fallback states for', country);

                // Clear and add options
                $(stateSelect).empty();
                $(stateSelect).append('<option value="">Select State/Province</option>');

                fallbackStates.forEach(state => {
                    console.log('Creating fallback option for state:', state);
                    // Use jQuery append with HTML string instead of Option constructor
                    $(stateSelect).append(`<option value="${state}">${state}</option>`);
                });

                // Set session value if available
                if (sessionBillingState) {
                    $(stateSelect).val(sessionBillingState).trigger('change');
                }

                // Force Select2 to update with a small delay
                setTimeout(() => {
                    $(stateSelect).trigger('change.select2');
                    console.log('Select2 change triggered for fallback states');
                }, 100);
                console.log('Fallback states loaded');
            } else {
                console.log('No fallback states available, using no-state option');
                loadNoStateOption();
            }
        }

        async function loadCities(country, state) {
            if (!country || !state) return;

            console.log('Loading cities for country:', country, 'state:', state);
            $(citySelect).prop('disabled', true);

            try {
                const response = await fetch(`https://countriesnow.space/api/v0.1/countries/state/cities/q?country=${encodeURIComponent(country)}&state=${encodeURIComponent(state)}`);
                const data = await response.json();
                console.log('Cities data:', data);

                if (data.error === false && data.data && data.data.length > 0) {
                    console.log('Cities data structure:', data.data[0]); // Log first city to see structure
                    $(citySelect).empty().append('<option value="">Select City</option>');
                    data.data.forEach(city => {
                        // Handle both string cities and object cities
                        const cityName = typeof city === 'string' ? city : city.name || city.city || city;
                        const option = new Option(cityName, cityName, false, false);
                        $(citySelect).append(option);
                    });

                    // Set session value if available
                    if (sessionBillingCity) {
                        $(citySelect).val(sessionBillingCity).trigger('change');
                    }

                    $(citySelect).trigger('change');
                    console.log('Cities loaded successfully');
                } else {
                    console.log('No cities found for this state, using fallback');
                    loadFallbackCities(country, state);
                }
            } catch (error) {
                console.error('Error loading cities:', error);
                loadFallbackCities(country, state);
            } finally {
                $(citySelect).prop('disabled', false);
            }
        }

        async function loadCitiesForCountry(country) {
            if (!country) return;

            console.log('Loading cities directly for country:', country);
            $(citySelect).prop('disabled', true);

            try {
                // Try to get cities for the country without specifying state
                const response = await fetch(`https://countriesnow.space/api/v0.1/countries/cities/q?country=${encodeURIComponent(country)}`);
                const data = await response.json();
                console.log('Cities for country data:', data);

                if (data.error === false && data.data && data.data.length > 0) {
                    console.log('Cities for country data structure:', data.data[0]); // Log first city to see structure
                    $(citySelect).empty().append('<option value="">Select City</option>');
                    data.data.forEach(city => {
                        // Handle both string cities and object cities
                        const cityName = typeof city === 'string' ? city : city.name || city.city || city;
                        const option = new Option(cityName, cityName, false, false);
                        $(citySelect).append(option);
                    });

                    // Set session value if available
                    if (sessionBillingCity) {
                        $(citySelect).val(sessionBillingCity).trigger('change');
                    }

                    $(citySelect).trigger('change');
                    console.log('Cities for country loaded successfully');
                } else {
                    console.log('No cities found for country, using fallback');
                    loadFallbackCitiesForCountry(country);
                }
            } catch (error) {
                console.error('Error loading cities for country:', error);
                loadFallbackCitiesForCountry(country);
            } finally {
                $(citySelect).prop('disabled', false);
            }
        }

        function loadFallbackCities(country, state) {
            console.log('Loading fallback cities for:', country, state);
            const fallbackCities = getFallbackCities(country, state);
            if (fallbackCities && fallbackCities.length > 0) {
                $(citySelect).empty().append('<option value="">Select City</option>');
                fallbackCities.forEach(city => {
                    const option = new Option(city, city, false, false);
                    $(citySelect).append(option);
                });

                // Set session value if available
                if (sessionBillingCity) {
                    $(citySelect).val(sessionBillingCity).trigger('change');
                }

                $(citySelect).trigger('change');
                console.log('Fallback cities loaded');
            } else {
                $(citySelect).empty().append('<option value="">No cities available</option>');
                $(citySelect).trigger('change');
            }
        }

        function loadFallbackCitiesForCountry(country) {
            console.log('Loading fallback cities for country:', country);
            const fallbackCities = getFallbackCitiesForCountry(country);
            if (fallbackCities && fallbackCities.length > 0) {
                $(citySelect).empty().append('<option value="">Select City</option>');
                fallbackCities.forEach(city => {
                    const option = new Option(city, city, false, false);
                    $(citySelect).append(option);
                });

                // Set session value if available
                if (sessionBillingCity) {
                    $(citySelect).val(sessionBillingCity).trigger('change');
                }

                $(citySelect).trigger('change');
                console.log('Fallback cities for country loaded');
            } else {
                $(citySelect).empty().append('<option value="">No cities available</option>');
                $(citySelect).trigger('change');
            }
        }

        function getFallbackStates(country) {
            const fallbackData = {
                'United States': ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'],
                'Canada': ['Alberta', 'British Columbia', 'Manitoba', 'New Brunswick', 'Newfoundland and Labrador', 'Northwest Territories', 'Nova Scotia', 'Nunavut', 'Ontario', 'Prince Edward Island', 'Quebec', 'Saskatchewan', 'Yukon'],
                'United Kingdom': ['England', 'Scotland', 'Wales', 'Northern Ireland'],
                'Germany': ['Baden-Württemberg', 'Bavaria', 'Berlin', 'Brandenburg', 'Bremen', 'Hamburg', 'Hesse', 'Lower Saxony', 'Mecklenburg-Vorpommern', 'North Rhine-Westphalia', 'Rhineland-Palatinate', 'Saarland', 'Saxony', 'Saxony-Anhalt', 'Schleswig-Holstein', 'Thuringia'],
                'France': ['Auvergne-Rhône-Alpes', 'Bourgogne-Franche-Comté', 'Bretagne', 'Centre-Val de Loire', 'Corse', 'Grand Est', 'Hauts-de-France', 'Île-de-France', 'Normandie', 'Nouvelle-Aquitaine', 'Occitanie', 'Pays de la Loire', 'Provence-Alpes-Côte d\'Azur'],
                'Australia': ['New South Wales', 'Victoria', 'Queensland', 'Western Australia', 'South Australia', 'Tasmania', 'Australian Capital Territory', 'Northern Territory'],
                'India': ['Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'],
                'Brazil': ['Acre', 'Alagoas', 'Amapá', 'Amazonas', 'Bahia', 'Ceará', 'Distrito Federal', 'Espírito Santo', 'Goiás', 'Maranhão', 'Mato Grosso', 'Mato Grosso do Sul', 'Minas Gerais', 'Pará', 'Paraíba', 'Paraná', 'Pernambuco', 'Piauí', 'Rio de Janeiro', 'Rio Grande do Norte', 'Rio Grande do Sul', 'Rondônia', 'Roraima', 'Santa Catarina', 'São Paulo', 'Sergipe', 'Tocantins'],
                'China': ['Anhui', 'Beijing', 'Chongqing', 'Fujian', 'Gansu', 'Guangdong', 'Guangxi', 'Guizhou', 'Hainan', 'Hebei', 'Heilongjiang', 'Henan', 'Hubei', 'Hunan', 'Inner Mongolia', 'Jiangsu', 'Jiangxi', 'Jilin', 'Liaoning', 'Ningxia', 'Qinghai', 'Shaanxi', 'Shandong', 'Shanghai', 'Shanxi', 'Sichuan', 'Tianjin', 'Tibet', 'Xinjiang', 'Yunnan', 'Zhejiang']
            };
            return fallbackData[country] || null;
        }

        function getFallbackCities(country, state) {
            const fallbackData = {
                'United States': {
                    'California': ['Los Angeles', 'San Francisco', 'San Diego', 'Sacramento', 'Fresno', 'Long Beach', 'Oakland', 'Bakersfield', 'Anaheim', 'Santa Ana'],
                    'New York': ['New York City', 'Buffalo', 'Rochester', 'Syracuse', 'Albany', 'Yonkers', 'New Rochelle', 'Mount Vernon', 'Schenectady', 'Utta'],
                    'Texas': ['Houston', 'Dallas', 'Austin', 'San Antonio', 'Fort Worth', 'El Paso', 'Arlington', 'Corpus Christi', 'Plano', 'Lubbock'],
                    'Florida': ['Miami', 'Orlando', 'Tampa', 'Jacksonville', 'Fort Lauderdale', 'Tallahassee', 'Gainesville', 'Pensacola', 'Daytona Beach', 'Key West']
                },
                'Canada': {
                    'Ontario': ['Toronto', 'Ottawa', 'Mississauga', 'Brampton', 'Hamilton', 'London', 'Windsor', 'Kitchener', 'Vaughan', 'Markham'],
                    'Quebec': ['Montreal', 'Quebec City', 'Laval', 'Gatineau', 'Longueuil', 'Sherbrooke', 'Saguenay', 'Levis', 'Trois-Rivieres', 'Terrebonne'],
                    'British Columbia': ['Vancouver', 'Surrey', 'Burnaby', 'Richmond', 'Abbotsford', 'Coquitlam', 'Kelowna', 'Nanaimo', 'Kamloops', 'Prince George']
                }
            };

            return fallbackData[country]?.[state] || null;
        }

        function getFallbackCitiesForCountry(country) {
            const fallbackData = {
                'Singapore': ['Singapore', 'Jurong West', 'Woodlands', 'Tampines', 'Sengkang', 'Hougang', 'Yishun', 'Punggol', 'Ang Mo Kio', 'Bukit Batok'],
                'Malta': ['Valletta', 'Birkirkara', 'Mosta', 'Qormi', 'Zabbar', 'Sliema', 'St. Paul\'s Bay', 'Fgura', 'Zejtun', 'Hamrun'],
                'Iceland': ['Reykjavik', 'Kopavogur', 'Hafnarfjordur', 'Akureyri', 'Reykjanesbaer', 'Gardabaer', 'Mosfellsbaer', 'Arborg', 'Akranes', 'Fjardabyggd'],
                'Luxembourg': ['Luxembourg City', 'Esch-sur-Alzette', 'Differdange', 'Dudelange', 'Ettelbruck', 'Diekirch', 'Wiltz', 'Echternach', 'Rumelange', 'Grevenmacher']
            };

            return fallbackData[country] || null;
        }
    });
</script>

{{-- <script>
        const buyerButton = document.getElementById('buyerButton');
        const sellerButton = document.getElementById('sellerButton');
        const buyerForm = document.getElementById('buyerForm');
        const sellerForm = document.getElementById('sellerForm');

        buyerButton.addEventListener('click', () => {
            buyerForm.style.display = 'block';
            sellerForm.style.display = 'none';
        });

        sellerButton.addEventListener('click', () => {
            sellerForm.style.display = 'block';
            buyerForm.style.display = 'none';
        });
    </script> --}}

@endsection