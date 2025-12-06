@extends('layouts.new_home_layout')
@section('title', 'Order Tracking')
@push('css')
<style>
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
        position: sticky;
        top: 0;
        z-index: 50;
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
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .nav-icon:hover {
        background-color: #ffffff;
        color: #1A4D3A;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }

    .nav-icon.dashboard:hover {
        background-color: #f0f9ff;
        color: #1A4D3A;
        border: 1px solid #1A4D3A;
    }

    .nav-icon.marketplace:hover {
        background-color: #f0fdf4;
        color: #1A4D3A;
        border: 1px solid #1A4D3A;
    }

    .nav-icon svg {
        width: 18px;
        height: 18px;
    }

    .cart-icon-container {
        position: relative;
        display: inline-block;
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
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .cart-icon:hover {
        background-color: #ffffff;
        color: #1A4D3A;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }

    .cart-icon svg {
        width: 18px;
        height: 18px;
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

    .mobile-user-menu {
        padding: 1rem;
        border-top: 1px solid #f3f4f6;
    }

    .mobile-profile-name {
        text-align: center;
        margin-bottom: 1rem;
        padding: 0.5rem;
    }

    .mobile-user-name {
        color: #374151;
        font-weight: 600;
        font-size: 14px;
    }

    .mobile-user-role {
        color: #6b7280;
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }

    .mobile-user-role.buyer {
        color: #059669;
        background: #d1fae5;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
    }

    .mobile-user-role.seller {
        color: #dc2626;
        background: #fee2e2;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
    }

    .mobile-nav-icons {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .mobile-nav-icon {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: #374151;
        text-decoration: none;
        border-radius: 0.375rem;
        transition: all 0.2s;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .mobile-nav-icon:hover {
        background-color: #f3f4f6;
        color: #111827;
    }

    .mobile-nav-icon svg {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
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

    /* Order tracking specific styles */
    .text-primary {
        color: #1A4D3A !important;
    }

    .text-secondary {
        color: #6b7280 !important;
    }

    /* Main page centering */
    .main-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
        margin-top: 64px;
        /* Add margin to account for navbar height */
    }

    #progressbar {
        list-style: none;
        padding: 0;
        margin: 2rem auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        max-width: 1000px;
        position: relative;
        gap: 0;
    }

    #progressbar li {
        flex: 1;
        text-align: center;
        position: relative;
        padding: 0 10px;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Progress line between stages - only show for first 3 stages */
    #progressbar li:nth-child(1)::after,
    #progressbar li:nth-child(2)::after {
        content: '';
        position: absolute;
        top: 35px;
        left: calc(50% + 25px);
        width: calc(100% - 50px);
        height: 3px;
        background: #1A4D3A;
        z-index: 1;
    }

    #progressbar li:nth-child(3)::after {
        display: none;
        /* Remove line before "Delivered" stage */
    }

    /* Progress circle indicators with better visual cues */
    #progressbar li::before {
        content: '';
        position: relative;
        top: 0;
        left: 0;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #1A4D3A;
        border: 4px solid #fff;
        box-shadow: 0 0 0 4px #1A4D3A;
        z-index: 3;
        transition: all 0.3s ease;
        margin-bottom: 25px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Add checkmark for completed stages */
    #progressbar li.active::before {
        background: #1A4D3A;
        box-shadow: 0 0 0 4px #1A4D3A;
    }

    #progressbar li.active::before::after {
        content: '✓';
        color: white;
        font-size: 20px;
        font-weight: bold;
        line-height: 1;
    }

    #progressbar li:not(.active)::before {
        background: #fff;
        border-color: #d1d5db;
        box-shadow: 0 0 0 4px #d1d5db;
    }

    /* Progress text labels */
    #progressbar li h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: #1A4D3A;
        transition: all 0.3s ease;
        line-height: 1.3;
        text-align: center;
        max-width: 120px;
        word-wrap: break-word;
    }

    #progressbar li.active h3 {
        color: #1A4D3A;
        font-weight: 700;
    }

    #progressbar li:not(.active) h3 {
        color: #9ca3af;
        font-weight: 500;
    }

    /* Progress bar container styling */
    .progress-container {
        background: #f8f9fa;
        border-radius: 20px;
        padding: 3rem 2rem;
        margin: 2rem 0;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
        position: relative;
        overflow: hidden;
    }

    .progress-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #1A4D3A 0%, #1A4D3A 50%, #e5e7eb 50%, #e5e7eb 100%);
    }

    /* Hero section improvements */
    .hero-section {
        text-align: center;
        padding: 0;
        width: 100%;
    }

    .hero-section h1 {
        margin-bottom: 3rem;
        line-height: 1.2;
        font-size: 2.5rem;
    }

    .tracking-image {
        max-width: 160px;
        margin-bottom: 2.5rem;
        opacity: 0.9;
        filter: drop-shadow(0 4px 8px rgba(26, 77, 58, 0.1));
    }

    /* Content container that matches navbar width */
    .content-container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 0 1rem;
        width: 100%;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .main-wrapper {
            padding: 1rem 0;
        }

        #progressbar {
            flex-direction: column;
            gap: 2rem;
            max-width: 100%;
            margin: 1.5rem auto;
        }

        #progressbar li {
            flex: none;
            width: 100%;
        }

        #progressbar li::after {
            display: none;
        }

        #progressbar li::before {
            margin-bottom: 20px;
            width: 45px;
            height: 45px;
        }

        #progressbar li.active::before::after {
            font-size: 18px;
        }

        #progressbar li h3 {
            margin-top: 0;
            font-size: 1rem;
            max-width: 200px;
        }

        .progress-container {
            padding: 2rem 1.5rem;
            margin: 1.5rem 0;
        }

        .hero-section h1 {
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .tracking-image {
            max-width: 140px;
            margin-bottom: 2rem;
        }
    }

    @media (max-width: 480px) {
        .hero-section h1 {
            font-size: 1.75rem;
        }

        .progress-container {
            padding: 1.5rem 1rem;
        }

        #progressbar li h3 {
            font-size: 0.9rem;
        }

        .tracking-image {
            max-width: 120px;
        }
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
                            <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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

