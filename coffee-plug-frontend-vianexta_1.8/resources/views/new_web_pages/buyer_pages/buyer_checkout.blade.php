@php
// Check if user session has expired
if (session('auth_user_tokin') == null) {
    header('Location: ' . route('login_page'));
    exit();
}

// Check if cart is empty - redirect to marketplace
if (!isset($cart_items) || !is_array($cart_items) || count($cart_items) < 1) {
    header('Location: ' . route('buyer_market_place'));
    exit();
}
@endphp

@extends('layouts.new_home_layout')
@section('title', 'Checkout - CoPlug')
@push('css')
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/clare-component.css') }}">
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Inter', Arial, sans-serif;
        line-height: 1.6;
    }

    .checkout-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .checkout-header {
        text-align: center;
        margin-bottom: 30px;
        padding: 20px 0;
        background: linear-gradient(135deg, #1A4D3A 0%, #2d7a5f 100%);
        color: white;
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .checkout-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .checkout-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .checkout-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .checkout-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        border: 1px solid #e9ecef;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1A4D3A;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
    }

    /* Cart Items Styling */
    .cart-items {
        max-height: 500px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .cart-item {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .cart-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .cart-item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e9ecef;
    }

    .cart-item-details h6 {
        color: #1A4D3A;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .cart-item-details p {
        color: #6c757d;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }

    .cart-item-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1A4D3A;
    }

    /* Price Summary Styling */
    .price-summary {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #dee2e6;
    }

    .price-row:last-child {
        border-bottom: none;
        font-weight: 700;
        font-size: 1.2rem;
        color: #1A4D3A;
        padding-top: 15px;
        margin-top: 15px;
        border-top: 2px solid #1A4D3A;
    }

    /* Checkout Buttons Styling */
    .checkout-buttons {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 30px;
    }

    .checkout-btn {
        width: 100%;
        height: 80px;
        /* Reduced from 100px to 80px */
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

    .btn-paypal {
        background: linear-gradient(135deg, #ffc439 0%, #f4b31d 100%);
        color: #000;
        border: 2px solid #f4b31d;
        position: relative;
        overflow: hidden;
    }

    .btn-paypal:hover {
        background: linear-gradient(135deg, #f4b31d 0%, #e6a800 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(244, 179, 29, 0.4);
        border-color: #e6a800;
    }

    .btn-paypal img {
        width: 120px !important;
        /* Increased from 80px to 120px */
        height: 120px !important;
        /* Increased from 80px to 120px */
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.15));
        transition: all 0.3s ease;
    }

    .btn-paypal:hover img {
        transform: scale(1.1);
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    }

    .btn-paypal-crypto {
        background: linear-gradient(135deg, #6c5ce7 0%, #5a4fcf 100%);
        color: #fff;
        border: 2px solid #5a4fcf;
        position: relative;
        overflow: hidden;
    }

    .btn-paypal-crypto:hover {
        background: linear-gradient(135deg, #5a4fcf 0%, #4c3fb8 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4);
        border-color: #4c3fb8;
    }

    .btn-paypal-crypto img {
        width: 40px !important;
        height: 40px !important;
        filter: brightness(0) invert(1);
        transition: all 0.3s ease;
    }

    .btn-paypal-crypto:hover img {
        transform: scale(1.1);
    }

    .checkout-btn span {
        font-size: 1.1rem;
        font-weight: 600;
        margin-left: 10px;
    }

    .divider {
        text-align: center;
        margin: 25px 0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #dee2e6;
    }

    .divider span {
        background: white;
        padding: 0 20px;
        color: #6c757d;
        font-weight: 500;
    }

    /* Form Styling */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #1A4D3A;
        box-shadow: 0 0 0 3px rgba(26, 77, 58, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 5px;
    }

    /* Enhanced Select Styling */
    select.form-control {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px 12px;
        padding-right: 40px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    /* Alert Styling */
    .alert {
        border-radius: 8px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    /* Hide shipping fields when checkbox is checked */
    .shipping-fields-hidden {
        display: none !important;
    }

    /* Smooth transition for hiding/showing fields */
    .shipping-section .form-group {
        transition: all 0.3s ease;
    }

    /* Enhanced checkbox styling */
    #sameAsBilling {
        transform: scale(1.2);
        margin-right: 8px;
    }

    #sameAsBilling:checked {
        background-color: #1A4D3A;
        border-color: #1A4D3A;
    }

    .form-check-label {
        cursor: pointer;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .form-check.text-success .form-check-label {
        color: #1A4D3A !important;
    }

    .form-check.text-success #sameAsBilling {
        background-color: #1A4D3A;
        border-color: #1A4D3A;
    }

    .alert-info {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
        color: #0c5460;
        border-left: 4px solid #17a2b8;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        color: #856404;
        border-left: 4px solid #ffc107;
    }

    /* Complete Purchase Button */
    .btn-complete-purchase {
        width: 100%;
        height: 50px;
        background: linear-gradient(135deg, #1A4D3A 0%, #2d7a5f 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-complete-purchase:hover {
        background: linear-gradient(135deg, #0f3d2a 0%, #1A4D3A 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(26, 77, 58, 0.3);
    }

    /* Zipcode Search Suggestions */
    .zipcode-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        margin-top: 2px;
    }

    .zipcode-suggestion-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f8f9fa;
        transition: background-color 0.2s;
    }

    .zipcode-suggestion-item:hover,
    .zipcode-suggestion-item.active {
        background-color: #f8f9fa;
    }

    .zipcode-suggestion-item:last-child {
        border-bottom: none;
    }

    .zipcode-suggestion-item .zipcode {
        font-weight: 600;
        color: #1A4D3A;
    }

    .zipcode-suggestion-item .location {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .checkout-container {
            padding: 15px;
        }

        .checkout-header h1 {
            font-size: 2rem;
        }

        .checkout-section {
            padding: 20px;
        }

        .cart-item {
            padding: 15px;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
        }
    }

    /* Empty Cart Styling */
    .empty-cart {
        text-align: center;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        border: 2px dashed #dee2e6;
    }

    .empty-cart h5 {
        color: #6c757d;
        margin-bottom: 15px;
    }

    .empty-cart p {
        color: #868e96;
        margin-bottom: 20px;
    }

    .btn-continue-shopping {
        background: linear-gradient(135deg, #1A4D3A 0%, #2d7a5f 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-continue-shopping:hover {
        background: linear-gradient(135deg, #0f3d2a 0%, #1A4D3A 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(26, 77, 58, 0.3);
        color: white;
        text-decoration: none;
    }

    /* Navbar Styles */
    .checkout-navbar {
        background: #fff;
        border-bottom: 1px solid #e9ecef;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 70px;
    }

    .nav-logo img {
        height: 40px;
        width: auto;
    }

    .nav-center {
        flex: 1;
        display: flex;
        justify-content: center;
    }

    .nav-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .nav-action {
        color: #374151;
        text-decoration: none;
        padding: 8px 16px;
        font-size: 0.9rem;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.3s ease;
        border: none;
        background: none;
        cursor: pointer;
    }

    .nav-action.signin {
        border: 1px solid #d1d5db;
        background: none;
    }

    .nav-action.signin:hover {
        border-color: #9ca3af;
        background: #f9fafb;
    }

    .nav-action.contact {
        background: #1A4D3A;
        color: #fff;
    }

    .nav-action.contact:hover {
        background: #0f3d2a;
        transform: translateY(-1px);
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .profile-name {
        text-align: right;
    }

    .profile-name .user-name {
        color: #374151;
        font-weight: 600;
        font-size: 0.9rem;
        display: block;
    }

    .profile-name .user-role {
        color: #6b7280;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }

    .profile-name .user-role.buyer {
        color: #059669;
        background: #d1fae5;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
    }

    .profile-name .user-role.seller {
        color: #dc2626;
        background: #fee2e2;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
    }

    /* Shipping and Billing Sections */
    .shipping-section,
    .billing-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
    }

    .shipping-section h5,
    .billing-section h5 {
        color: #1A4D3A;
        font-size: 1.1rem;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid #1A4D3A;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 6px;
        font-size: 0.9rem;
    }

    .form-control {
        padding: 10px 12px;
        font-size: 0.9rem;
    }

    .form-check {
        margin-bottom: 0;
    }

    .form-check-input:checked {
        background-color: #1A4D3A;
        border-color: #1A4D3A;
    }

    .form-check-label {
        font-weight: 500;
        color: #495057;
        font-size: 0.9rem;
    }

    .nav-icons {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .nav-icon,
    .cart-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #ffffff;
        color: #374151;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .nav-icon:hover,
    .cart-icon:hover {
        background-color: #f9fafb;
        color: #1A4D3A;
        border-color: #1A4D3A;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(26, 77, 58, 0.15);
    }

    .cart-icon-container {
        position: relative;
    }

    .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #1A4D3A;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 600;
        border: 2px solid white;
    }

    /* Responsive navbar */
    @media (max-width: 768px) {
        .navbar-container {
            padding: 0 15px;
            height: 60px;
        }

        .nav-logo img {
            height: 32px;
        }

        .nav-actions {
            gap: 10px;
        }

        .nav-action {
            padding: 6px 12px;
            font-size: 0.8rem;
        }

        .user-menu {
            gap: 10px;
        }

        .nav-icons {
            gap: 8px;
        }

        .nav-icon,
        .cart-icon {
            width: 32px;
            height: 32px;
        }

        .profile-name .user-name {
            font-size: 0.8rem;
        }

        .profile-name .user-role {
            font-size: 0.65rem;
        }
    }
</style>
@endpush

@section('content')

<!-- Navigation Bar -->
<nav class="checkout-navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <div class="nav-logo">
            <a href="{{ route('home_page') }}">
                <img src="{{ asset('new_landing_assets/logo.png') }}" alt="CoPlug Logo">
            </a>
        </div>
        <!-- Centered Navigation Menu -->
        <div class="nav-center">
            <div class="nav-links">
                <!-- Navigation links can be added here if needed -->
            </div>
        </div>
        <!-- Action Buttons -->
        <div class="nav-actions">
            @if(session('auth_user_tokin') == null)
            <a href="{{ route('login_page') }}" class="nav-action signin">Sign In</a>
            <a href="#contact" class="nav-action contact">Get in touch</a>
            @else
            <div class="user-menu">
                <div class="profile-name">
                    <span class="user-name">{{ session('auth_user_name') }}</span>
                    <div class="user-role {{ strtolower(session('auth_user_role')) }}">{{ session('auth_user_role') }}</div>
                </div>
                <div class="nav-icons">
                    <a href="{{ session('auth_user_role') == 'Buyer' ? route('buyerDashboard') : route('sellersDashboardHome') }}" class="nav-icon dashboard" title="Dashboard">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 20.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <a href="{{ session('auth_user_role') == 'Buyer' ? route('buyer_new_wizard') : route('sellers_add_product') }}" class="nav-icon marketplace" title="{{ session('auth_user_role') == 'Buyer' ? 'Marketplace' : 'Add Product' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.7 15.3C4.3 15.7 4.6 16.5 5.1 16.5H17M17 13V17C17 17.6 16.6 18 16 18H8C7.4 18 7 17.6 7 17V13H17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <div class="cart-icon-container">
                        <a href="{{ session('auth_user_role') == 'Buyer' ? route('buyer_cart') : route('sellersDashboardHome') }}" class="cart-icon" title="{{ session('auth_user_role') == 'Buyer' ? 'Cart' : 'Orders' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            @if(session('auth_user_role') == 'Buyer' && isset($cart_items) && count($cart_items) > 0)
                            <span class="cart-count">{{ count($cart_items) }}</span>
                            @endif
                        </a>
                    </div>
                    <a href="{{ route('logout') }}" class="nav-icon" title="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</nav>

<!-- Checkout Header -->
<div class="checkout-header">
    <div class="checkout-container">
        <h1>Complete Your Order</h1>
        <p>Review your items and provide billing information to complete your purchase</p>
    </div>
</div>

<div class="checkout-container">
    <div class="checkout-grid">
        <!-- Left Column - Cart Items & Summary -->
        <div class="checkout-section">
            <h2 class="section-title">Order Summary</h2>

            @php
            $total_price = 0;
            $isRoast = false;
            $roast_price = 10.0;
            $bag_price = 0.53;
            $package_price = 0;
            @endphp

            @if(isset($cart_items) && is_array($cart_items) && count($cart_items) > 0)
            <div class="cart-items">
                @foreach($cart_items as $cart_item)
                @php
                $total_price = $total_price + ($cart_item->stockPosting->bagPrice * $cart_item->numBags);

                if($cart_item->isRoast){
                $isRoast = true;
                $bag_price = 0.53;

                if($cart_item->bagSize == 'oz_frac_pack'){
                $bag_price = 1.10;
                } else if($cart_item->bagSize == 'lb'){
                $bag_price = 0.96;
                } else if($cart_item->bagSize == 'k_cup'){
                $bag_price = 1.05;
                }

                $package_price += (double)$cart_item->numBags * $bag_price;
                }
                @endphp

                <div class="cart-item">
                    <div class="row align-items-center">
                        <div class="col-md-3 col-xs-3">
                            <img src="{{ $cart_item->stockPosting->imageUrl != null ? urldecode($cart_item->stockPosting->imageUrl) : asset('images/market_place/prod_sub.png') }}"
                                class="cart-item-image" alt="Product Image">
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="cart-item-details">
                                <h6>ORDER #{{$cart_item->stockPosting->id}}</h6>
                                <p><strong>Product:</strong> {{$cart_item->stockPosting->supplierInfo->firstName == 'Win' || $cart_item->stockPosting->productType == 'whole_sale_brand' ? strtoupper($cart_item->stockPosting->description) : (isset($cart_item->stockPosting->name) ? $cart_item->stockPosting->name : ($cart_item->stockPosting->description != null ? $cart_item->stockPosting->description : 'Product Name'))}}</p>
                                <p><strong>Quantity:</strong> {{$cart_item->numBags}} bags</p>
                                @if($cart_item->stockPosting->productType != 'whole_sale_brand')
                                <p><strong>Package:</strong> {{$cart_item->stockPosting->bagWeight}} lb</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-3 text-end">
                            <div class="cart-item-price">
                                ${{$helper->formatMoney($cart_item->stockPosting->bagPrice * $cart_item->numBags * $cart_item->stockPosting->bagWeight)}}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Price Summary -->
            <div class="price-summary">
                <div class="price-row">
                    <span>Sub Total:</span>
                    <span>${{$helper->formatMoney(isset($price_breakdown->itemsPriceTotal) ? $price_breakdown->itemsPriceTotal : "0.0")}}</span>
                </div>
                <div class="price-row">
                    <span>Coordination Fee:</span>
                    <span>${{$helper->formatMoney(isset($price_breakdown->cooperativeFee) ? $price_breakdown->cooperativeFee : "0.0")}}</span>
                </div>
                <div class="price-row">
                    <span><strong>TOTAL:</strong></span>
                    <span><strong>${{$helper->formatMoney(isset($price_breakdown->totalPrice) ? $price_breakdown->totalPrice : "0.0")}}</strong></span>
                </div>
            </div>
            @else
            <div class="empty-cart">
                <h5>No items in cart</h5>
                <p>Please add items to your cart before proceeding to checkout.</p>
                <a href="{{ route('buyer_market_place') }}" class="btn-continue-shopping">Continue Shopping</a>
            </div>
            @endif
        </div>

        <!-- Right Column - Checkout Options, Shipping & Billing -->
        <div class="checkout-section">
            <h2 class="section-title">Payment & Shipping</h2>

            @if(isset($cart_items) && count($cart_items) > 0)
            <form action="{{ route('cartCheckout') }}" method="POST" id="checkoutForm">
            @csrf
            <!-- Billing Details -->
            <div class="billing-section mb-4">
                <h5 class="mb-3 fw-bold">Billing Details</h5>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(isset($profile_data->shippingAddressLine1) && $profile_data->shippingAddressLine1)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Your billing information has been prepopulated with your shipping address. You can modify these details if needed.
                </div>
                @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Please fill in your billing information. You can save your address in your profile for future checkouts.
                </div>
                @endif

                <div class="form-group">
                    <label class="form-label" for="addressLine1">Address Line 1 *</label>
                    <input type="text" id="addressLine1" name="addressLine1" autocomplete="address-line1"
                        placeholder="Enter your street address"
                        value="{{ isset($profile_data->shippingAddressLine1) ? $profile_data->shippingAddressLine1 : (empty(session('addressLine1')) ? old('addressLine1') : session('addressLine1')) }}"
                        class="form-control @error('addressLine1') is-invalid @enderror" required>
                    @if ($errors->has('addressLine1'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('addressLine1') }}</strong>
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label" for="addressLine2">Address Line 2</label>
                    <input type="text" id="addressLine2" name="addressLine2" autocomplete="address-line2"
                        placeholder="Apartment, suite, etc. (optional)"
                        value="{{ isset($profile_data->shippingAddressLine2) ? $profile_data->shippingAddressLine2 : (empty(session('addressLine2')) ? old('addressLine2') : session('addressLine2')) }}"
                        class="form-control @error('addressLine2') is-invalid @enderror">
                    @if ($errors->has('addressLine2'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('addressLine2') }}</strong>
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label" for="country">Country *</label>
                    <select id="country" name="country" class="form-control no-select2 @error('country') is-invalid @enderror" autocomplete="country" required>
                        <option value="">Select Country</option>
                        <option value="United States" selected>United States</option>
                    </select>
                    @if ($errors->has('country'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('country') }}</strong>
                    </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="state">State/Province *</label>
                            <select id="state" name="state" class="form-control no-select2 @error('state') is-invalid @enderror" autocomplete="address-level1" required>
                                <option value="">Select State/Province</option>
                                <option value="Alabama">Alabama</option>
                                <option value="Alaska">Alaska</option>
                                <option value="Arizona">Arizona</option>
                                <option value="Arkansas">Arkansas</option>
                                <option value="California">California</option>
                                <option value="Colorado">Colorado</option>
                                <option value="Connecticut">Connecticut</option>
                                <option value="Delaware">Delaware</option>
                                <option value="Florida">Florida</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Hawaii">Hawaii</option>
                                <option value="Idaho">Idaho</option>
                                <option value="Illinois">Illinois</option>
                                <option value="Indiana">Indiana</option>
                                <option value="Iowa">Iowa</option>
                                <option value="Kansas">Kansas</option>
                                <option value="Kentucky">Kentucky</option>
                                <option value="Louisiana">Louisiana</option>
                                <option value="Maine">Maine</option>
                                <option value="Maryland">Maryland</option>
                                <option value="Massachusetts">Massachusetts</option>
                                <option value="Michigan">Michigan</option>
                                <option value="Minnesota">Minnesota</option>
                                <option value="Mississippi">Mississippi</option>
                                <option value="Missouri">Missouri</option>
                                <option value="Montana">Montana</option>
                                <option value="Nebraska">Nebraska</option>
                                <option value="Nevada">Nevada</option>
                                <option value="New Hampshire">New Hampshire</option>
                                <option value="New Jersey">New Jersey</option>
                                <option value="New Mexico">New Mexico</option>
                                <option value="New York">New York</option>
                                <option value="North Carolina">North Carolina</option>
                                <option value="North Dakota">North Dakota</option>
                                <option value="Ohio">Ohio</option>
                                <option value="Oklahoma">Oklahoma</option>
                                <option value="Oregon">Oregon</option>
                                <option value="Pennsylvania">Pennsylvania</option>
                                <option value="Rhode Island">Rhode Island</option>
                                <option value="South Carolina">South Carolina</option>
                                <option value="South Dakota">South Dakota</option>
                                <option value="Tennessee">Tennessee</option>
                                <option value="Texas">Texas</option>
                                <option value="Utah">Utah</option>
                                <option value="Vermont">Vermont</option>
                                <option value="Virginia">Virginia</option>
                                <option value="Washington">Washington</option>
                                <option value="West Virginia">West Virginia</option>
                                <option value="Wisconsin">Wisconsin</option>
                                <option value="Wyoming">Wyoming</option>
                                <option value="District of Columbia">District of Columbia</option>
                            </select>
                            @if ($errors->has('state'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('state') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="city">City *</label>
                            <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror" 
                                placeholder="Enter your city" autocomplete="address-level2" 
                                value="{{ old('city', isset($profile_data) && isset($profile_data->billingCity) ? $profile_data->billingCity : '') }}" required>
                            @if ($errors->has('city'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('city') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="zipCode">ZIP/Postal Code *</label>
                    <div class="position-relative">
                        <input type="text" id="zipCode" name="zipCode" class="form-control @error('zipCode') is-invalid @enderror" 
                            placeholder="Search or enter ZIP/Postal Code" 
                            value="{{ old('zipCode', isset($profile_data) && isset($profile_data->billingZipCode) ? $profile_data->billingZipCode : '') }}" 
                            autocomplete="off" required>
                        <div id="zipCodeSuggestions" class="zipcode-suggestions" style="display: none;"></div>
                    </div>
                    @if ($errors->has('zipCode'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('zipCode') }}</strong>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Shipping Details -->
            <div class="shipping-section mb-4">
                <h5 class="mb-3 fw-bold">Shipping Details</h5>

                <div class="form-group mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sameAsBilling">
                        <label class="form-check-label" for="sameAsBilling">
                            <i class="fas fa-copy me-2"></i>Use same address for shipping and billing
                        </label>
                    </div>
                </div>

                <div id="shippingFieldsContainer">
                <div class="form-group">
                    <label class="form-label" for="shippingAddressLine1">Shipping Address Line 1 *</label>
                    <input type="text" id="shippingAddressLine1" name="shippingAddressLine1" autocomplete="shipping address-line1"
                        placeholder="Enter your shipping address"
                        value="{{ isset($profile_data->shippingAddressLine1) ? $profile_data->shippingAddressLine1 : '' }}"
                        class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="shippingAddressLine2">Shipping Address Line 2</label>
                    <input type="text" id="shippingAddressLine2" name="shippingAddressLine2" autocomplete="shipping address-line2"
                        placeholder="Apartment, suite, etc. (optional)"
                        value="{{ isset($profile_data->shippingAddressLine2) ? $profile_data->shippingAddressLine2 : '' }}"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label" for="shippingCountry">Shipping Country *</label>
                    <select id="shippingCountry" name="shippingCountry" class="form-control no-select2" autocomplete="shipping country" required>
                        <option value="">Select Country</option>
                        <option value="United States" selected>United States</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="shippingState">Shipping State/Province *</label>
                            <select id="shippingState" name="shippingState" class="form-control no-select2" autocomplete="shipping address-level1" required>
                                <option value="">Select State/Province</option>
                                <option value="Alabama">Alabama</option>
                                <option value="Alaska">Alaska</option>
                                <option value="Arizona">Arizona</option>
                                <option value="Arkansas">Arkansas</option>
                                <option value="California">California</option>
                                <option value="Colorado">Colorado</option>
                                <option value="Connecticut">Connecticut</option>
                                <option value="Delaware">Delaware</option>
                                <option value="Florida">Florida</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Hawaii">Hawaii</option>
                                <option value="Idaho">Idaho</option>
                                <option value="Illinois">Illinois</option>
                                <option value="Indiana">Indiana</option>
                                <option value="Iowa">Iowa</option>
                                <option value="Kansas">Kansas</option>
                                <option value="Kentucky">Kentucky</option>
                                <option value="Louisiana">Louisiana</option>
                                <option value="Maine">Maine</option>
                                <option value="Maryland">Maryland</option>
                                <option value="Massachusetts">Massachusetts</option>
                                <option value="Michigan">Michigan</option>
                                <option value="Minnesota">Minnesota</option>
                                <option value="Mississippi">Mississippi</option>
                                <option value="Missouri">Missouri</option>
                                <option value="Montana">Montana</option>
                                <option value="Nebraska">Nebraska</option>
                                <option value="Nevada">Nevada</option>
                                <option value="New Hampshire">New Hampshire</option>
                                <option value="New Jersey">New Jersey</option>
                                <option value="New Mexico">New Mexico</option>
                                <option value="New York">New York</option>
                                <option value="North Carolina">North Carolina</option>
                                <option value="North Dakota">North Dakota</option>
                                <option value="Ohio">Ohio</option>
                                <option value="Oklahoma">Oklahoma</option>
                                <option value="Oregon">Oregon</option>
                                <option value="Pennsylvania">Pennsylvania</option>
                                <option value="Rhode Island">Rhode Island</option>
                                <option value="South Carolina">South Carolina</option>
                                <option value="South Dakota">South Dakota</option>
                                <option value="Tennessee">Tennessee</option>
                                <option value="Texas">Texas</option>
                                <option value="Utah">Utah</option>
                                <option value="Vermont">Vermont</option>
                                <option value="Virginia">Virginia</option>
                                <option value="Washington">Washington</option>
                                <option value="West Virginia">West Virginia</option>
                                <option value="Wisconsin">Wisconsin</option>
                                <option value="Wyoming">Wyoming</option>
                                <option value="District of Columbia">District of Columbia</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="shippingCity">Shipping City *</label>
                            <input type="text" id="shippingCity" name="shippingCity" class="form-control" 
                                placeholder="Enter your city" autocomplete="shipping address-level2"
                                value="{{ old('shippingCity', isset($profile_data) && isset($profile_data->shippingCity) ? $profile_data->shippingCity : '') }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="shippingZipCode">Shipping ZIP/Postal Code *</label>
                    <div class="position-relative">
                        <input type="text" id="shippingZipCode" name="shippingZipCode" class="form-control" 
                            placeholder="Search or enter ZIP/Postal Code" 
                            value="{{ old('shippingZipCode', isset($profile_data) && isset($profile_data->shippingZipCode) ? $profile_data->shippingZipCode : '') }}" 
                            autocomplete="off" required>
                        <div id="shippingZipCodeSuggestions" class="zipcode-suggestions" style="display: none;"></div>
                    </div>
                </div>
                </div> <!-- End shippingFieldsContainer -->
            </div>

            <!-- Delivery Option -->
            <div class="delivery-section mb-4">
                <h5 class="mb-3 fw-bold">Delivery Options</h5>
                <div class="form-group mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="deliveryOption" name="delivery" value="1">
                        <label class="form-check-label" for="deliveryOption">
                            <i class="fas fa-truck me-2"></i>I want delivery options for this order
                        </label>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle me-1"></i>Select this option to view and choose from available delivery quotes
                    </small>
                </div>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Payment Options -->
            <div class="checkout-buttons mt-4">
                <h6 class="text-center mb-3">Choose Payment Method</h6>
                
                <!-- PayPal Payment Button -->
                <button type="submit" class="checkout-btn btn-paypal mb-3" name="paymentType" value="PAYPAL_CHECKOUT">
                    <img src="{{asset('images/market_place/paypal.svg')}}" alt="PayPal">
                    <span>Pay with PayPal</span>
                </button>

                <!-- PayPal Crypto Payment Button -->
                <button type="submit" class="checkout-btn btn-paypal-crypto mb-3" name="paymentType" value="PAYPAL_CRYPTO">
                    <img src="{{asset('images/market_place/paypal.svg')}}" alt="PayPal">
                    <span>Pay with PayPal Crypto</span>
                </button>
            </div>
            </form>
            @endif
        </div>
    </div>
</div>

@include('new_web_pages.buyer_pages.order_placed_modal')
@endsection
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Defensive code to prevent browser extension errors from breaking the page
    // This catches errors from password managers and autofill extensions
    (function() {
        const originalError = window.onerror;
        window.onerror = function(msg, url, line, col, error) {
            // Suppress errors from browser extension content scripts
            if (msg && (msg.includes('content_script') || 
                       msg.includes('Cannot read properties of undefined') ||
                       msg.includes('reading \'control\''))) {
                console.warn('Suppressed browser extension error:', msg);
                return true; // Prevent default error handling
            }
            // Call original error handler for other errors
            if (originalError) {
                return originalError.apply(this, arguments);
            }
            return false;
        };

        // Also catch unhandled promise rejections from extensions
        window.addEventListener('unhandledrejection', function(event) {
            if (event.reason && (
                event.reason.toString().includes('content_script') ||
                event.reason.toString().includes('control')
            )) {
                console.warn('Suppressed browser extension promise rejection:', event.reason);
                event.preventDefault();
            }
        });

        // Ensure form fields are properly initialized for browser extensions
        document.addEventListener('DOMContentLoaded', function() {
            // Add data attributes to help extensions understand form structure
            const form = document.getElementById('checkoutForm');
            if (form) {
                form.setAttribute('data-form-type', 'checkout');
                
                // Ensure all input fields have proper structure
                const inputs = form.querySelectorAll('input, select, textarea');
                inputs.forEach(function(input) {
                    if (!input.hasAttribute('data-field-initialized')) {
                        input.setAttribute('data-field-initialized', 'true');
                    }
                });
            }
        });
    })();

    // Use setTimeout to ensure this runs after layout's ready function
    setTimeout(function() {
        console.log('Checkout: Document ready, starting initialization...');
        console.log('jQuery version:', $.fn.jquery);
        
        // Test if checkbox exists immediately
        setTimeout(() => {
            const checkbox = $('#sameAsBilling');
            console.log('Immediate checkbox check - Found:', checkbox.length > 0);
            console.log('Checkbox element:', checkbox[0]);
            if (checkbox.length > 0) {
                console.log('Checkbox is ready for event binding');
            } else {
                console.error('Checkbox not found - checking DOM...');
                console.log('All checkboxes on page:', $('input[type="checkbox"]').length);
                console.log('All elements with ID containing "same":', $('[id*="same"]').length);
            }
        }, 100);

        // Initialize dropdowns with standard HTML styling
        function initializeDropdowns() {
            console.log('Initializing standard HTML dropdowns...');
            
            // Style all select elements
            $('select').addClass('form-control');
            
            // Ensure all select elements exist
            const selectElements = ['#country', '#state', '#city', '#shippingCountry', '#shippingState', '#shippingCity'];
            selectElements.forEach(selector => {
                if ($(selector).length > 0) {
                    console.log(`Found select element: ${selector}`);
                } else {
                    console.warn(`Select element not found: ${selector}`);
                }
            });
            
            console.log('Standard dropdown initialization successful');
                    return true;
        }

        // Function to fetch buyer profile data
        async function fetchBuyerProfile() {
            try {
                console.log('Fetching buyer profile data...');

                // Debug: Log what's available from the server

                // First try to use the existing profile data from the server
                const serverProfileData = {
                    addressLine1: {!! json_encode(isset($profile_data) && isset($profile_data->billingAddressLine1) ? $profile_data->billingAddressLine1 : '') !!},
                    addressLine2: {!! json_encode(isset($profile_data) && isset($profile_data->billingAddressLine2) ? $profile_data->billingAddressLine2 : '') !!},
                    zipCode: {!! json_encode(isset($profile_data) && isset($profile_data->billingZipCode) ? $profile_data->billingZipCode : '') !!},
                    country: {!! json_encode(isset($profile_data) && isset($profile_data->billingCountry) ? $profile_data->billingCountry : '') !!},
                    state: {!! json_encode(isset($profile_data) && isset($profile_data->billingState) ? $profile_data->billingState : '') !!},
                    city: {!! json_encode(isset($profile_data) && isset($profile_data->billingCity) ? $profile_data->billingCity : '') !!},
                    shippingAddressLine1: {!! json_encode(isset($profile_data) && isset($profile_data->shippingAddressLine1) ? $profile_data->shippingAddressLine1 : '') !!},
                    shippingAddressLine2: {!! json_encode(isset($profile_data) && isset($profile_data->shippingAddressLine2) ? $profile_data->shippingAddressLine2 : '') !!},
                    shippingZipCode: {!! json_encode(isset($profile_data) && isset($profile_data->shippingZipCode) ? $profile_data->shippingZipCode : '') !!},
                    shippingCountry: {!! json_encode(isset($profile_data) && isset($profile_data->shippingCountry) ? $profile_data->shippingCountry : '') !!},
                    shippingState: {!! json_encode(isset($profile_data) && isset($profile_data->shippingState) ? $profile_data->shippingState : '') !!},
                    shippingCity: {!! json_encode(isset($profile_data) && isset($profile_data->shippingCity) ? $profile_data->shippingCity : '') !!}
                };

                console.log('Server profile data:', serverProfileData);

                // Apply the server profile data immediately
                if (Object.values(serverProfileData).some(val => val)) {
                    applyBuyerProfileData(serverProfileData);
                }

                // Also try to fetch from API endpoint if it exists
                try {
                    const response = await fetch('/buyer-profile', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    });

                    if (response.ok) {
                        const profileData = await response.json();
                        console.log('API buyer profile data fetched:', profileData);

                        // Apply the fetched profile data to forms
                        if (profileData && profileData.data) {
                            applyBuyerProfileData(profileData.data);
                        }
                        return profileData;
                    } else {
                        console.log('API endpoint not available, using server data only');
                        return null;
                    }
                } catch (error) {
                    console.log('API endpoint not available, using server data only');
                    return null;
                }
            } catch (error) {
                console.error('Error in profile data handling:', error);
                return null;
            }
        }

        // Function to apply buyer profile data to forms
        function applyBuyerProfileData(profileData) {
            console.log('Applying buyer profile data to forms...');
            console.log('Profile data to apply:', profileData);

            // Apply billing data
            if (profileData.addressLine1) {
                $('#addressLine1').val(profileData.addressLine1);
                console.log('Set billing addressLine1:', profileData.addressLine1);
            }
            if (profileData.addressLine2) {
                $('#addressLine2').val(profileData.addressLine2);
                console.log('Set billing addressLine2:', profileData.addressLine2);
            }
            if (profileData.zipCode) {
                $('#zipCode').val(profileData.zipCode);
                console.log('Set billing zipCode:', profileData.zipCode);
            }

            // Apply shipping data
            if (profileData.shippingAddressLine1) {
                $('#shippingAddressLine1').val(profileData.shippingAddressLine1);
                console.log('Set shipping addressLine1:', profileData.shippingAddressLine1);
            }
            if (profileData.shippingAddressLine2) {
                $('#shippingAddressLine2').val(profileData.shippingAddressLine2);
                console.log('Set shipping addressLine2:', profileData.shippingAddressLine2);
            }
            if (profileData.shippingZipCode) {
                $('#shippingZipCode').val(profileData.shippingZipCode);
                console.log('Set shipping zipCode:', profileData.shippingZipCode);
            }

            // Set dropdown values after they're loaded
            setTimeout(() => {
                if (profileData.country) {
                    $('#country').val(profileData.country).trigger('change');
                    console.log('Set billing country:', profileData.country);
                }
                if (profileData.shippingCountry) {
                    $('#shippingCountry').val(profileData.shippingCountry).trigger('change');
                    console.log('Set shipping country:', profileData.shippingCountry);
                }
            }, 3000); // Increased timeout to ensure dropdowns are loaded
        }


        // Main initialization function
        function initializeEverything() {
            console.log('Initializing everything...');

            // Initialize dropdowns first
            initializeDropdowns();

            // COMMENTED OUT: Auto-loading functionality
            // Load countries for billing
            // console.log('Loading countries for billing...');
            // loadCountries();

            // Load countries for shipping
            // console.log('Loading countries for shipping...');
            // loadShippingCountries();

            // Set up event handlers with a delay to ensure DOM is ready
            setTimeout(() => {
                console.log('Setting up event handlers with delay...');
                setupEventHandlers();
            }, 200);

            // Apply profile data if available
            setTimeout(() => {
                applyProfileData();
            }, 2000);
        }

        // Set up event handlers
        function setupEventHandlers() {
            console.log('=== setupEventHandlers() called ===');
            console.log('Setting up event handlers...');
            
            // Check if the checkbox element exists
            const checkbox = $('#sameAsBilling');
            console.log('Checkbox element found:', checkbox.length > 0);
            console.log('Checkbox element:', checkbox[0]);
            console.log('All checkboxes on page:', $('input[type="checkbox"]').length);
            console.log('Elements with ID containing "same":', $('[id*="same"]').length);
            
            if (checkbox.length === 0) {
                console.error('Checkbox #sameAsBilling not found!');
                console.log('Available checkboxes:', $('input[type="checkbox"]').map(function() { return this.id; }).get());
                return;
            }

            // Same as billing checkbox functionality
            checkbox.on('change', function() {
                console.log('Checkbox change event triggered!');
                if (this.checked) {
                    console.log('Checkbox is checked, copying billing data...');
                    // Add loading state
                    const label = $(this).closest('.form-check').find('label');
                    const originalText = label.html();
                    label.html('<i class="fas fa-spinner fa-spin me-2"></i>Copying address...');
                    
                    // Copy billing data to shipping fields
                    setTimeout(() => {
                        populateFromBilling();
                        // Add visual feedback
                        $(this).closest('.form-check').addClass('text-success');
                        label.html('<i class="fas fa-check-circle me-2"></i>Use same address for shipping and billing');
                    }, 500);
                } else {
                    console.log('Checkbox is unchecked, clearing shipping fields...');
                    // Clear shipping fields when unchecked
                    clearShippingFields();
                    // Remove visual feedback
                    $(this).closest('.form-check').removeClass('text-success');
                    const label = $(this).closest('.form-check').find('label');
                    label.html('<i class="fas fa-copy me-2"></i>Use same address for shipping and billing');
                }
            });

            // Auto-copy billing data to shipping when billing fields change and checkbox is checked
            // Note: This handler runs in addition to the state/country change handlers above
            $('#addressLine1, #addressLine2, #country, #state, #city, #zipCode').on('input change', function() {
                if ($('#sameAsBilling').is(':checked')) {
                    populateFromBilling();
                }
            });
            
            // Event handler for billing country change
            $(document).on('change', '#country', function() {
                const country = $(this).val();
                console.log('Country changed to:', country);
                if (country) {
                    loadStates(country);
                    // Clear city and zipcode when country changes
                    $('#city').empty().append('<option value="">Select City</option>');
                    $('#zipCode').empty().append('<option value="">Select ZIP/Postal Code</option>');
                } else {
                    $('#state').empty().append('<option value="">Select State/Province</option>');
                    $('#city').empty().append('<option value="">Select City</option>');
                    $('#zipCode').empty().append('<option value="">Select ZIP/Postal Code</option>');
                }
            });

            // Event handler for billing state change
            $(document).on('change', '#state', function() {
                const country = $('#country').val();
                const state = $(this).val();
                console.log('State changed - Country:', country, 'State:', state);
                if (country && state) {
                    // COMMENTED OUT: City and zipcode loading
                    // loadCities(country, state);
                    // loadZipcodes(country, state);
                    
                    // Load zipcodes for search when state is selected (US only)
                    if (country === 'United States' && state) {
                        loadZipcodesForSearch(state);
                    }
                } else {
                    // Clear zipcode suggestions
                    $('#zipCodeSuggestions').hide().empty();
                }
            });
            
            console.log('Event handlers setup complete!');
            
            // Test the event handler manually
            console.log('Testing event handler manually...');
            setTimeout(() => {
                const testCheckbox = $('#sameAsBilling');
                if (testCheckbox.length > 0) {
                    console.log('Test: Checkbox found, triggering change event...');
                    testCheckbox.trigger('change');
                } else {
                    console.log('Test: Checkbox not found for testing');
                }
            }, 1000);
        }

        // Apply profile data
        function applyProfileData() {
            console.log('Applying profile data...');

            // Apply billing data
            const profileCountry = '{{ isset($profile_data->billingCountry) ? $profile_data->billingCountry : "" }}';
            const profileState = '{{ isset($profile_data->billingState) ? $profile_data->billingState : "" }}';
            const profileCity = '{{ isset($profile_data->billingCity) ? $profile_data->billingCity : "" }}';
            
            if (profileCountry) {
                $('#country').val(profileCountry);
                console.log('Set billing country from profile:', profileCountry);
            }

            // Apply shipping data
            const shippingCountry = '{{ isset($profile_data->shippingCountry) ? $profile_data->shippingCountry : "" }}';
            const shippingState = '{{ isset($profile_data->shippingState) ? $profile_data->shippingState : "" }}';
            const shippingCity = '{{ isset($profile_data->shippingCity) ? $profile_data->shippingCity : "" }}';
            
            if (shippingCountry) {
                $('#shippingCountry').val(shippingCountry);
                console.log('Set shipping country from profile:', shippingCountry);
            }
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

        // Populate from billing address
        function populateFromBilling() {
            // Copy billing address fields to shipping address fields
            const fieldMappings = [
                { from: 'addressLine1', to: 'shippingAddressLine1' },
                { from: 'addressLine2', to: 'shippingAddressLine2' },
                { from: 'country', to: 'shippingCountry' },
                { from: 'state', to: 'shippingState' },
                { from: 'city', to: 'shippingCity' },
                { from: 'zipCode', to: 'shippingZipCode' }
            ];

            fieldMappings.forEach(mapping => {
                const sourceField = document.getElementById(mapping.from);
                const targetField = document.getElementById(mapping.to);
                
                if (sourceField && targetField) {
                    // For select elements, trigger change event to ensure proper handling
                    if (targetField.tagName === 'SELECT') {
                        targetField.value = sourceField.value;
                        $(targetField).trigger('change');
                    } else {
                        targetField.value = sourceField.value;
                    }
                }
            });

            // Show a brief success message
            showTemporaryMessage('Billing address copied to shipping!', 'success');
        }

        // Show temporary message
        function showTemporaryMessage(message, type = 'info') {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-info';
            const messageHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                    <i class="fas fa-check-circle me-2"></i>${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            // Remove any existing temporary messages
            $('.alert[style*="position: fixed"]').remove();
            
            // Add new message
            $('body').append(messageHtml);
            
            // Auto-remove after 3 seconds
            setTimeout(() => {
                $('.alert[style*="position: fixed"]').fadeOut(500, function() {
                    $(this).remove();
                });
            }, 3000);
        }

        // Clear shipping fields
        function clearShippingFields() {
            const shippingFields = [
                'shippingAddressLine1',
                'shippingAddressLine2', 
                'shippingCountry',
                'shippingState',
                'shippingCity',
                'shippingZipCode'
            ];

            shippingFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    if (field.tagName === 'SELECT') {
                        field.selectedIndex = 0; // Reset to first option
                        $(field).trigger('change'); // Trigger change event for select elements
                    } else {
                        field.value = '';
                    }
                }
            });

            // Show a brief info message
            showTemporaryMessage('Shipping fields cleared. You can now enter different shipping details.', 'info');
        }


        // Fallback countries for billing
        function loadFallbackCountries(browserCountry) {
            console.log('Loading fallback countries for billing...');
            const fallbackCountries = ['United States', 'Canada', 'United Kingdom', 'Germany', 'France', 'Australia', 'Japan', 'Brazil', 'India', 'China', 'Singapore', 'Malta', 'Iceland', 'Luxembourg'];

            // Clear existing options
            $('#country').empty();

            // Add browser country first if detected
            if (browserCountry && fallbackCountries.includes(browserCountry)) {
                const browserOption = new Option(browserCountry, browserCountry, false, true);
                $('#country').append(browserOption);
            }

            // Add all countries
            fallbackCountries.forEach(country => {
                if (!browserCountry || country !== browserCountry) {
                    const option = new Option(country, country, false, false);
                    $('#country').append(option);
                }
            });

            // Set profile data if available
            const profileCountry = '{{ isset($profile_data->billingCountry) ? $profile_data->billingCountry : "" }}';
            if (profileCountry) {
                $('#country').val(profileCountry);
            }

            console.log('Fallback countries loaded for billing');
        }

        // Fallback shipping countries
        function loadFallbackShippingCountries() {
            const countries = ['United States', 'Canada', 'United Kingdom', 'Germany', 'France', 'Australia', 'Japan', 'Brazil', 'India', 'China'];
            $('#shippingCountry').empty().append('<option value="">Select Country</option>');
            countries.forEach(country => {
                $('#shippingCountry').append(`<option value="${country}">${country}</option>`);
            });
        }

        // Load shipping countries
        async function loadShippingCountries() {
            try {
                console.log('Loading countries for shipping...');
                console.log('Shipping country dropdown element:', $('#shippingCountry').length);

                const response = await fetch('https://countriesnow.space/api/v0.1/countries');
                console.log('Shipping API response status:', response.status);

                const data = await response.json();
                console.log('Shipping API response data:', data);

                if (data.error === false && data.data) {
                    $('#shippingCountry').empty().append('<option value="">Select Country</option>');
                    data.data.forEach(country => {
                        $('#shippingCountry').append(`<option value="${country.country}">${country.country}</option>`);
                    });

                    // Set profile data if available
                    const profileCountry = '{{ isset($profile_data->shippingCountry) ? $profile_data->shippingCountry : "" }}';
                    if (profileCountry) {
                        $('#shippingCountry').val(profileCountry);
                        console.log('Set shipping country from profile:', profileCountry);
                    }
                    console.log('Countries loaded successfully for shipping');
                } else {
                    console.error('Shipping API returned error:', data);
                    loadFallbackShippingCountries();
                }
            } catch (error) {
                console.error('Error loading shipping countries:', error);
                loadFallbackShippingCountries();
            }
        }

            // Load countries function for billing
            async function loadCountries() {
                console.log('Loading countries for billing...');

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
                        $('#country').empty();

                        // Add browser country first if detected
                        if (browserCountry) {
                            const browserOption = new Option(browserCountry, browserCountry, false, false);
                            $('#country').append(browserOption);
                        }

                        // Add all countries
                        data.data.forEach(country => {
                            if (!browserCountry || country.country !== browserCountry) {
                                const option = new Option(country.country, country.country, false, false);
                                $('#country').append(option);
                            }
                        });

                        // Set profile data if available
                        const profileCountry = '{{ isset($profile_data->billingCountry) ? $profile_data->billingCountry : "" }}';
                        if (profileCountry) {
                        $('#country').val(profileCountry);
                            console.log('Set billing country from profile:', profileCountry);
                        } else if (browserCountry) {
                        $('#country').val(browserCountry);
                        }

                        console.log('Countries loaded successfully for billing');
                    } else {
                        console.error('API returned error:', data);
                        loadFallbackCountries(browserCountry);
                    }
                } catch (error) {
                    console.error('Error loading countries:', error);
                    loadFallbackCountries(browserCountry);
                }
            }

            // Load states function for billing
            async function loadStates(country) {
                if (!country) return;

                console.log('Loading states for country:', country);
                console.log('State select element:', $('#state').length);

                $('#state').prop('disabled', true);

                try {
                    const response = await fetch(`https://countriesnow.space/api/v0.1/countries/states/q?country=${encodeURIComponent(country)}`);
                    const data = await response.json();
                    console.log('States data:', data);

                    if (data.error === false && data.data && data.data.states && data.data.states.length > 0) {
                        console.log('Found', data.data.states.length, 'states for', country);
                        console.log('First few states:', data.data.states.slice(0, 3));

                        // Clear and add options
                        $('#state').empty();
                        $('#state').append('<option value="">Select State/Province</option>');

                        data.data.states.forEach((state, index) => {
                            console.log(`State ${index}:`, state);
                            console.log('State object keys:', Object.keys(state));
                            console.log('State name value:', state.name);
                            console.log('State name type:', typeof state.name);

                            // Use the correct property 'name' instead of 'state'
                            $('#state').append(`<option value="${state.name}">${state.name}</option>`);
                        });

                        console.log('Options added to state. Current options:', $('#state').find('option').length);
                        console.log('State HTML:', $('#state').html());

                        // Set profile data if available
                        const profileState = '{{ isset($profile_data) && isset($profile_data->billingState) ? $profile_data->billingState : "" }}';
                        if (profileState) {
                            $('#state').val(profileState);
                            console.log('Set billing state from profile:', profileState);
                            // Trigger change event to ensure cities and zipcodes load
                            setTimeout(() => {
                                $('#state').trigger('change');
                            }, 100);
                        }
                        console.log('States loaded successfully');
                    } else {
                        console.log('No states found for this country, using no-state option');
                        loadNoStateOption();
                    }
                } catch (error) {
                    console.error('Error loading states:', error);
                    loadFallbackStates(country);
                } finally {
                    $('#state').prop('disabled', false);
                }
            }


            // COMMENTED OUT: Load cities function for billing
            /*
            async function loadCities(country, state) {
                if (!country || !state) {
                    console.warn('loadCities: Missing country or state', { country, state });
                    return;
                }

                console.log('Loading cities for country:', country, 'state:', state);
                
                // Check if city dropdown exists
                if ($('#city').length === 0) {
                    console.error('City dropdown not found!');
                    return;
                }
                
                $('#city').prop('disabled', true);

                try {
                    // If US, use our controller endpoint
                    if (country === 'United States') {
                        const citiesUrl = '{{ route('api.usCities') }}';
                        const response = await fetch(citiesUrl + '?state=' + encodeURIComponent(state));
                        const data = await response.json();
                        console.log('US Cities data from controller:', data);

                        if (data.success && data.cities && data.cities.length > 0) {
                            $('#city').empty().append('<option value="">Select City</option>');
                            data.cities.forEach(city => {
                                const cityName = typeof city === 'string' ? city : city.name || city.city || city;
                                const option = new Option(cityName, cityName, false, false);
                                $('#city').append(option);
                            });

                            // Set profile data if available
                            const profileCity = '{{ isset($profile_data->billingCity) ? $profile_data->billingCity : "" }}';
                            if (profileCity) {
                                $('#city').val(profileCity);
                                console.log('Set billing city from profile:', profileCity);
                            }
                            console.log('US Cities loaded successfully from controller');
                        } else {
                            console.log('No cities found from controller, using fallback');
                            loadFallbackCities(country, state);
                        }
                    } else {
                        // For non-US countries, use the external API
                        const response = await fetch(`https://countriesnow.space/api/v0.1/countries/state/cities/q?country=${encodeURIComponent(country)}&state=${encodeURIComponent(state)}`);
                        const data = await response.json();
                        console.log('Cities data:', data);

                        if (data.error === false && data.data && data.data.length > 0) {
                            console.log('Cities data structure:', data.data[0]);
                            $('#city').empty().append('<option value="">Select City</option>');
                            data.data.forEach(city => {
                                const cityName = typeof city === 'string' ? city : city.name || city.city || city;
                                const option = new Option(cityName, cityName, false, false);
                                $('#city').append(option);
                            });

                            // Set profile data if available
                            const profileCity = '{{ isset($profile_data->billingCity) ? $profile_data->billingCity : "" }}';
                            if (profileCity) {
                                $('#city').val(profileCity);
                                console.log('Set billing city from profile:', profileCity);
                            }
                            console.log('Cities loaded successfully');
                        } else {
                            console.log('No cities found for this state, using fallback');
                            loadFallbackCities(country, state);
                        }
                    }
                } catch (error) {
                    console.error('Error loading cities:', error);
                    loadFallbackCities(country, state);
                } finally {
                    $('#city').prop('disabled', false);
                }
            }
            */

            // COMMENTED OUT: Load zipcodes function for billing (dropdown version)
            /*
            async function loadZipcodes(country, state) {
                if (!country || !state) {
                    console.warn('loadZipcodes: Missing country or state', { country, state });
                    return;
                }

                // Only load zipcodes for US
                if (country !== 'United States') {
                    if ($('#zipCode').length > 0) {
                        $('#zipCode').empty().append('<option value="">Enter ZIP/Postal Code</option>');
                    }
                    return;
                }

                console.log('Loading zipcodes for US state:', state);
                
                // Check if zipCode dropdown exists
                if ($('#zipCode').length === 0) {
                    console.error('ZipCode dropdown not found!');
                    return;
                }
                
                $('#zipCode').prop('disabled', true);

                try {
                    const zipcodesUrl = '{{ route('api.usZipcodes') }}';
                    const response = await fetch(zipcodesUrl + '?state=' + encodeURIComponent(state));
                    const data = await response.json();
                    console.log('US Zipcodes data from controller:', data);

                    if (data.success && data.zipcodes && data.zipcodes.length > 0) {
                        $('#zipCode').empty().append('<option value="">Select ZIP/Postal Code</option>');
                        data.zipcodes.forEach(zipcode => {
                            const option = new Option(zipcode, zipcode, false, false);
                            $('#zipCode').append(option);
                        });

                        // Set profile data if available
                        const profileZipCode = '{{ isset($profile_data->shippingZipCode) ? $profile_data->shippingZipCode : (empty(session("zipCode")) ? old("zipCode") : session("zipCode")) }}';
                        if (profileZipCode) {
                            $('#zipCode').val(profileZipCode);
                            console.log('Set billing zipcode from profile:', profileZipCode);
                        }
                        console.log('US Zipcodes loaded successfully from controller');
                    } else {
                        console.log('No zipcodes found from controller');
                        $('#zipCode').empty().append('<option value="">Enter ZIP/Postal Code</option>');
                    }
                } catch (error) {
                    console.error('Error loading zipcodes:', error);
                    $('#zipCode').empty().append('<option value="">Enter ZIP/Postal Code</option>');
                } finally {
                    $('#zipCode').prop('disabled', false);
                }
            }
            */

            // Store all US zipcodes for search
            let allUSZipcodes = [];
            let currentZipcodeSuggestions = [];

            // Load zipcodes for search functionality
            async function loadZipcodesForSearch(state) {
                if (!state) return;

                console.log('Loading zipcodes for search, state:', state);

                try {
                    const zipcodesUrl = '{{ route('api.usZipcodes') }}';
                    const response = await fetch(zipcodesUrl + '?state=' + encodeURIComponent(state));
                    const data = await response.json();
                    console.log('US Zipcodes data from controller:', data);

                    if (data.success && data.zipcodes && data.zipcodes.length > 0) {
                        // Store zipcodes for this state
                        allUSZipcodes = data.zipcodes.map(zip => ({
                            zipcode: zip,
                            state: state
                        }));
                        console.log('Loaded', allUSZipcodes.length, 'zipcodes for state:', state);
                    }
                } catch (error) {
                    console.error('Error loading zipcodes for search:', error);
                }
            }

            // Search zipcodes function
            function searchZipcodes(query) {
                if (!query || query.length < 2) {
                    $('#zipCodeSuggestions').hide().empty();
                    return;
                }

                const searchTerm = query.toLowerCase();
                const matches = allUSZipcodes.filter(item => 
                    item.zipcode.toString().toLowerCase().includes(searchTerm)
                ).slice(0, 10); // Limit to 10 results

                currentZipcodeSuggestions = matches;

                if (matches.length > 0) {
                    let html = '';
                    matches.forEach((item, index) => {
                        html += `<div class="zipcode-suggestion-item" data-zipcode="${item.zipcode}" data-index="${index}">
                            <div class="zipcode">${item.zipcode}</div>
                            <div class="location">${item.state}</div>
                        </div>`;
                    });
                    $('#zipCodeSuggestions').html(html).show();
                } else {
                    $('#zipCodeSuggestions').hide().empty();
                }
            }

            // Setup zipcode search functionality
            $(document).on('input', '#zipCode', function() {
                const query = $(this).val();
                searchZipcodes(query);
            });

            // Handle zipcode suggestion click
            $(document).on('click', '.zipcode-suggestion-item', function() {
                const zipcode = $(this).data('zipcode');
                $('#zipCode').val(zipcode);
                $('#zipCodeSuggestions').hide().empty();
            });

            // Hide suggestions when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#zipCode, #zipCodeSuggestions').length) {
                    $('#zipCodeSuggestions').hide();
                }
            });

            // Handle keyboard navigation for zipcode suggestions
            let selectedZipcodeIndex = -1;
            $(document).on('keydown', '#zipCode', function(e) {
                if (currentZipcodeSuggestions.length === 0) return;

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedZipcodeIndex = Math.min(selectedZipcodeIndex + 1, currentZipcodeSuggestions.length - 1);
                    updateZipcodeSelection();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedZipcodeIndex = Math.max(selectedZipcodeIndex - 1, -1);
                    updateZipcodeSelection();
                } else if (e.key === 'Enter' && selectedZipcodeIndex >= 0) {
                    e.preventDefault();
                    const zipcode = currentZipcodeSuggestions[selectedZipcodeIndex].zipcode;
                    $('#zipCode').val(zipcode);
                    $('#zipCodeSuggestions').hide().empty();
                    selectedZipcodeIndex = -1;
                } else if (e.key === 'Escape') {
                    $('#zipCodeSuggestions').hide().empty();
                    selectedZipcodeIndex = -1;
                }
            });

            function updateZipcodeSelection() {
                $('.zipcode-suggestion-item').removeClass('active');
                if (selectedZipcodeIndex >= 0) {
                    $('.zipcode-suggestion-item').eq(selectedZipcodeIndex).addClass('active');
                    // Scroll into view
                    const $selected = $('.zipcode-suggestion-item').eq(selectedZipcodeIndex);
                    const container = $('#zipCodeSuggestions');
                    const scrollTop = container.scrollTop();
                    const containerHeight = container.height();
                    const itemTop = $selected.position().top;
                    const itemHeight = $selected.outerHeight();

                    if (itemTop < 0) {
                        container.scrollTop(scrollTop + itemTop);
                    } else if (itemTop + itemHeight > containerHeight) {
                        container.scrollTop(scrollTop + (itemTop + itemHeight - containerHeight));
                    }
                }
            }

            // Helper functions for cities
            async function loadCitiesForCountry(country) {
                if (!country) return;

                console.log('Loading cities directly for country:', country);
                $('#city').prop('disabled', true);

                try {
                    // Try to get cities for the country without specifying state
                    const response = await fetch(`https://countriesnow.space/api/v0.1/countries/cities/q?country=${encodeURIComponent(country)}`);
                    const data = await response.json();
                    console.log('Cities for country data:', data);

                    if (data.error === false && data.data && data.data.length > 0) {
                        console.log('Cities for country data structure:', data.data[0]); // Log first city to see structure
                        $('#city').empty().append('<option value="">Select City</option>');
                        data.data.forEach(city => {
                            // Handle both string cities and object cities
                            const cityName = typeof city === 'string' ? city : city.name || city.city || city;
                            const option = new Option(cityName, cityName, false, false);
                            $('#city').append(option);
                        });

                        // Set profile data if available
                        const profileCity = '{{ isset($profile_data->billingCity) ? $profile_data->billingCity : "" }}';
                        if (profileCity) {
                            $('#city').val(profileCity);
                        }
                        console.log('Cities for country loaded successfully');
                    } else {
                        console.log('No cities found for country, using fallback');
                        loadFallbackCitiesForCountry(country);
                    }
                } catch (error) {
                    console.error('Error loading cities for country:', error);
                    loadFallbackCitiesForCountry(country);
                } finally {
                    $('#city').prop('disabled', false);
                }
            }

            function loadFallbackCities(country, state) {
                console.log('Loading fallback cities for:', country, state);
                const fallbackCities = getFallbackCities(country, state);
                if (fallbackCities && fallbackCities.length > 0) {
                    $('#city').empty().append('<option value="">Select City</option>');
                    fallbackCities.forEach(city => {
                        const option = new Option(city, city, false, false);
                        $('#city').append(option);
                    });

                    // Set profile data if available
                    const profileCity = '{{ isset($profile_data->billingCity) ? $profile_data->billingCity : "" }}';
                    if (profileCity) {
                        $('#city').val(profileCity);
                    }
                    console.log('Fallback cities loaded');
                } else {
                    $('#city').empty().append('<option value="">No cities available</option>');
                }
            }

            function loadFallbackCitiesForCountry(country) {
                console.log('Loading fallback cities for country:', country);
                const fallbackCities = getFallbackCitiesForCountry(country);
                if (fallbackCities && fallbackCities.length > 0) {
                    $('#city').empty().append('<option value="">Select City</option>');
                    fallbackCities.forEach(city => {
                        const option = new Option(city, city, false, false);
                        $('#city').append(option);
                    });

                    // Set profile data if available
                    const profileCity = '{{ isset($profile_data->billingCity) ? $profile_data->billingCity : "" }}';
                    if (profileCity) {
                        $('#city').val(profileCity);
                    }
                    console.log('Fallback cities for country loaded');
                } else {
                    $('#city').empty().append('<option value="">No cities available</option>');
                }
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


            // Helper functions for states
            function loadNoStateOption() {
                console.log('Loading no-state option for country without states');

                // Clear and add options
                $('#state').empty();
                $('#state').append('<option value="">Select State/Province</option>');

                // Use jQuery append with HTML string instead of Option constructor
                $('#state').append('<option value="no-state">No State/Province (Direct to Cities)</option>');

                // Set profile data if available
                const profileState = '{{ isset($profile_data->billingState) ? $profile_data->billingState : "" }}';
                if (profileState) {
                    $('#state').val(profileState);
                }
            }

            function loadFallbackStates(country) {
                console.log('Loading fallback states for:', country);
                const fallbackStates = getFallbackStates(country);
                if (fallbackStates && fallbackStates.length > 0) {
                    console.log('Loading', fallbackStates.length, 'fallback states for', country);

                    // Clear and add options
                    $('#state').empty();
                    $('#state').append('<option value="">Select State/Province</option>');

                    fallbackStates.forEach(state => {
                        console.log('Creating fallback option for state:', state);
                        // Use jQuery append with HTML string instead of Option constructor
                        $('#state').append(`<option value="${state}">${state}</option>`);
                    });

                    // Set profile data if available
                    const profileState = '{{ isset($profile_data->billingState) ? $profile_data->billingState : "" }}';
                    if (profileState) {
                        $('#state').val(profileState);
                    }
                    console.log('Fallback states loaded');
                } else {
                    console.log('No fallback states available, using no-state option');
                    loadNoStateOption();
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

            // Populate from shipping address
            function populateFromShipping() {
                const shippingData = {
                    'addressLine1': '{{ isset($profile_data->shippingAddressLine1) ? $profile_data->shippingAddressLine1 : "" }}',
                    'addressLine2': '{{ isset($profile_data->shippingAddressLine2) ? $profile_data->shippingAddressLine2 : "" }}',
                    'zipCode': '{{ isset($profile_data->shippingZipCode) ? $profile_data->shippingZipCode : "" }}'
                };

                Object.keys(shippingData).forEach(field => {
                    if (shippingData[field]) {
                        $(`#${field}`).val(shippingData[field]);
                    }
                });
            }

            // Initialize shipping dropdowns
            function initializeShippingDropdowns() {
                // Select2 not available, using standard HTML dropdowns
                console.log('Initializing standard HTML dropdowns for shipping...');
                /*
                $('#shippingCountry, #shippingState, #shippingCity').select2({
                    theme: 'bootstrap-5',
                    placeholder: 'Select option',
                    allowClear: true,
                    width: '100%'
                });

                // Load countries for shipping
                loadShippingCountries();

                // Event handlers for shipping
                $('#shippingCountry').on('change', function() {
                    const country = $(this).val();
                    if (country) {
                        loadShippingStates(country);
                    }
                    $('#shippingState, #shippingCity').empty().append('<option value="">Select option</option>').trigger('change');
                });

                $('#shippingState').on('change', function() {
                    const country = $('#shippingCountry').val();
                    const state = $(this).val();
                    if (country && state) {
                        loadShippingCities(country, state);
                    }
                    $('#shippingCity').empty().append('<option value="">Select option</option>').trigger('change');
                });
                */
            }


            // Load shipping states
            async function loadShippingStates(country) {
                if (!country) return;

                console.log('Loading shipping states for country:', country);
                $('#shippingState').prop('disabled', true);

                try {
                    const response = await fetch(`https://countriesnow.space/api/v0.1/countries/states/q?country=${encodeURIComponent(country)}`);
                    const data = await response.json();

                    if (data.error === false && data.data && data.data.states) {
                        $('#shippingState').empty().append('<option value="">Select State/Province</option>');
                        data.data.states.forEach(state => {
                            const stateName = state.name || state.state || state;
                            $('#shippingState').append(`<option value="${stateName}">${stateName}</option>`);
                        });

                        // Set profile data if available
                        const profileState = '{{ isset($profile_data) && isset($profile_data->shippingState) ? $profile_data->shippingState : "" }}';
                        if (profileState) {
                            $('#shippingState').val(profileState);
                            console.log('Set shipping state from profile:', profileState);
                            // COMMENTED OUT: Load cities and zipcodes for the selected state
                            // loadShippingCities(country, profileState);
                            // loadShippingZipcodes(country, profileState);
                            
                            // Load zipcodes for search when state is selected (US only)
                            if (country === 'United States' && profileState) {
                                setTimeout(() => {
                                    loadShippingZipcodesForSearch(profileState);
                                }, 100);
                            }
                        }
                    }
                } catch (error) {
                    console.error('Error loading shipping states:', error);
                } finally {
                    $('#shippingState').prop('disabled', false);
                }
            }

            // COMMENTED OUT: Load shipping cities
            /*
            async function loadShippingCities(country, state) {
                if (!country || !state) return;

                console.log('Loading shipping cities for country:', country, 'state:', state);
                $('#shippingCity').prop('disabled', true);

                try {
                    // If US, use our controller endpoint
                    if (country === 'United States') {
                        const citiesUrl = '{{ route('api.usCities') }}';
                        const response = await fetch(citiesUrl + '?state=' + encodeURIComponent(state));
                        const data = await response.json();
                        console.log('US Shipping Cities data from controller:', data);

                        if (data.success && data.cities && data.cities.length > 0) {
                            $('#shippingCity').empty().append('<option value="">Select City</option>');
                            data.cities.forEach(city => {
                                const cityName = typeof city === 'string' ? city : city.name || city.city || city;
                                const option = new Option(cityName, cityName, false, false);
                                $('#shippingCity').append(option);
                            });

                            // Set profile data if available
                            const profileCity = '{{ isset($profile_data->shippingCity) ? $profile_data->shippingCity : "" }}';
                            if (profileCity) {
                                $('#shippingCity').val(profileCity);
                                console.log('Set shipping city from profile:', profileCity);
                            }
                            console.log('US Shipping Cities loaded successfully from controller');
                        } else {
                            console.log('No shipping cities found from controller');
                            $('#shippingCity').empty().append('<option value="">Select City</option>');
                        }
                    } else {
                        // For non-US countries, use the external API
                        const response = await fetch(`https://countriesnow.space/api/v0.1/countries/state/cities/q?country=${encodeURIComponent(country)}&state=${encodeURIComponent(state)}`);
                        const data = await response.json();

                        if (data.error === false && data.data) {
                            $('#shippingCity').empty().append('<option value="">Select City</option>');
                            data.data.forEach(city => {
                                const cityName = typeof city === 'string' ? city : city.name || city.city || city;
                                $('#shippingCity').append(`<option value="${cityName}">${cityName}</option>`);
                            });

                            // Set profile data if available
                            const profileCity = '{{ isset($profile_data->shippingCity) ? $profile_data->shippingCity : "" }}';
                            if (profileCity) {
                                $('#shippingCity').val(profileCity);
                            }
                        }
                    }
                } catch (error) {
                    console.error('Error loading shipping cities:', error);
                    $('#shippingCity').empty().append('<option value="">Select City</option>');
                } finally {
                    $('#shippingCity').prop('disabled', false);
                }
            }
            */

            // COMMENTED OUT: Load shipping zipcodes function (dropdown version)
            /*
            async function loadShippingZipcodes(country, state) {
                if (!country || !state) return;

                // Only load zipcodes for US
                if (country !== 'United States') {
                    $('#shippingZipCode').empty().append('<option value="">Enter ZIP/Postal Code</option>');
                    return;
                }

                console.log('Loading shipping zipcodes for US state:', state);
                $('#shippingZipCode').prop('disabled', true);

                try {
                    const zipcodesUrl = '{{ route('api.usZipcodes') }}';
                    const response = await fetch(zipcodesUrl + '?state=' + encodeURIComponent(state));
                    const data = await response.json();
                    console.log('US Shipping Zipcodes data from controller:', data);

                    if (data.success && data.zipcodes && data.zipcodes.length > 0) {
                        $('#shippingZipCode').empty().append('<option value="">Select ZIP/Postal Code</option>');
                        data.zipcodes.forEach(zipcode => {
                            const option = new Option(zipcode, zipcode, false, false);
                            $('#shippingZipCode').append(option);
                        });

                        // Set profile data if available
                        const profileZipCode = '{{ isset($profile_data->shippingZipCode) ? $profile_data->shippingZipCode : "" }}';
                        if (profileZipCode) {
                            $('#shippingZipCode').val(profileZipCode);
                            console.log('Set shipping zipcode from profile:', profileZipCode);
                        }
                        console.log('US Shipping Zipcodes loaded successfully from controller');
                    } else {
                        console.log('No shipping zipcodes found from controller');
                        $('#shippingZipCode').empty().append('<option value="">Enter ZIP/Postal Code</option>');
                    }
                } catch (error) {
                    console.error('Error loading shipping zipcodes:', error);
                    $('#shippingZipCode').empty().append('<option value="">Enter ZIP/Postal Code</option>');
                } finally {
                    $('#shippingZipCode').prop('disabled', false);
                }
            }
            */

            // Store all US zipcodes for shipping search
            let allShippingUSZipcodes = [];
            let currentShippingZipcodeSuggestions = [];

            // Load zipcodes for shipping search functionality
            async function loadShippingZipcodesForSearch(state) {
                if (!state) return;

                console.log('Loading shipping zipcodes for search, state:', state);

                try {
                    const zipcodesUrl = '{{ route('api.usZipcodes') }}';
                    const response = await fetch(zipcodesUrl + '?state=' + encodeURIComponent(state));
                    const data = await response.json();
                    console.log('US Shipping Zipcodes data from controller:', data);

                    if (data.success && data.zipcodes && data.zipcodes.length > 0) {
                        // Store zipcodes for this state
                        allShippingUSZipcodes = data.zipcodes.map(zip => ({
                            zipcode: zip,
                            state: state
                        }));
                        console.log('Loaded', allShippingUSZipcodes.length, 'shipping zipcodes for state:', state);
                    }
                } catch (error) {
                    console.error('Error loading shipping zipcodes for search:', error);
                }
            }

            // Search shipping zipcodes function
            function searchShippingZipcodes(query) {
                if (!query || query.length < 2) {
                    $('#shippingZipCodeSuggestions').hide().empty();
                    return;
                }

                const searchTerm = query.toLowerCase();
                const matches = allShippingUSZipcodes.filter(item => 
                    item.zipcode.toString().toLowerCase().includes(searchTerm)
                ).slice(0, 10); // Limit to 10 results

                currentShippingZipcodeSuggestions = matches;

                if (matches.length > 0) {
                    let html = '';
                    matches.forEach((item, index) => {
                        html += `<div class="zipcode-suggestion-item" data-zipcode="${item.zipcode}" data-index="${index}">
                            <div class="zipcode">${item.zipcode}</div>
                            <div class="location">${item.state}</div>
                        </div>`;
                    });
                    $('#shippingZipCodeSuggestions').html(html).show();
                } else {
                    $('#shippingZipCodeSuggestions').hide().empty();
                }
            }

            // Setup shipping zipcode search functionality
            $(document).on('input', '#shippingZipCode', function() {
                const query = $(this).val();
                searchShippingZipcodes(query);
            });

            // Handle shipping zipcode suggestion click
            $(document).on('click', '#shippingZipCodeSuggestions .zipcode-suggestion-item', function() {
                const zipcode = $(this).data('zipcode');
                $('#shippingZipCode').val(zipcode);
                $('#shippingZipCodeSuggestions').hide().empty();
            });

            // Hide shipping suggestions when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#shippingZipCode, #shippingZipCodeSuggestions').length) {
                    $('#shippingZipCodeSuggestions').hide();
                }
            });

            // Handle keyboard navigation for shipping zipcode suggestions
            let selectedShippingZipcodeIndex = -1;
            $(document).on('keydown', '#shippingZipCode', function(e) {
                if (currentShippingZipcodeSuggestions.length === 0) return;

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedShippingZipcodeIndex = Math.min(selectedShippingZipcodeIndex + 1, currentShippingZipcodeSuggestions.length - 1);
                    updateShippingZipcodeSelection();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedShippingZipcodeIndex = Math.max(selectedShippingZipcodeIndex - 1, -1);
                    updateShippingZipcodeSelection();
                } else if (e.key === 'Enter' && selectedShippingZipcodeIndex >= 0) {
                    e.preventDefault();
                    const zipcode = currentShippingZipcodeSuggestions[selectedShippingZipcodeIndex].zipcode;
                    $('#shippingZipCode').val(zipcode);
                    $('#shippingZipCodeSuggestions').hide().empty();
                    selectedShippingZipcodeIndex = -1;
                } else if (e.key === 'Escape') {
                    $('#shippingZipCodeSuggestions').hide().empty();
                    selectedShippingZipcodeIndex = -1;
                }
            });

            function updateShippingZipcodeSelection() {
                $('#shippingZipCodeSuggestions .zipcode-suggestion-item').removeClass('active');
                if (selectedShippingZipcodeIndex >= 0) {
                    $('#shippingZipCodeSuggestions .zipcode-suggestion-item').eq(selectedShippingZipcodeIndex).addClass('active');
                    // Scroll into view
                    const $selected = $('#shippingZipCodeSuggestions .zipcode-suggestion-item').eq(selectedShippingZipcodeIndex);
                    const container = $('#shippingZipCodeSuggestions');
                    const scrollTop = container.scrollTop();
                    const containerHeight = container.height();
                    const itemTop = $selected.position().top;
                    const itemHeight = $selected.outerHeight();

                    if (itemTop < 0) {
                        container.scrollTop(scrollTop + itemTop);
                    } else if (itemTop + itemHeight > containerHeight) {
                        container.scrollTop(scrollTop + (itemTop + itemHeight - containerHeight));
                    }
                }
            }

            // Event handler for shipping country change
            $(document).on('change', '#shippingCountry', function() {
                const country = $(this).val();
                if (country) {
                    loadShippingStates(country);
                    // Clear city and zipcode when country changes
                    $('#shippingCity').empty().append('<option value="">Select City</option>');
                    $('#shippingZipCode').empty().append('<option value="">Select ZIP/Postal Code</option>');
                } else {
                    $('#shippingState').empty().append('<option value="">Select State/Province</option>');
                    $('#shippingCity').empty().append('<option value="">Select City</option>');
                    $('#shippingZipCode').empty().append('<option value="">Select ZIP/Postal Code</option>');
                }
            });

            // Event handler for shipping state change
            $(document).on('change', '#shippingState', function() {
                const country = $('#shippingCountry').val();
                const state = $(this).val();
                console.log('Shipping state changed - Country:', country, 'State:', state);
                if (country && state) {
                    // COMMENTED OUT: Shipping city and zipcode loading
                    // loadShippingCities(country, state);
                    // loadShippingZipcodes(country, state);
                    
                    // Load zipcodes for search when state is selected (US only)
                    if (country === 'United States' && state) {
                        loadShippingZipcodesForSearch(state);
                    }
                } else {
                    // Clear zipcode suggestions
                    $('#shippingZipCodeSuggestions').hide().empty();
                }
            });


            // Shipping dropdowns are now initialized above

            // Prefill forms with profile data when page loads
            function prefillFormsFromProfile() {
                // Prefill shipping form
                if ('{{ isset($profile_data->shippingAddressLine1) ? $profile_data->shippingAddressLine1 : "" }}') {
                    $('#shippingAddressLine1').val('{{ isset($profile_data->shippingAddressLine1) ? $profile_data->shippingAddressLine1 : "" }}');
                }
                if ('{{ isset($profile_data->shippingAddressLine2) ? $profile_data->shippingAddressLine2 : "" }}') {
                    $('#shippingAddressLine2').val('{{ isset($profile_data->shippingAddressLine2) ? $profile_data->shippingAddressLine2 : "" }}');
                }
                if ('{{ isset($profile_data->shippingZipCode) ? $profile_data->shippingZipCode : "" }}') {
                    $('#shippingZipCode').val('{{ isset($profile_data->shippingZipCode) ? $profile_data->shippingZipCode : "" }}');
                }

                // Prefill billing form
                if ('{{ isset($profile_data->shippingAddressLine1) ? $profile_data->shippingAddressLine1 : "" }}') {
                    $('#addressLine1').val('{{ isset($profile_data->shippingAddressLine1) ? $profile_data->shippingAddressLine1 : "" }}');
                }
                if ('{{ isset($profile_data->shippingAddressLine2) ? $profile_data->shippingAddressLine2 : "" }}') {
                    $('#addressLine2').val('{{ isset($profile_data->shippingAddressLine2) ? $profile_data->shippingAddressLine2 : "" }}');
                }
                if ('{{ isset($profile_data->shippingZipCode) ? $profile_data->shippingZipCode : "" }}') {
                    $('#zipCode').val('{{ isset($profile_data->shippingZipCode) ? $profile_data->shippingZipCode : "" }}');
                }

                // Set shipping dropdown values if profile data exists
                setTimeout(() => {
                    if ('{{ isset($profile_data->shippingCountry) ? $profile_data->shippingCountry : "" }}') {
                        $('#shippingCountry').val('{{ isset($profile_data->shippingCountry) ? $profile_data->shippingCountry : "" }}').trigger('change');
                    }
                    if ('{{ isset($profile_data->shippingState) ? $profile_data->shippingState : "" }}') {
                        $('#shippingState').val('{{ isset($profile_data->shippingState) ? $profile_data->shippingState : "" }}').trigger('change');
                    }
                    if ('{{ isset($profile_data->shippingCity) ? $profile_data->shippingCity : "" }}') {
                        $('#shippingCity').val('{{ isset($profile_data->shippingCity) ? $profile_data->shippingCity : "" }}').trigger('change');
                    }
                }, 2000); // Wait for dropdowns to be fully loaded
            }

            // Call prefill function after a short delay to ensure dropdowns are loaded
            setTimeout(prefillFormsFromProfile, 1000);

            // Primary event handler using event delegation for better reliability
            $(document).on('change', '#sameAsBilling', function() {
                console.log('Delegated event handler triggered!');
                if (this.checked) {
                    console.log('Checkbox is checked via delegation, copying billing data...');
                    // Add loading state
                    const label = $(this).closest('.form-check').find('label');
                    const originalText = label.html();
                    label.html('<i class="fas fa-spinner fa-spin me-2"></i>Copying address...');
                    
                    // Copy billing data to shipping fields
                    setTimeout(() => {
                        populateFromBilling();
                        // Add visual feedback
                        $(this).closest('.form-check').addClass('text-success');
                        label.html('<i class="fas fa-check-circle me-2"></i>Use same address for shipping and billing');
                    }, 500);
                } else {
                    console.log('Checkbox is unchecked via delegation, clearing shipping fields...');
                    // Clear shipping fields when unchecked
                    clearShippingFields();
                    // Remove visual feedback
                    $(this).closest('.form-check').removeClass('text-success');
                    const label = $(this).closest('.form-check').find('label');
                    label.html('<i class="fas fa-copy me-2"></i>Use same address for shipping and billing');
                }
            });

            // Backup click handler for additional reliability
            $(document).on('click', '#sameAsBilling', function() {
                console.log('Click event handler triggered!');
                // Trigger change event to ensure consistency
                $(this).trigger('change');
            });

            // Update form submission to include shipping and billing data
            $('form[action="{{ route("cartCheckout") }}"]').on('submit', function(e) {
                // If checkbox is checked, ensure shipping fields are populated with billing data
                if ($('#sameAsBilling').is(':checked')) {
                    populateFromBilling();
                }

                // Add shipping data to the form before submission
                const shippingData = {
                    'shippingAddressLine1': $('#shippingAddressLine1').val(),
                    'shippingAddressLine2': $('#shippingAddressLine2').val(),
                    'shippingCountry': $('#shippingCountry').val(),
                    'shippingState': $('#shippingState').val(),
                    'shippingCity': $('#shippingCity').val(),
                    'shippingZipCode': $('#shippingZipCode').val()
                };

                // Add billing data to the form before submission
                const billingData = {
                    'addressLine1': $('#addressLine1').val(),
                    'addressLine2': $('#addressLine2').val(),
                    'country': $('#country').val(),
                    'state': $('#state').val(),
                    'city': $('#city').val(),
                    'zipCode': $('#zipCode').val()
                };

                // Add shipping data as hidden fields
                Object.keys(shippingData).forEach(key => {
                    if (shippingData[key]) {
                        const hiddenField = document.createElement('input');
                        hiddenField.type = 'hidden';
                        hiddenField.name = key;
                        hiddenField.value = shippingData[key];
                        this.appendChild(hiddenField);
                    }
                });

                // Add billing data as hidden fields
                Object.keys(billingData).forEach(key => {
                    if (billingData[key]) {
                        const hiddenField = document.createElement('input');
                        hiddenField.type = 'hidden';
                        hiddenField.name = key;
                        hiddenField.value = billingData[key];
                        this.appendChild(hiddenField);
                    }
                });

                // Add delivery option to the form
                const deliveryField = document.createElement('input');
                deliveryField.type = 'hidden';
                deliveryField.name = 'delivery';
                deliveryField.value = $('#deliveryOption').is(':checked') ? '1' : '0';
                this.appendChild(deliveryField);

                // Form will submit normally
            });

            // Function to update profile - temporarily disabled
            /*
            async function updateProfile(formData) {
                try {
                    const response = await fetch('{{ route("saveProfile") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            shippingAddressLine1: formData.get('shippingAddressLine1'),
                            shippingAddressLine2: formData.get('shippingAddressLine2'),
                            shippingCountry: formData.get('shippingCountry'),
                            shippingState: formData.get('shippingState'),
                            shippingCity: formData.get('shippingCity'),
                            shippingZipCode: formData.get('shippingZipCode'),
                            addressLine1: formData.get('addressLine1'),
                            addressLine2: formData.get('addressLine2'),
                            country: formData.get('country'),
                            state: formData.get('state'),
                            city: formData.get('city'),
                            zipCode: formData.get('zipCode')
                        })
                    });
                    
                    if (!response.ok) {
                        throw new Error('Profile update failed');
                    }
                    
                    return await response.json();
                } catch (error) {
                    console.error('Error updating profile:', error);
                    throw error;
                }
            }
            */

            // Function to submit checkout
                function submitCheckout(formData) {
                    // Create a new form and submit
                    const checkoutForm = document.createElement('form');
                    checkoutForm.method = 'POST';
                    checkoutForm.action = '{{ route("cartCheckout") }}';

                    // Add CSRF token
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    checkoutForm.appendChild(csrfInput);

                    // Add all form data
                    for (let [key, value] of formData.entries()) {
                        if (key !== '_token') {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = key;
                            input.value = value;
                            checkoutForm.appendChild(input);
                        }
                    }

                    // Submit the form
                    document.body.appendChild(checkoutForm);
                    checkoutForm.submit();
                }
            */
            // });
            
            // Start the initialization
            initializeEverything();
        }

    }, 100); // Close setTimeout with 100ms delay
</script>

<!-- Clare Chat Component -->
<script src="{{ asset('js/clare-component.js') }}"></script>
