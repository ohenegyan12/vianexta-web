@extends('layouts.new_home_layout')
@section('title', 'Shoping Cart')
@php $donnot_show_footer = true; @endphp
@push('css')
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body {
        background-color: #ECECEC;
        padding-top: 300px;
        /* Account for fixed navbar height */
    }

    /* Loader styles */
    .loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loader {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #d8501c;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .quantity-input {
        transition: all 0.3s ease;
    }

    .quantity-input:focus {
        border-color: #d8501c !important;
        box-shadow: 0 0 0 0.2rem rgba(216, 80, 28, 0.25) !important;
    }

    /* Navbar Styles */
    * {
        box-sizing: border-box;
    }

    html,
    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        width: 100%;
        max-width: 100%;
    }

    body {
        font-family: 'Inter', Arial, sans-serif;
    }

    nav {
        background: #fff;
        border-bottom: 1px solid #f3f4f6;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        width: 100%;
    }

    .container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 0 1rem;
        display: flex;
        align-items: center;
        height: 64px;
        position: relative;
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

    .nav-links {
        display: none;
    }

    .nav-actions {
        display: none;
    }

    .nav-link,
    .nav-action {
        color: #374151;
        text-decoration: none;
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: color 0.2s, background 0.2s, border 0.2s;
        border: none;
        background: none;
        cursor: pointer;
    }

    .nav-link:hover,
    .nav-action:hover {
        color: #111827;
    }

    .nav-action.signin {
        border: 1px solid #d1d5db;
        background: none;
    }

    .nav-action.signin:hover {
        border-color: #9ca3af;
    }

    .nav-action.contact {
        background: #1A4D3A;
        color: #fff;
    }

    .nav-action.contact:hover {
        background: #0f3d2a;
    }

    .mobile-menu-btn {
        display: block;
        background: none;
        border: none;
        color: #374151;
        cursor: pointer;
        padding: 0.5rem;
        margin-left: auto;
    }

    .mobile-menu-btn:focus {
        outline: 2px solid #111827;
    }

    .mobile-menu {
        display: none;
        position: absolute;
        left: 0;
        right: 0;
        top: 64px;
        background: #fff;
        border-bottom: 1px solid #f3f4f6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        z-index: 100;
        animation: fade-in 0.2s;
    }

    .mobile-menu .mobile-link,
    .mobile-menu .mobile-action {
        display: block;
        width: 100%;
        text-align: center;
        color: #374151;
        text-decoration: none;
        padding: 0.75rem 1rem;
        font-size: 1.125rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: color 0.2s, background 0.2s, border 0.2s;
        border: none;
        background: none;
        margin: 0.25rem 0;
    }

    .mobile-menu .mobile-link:hover,
    .mobile-menu .mobile-action:hover {
        color: #111827;
        background: #f3f4f6;
    }

    .mobile-menu .mobile-action.signin {
        border: 1px solid #d1d5db;
        background: none;
    }

    .mobile-menu .mobile-action.signin:hover {
        border-color: #9ca3af;
    }

    .mobile-menu .mobile-action.contact {
        background: #1A4D3A;
        color: #fff;
    }

    .mobile-menu .mobile-action.contact:hover {
        background: #0f3d2a;
    }

    @media (min-width: 768px) {
        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .mobile-menu-btn {
            display: none;
        }

        .mobile-menu {
            display: none !important;
        }

        .user-menu {
            gap: 20px;
        }

        .nav-icons {
            gap: 15px;
        }

        .nav-icon,
        .cart-icon {
            width: 40px;
            height: 40px;
        }

        .nav-icon svg,
        .cart-icon svg {
            width: 20px;
            height: 20px;
        }
    }

    @media (max-width: 767px) {
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

        .nav-icon svg,
        .cart-icon svg {
            width: 16px;
            height: 16px;
        }

        .profile-name {
            padding: 6px 12px;
        }

        .profile-name .user-name {
            font-size: 12px;
        }

        .cart-count {
            width: 18px;
            height: 18px;
            font-size: 10px;
            min-width: 18px;
        }
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .profile-name {
        padding: 8px 16px;
    }

    .profile-name .user-name {
        color: #374151;
        font-weight: 600;
        font-size: 14px;
    }

    .profile-name .user-role {
        color: #6b7280;
        font-size: 11px;
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
        font-size: 10px;
    }

    .profile-name .user-role.seller {
        color: #dc2626;
        background: #fee2e2;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
    }

    .nav-icons {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .nav-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #ffffff;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid #e5e7eb;
    }

    .nav-icon:hover {
        background-color: #f9fafb;
        color: #1A4D3A;
        border-color: #1A4D3A;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(26, 77, 58, 0.15);
    }

    .nav-icon.dashboard:hover {
        background-color: #f0f9ff;
        color: #1A4D3A;
        border-color: #1A4D3A;
    }

    .nav-icon.marketplace:hover {
        background-color: #f0fdf4;
        color: #1A4D3A;
        border-color: #1A4D3A;
    }

    .cart-icon-container {
        position: relative;
    }

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
        transition: all 0.2s;
        border: 1px solid #e5e7eb;
        position: relative;
    }

    .cart-icon:hover {
        background-color: #f9fafb;
        color: #1A4D3A;
        border-color: #1A4D3A;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(26, 77, 58, 0.15);
    }

    .cart-icon svg {
        width: 20px;
        height: 20px;
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
        font-size: 12px;
        font-weight: 600;
        border: 2px solid white;
    }

    .mobile-user-menu {
        padding: 1rem;
        border-top: 1px solid #f3f4f6;
    }

    .mobile-profile-name {
        text-align: center;
        margin-bottom: 1rem;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 0.5rem;
    }

    .mobile-user-name {
        display: block;
        color: #374151;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .mobile-user-role {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .mobile-user-role.buyer {
        color: #059669;
        background: #d1fae5;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.75rem;
        display: inline-block;
        margin-top: 0.25rem;
    }

    .mobile-user-role.seller {
        color: #dc2626;
        background: #fee2e2;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.75rem;
        display: inline-block;
        margin-top: 0.25rem;
    }

    .mobile-nav-icons {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .mobile-nav-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: #f8f9fa;
        border-radius: 0.5rem;
        color: #374151;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        border: 1px solid #e9ecef;
    }

    .mobile-nav-icon:hover {
        background: #1A4D3A;
        color: white;
        border-color: #1A4D3A;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(26, 77, 58, 0.15);
    }

    .mobile-nav-icon.dashboard:hover {
        background: #1A4D3A;
        color: white;
    }

    .mobile-nav-icon.marketplace:hover {
        background: #1A4D3A;
        color: white;
    }

    .mobile-nav-icon svg {
        width: 20px;
        height: 20px;
    }

    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Override Bootstrap primary colors */
    .text-primary {
        color: #1A4D3A !important;
    }

    .btn-primary {
        background-color: #1A4D3A !important;
        border-color: #1A4D3A !important;
        color: white !important;
    }

    .btn-primary:hover {
        background-color: #0f3d2a !important;
        border-color: #0f3d2a !important;
        color: white !important;
    }

    .btn-primary:focus {
        background-color: #1A4D3A !important;
        border-color: #1A4D3A !important;
        box-shadow: 0 0 0 0.25rem rgba(26, 77, 58, 0.25) !important;
    }

    /* Cart Item Styling */
    .card {
        transition: all 0.3s ease;
        border-radius: 12px;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .card-body {
        border-radius: 12px;
    }

    .quantity-input {
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .quantity-input:focus {
        border-color: #1A4D3A !important;
        box-shadow: 0 0 0 0.2rem rgba(26, 77, 58, 0.15) !important;
    }

    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
        transform: translateY(-1px);
    }

    .sticky-top {
        position: sticky;
        top: 100px;
        z-index: 1020;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }

    .text-secondary {
        color: #6c757d !important;
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }

    /* Ensure proper spacing and visibility */
    .card {
        background: white;
        border: none;
        margin-bottom: 1.5rem;
    }

    .card-body {
        background: white;
    }

    /* Better contrast for the page background */
    section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    /* Ensure navbar doesn't overlap content */
    .navbar-fixed-top {
        z-index: 1030;
    }

    /* Improve card visibility */
    .card:hover {
        border-color: #1A4D3A;
        box-shadow: 0 8px 25px rgba(26, 77, 58, 0.15) !important;
    }

    /* Ensure proper spacing from navbar */
    .card:first-child {
        margin-top: 20px;
    }

    /* Additional safety margin for the entire section */
    section {
        position: relative;
        z-index: 1;
    }

    /* Ensure footer is visible and properly styled */
    footer {
        position: relative;
        z-index: 10;
        margin-top: auto;
    }

    /* Fix body layout for fixed navbar */
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* Ensure content area takes remaining space */
    main {
        flex: 1;
    }

    /* Additional spacing for first card to prevent navbar overlap */
    .card:first-child {
        margin-top: 0;
    }

    /* Ensure proper spacing between header and products */
    .sticky-header {
        background: transparent !important;
        border-radius: 0;
    }

    .products-scroll-container {
        margin-top: 70px;
        background: transparent;
    }

    /* Ensure navbar height is accounted for */
    .navbar-height {
        height: 120px;
        display: block;
    }

    /* Force footer background color */
    footer section,
    .footer-section {
        background-color: #1A4D3A !important;
        color: white !important;
    }

    /* Additional safety for content spacing */
    .content-wrapper {
        margin-top: 100px;
        padding-top: 20px;
    }

    /* Static header styling */
    .sticky-header {
        background: #ECECEC;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Products scrollable container */
    .products-scroll-container {
        scrollbar-width: thin;
        scrollbar-color: #1A4D3A #f1f1f1;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
    }

    .products-scroll-container::-webkit-scrollbar {
        width: 8px;
    }

    .products-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .products-scroll-container::-webkit-scrollbar-thumb {
        background: #1A4D3A;
        border-radius: 10px;
        transition: background 0.3s ease;
    }

    .products-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #0f3d2a;
    }

    /* Ensure header text is always visible */
    .sticky-header h1,
    .sticky-header p {
        margin: 0;
        padding: 15px 0;
    }
</style>

@endpush

@section('content')

<!-- Navigation Bar -->
<nav>
    <div class="container">
        <!-- Logo -->
        <div class="nav-logo">
            <a href="{{ route('home_page') }}">
                <img src="{{ asset('new_landing_assets/logo.png') }}" alt="ViaNexta Logo">
            </a>
        </div>
        <!-- Centered Navigation Menu -->
        <div class="nav-center">
            <div class="nav-links">
                <!-- Removed: Why Choose Us, Clare & Forman, Testimonials, Careers -->
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
        <!-- Mobile menu button -->
        <button class="mobile-menu-btn" aria-label="Toggle menu" id="mobileMenuBtn">
            <svg height="24" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
    <!-- Mobile Dropdown Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <!-- Removed: Why Choose Us, Clare & Forman, Testimonials, Careers -->
        @if(session('auth_user_tokin') == null)
        <a href="{{ route('login_page') }}" class="mobile-action signin">Sign In</a>
        <a href="#contact" class="mobile-action contact">Get in touch</a>
        @else
        <div class="mobile-user-menu">
            <div class="mobile-profile-name">
                <span class="mobile-user-name">{{ session('auth_user_name') }}</span>
                <div class="mobile-user-role {{ strtolower(session('auth_user_role')) }}">{{ session('auth_user_role') }}</div>
            </div>
            <div class="mobile-nav-icons">
                <a href="{{ session('auth_user_role') == 'Buyer' ? route('buyerDashboard') : route('sellersDashboardHome') }}" class="mobile-nav-icon dashboard" title="Dashboard">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 20.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ session('auth_user_role') == 'Buyer' ? route('buyer_new_wizard') : route('sellers_add_product') }}" class="mobile-nav-icon marketplace" title="{{ session('auth_user_role') == 'Buyer' ? 'Marketplace' : 'Add Product' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.7 15.3C4.3 15.7 4.6 16.5 5.1 16.5H17M17 13V17C17 17.6 16.6 18 16 18H8C7.4 18 7 17.6 7 17V13H17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>{{ session('auth_user_role') == 'Buyer' ? 'Marketplace' : 'Add Product' }}</span>
                </a>
                <a href="{{ session('auth_user_role') == 'Buyer' ? route('buyer_cart') : route('sellersDashboardHome') }}" class="mobile-nav-icon" title="{{ session('auth_user_role') == 'Buyer' ? 'Cart' : 'Orders' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>{{ session('auth_user_role') == 'Buyer' ? 'Cart' : 'Orders' }}</span>
                </a>
                <a href="{{ route('logout') }}" class="mobile-nav-icon" title="Logout" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Logout</span>
                </a>
                <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        @endif
    </div>
</nav>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Loader Overlay -->
<div class="loader-overlay" id="loaderOverlay">
    <div class="loader"></div>
</div>

{{-- STATIC HEADER SECTION --}}
<div class="" style="position: sticky; top: 100px; padding: 20px 0; margin-bottom: 30px; background: transparent;">
    <div class="container px-2 px-lg-3">
        <div class="row gx-4 gx-lg-5">
            <div class="col-md-12">
                <div class="position-relative">
                    <h1 class="display-6 fw-bolder text-primary">My Shopping Cart</h1>
                    <p class="font-medium md:text-lg text-secondary">{{count($cart_items)}} <span>item(s)</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CART SECTION --}}