<!-- Main Content -->
<main class="py-4 pb-40 sm:py-8 h-5/6">
    <div class="main-wrapper">
        <div class="content-container">
            {{-- HERO SECTION --}}
            <section class="hero-section">
                <div class="container px-2 px-lg-3">
                    <div class="row gx-4 gx-lg-5">
                        <div class="col-md-12">
                            <div class="position-relative text-center">
                                <img class="tracking-image" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out" src="{{ asset('images/market_place/track_image.svg') }}"
                                    alt="Order Tracking">
                                <h1 class="display-6 fw-bolder text-primary" data-aos="fade-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="2000" data-aos-easing="ease-in-out">Your order #234325235 is <span class="text-secondary">being processed</span></h1>

                                <div class="progress-container" data-aos="fade-up" data-aos-offset="250" data-aos-delay="60" data-aos-duration="3000" data-aos-easing="ease-in-out">
                                    <ul id="progressbar" class="text-center">
                                        <li class="active step0">
                                            <h3>Order placed</h3>
                                        </li>
                                        <li class="active step0">
                                            <h3>Being processed</h3>
                                        </li>
                                        <li class="step0">
                                            <h3>On it's way</h3>
                                        </li>
                                        <li class="step0">
                                            <h3>Delivered</h3>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

@endsection

@section('scripts')
<script>
    // Mobile menu functionality
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.style.display = mobileMenu.style.display === 'block' ? 'none' : 'block';
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenuBtn.contains(event.target) && !mobileMenu.contains(event.target)) {
                    mobileMenu.style.display = 'none';
                }
            });
        }
    });

    window.addEventListener('scroll', function() {
        var header = document.getElementById('app_header');
        if (window.scrollY > 0) {
            header.style.backgroundColor = '#FFFF';

        } else {
            header.style.backgroundColor = '#FFFF';
        }
    });
</script>
@endsection