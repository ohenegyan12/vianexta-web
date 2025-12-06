@extends('layouts.new_home_layout')
@section('title', 'Help')

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
        background: #06382F;
        color: #fff;
    }

    .nav-action.contact:hover {
        background: #054a3a;
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
        background: #06382F;
        color: #fff;
    }

    .mobile-menu .mobile-action.contact:hover {
        background: #054a3a;
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
        color: #06382F;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }

    .nav-icon.dashboard:hover {
        background-color: #f0f9ff;
        color: #0369a1;
        border: 1px solid #0ea5e9;
    }

    .nav-icon.marketplace:hover {
        background-color: #f0fdf4;
        color: #16a34a;
        border: 1px solid #22c55e;
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
        color: #06382F;
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

    /* Help page specific styles */
    .help-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .help-category {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .help-category:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .help-category h4 {
        color: #07382f;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .help-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .help-button {
        background: white;
        border: 2px solid #07382f;
        color: #07382f;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        text-align: center;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .help-button:hover {
        background: #07382f;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(7, 56, 47, 0.3);
    }

    .contact-section {
        background: linear-gradient(135deg, #07382f 0%, #0a4a3a 100%);
        color: white;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        margin-top: 2rem;
    }

    .contact-section h3 {
        color: white;
        margin-bottom: 1rem;
    }

    .contact-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 1.5rem;
    }

    .contact-button {
        background: white;
        color: #07382f;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .contact-button:hover {
        background: #f8f9fa;
        color: #07382f;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Content container that matches navbar width */
    .content-container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 0;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease-out;
        position: relative;
        max-height: 80vh;
        overflow-y: auto;
    }

    .modal-header {
        background: linear-gradient(135deg, #07382f 0%, #0a4a3a 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 12px 12px 0 0;
        position: relative;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .modal-close {
        position: absolute;
        right: 1.5rem;
        top: 1.5rem;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-body h4 {
        color: #07382f;
        margin-bottom: 1rem;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .modal-body p {
        color: #4b5563;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .modal-body ul {
        color: #4b5563;
        line-height: 1.6;
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }

    .modal-body li {
        margin-bottom: 0.5rem;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
        border-radius: 0 0 12px 12px;
        text-align: center;
    }

    .modal-footer .btn {
        background: #07382f;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .modal-footer .btn:hover {
        background: #0a4a3a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(7, 56, 47, 0.3);
    }

    .modal-footer .btn-secondary {
        background: #6b7280;
        margin-left: 1rem;
    }

    .modal-footer .btn-secondary:hover {
        background: #4b5563;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px) scale(0.9);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @media (max-width: 768px) {
        .modal-content {
            width: 95%;
            margin: 10% auto;
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 1rem;
        }

        .modal-footer .btn {
            display: block;
            width: 100%;
            margin: 0.5rem 0;
        }
    }

    @media (max-width: 768px) {
        .help-buttons {
            grid-template-columns: 1fr;
        }

        .contact-buttons {
            flex-direction: column;
            align-items: center;
        }

        .contact-button {
            width: 100%;
            max-width: 300px;
        }
    }

    /* Chat functionality styles */
    .clare-chat-btn {
        position: fixed;
        z-index: 9999;
        bottom: 2rem;
        right: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        border-radius: 9999px;
        background: #07382F;
        color: #fff;
        font-weight: 500;
        font-size: 1.25rem;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 4px 24px 0 rgba(7, 56, 47, 0.15);
        border: none;
        cursor: pointer;
        transition: background 0.3s, color 0.3s, border 0.3s;
    }

    .clare-chat-btn:hover {
        background: #0a4a3a;
        transform: translateY(-2px);
        box-shadow: 0 6px 28px 0 rgba(7, 56, 47, 0.25);
    }

    .clare-chat-icon {
        width: 1.75rem;
        height: 1.75rem;
        display: inline-block;
        transition: filter 0.3s;
        user-select: none;
        pointer-events: none;
    }

    .clare-chat-text {
        font-family: 'Inter', sans-serif;
        font-weight: 500;
    }

    .clare-chat-drawer {
        position: fixed;
        top: 0;
        right: 0;
        height: 100vh;
        width: 100%;
        max-width: 400px;
        z-index: 99999;
        background: #f5f7fc;
        box-shadow: -4px 0 24px 0 rgba(7, 56, 47, 0.15);
        border-top-left-radius: 16px;
        border-bottom-left-radius: 16px;
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        transition: transform 0.3s cubic-bezier(.4, 0, .2, 1);
        pointer-events: none;
        visibility: hidden;
        /* Ensure proper initial state */
        will-change: transform;
        backface-visibility: hidden;
        /* Fix positioning to prevent cutting through content */
        overflow: hidden;
        box-sizing: border-box;
        /* Ensure proper stacking context */
        isolation: isolate;
    }

    .clare-chat-drawer.open {
        transform: translateX(0) !important;
        pointer-events: auto;
        visibility: visible;
        /* Ensure proper layering */
        z-index: 99999;
    }

    /* Add backdrop when chat is open to prevent content interaction */
    .clare-chat-drawer.open::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
        z-index: -1;
        pointer-events: auto;
    }

    .clare-chat-content {
        background: #f5f7fc;
        border-radius: 16px 0 0 16px;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .clare-chat-drawer.open .clare-chat-content {
        /* No transform needed for side drawer */
    }

    .clare-chat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        background: #fff;
        border-radius: 16px 16px 0 0;
        border-bottom: 1px solid #e5e7eb;
        flex-shrink: 0;
    }

    .clare-chat-header-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .clare-chat-logo {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
    }

    .clare-chat-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: #07382f;
    }

    .clare-chat-close {
        background: none;
        border: none;
        padding: 0.5rem;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .clare-chat-close:hover {
        background: #f3f4f6;
        color: #374151;
        transform: scale(1.1);
    }

    .clare-chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
        background: #f5f7fc;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        min-height: 400px;
        max-height: 600px;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    .clare-chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    .clare-chat-messages::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .clare-chat-messages::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .clare-chat-messages::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .clare-chat-message-user {
        align-self: flex-end;
        background: #07382f;
        color: #fff;
        padding: 0.875rem 1.25rem;
        border-radius: 1.25rem;
        box-shadow: 0 2px 8px rgba(7, 56, 47, 0.2);
        max-width: 80%;
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.4;
    }

    .clare-chat-message-bot {
        align-self: flex-start;
        background: #fff;
        color: #222;
        padding: 1rem 1.25rem;
        border-radius: 1rem;
        border: 1px solid #b6e2b6;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        max-width: 90%;
        display: flex;
        gap: 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
    }

    .clare-chat-bot-avatar {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        margin-top: 0.125rem;
        flex-shrink: 0;
    }

    .clare-chat-message-bot-content {
        flex: 1;
    }

    .clare-chat-message-typing {
        color: #888;
        font-style: italic;
        opacity: 0.7;
    }

    .clare-chat-input-area {
        display: flex;
        align-items: flex-end;
        gap: 0.75rem;
        padding: 1.25rem 1.5rem;
        background: #fff;
        border-radius: 0 0 16px 16px;
        border-top: 1px solid #e5e7eb;
        flex-shrink: 0;
        position: sticky;
        bottom: 0;
        margin-top: auto;
    }

    .clare-chat-input {
        flex: 1;
        padding: 0.875rem 1.25rem;
        border-radius: 1.5rem;
        border: 2px solid #e5e7eb;
        background: #f9fafb;
        font-size: 1rem;
        color: #374151;
        font-weight: 500;
        outline: none;
        resize: none;
        min-height: 3.5rem;
        max-height: 12rem;
        transition: all 0.2s;
        font-family: inherit;
        line-height: 1.5;
    }

    .clare-chat-input:focus {
        border-color: #07382f;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(7, 56, 47, 0.1);
    }

    .clare-chat-send {
        background: #07382f;
        border: none;
        border-radius: 50%;
        width: 2.75rem;
        height: 2.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        min-width: 2.75rem;
        min-height: 2.75rem;
        flex-shrink: 0;
    }

    .clare-chat-send:hover {
        background: #0a4a3a;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(7, 56, 47, 0.3);
    }

    .clare-chat-send:active {
        transform: scale(0.95);
    }

    .clare-chat-send-icon {
        width: 1.25rem;
        height: 1.25rem;
        filter: brightness(0) invert(1);
    }

    .clare-chat-message-user,
    .clare-chat-message-bot {
        word-break: break-word;
        overflow-wrap: anywhere;
        white-space: pre-line;
        max-width: 90%;
        box-sizing: border-box;
    }

    @media (max-width: 768px) {
        .clare-chat-drawer {
            max-width: 100%;
            width: 100%;
            /* Ensure full width on mobile */
            right: 0;
            left: 0;
        }

        .clare-chat-content {
            border-radius: 0;
            /* Full width content on mobile */
            width: 100%;
        }

        .clare-chat-messages {
            min-height: 350px;
            max-height: 500px;
            padding: 1rem;
        }

        .clare-chat-header {
            padding: 1rem 1.25rem;
        }

        .clare-chat-input-area {
            padding: 1rem 1.25rem;
            padding-bottom: calc(1rem + env(safe-area-inset-bottom, 0px));
            margin-bottom: env(safe-area-inset-bottom, 0px);
        }

        .clare-chat-title {
            font-size: 1.125rem;
        }

        .clare-chat-logo {
            width: 2rem;
            height: 2rem;
        }

        /* Ensure chat drawer doesn't interfere with page content on mobile */
        .clare-chat-drawer.open {
            transform: translateX(0) !important;
            width: 100%;
            max-width: 100%;
        }

        /* Ensure input area has proper height on mobile */
        .clare-chat-input {
            min-height: 3rem;
            max-height: 10rem;
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
    <div class="content-container">
        <div class="w-full">

            <!-- Welcome Section -->
            <div class="help-section">
                <h1 class="mb-4 text-3xl font-bold text-secondary">Hello there!</h1>
                <p class="text-lg text-gray-600">Welcome to ViaNexta Exchange support. You can quickly fix your problem here, or we'll connect you to someone who can.</p>
            </div>

            <!-- Help Categories -->
            <div class="help-category">
                <h4 class="text-xl font-semibold">Payment Issues</h4>
                <div class="help-buttons">
                    <button class="help-button" data-modal="payment-method">Update payment method</button>
                    <button class="help-button" data-modal="payment-declined">Payment declined</button>
                    <button class="help-button" data-modal="refund-request">Refund request</button>
                    <button class="help-button" data-modal="billing-questions">Billing questions</button>
                </div>
            </div>

            <div class="help-category">
                <h4 class="text-xl font-semibold">Account & Security</h4>
                <div class="help-buttons">
                    <button class="help-button" data-modal="login-security">Login & Security</button>
                    <button class="help-button" data-modal="update-address">Update address</button>
                    <button class="help-button" data-modal="password-reset">Password reset</button>
                    <button class="help-button" data-modal="privacy-settings">Privacy settings</button>
                </div>
            </div>

            <div class="help-category">
                <h4 class="text-xl font-semibold">Trading & Orders</h4>
                <div class="help-buttons">
                    <button class="help-button" data-modal="order-status">Order status</button>
                    <button class="help-button" data-modal="shipping-issues">Shipping issues</button>
                    <button class="help-button" data-modal="product-questions">Product questions</button>
                    <button class="help-button" data-modal="return-policy">Return policy</button>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="contact-section">
                <h3 class="text-2xl font-bold">Still need help?</h3>
                <p class="mb-4">Our support team is here to help you with any questions or concerns.</p>
                <div class="contact-buttons">
                    <a href="mailto:winner@winwin.coffee?cc=matthew@winwin.coffee,nikisha@winwin.coffee" class="contact-button">
                        <i class="fas fa-envelope me-2"></i>Email us
                    </a>
                    <a href="tel:+1234567890" class="contact-button">
                        <i class="fas fa-phone me-2"></i>Call us
                    </a>
                    <button class="contact-button" onclick="openClareChatWithContext('general help')">
                        <i class="fas fa-comments me-2"></i>Talk to Clare
                    </button>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- Payment Method Modal -->
<div id="payment-method-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Update Payment Method</h3>
            <button class="modal-close" onclick="closeModal('payment-method-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <h4>How to update your payment method</h4>
            <p>Follow these steps to update your payment information:</p>
            <ol>
                <li>Go to your Account Settings</li>
                <li>Click on "Payment Methods"</li>
                <li>Select "Add New Payment Method"</li>
                <li>Enter your new card details</li>
                <li>Click "Save" to update</li>
            </ol>
            <h4>Accepted payment methods</h4>
            <ul>
                <li>Visa, Mastercard, American Express</li>
                <li>PayPal</li>
                <li>Bank transfers (for verified accounts)</li>
            </ul>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="openClareChatWithContext('payment method update')">Talk to Clare</button>
            <button class="btn btn-secondary" onclick="closeModal('payment-method-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Payment Declined Modal -->
<div id="payment-declined-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Payment Declined</h3>
            <button class="modal-close" onclick="closeModal('payment-declined-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <h4>Common reasons for payment decline</h4>
            <ul>
                <li><strong>Insufficient funds:</strong> Your account doesn't have enough balance</li>
                <li><strong>Card expired:</strong> Check your card's expiration date</li>
                <li><strong>Incorrect CVV:</strong> Verify the 3-digit security code</li>
                <li><strong>Bank restrictions:</strong> Contact your bank for assistance</li>
            </ul>
            <h4>What to do next</h4>
            <p>Try using a different payment method or contact your bank to resolve the issue. If the problem persists, our support team is here to help.</p>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="openClareChatWithContext('payment declined')">Talk to Clare</button>
            <button class="btn btn-secondary" onclick="closeModal('payment-declined-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Refund Request Modal -->
<div id="refund-request-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Refund Request</h3>
            <button class="modal-close" onclick="closeModal('refund-request-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <h4>How to request a refund</h4>
            <p>To request a refund for your order:</p>
            <ol>
                <li>Go to your Order History</li>
                <li>Find the order you want to refund</li>
                <li>Click "Request Refund"</li>
                <li>Select the reason for refund</li>
                <li>Submit your request</li>
            </ol>
            <h4>Refund processing time</h4>
            <ul>
                <li>Credit card refunds: 5-10 business days</li>
                <li>PayPal refunds: 3-5 business days</li>
                <li>Bank transfers: 7-14 business days</li>
            </ul>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="openClareChatWithContext('refund request')">Talk to Clare</button>
            <button class="btn btn-secondary" onclick="closeModal('refund-request-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Billing Questions Modal -->
<div id="billing-questions-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Billing Questions</h3>
            <button class="modal-close" onclick="closeModal('billing-questions-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <h4>Understanding your bill</h4>
            <p>Your bill includes:</p>
            <ul>
                <li><strong>Transaction fees:</strong> Standard 2.9% + $0.30 per transaction</li>
                <li><strong>Processing fees:</strong> Varies by payment method</li>
                <li><strong>Service charges:</strong> Applied for premium features</li>
            </ul>
            <h4>Need help with billing?</h4>
            <p>Our billing team can help you understand charges, resolve disputes, and provide detailed statements. Contact us for personalized assistance.</p>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="openClareChatWithContext('billing questions')">Talk to Clare</button>
            <button class="btn btn-secondary" onclick="closeModal('billing-questions-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Login & Security Modal -->
<div id="login-security-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Login & Security</h3>
            <button class="modal-close" onclick="closeModal('login-security-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <h4>Secure your account</h4>
            <p>Protect your account with these security measures:</p>
            <ul>
                <li><strong>Two-factor authentication:</strong> Enable 2FA for extra security</li>
                <li><strong>Strong password:</strong> Use a unique, complex password</li>
                <li><strong>Login alerts:</strong> Get notified of new logins</li>
                <li><strong>Session management:</strong> Review active sessions</li>
            </ul>
            <h4>Security best practices</h4>
            <p>Never share your login credentials, enable 2FA, and regularly review your account activity for any suspicious behavior.</p>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="openClareChatWithContext('login and security')">Talk to Clare</button>
            <button class="btn btn-secondary" onclick="closeModal('login-security-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Update Address Modal -->
<div id="update-address-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Update Address</h3>
            <button class="modal-close" onclick="closeModal('update-address-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <h4>How to update your address</h4>
            <p>Keep your address current to ensure smooth order delivery:</p>
            <ol>
                <li>Go to Account Settings</li>
                <li>Click "Profile Information"</li>
                <li>Update your shipping address</li>
                <li>Add billing address if different</li>
                <li>Save your changes</li>
            </ol>
            <h4>Address verification</h4>
            <p>We may verify your address for security purposes. Please ensure all information is accurate and up-to-date.</p>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="openClareChatWithContext('update address')">Talk to Clare</button>
            <button class="btn btn-secondary" onclick="closeModal('update-address-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Password Reset Modal -->
<div id="password-reset-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Password Reset</h3>
            <button class="modal-close" onclick="closeModal('password-reset-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <h4>Reset your password</h4>
            <p>If you've forgotten your password:</p>
            <ol>
                <li>Click "Forgot Password" on login page</li>
                <li>Enter your email address</li>
                <li>Check your email for reset link</li>
                <li>Click the link and create new password</li>
                <li>Login with your new password</li>
            </ol>
            <h4>Password requirements</h4>
            <ul>
                <li>Minimum 8 characters</li>
                <li>Include uppercase and lowercase letters</li>
                <li>Include numbers and special characters</li>
                <li>Don't reuse old passwords</li>
            </ul>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="openClareChatWithContext('password reset')">Talk to Clare</button>
            <button class="btn btn-secondary" onclick="closeModal('password-reset-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Privacy Settings Modal -->
<div id="privacy-settings-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Privacy Settings</h3>
            <button class="modal-close" onclick="closeModal('privacy-settings-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <h4>Control your privacy</h4>
            <p>Manage how your information is used:</p>
            <ul>
                <li><strong>Data sharing:</strong> Control what data we share with partners</li>
                <li><strong>Marketing preferences:</strong> Opt in/out of promotional emails</li>
                <li><strong>Profile visibility:</strong> Control who can see your profile</li>
                <li><strong>Data export:</strong> Download your personal data</li>
            </ul>
            <h4>Your rights</h4>
            <p>You have the right to access, modify, or delete your personal information at any time through your privacy settings.</p>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="openClareChatWithContext('privacy settings')">Talk to Clare</button>
            <button class="btn btn-secondary" onclick="closeModal('privacy-settings-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Order Status Modal -->
<div id="order-status-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Order Status</h3>
            <button class="modal-close" onclick="closeModal('order-status-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <h4>Track your order</h4>
            <p>Check the status of your order:</p>
            <ol>
                <li>Go to Order History</li>
                <li>Find your order number</li>
                <li>Click "Track Order"</li>
                <li>View real-time updates</li>
            </ol>
            <h4>Order statuses</h4>
            <ul>
                <li><strong>Processing:</strong> Order confirmed, preparing for shipment</li>
                <li><strong>Shipped:</strong> Order is on its way</li>
                <li><strong>Delivered:</strong> Order has been received</li>
                <li><strong>Cancelled:</strong> Order was cancelled</li>
            </ul>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="openClareChatWithContext('order status')">Talk to Clare</button>
            <button class="btn btn-secondary" onclick="closeModal('order-status-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Shipping Issues Modal -->
<div id="shipping-issues-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Shipping Issues</h3>
            <button class="modal-close" onclick="closeModal('shipping-issues-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <h4>Common shipping problems</h4>
            <p>If you're experiencing shipping issues:</p>
            <ul>
                <li><strong>Delayed delivery:</strong> Check tracking for updates</li>
                <li><strong>Package lost:</strong> Contact our support team</li>
                <li><strong>Damaged items:</strong> Document damage and contact us</li>
                <li><strong>Wrong address:</strong> Verify your shipping address</li>
            </ul>
            <h4>What we can do</h4>
            <p>We'll work with the shipping carrier to resolve issues and ensure you receive your order or a full refund if necessary.</p>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="openClareChatWithContext('shipping issues')">Talk to Clare</button>
            <button class="btn btn-secondary" onclick="closeModal('shipping-issues-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Product Questions Modal -->
<div id="product-questions-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Product Questions</h3>
            <button class="modal-close" onclick="closeModal('product-questions-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <h4>Get product information</h4>
            <p>Find answers about our products:</p>
            <ul>
                <li><strong>Product specifications:</strong> Detailed technical information</li>
                <li><strong>Usage guidelines:</strong> How to use products safely</li>
                <li><strong>Quality standards:</strong> Our quality assurance process</li>
                <li><strong>Origin information:</strong> Where products come from</li>
            </ul>
            <h4>Need more details?</h4>
            <p>Our product specialists can answer specific questions about ingredients, sourcing, and quality standards. Contact us for detailed information.</p>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="openClareChatWithContext('product questions')">Talk to Clare</button>
            <button class="btn btn-secondary" onclick="closeModal('product-questions-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Return Policy Modal -->
<div id="return-policy-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Return Policy</h3>
            <button class="modal-close" onclick="closeModal('return-policy-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <h4>Our return policy</h4>
            <p>We want you to be completely satisfied with your purchase:</p>
            <ul>
                <li><strong>30-day return window:</strong> Return items within 30 days</li>
                <li><strong>Original condition:</strong> Items must be unused and in original packaging</li>
                <li><strong>Free returns:</strong> We cover return shipping costs</li>
                <li><strong>Full refund:</strong> Get your money back or exchange</li>
            </ul>
            <h4>Return process</h4>
            <p>Initiate a return through your order history, print a shipping label, and send the item back. Refunds are processed within 5-10 business days.</p>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="openClareChatWithContext('return policy')">Talk to Clare</button>
            <button class="btn btn-secondary" onclick="closeModal('return-policy-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Floating Chat Button -->
<!-- <button id="clare-chat-btn" class="clare-chat-btn" aria-label="Talk to Clare" type="button">
    <img src="{{ asset('new_landing_assets/clare-icon.svg') }}" alt="Clare Icon" class="clare-chat-icon" draggable="false" />
    <span class="clare-chat-text">Talk to Clare</span>
</button> -->

<!-- Clare Chat Drawer -->
<div id="clare-chat-drawer" class="clare-chat-drawer">
    <div class="clare-chat-content">
        <div class="clare-chat-header">
            <div class="clare-chat-header-left">
                <img src="{{ asset('new_landing_assets/winwin-circle.svg') }}" alt="Clare Logo" class="clare-chat-logo" />
                <span class="clare-chat-title">Clare</span>
            </div>
            <button class="clare-chat-close" id="clare-chat-close" aria-label="Close">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 6l12 12M6 18L18 6" />
                </svg>
            </button>
        </div>
        <div class="clare-chat-messages" id="clare-chat-messages"></div>
        <div class="clare-chat-input-area">
            <textarea id="clare-chat-input" class="clare-chat-input" placeholder="What can I help you with?" rows="1"></textarea>
            <button id="clare-chat-send" class="clare-chat-send" aria-label="Send">
                <img src="{{ asset('new_landing_assets/send-icon.svg') }}" alt="Send" class="clare-chat-send-icon" />
            </button>
        </div>
    </div>
</div>

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

        // Modal functionality
        setupModals();

        // Chat functionality
        setupChat();
    });

    // Modal functions
    function setupModals() {
        // Add click event listeners to all help buttons
        const helpButtons = document.querySelectorAll('.help-button[data-modal]');

        helpButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal') + '-modal';
                openModal(modalId);
            });
        });

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                closeModal(event.target.id);
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const openModal = document.querySelector('.modal[style*="display: block"]');
                if (openModal) {
                    closeModal(openModal.id);
                }
            }
        });
    }

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = ''; // Restore scrolling
        }
    }

    // Global function for onclick attributes
    window.closeModal = closeModal;

    // Chat functions
    function setupChat() {
        console.log('Setting up chat functionality...');

        const chatDrawer = document.getElementById('clare-chat-drawer');
        const chatClose = document.getElementById('clare-chat-close');
        const chatInput = document.getElementById('clare-chat-input');
        const chatSend = document.getElementById('clare-chat-send');
        const chatMessages = document.getElementById('clare-chat-messages');

        if (!chatDrawer || !chatClose || !chatInput || !chatSend || !chatMessages) {
            console.error('Some chat elements not found:', {
                chatDrawer: !!chatDrawer,
                chatClose: !!chatClose,
                chatInput: !!chatInput,
                chatSend: !!chatSend,
                chatMessages: !!chatMessages
            });
            return;
        }

        console.log('All chat elements found, setting up event listeners...');

        // Ensure chat drawer starts in closed state
        chatDrawer.classList.remove('open');

        // Close button functionality
        chatClose.addEventListener('click', () => {
            console.log('Close button clicked');
            chatDrawer.classList.remove('open');
            console.log('Chat drawer closed');
        });

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && chatDrawer.classList.contains('open')) {
                console.log('Escape key pressed, closing chat');
                chatDrawer.classList.remove('open');
                console.log('Chat drawer closed with Escape key');
            }
        });

        // Close on click outside (clicking on the backdrop)
        chatDrawer.addEventListener('click', (e) => {
            if (e.target === chatDrawer) {
                console.log('Clicked on backdrop, closing chat');
                chatDrawer.classList.remove('open');
                console.log('Chat drawer closed by clicking backdrop');
            }
        });

        // Clear chat messages when chat is closed
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    const target = mutation.target;
                    if (!target.classList.contains('open')) {
                        // Chat was closed, clear messages
                        if (chatMessages) {
                            chatMessages.innerHTML = '';
                            console.log('Chat messages cleared');
                        }
                    }
                }
            });
        });

        observer.observe(chatDrawer, {
            attributes: true,
            attributeFilter: ['class']
        });

        // Auto-resize textarea
        chatInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 8 * 16) + 'px';
        });

        // Send message functionality
        chatSend.addEventListener('click', handleSend);
        chatInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                handleSend();
            }
        });

        console.log('Chat setup completed successfully');

        // Test if the open function works
        console.log('Testing chat open function...');
        setTimeout(() => {
            console.log('Chat drawer initial state:', {
                classes: chatDrawer.className,
                opacity: window.getComputedStyle(chatDrawer).opacity,
                visibility: window.getComputedStyle(chatDrawer).visibility
            });
        }, 100);
    }

    // User ID management
    function generateUserId() {
        return 'user_' + Math.random().toString(36).substr(2, 9) + '_' + Date.now();
    }

    function getUserId() {
        let userId = localStorage.getItem('clare_chat_user_id');
        if (!userId) {
            userId = generateUserId();
            localStorage.setItem('clare_chat_user_id', userId);
        }
        return userId;
    }

    // Chat message functions
    function addUserMessage(text) {
        const chatMessages = document.getElementById('clare-chat-messages');
        const div = document.createElement('div');
        div.className = 'clare-chat-message-user';
        div.textContent = text;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addBotMessage(html) {
        const chatMessages = document.getElementById('clare-chat-messages');
        const div = document.createElement('div');
        div.className = 'clare-chat-message-bot';
        div.innerHTML = `
            <img src="{{ asset('new_landing_assets/winwin-circle.svg') }}" alt="Clare" class="clare-chat-bot-avatar" />
            <div class="clare-chat-message-bot-content">${html}</div>
        `;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addTypingIndicator() {
        const chatMessages = document.getElementById('clare-chat-messages');
        const div = document.createElement('div');
        div.className = 'clare-chat-message-bot clare-chat-message-typing';
        div.innerHTML = `
            <img src="{{ asset('new_landing_assets/winwin-circle.svg') }}" alt="Clare" class="clare-chat-bot-avatar" style="opacity:0.6;" />
            <div class="clare-chat-message-bot-content">Clare is typing...</div>
        `;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return div;
    }

    async function sendMessageToAPI(message) {
        const userId = getUserId();
        const payload = {
            userId: userId,
            message: message
        };

        try {
            const response = await fetch('https://coffeeplug-api-b982ba0e7659.herokuapp.com/api/voiceflow/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success && data.data && data.data.formattedResponse) {
                return data.data.formattedResponse;
            } else {
                throw new Error('Invalid response format');
            }
        } catch (error) {
            console.error('Error sending message to API:', error);
            return '<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">Sorry, I\'m having trouble connecting right now. Please try again in a moment.</p></div>';
        }
    }

    async function handleSend() {
        const chatInput = document.getElementById('clare-chat-input');
        const value = chatInput.value.trim();
        if (!value) return;

        // Add user message
        addUserMessage(value);
        chatInput.value = '';
        chatInput.style.height = 'auto';
        chatInput.focus();

        // Show typing indicator
        const typingDiv = addTypingIndicator();

        try {
            // Send message to API
            const response = await sendMessageToAPI(value);

            // Remove typing indicator
            typingDiv.remove();

            // Add bot response
            addBotMessage(response);
        } catch (error) {
            // Remove typing indicator
            typingDiv.remove();

            // Add error message
            addBotMessage('<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">Sorry, something went wrong. Please try again.</p></div>');
        }
    }

    // Global functions for onclick attributes
    window.openClareChat = function() {
        try {
            console.log('openClareChat function called');
            const chatDrawer = document.getElementById('clare-chat-drawer');
            console.log('Chat drawer element:', chatDrawer);
            if (chatDrawer) {
                // Check if chat is already open
                if (chatDrawer.classList.contains('open')) {
                    console.log('Chat is already open, focusing on input...');
                    // Focus on the chat input if already open
                    const chatInput = document.getElementById('clare-chat-input');
                    if (chatInput) {
                        chatInput.focus();
                    }
                } else {
                    console.log('Chat drawer found, opening...');
                    // Add the open class which will handle the CSS transition
                    chatDrawer.classList.add('open');
                    // Add welcome message
                    setTimeout(() => {
                        addWelcomeMessage();
                    }, 300);
                    console.log('Chat drawer opened successfully');
                }
            } else {
                console.error('Chat drawer not found');
            }
        } catch (error) {
            console.error('Error in openClareChat:', error);
        }
    };

    window.openClareChatWithContext = function(context) {
        try {
            console.log('openClareChatWithContext function called with context:', context);
            const chatDrawer = document.getElementById('clare-chat-drawer');
            console.log('Chat drawer element:', chatDrawer);
            if (chatDrawer) {
                // Check if chat is already open
                if (chatDrawer.classList.contains('open')) {
                    console.log('Chat is already open, sending message directly...');
                    // Send the contextual message directly to the existing chat
                    const contextualMessage = getContextualMessage(context);
                    if (contextualMessage) {
                        addUserMessage(contextualMessage);
                        // Send the message to Clare automatically
                        setTimeout(() => {
                            handleContextualMessage(contextualMessage);
                        }, 500);
                    }
                } else {
                    console.log('Chat drawer found, opening with context...');
                    // Add the open class which will handle the CSS transition
                    chatDrawer.classList.add('open');
                    // Add welcome message with context
                    setTimeout(() => {
                        addWelcomeMessageWithContext(context);
                    }, 300);
                    console.log('Chat drawer opened successfully with context');
                }
            } else {
                console.error('Chat drawer not found');
            }
        } catch (error) {
            console.error('Error in openClareChatWithContext:', error);
        }
    };

    // Add welcome message function
    function addWelcomeMessage() {
        const chatMessages = document.getElementById('clare-chat-messages');
        if (chatMessages && chatMessages.children.length === 0) {
            addBotMessage('<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">👋 Hello! I\'m Clare, your AI assistant. How can I help you today?</p></div>');
        }
    }

    // Add welcome message with context function
    function addWelcomeMessageWithContext(context) {
        const chatMessages = document.getElementById('clare-chat-messages');
        if (chatMessages && chatMessages.children.length === 0) {
            const contextMessage = context ? `I see you're having an issue with <strong>${context}</strong>. ` : '';
            addBotMessage(`<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">👋 Hello! I'm Clare, your AI assistant. ${contextMessage}How can I help you resolve this?</p></div>`);

            // Automatically send a contextual message to Clare after a short delay
            setTimeout(() => {
                const contextualMessage = getContextualMessage(context);
                if (contextualMessage) {
                    addUserMessage(contextualMessage);
                    // Send the message to Clare automatically
                    setTimeout(() => {
                        handleContextualMessage(contextualMessage);
                    }, 500);
                }
            }, 1000);
        }
    }

    // Function to get contextual message based on the issue type
    function getContextualMessage(context) {
        const contextMessages = {
            'payment method update': 'I need help updating my payment method. Can you guide me through the process?',
            'payment declined': 'My payment was declined. What are the common reasons and how can I fix this?',
            'refund request': 'I want to request a refund for my order. What is the process and timeline?',
            'billing questions': 'I have questions about my bill and the charges. Can you explain the fees?',
            'login and security': 'I need help with my account security and login issues. What should I do?',
            'update address': 'I need to update my shipping and billing address. How do I do this?',
            'password reset': 'I forgot my password and need to reset it. What are the steps?',
            'privacy settings': 'I want to review and update my privacy settings. Where can I find these options?',
            'order status': 'I want to check the status of my order. How can I track it?',
            'shipping issues': 'I\'m experiencing shipping problems with my order. What can you do to help?',
            'product questions': 'I have questions about the products. Can you provide more details?',
            'return policy': 'I want to return an item. What is your return policy and process?',
            'general help': 'I need general help with my account and services. Where should I start?'
        };

        return contextMessages[context] || `I need help with ${context}. Can you assist me?`;
    }

    // Function to handle contextual message automatically
    async function handleContextualMessage(message) {
        // Show typing indicator
        const typingDiv = addTypingIndicator();

        try {
            // Send message to API
            const response = await sendMessageToAPI(message);

            // Remove typing indicator
            typingDiv.remove();

            // Add bot response
            addBotMessage(response);
        } catch (error) {
            // Remove typing indicator
            typingDiv.remove();

            // Add error message
            addBotMessage('<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">Sorry, something went wrong. Please try again.</p></div>');
        }
    }
</script>
@endsection