<section class="pt-5" style="min-height:100vh; padding-top: 500px;  top: 200px;">
    <!-- Spacer to prevent navbar overlap -->
    <div class="navbar-height"></div>
    <div class="container px-2 px-lg-3">
        <div class="row gx-4 gx-lg-5">
            <div class="col-lg-8 mb-md-5">
                <div class="products-scroll-container" style="max-height: 70vh; overflow-y: auto; padding-right: 10px; margin-top: 70px;">
                    @php $total_price=0; @endphp
                    @foreach($cart_items as $cart_item)
                    @php $total_price=$total_price + ($cart_item->stockPosting->bagPrice * $cart_item->numBags * $cart_item->stockPosting->bagWeight); @endphp

                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <!-- Product Image -->
                                <div class="col-md-3 col-lg-2 mb-3 mb-md-0">
                                    <img class="img-fluid rounded" style="width: 100%; height: 120px; object-fit: cover;"
                                        src="{{ $cart_item->stockPosting->imageUrl !=null ? urldecode($cart_item->stockPosting->imageUrl) : asset('images/market_place/prod_sub.png') }}"
                                        alt="product">
                                </div>

                                <!-- Product Details -->
                                <div class="col-md-6 col-lg-7 mb-3 mb-md-0">
                                    <h6 class="fw-bold text-secondary mb-2" style="text-transform:uppercase">
                                        {{$cart_item->stockPosting->description}}
                                    </h6>

                                    <div class="row text-muted small">
                                        <div class="col-6">
                                            <p class="mb-1"><strong>Species:</strong> {{$cart_item->stockPosting->coffeeType}}</p>
                                            @if($cart_item->stockPosting->productType != 'whole_sale_brand')
                                            <p class="mb-1"><strong>Package:</strong> {{$cart_item->stockPosting->bagWeight}} lb</p>
                                            @endif
                                            <p class="mb-1"><strong>Location:</strong> {{$cart_item->stockPosting->supplierInfo->billingCountry}}</p>
                                        </div>
                                        <div class="col-6">
                                            @if($cart_item->isRoast)
                                            <p class="mb-1">
                                                <span class="badge rounded-pill text-bg-warning">
                                                    <span class="fa fa-circle text-c-red f-10 m-r-5" style="color:#07382F;"></span>Roasted
                                                </span>
                                            </p>
                                            <p class="mb-1"><strong>Roast Type:</strong> {{ucfirst($cart_item->roastType)}}</p>
                                            <p class="mb-1"><strong>Grind Type:</strong> {{ucfirst($cart_item->grindType)}}</p>
                                            <p class="mb-1"><strong>Bag Size:</strong> {{$helper->getBagDetails($cart_item->bagSize)['title']}}</p>
                                            @else
                                            <p class="mb-1">
                                                <span class="badge rounded-pill text-bg-success">
                                                    <span class="fa fa-circle text-c-red f-10 m-r-5" style="color:#D8501C;"></span>{{$cart_item->stockPosting->productType}}
                                                </span>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Price, Quantity, Total, Actions -->
                                <div class="col-md-3 col-lg-3">
                                    <div class="text-end">
                                        <p class="mb-2"><strong>Price:</strong> ${{$helper->formatMoney($cart_item->stockPosting->bagPrice)}}</p>

                                        <div class="mb-3">
                                            <label class="form-label small mb-1"><strong>Quantity:</strong></label>
                                            <input type="number" class="quantity-input form-control form-control-sm"
                                                value="{{ $cart_item->numBags }}" name="quantity"
                                                placeholder="1" min="1"
                                                data-stock-posting-id="{{ $helper->encode($cart_item->stockPosting->id) }}"
                                                data-is-roast="{{ $cart_item->isRoast }}"
                                                data-roast-type="{{ $cart_item->roastType }}"
                                                data-grind-type="{{ $cart_item->grindType }}"
                                                data-bag-size="{{ $cart_item->bagSize }}"
                                                data-bag-image="{{ $cart_item->bagImage }}">
                                            @if($errors->has('quantity'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('quantity') }}
                                            </div>
                                            @endif
                                        </div>

                                        <p class="mb-2"><strong>Total:</strong> ${{$helper->formatMoney($cart_item->stockPosting->bagPrice * $cart_item->numBags * $cart_item->stockPosting->bagWeight)}}</p>

                                        <div class="mt-3">
                                            @php
                                            $product_data = array('stockPostingId'=>$cart_item->stockPosting->id,'numBags'=>$cart_item->numBags,'isRoast'=>$cart_item->isRoast,'roastType'=>$cart_item->roastType,'grindType'=>$cart_item->grindType,'bagSize'=>$cart_item->bagSize,'bagImage'=>$cart_item->bagImage);
                                            $product_data = $helper->encryptData(json_encode($product_data));
                                            @endphp
                                            <a href="{{ route('deleteOrder',$helper->encode($cart_item->stockPosting->id))}}"
                                                class="btn btn-outline-danger btn-sm">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="col-lg-4" style="margin-top: 100px;">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 fw-bold">Order Summary</h5>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-semibold">Subtotal:</span>
                            <span class="fw-bold">${{$helper->formatMoney($total_price)}}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-semibold">Taxes & Shipping:</span>
                            <span class="text-muted">Calculated at checkout</span>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 fw-bold">Total:</span>
                            <span class="h5 fw-bold text-primary">${{$helper->formatMoney($total_price)}}</span>
                        </div>

                        <a href="{{route('buyerCheckout')}}" class="btn btn-primary w-100 mb-3">
                            Proceed to Checkout <span class="fa fa-arrow-right ms-2"></span>
                        </a>

                        <div class="text-center">
                            <a href="{{route('buyer_new_wizard')}}" class="text-decoration-none" style="color:#d8501c;">
                                <i class="fa fa-plus me-1"></i> Add More to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('new_web_pages.buyer_pages.order_placed_modal')
@endsection

<script>
    // Scroll handler for navbar
    window.addEventListener('scroll', function() {
        var nav = document.querySelector('nav');
        if (window.scrollY > 0) {
            nav.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
        } else {
            nav.style.boxShadow = 'none';
        }
    });

    // Quantity update functionality
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInputs = document.querySelectorAll('.quantity-input');
        let updateTimeout;

        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                const stockPostingId = this.getAttribute('data-stock-posting-id');
                const quantity = this.value;
                const isRoast = this.getAttribute('data-is-roast');
                const roastType = this.getAttribute('data-roast-type');
                const grindType = this.getAttribute('data-grind-type');
                const bagSize = this.getAttribute('data-bag-size');
                const bagImage = this.getAttribute('data-bag-image');

                // Validate quantity
                if (quantity < 1) {
                    this.value = 1;
                    return;
                }

                // Show loader
                showLoader();

                // Prepare payload for API
                const payload = {
                    stockPostingId: stockPostingId,
                    numBags: parseInt(quantity),
                    isRoast: isRoast === '1',
                    roastType: roastType,
                    grindType: grindType,
                    bagSize: bagSize,
                    bagImage: bagImage
                };

                // Update cart item
                updateCartItem(payload);
            });
        });

        function updateCartItem(payload) {
            // Create form data for the update_order route
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('product_id', payload.stockPostingId);
            formData.append('num_of_bags', payload.numBags);
            formData.append('roast_type', payload.roastType || '');
            formData.append('grind_type', payload.grindType || '');
            formData.append('bag_size', payload.bagSize || '');
            formData.append('bag_image', payload.bagImage || '');

            // Make API call to update cart item using update_order route
            fetch('{{ route("updateOrder") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to show updated data
                        window.location.reload();
                    } else {
                        console.error('Error updating cart item:', data.message);
                        hideLoader();
                        alert('Error updating quantity. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoader();
                    alert('Error updating quantity. Please try again.');
                });
        }

        function showLoader() {
            document.getElementById('loaderOverlay').style.display = 'flex';
        }

        function hideLoader() {
            document.getElementById('loaderOverlay').style.display = 'none';
        }
    });

    // Mobile Menu JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                const isOpen = mobileMenu.style.display === 'block';
                mobileMenu.style.display = isOpen ? 'none' : 'block';

                // Update button icon
                if (isOpen) {
                    mobileMenuBtn.innerHTML = '<svg height="24" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>';
                } else {
                    mobileMenuBtn.innerHTML = '<svg height="24" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
                }
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenuBtn.contains(event.target) && !mobileMenu.contains(event.target)) {
                    mobileMenu.style.display = 'none';
                    mobileMenuBtn.innerHTML = '<svg height="24" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>';
                }
            });
        }
    });
</script>