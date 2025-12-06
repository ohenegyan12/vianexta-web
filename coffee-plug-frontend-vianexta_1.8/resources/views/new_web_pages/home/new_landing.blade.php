<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ViaNexta </title>
    <style>
        body {
            margin: 0;
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

            /* Desktop user menu adjustments */
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

        /* Mobile responsive adjustments */
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

        /* User Menu Styles */
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

        /* Mobile User Menu Styles */
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
            font-size: 16px;
        }

        .mobile-nav-icons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .mobile-nav-icon {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }

        .mobile-nav-icon:hover {
            background-color: #f3f4f6;
            color: #06382F;
        }

        .mobile-nav-icon svg {
            width: 20px;
            height: 20px;
        }

        .mobile-nav-icon span {
            font-size: 14px;
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

        /* Global Section Styles */
        .global-section {
            position: relative;
            background: #ffffff;
            padding: 4rem 0 6rem 0;
        }

        .global-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .global-content {
            display: flex;
            flex-direction: column;
            gap: 3rem;
        }

        .global-text {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .global-heading {
            font-size: 2.25rem;
            font-weight: 700;
            color: #06382F;
            line-height: 1.2;
            text-align: left;
            margin: 0;
        }

        .global-description {
            font-size: 1.125rem;
            color: #374151;
            font-weight: 400;
            line-height: 1.6;
            margin: 0;
            max-width: 64rem;
        }

        .map-section {
            position: relative;
        }

        .map-container {
            position: relative;
            width: 100%;
            height: auto;
        }

        .map-image {
            width: 100%;
            height: auto;
        }

        /* Responsive Design for Global Section */
        @media (min-width: 768px) {
            .global-heading {
                font-size: 3rem;
            }

            .global-description {
                font-size: 1.25rem;
            }
        }

        @media (min-width: 1024px) {
            .global-section {
                padding: 6rem 0;
            }

            .global-content {
                gap: 4rem;
            }

            .global-heading {
                font-size: 3.75rem;
            }
        }

        /* Why Choose Section Styles */
        .why-choose-section {
            position: relative;
            background: #06382F;
            padding: 4rem 0 6rem 0;
            color: white;
        }

        .why-choose-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .why-choose-header {
            margin-bottom: 3rem;
        }

        .why-choose-title {
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            margin: 0 0 1.5rem 0;
        }

        .highlight {
            color: #f97316;
        }

        .why-choose-subtitle {
            max-width: 32rem;
        }

        .subtitle-text {
            font-size: 1.125rem;
            color: #d1d5db;
            font-weight: 400;
            line-height: 1.6;
            margin: 0 0 0.5rem 0;
        }

        .why-choose-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
            align-items: center;
        }

        @media (min-width: 1024px) {
            .why-choose-grid {
                grid-template-columns: 1fr 1fr;
                gap: 4rem;
            }
        }

        .image-area {
            position: relative;
        }

        .image-container {
            position: relative;
            width: 100%;
            height: 24rem;
            background: #fff;
            border-radius: 1rem;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            transition: opacity 0.3s ease-in-out;
            min-height: 0;
        }

        @media (min-width: 1024px) {
            .image-container {
                height: 500px !important;
            }
        }

        .feature-image {
            width: 100%;
            height: 100%;
            max-width: 100%;
            max-height: 100%;
            min-width: 0;
            min-height: 0;
            object-fit: cover;
            object-position: center;
            border-radius: 1rem;
            display: block;
            background: #fff;
        }

        .features-list {
            display: flex;
            flex-direction: column;
            height: 24rem;
        }

        .features-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .feature-item {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .feature-item.active .feature-description {
            display: block;
        }

        .feature-item:not(.active) .feature-description {
            display: none;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: white;
        }

        .feature-description {
            color: #d1d5db;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .progress-line {
            position: relative;
            width: 100%;
            height: 1px;
            background: white;
        }

        .progress-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: #f97316;
            transition: width 0.1s ease linear;
            width: 0%;
        }

        .bottom-description {
            margin-top: 2rem;
        }

        .description-text {
            font-size: 1.125rem;
            color: #374151;
            font-weight: 300;
            line-height: 1.6;
            margin: 0;
            font-style: normal !important;
        }

        /* Responsive Design for Why Choose Section */
        @media (min-width: 768px) {
            .why-choose-title {
                font-size: 3rem;
            }

            .subtitle-text {
                font-size: 1.25rem;
            }

            .feature-title {
                font-size: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .why-choose-section {
                padding: 6rem 0;
            }

            .why-choose-header {
                margin-bottom: 4rem;
            }

            .why-choose-grid {
                grid-template-columns: 1fr 1fr;
                gap: 4rem;
            }

            .image-container {
                height: 31.25rem;
            }

            .features-list {
                height: 31.25rem;
            }

            .why-choose-title {
                font-size: 3.75rem;
            }

            .bottom-description {
                margin-top: auto;
            }
        }

        /* Supply Chain Section Styles */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }

        .supply-chain-section {
            position: relative;
            background: #ffffff;
            padding: 4rem 0 6rem 0;
        }

        .supply-chain-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .supply-chain-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .supply-chain-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: #06382F;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            margin: 0 0 1.5rem 0;
        }

        .supply-chain-subtitle {
            font-size: 1.125rem;
            color: #6b7280;
            max-width: 64rem;
            margin: 0 auto;
        }

        .step-cards-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            align-items: start;
            justify-content: center;
        }

        .step-card {
            transition: all 0.5s ease-in-out;
            cursor: pointer;
            flex-shrink: 0;
            width: 100%;
            height: 160px;
        }

        .step-card.active {
            height: 480px;
        }

        .step-card-inner {
            height: 100%;
            display: flex;
            border-radius: 12px;
        }

        .step-1 {
            background-color: #E6E6E6;
        }

        .step-2 {
            background-color: #333333;
        }

        .step-3 {
            background-color: #000000;
        }

        .step-content {
            flex: 1;
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }

        .step-number {
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 13px;
            font-family: Inter;
        }

        .step-1 .step-number {
            color: #000000;
        }

        .step-2 .step-number {
            color: #E5E5E5;
        }

        .step-3 .step-number {
            color: #E5E5E5;
        }

        .step-title-container {
            margin-bottom: 1rem;
            opacity: 0;
            animation: fade-in 0.4s ease-out 0.2s forwards;
        }

        .step-title {
            font-weight: 500;
            line-height: 1.2;
            font-size: 1.5rem;
            font-family: Inter;
            margin: 0;
        }

        .step-1 .step-title {
            color: #000000;
        }

        .step-2 .step-title {
            color: #E5E5E5;
        }

        .step-3 .step-title {
            color: #E5E5E5;
        }

        .step-points {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex-grow: 1;
            opacity: 0;
            animation: fade-in 0.4s ease-out 0.3s forwards;
        }

        .step-point {
            display: flex;
            align-items: start;
            gap: 0.5rem;
        }

        .checkmark {
            flex-shrink: 0;
            width: 1rem;
            height: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 2px;
        }

        .step-1-check {
            background-color: #06382F;
            color: white;
        }

        .step-2-check {
            background-color: #06382F;
            color: white;
        }

        .step-3-check {
            background-color: #FFFFFF;
            color: #06382F;
        }

        .checkmark svg {
            width: 0.625rem;
            height: 0.625rem;
        }

        .point-text {
            line-height: 1.6;
            font-size: 0.875rem;
            margin: 0;
        }

        .step-1 .point-text {
            color: #000000;
        }

        .step-2 .point-text {
            color: #E5E5E5;
        }

        .step-3 .point-text {
            color: #E5E5E5;
        }

        .step-image-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1.5rem;
            padding: 1rem;
            padding-right: 2rem;
            margin-bottom: 1.5rem;
        }

        .step-image-wrapper {
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 180px;
            border-radius: 20px;
            border: 4px solid #FFFFFF;
        }

        .step-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Inactive card styles */
        .step-card:not(.active) .step-content {
            justify-content: flex-end;
            padding: 1rem;
        }

        .step-card:not(.active) .step-title-container,
        .step-card:not(.active) .step-points,
        .step-card:not(.active) .step-image-container {
            display: none;
        }

        .step-card:not(.active) .step-number {
            font-size: 1rem;
        }

        /* Responsive Design for Supply Chain Section */
        @media (min-width: 768px) {
            .supply-chain-title {
                font-size: 3rem;
            }

            .supply-chain-subtitle {
                font-size: 1.25rem;
            }

            .step-title {
                font-size: 2rem;
            }

            .checkmark {
                width: 1.25rem;
                height: 1.25rem;
            }

            .checkmark svg {
                width: 0.75rem;
                height: 0.75rem;
            }

            .point-text {
                font-size: 1rem;
            }
        }

        @media (min-width: 1024px) {
            .supply-chain-section {
                padding: 6rem 0;
            }

            .supply-chain-header {
                margin-bottom: 4rem;
            }

            .step-cards-container {
                flex-direction: row;
                gap: 1.5rem;
            }

            .step-card {
                width: 167px;
                height: 480px;
            }

            .step-card.active {
                width: 1082px;
                height: 480px;
            }

            .step-card-inner {
                flex-direction: row;
            }

            .step-content {
                padding: 2rem;
            }

            .step-title {
                font-size: 3.375rem;
            }

            .step-points {
                gap: 1rem;
            }

            .step-point {
                gap: 0.75rem;
            }

            .checkmark {
                width: 1.25rem;
                height: 1.25rem;
            }

            .checkmark svg {
                width: 0.75rem;
                height: 0.75rem;
            }

            .point-text {
                font-size: 1rem;
            }

            .step-image-container {
                margin-top: 0;
                padding: 0;
                padding-right: 2rem;
                margin-bottom: 0;
            }

            .step-image-wrapper {
                width: 465px;
                height: 347px;
            }

            .step-card:not(.active) .step-number {
                font-size: 2rem;
            }
        }

        /* Testimonials Section Styles */
        .testimonials-section {
            position: relative;
            background: #ffffff;
            padding: 4rem 0 6rem 0;
        }

        .testimonials-container {
            max-width: 1120px;
            margin: 0 auto;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .testimonials-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .testimonials-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: #06382F;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            margin: 0 0 1.5rem 0;
        }

        .testimonials-subtitle {
            font-size: 1.125rem;
            color: #6b7280;
            max-width: 64rem;
            margin: 0 auto;
        }

        .highlight-text {
            font-weight: 600;
            color: #06382F;
        }

        .testimonials-grid {
            column-count: 1;
            column-gap: 2.25rem;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        @media (min-width: 768px) {
            .testimonials-grid {
                column-count: 2;
            }
        }

        @media (min-width: 1024px) {
            .testimonials-grid {
                column-count: 3;
            }
        }

        @media (min-width: 1280px) {
            .testimonials-grid {
                column-count: 4;
            }
        }

        .testimonial-card {
            break-inside: avoid;
            border-radius: 1.5rem;
            padding: 1.5rem;
            color: white;
            background-color: #000;
            display: inline-block;
            width: calc(100% - 1.5rem);
            margin-bottom: 2.25rem;
        }

        .testimonial-content {
            color: #f3f4f6;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .testimonial-footer {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: #374151;
            overflow: hidden;
            flex-shrink: 0;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .name {
            font-weight: 600;
            color: white;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .username {
            color: #9ca3af;
            font-size: 0.875rem;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .social-icon {
            flex-shrink: 0;
        }

        .instagram-icon {
            width: 1.25rem;
            height: 1.25rem;
        }

        /* Responsive Design for Testimonials Section */
        @media (min-width: 768px) {
            .testimonials-title {
                font-size: 3rem;
            }

            .testimonials-subtitle {
                font-size: 1.25rem;
            }

            .testimonials-grid {
                column-count: 2;
            }
        }

        @media (min-width: 1024px) {
            .testimonials-section {
                padding: 6rem 0;
            }

            .testimonials-header {
                margin-bottom: 4rem;
            }

            .testimonials-grid {
                column-count: 3;
            }

            .testimonials-title {
                font-size: 3.75rem;
            }
        }

        @media (min-width: 1280px) {
            .testimonials-grid {
                column-count: 4;
            }
        }

        @media (max-width: 767px) {
            .testimonials-container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .testimonials-grid {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding-left: 0;
                padding-right: 0;
            }

            .testimonial-card {
                margin: 0 auto 2.25rem auto;
                width: 100%;
                max-width: 400px;
                padding: 1.5rem 1rem 1.5rem 1rem;
                box-sizing: border-box;
            }

            .testimonial-content {
                margin-bottom: 1.2rem;
                font-size: 1.1rem;
                line-height: 1.5;
            }

            .testimonial-footer {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                justify-content: space-between;
            }

            .avatar {
                width: 2.2rem;
                height: 2.2rem;
            }

            .user-info {
                flex: 1;
                min-width: 0;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .social-icon {
                margin-left: auto;
                margin-right: 0.2rem;
                display: flex;
                align-items: center;
            }
        }

        /* Forman Section Styles */
        .forman-section {
            position: relative;
            background: #06382F;
            color: #fff;
            padding: 4rem 0 6rem 0;
        }

        .forman-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .forman-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
            align-items: center;
        }

        .forman-text {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .forman-header {
            font-size: 3rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.1;
            margin: 0;
        }

        .forman-header-orange {
            color: #d8501c;
            font-style: italic;
        }

        .forman-subtitle {
            font-size: 1.25rem;
            color: #fff;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .forman-description {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .forman-desc-main {
            font-size: 1.125rem;
            color: #e5e7eb;
            line-height: 1.6;
        }

        .forman-desc-highlight {
            color: #fff;
            font-weight: 600;
        }

        .forman-features {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .forman-feature {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            color: #e5e7eb;
        }

        .forman-check {
            width: 1.5rem;
            height: 1.5rem;
            background: #d8501c;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .forman-check svg {
            width: 1rem;
            height: 1rem;
            color: #000;
        }

        .forman-disclaimer {
            font-size: 0.875rem;
            color: #d1d5db;
            font-style: italic;
            margin-top: 1rem;
        }

        .forman-cta {
            padding-top: 1rem;
        }

        .forman-btn {
            background: #d8501c;
            color: #fff;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            font-weight: 700;
            font-size: 1.125rem;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .forman-btn:hover {
            opacity: 0.9;
        }

        .forman-image-area {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .forman-image-wrapper {
            width: 100%;
            height: 100%;
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }

        .forman-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 1rem;
        }

        .forman-image-blur {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 100px;
            background: linear-gradient(to bottom, rgba(6, 56, 47, 0) 0%, #06382F 100%);
            z-index: 2;
            pointer-events: none;
            border-radius: 0 0 1rem 1rem;
        }

        @media (min-width: 768px) {
            .forman-header {
                font-size: 4rem;
            }

            .forman-subtitle {
                font-size: 1.5rem;
            }

            .forman-desc-main {
                font-size: 1.25rem;
            }

            .forman-feature {
                font-size: 1.125rem;
            }
        }

        @media (min-width: 1024px) {
            .forman-section {
                padding: 6rem 0;
            }

            .forman-grid {
                grid-template-columns: 1fr 1fr;
                gap: 4rem;
            }

            .forman-header {
                font-size: 5rem;
            }

            .forman-image-wrapper {
                max-width: 500px;
            }
        }

        @media (min-width: 1280px) {
            .forman-header {
                font-size: 6rem;
            }
        }

        /* Brands Section Styles */
        .brands-section {
            position: relative;
            background: #fff;
            padding: 3rem 0 3rem 0;
            overflow: hidden;
        }

        .brands-title {
            text-align: center;
            color: #111;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 0.1em;
            margin-bottom: 2rem;
        }

        .brands-marquee-wrapper {
            position: relative;
            width: 100%;
            max-width: 100vw;
            margin: 0 auto;
            overflow: hidden;
        }

        .brands-blur {
            position: absolute;
            top: 0;
            width: 8rem;
            height: 100%;
            z-index: 2;
            pointer-events: none;
        }

        .brands-blur-left {
            left: 0;
            background: linear-gradient(to right, #fff 60%, transparent);
        }

        .brands-blur-right {
            right: 0;
            background: linear-gradient(to left, #fff 60%, transparent);
        }

        .brands-marquee-outer {
            overflow-x: hidden;
            width: 100%;
        }

        .brands-marquee {
            display: flex;
            width: max-content;
            animation: brands-marquee 60s linear infinite;
            gap: 0;
            will-change: transform;
        }

        .brand-logo {
            height: 4rem;
            width: auto;
            object-fit: contain;
            display: inline-block;
            user-select: none;
            pointer-events: none;
            margin-right: 4rem;
            flex-shrink: 0;
        }

        .brand-logo:last-child {
            margin-right: 0;
        }

        @keyframes brands-marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-33.333333%);
            }
        }

        @media (max-width: 600px) {
            .brands-marquee {
                gap: 0;
                animation: brands-marquee 60s linear infinite;
            }

            .brand-logo {
                height: 2.5rem;
                margin-right: 2rem;
                flex-shrink: 0;
            }

            .brand-logo:last-child {
                margin-right: 0;
            }

            .brands-blur {
                width: 4rem;
            }
        }

        /* FAQ Section Styles */
        .faq-section {
            position: relative;
            background: #fff;
            padding: 4rem 0 6rem 0;
        }

        .faq-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .faq-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 4rem;
            align-items: flex-start;
            min-height: 400px;
        }

        .faq-title-area {
            display: flex;
            align-items: flex-start;
            height: 100%;
            justify-content: flex-start;
        }

        .faq-title {
            font-size: 3rem;
            font-weight: 700;
            color: #111827;
            line-height: 1.1;
            margin: 0;
            text-align: left;
            word-break: break-word;
        }

        .faq-items {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            align-items: flex-start;
        }

        @media (max-width: 1023px) {
            .faq-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
                min-height: unset;
            }

            .faq-title-area {
                justify-content: flex-start;
                align-items: flex-start;
            }

            .faq-title {
                font-size: 2.5rem;
            }
        }

        .faq-item {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 0.5rem;
        }

        .faq-item:last-child {
            border-bottom: none;
        }

        .faq-question {
            width: 100%;
            padding: 1.5rem 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: none;
            border: none;
            outline: none;
            font-size: 1.125rem;
            font-weight: 500;
            color: #111827;
            cursor: pointer;
            transition: color 0.2s;
            text-align: left;
        }

        .faq-question:hover span {
            color: #06382F;
        }

        .faq-arrow {
            margin-left: 1rem;
            display: flex;
            align-items: center;
            transition: transform 0.3s;
        }

        .faq-arrow-svg {
            width: 1.5rem;
            height: 1.5rem;
            color: #6b7280;
            transition: transform 0.3s;
        }

        .faq-item.active .faq-arrow-svg {
            transform: rotate(180deg);
            color: #06382F;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding-bottom 0.3s;
            color: #4b5563;
            font-size: 1rem;
            line-height: 1.6;
            padding-bottom: 0;
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
            padding-bottom: 1.5rem;
        }

        @media (min-width: 768px) {
            .faq-title {
                font-size: 3rem;
            }

            .faq-grid {
                grid-template-columns: 1fr 1fr;
                gap: 4rem;
            }
        }

        @media (min-width: 1024px) {
            .faq-section {
                padding: 6rem 0;
            }

            .faq-title {
                font-size: 4rem;
            }
        }

        /* Footer Section Styles */
        .footer-section {
            background: linear-gradient(to bottom, #fff, #fff);
            position: relative;
            width: 100%;
        }

        .footer-cta {
            padding: 4rem 0 4rem 0;
            position: relative;
            z-index: 10;
        }

        .footer-cta-inner {
            width: 1086px;
            max-width: 100vw;
            margin: 0 auto;
            display: flex;
            flex-direction: row;
            gap: 1.5rem;
            justify-content: center;
            align-items: stretch;
            box-sizing: border-box;
        }

        @media (min-width: 1024px) {
            .footer-cta-inner {
                flex-direction: row;
                gap: 1.5rem;
                align-items: stretch;
                /* Remove fixed height */
            }
        }

        .footer-cta-image {
            position: relative;
            width: 733px;
            height: 391px;
            box-sizing: border-box;
            flex: none;
            display: flex;
            flex-direction: column;
            border-radius: 12px;
            background-image: url("{{ asset('new_landing_assets/ctaimage.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
            min-height: 0;
        }

        .footer-cta-image-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.25);
        }

        .footer-cta-image-link {
            color: #fff;
            font-family: 'Inter', Arial, sans-serif;
            font-size: 2.5rem;
            font-weight: 600;
            line-height: 1.2;
            text-decoration: none;
            text-align: center;
            display: block;
            padding: 1rem 2rem;
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.2);
            transition: background 0.2s;
        }

        .footer-cta-image-link:hover {
            background: rgba(0, 0, 0, 0.35);
        }

        .footer-cta-card {
            background: #000;
            color: #fff;
            border-radius: 12px;
            padding: 1.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
            width: 353px;
            height: 391px;
            box-sizing: border-box;
            flex: none;
            gap: 1.25rem;
            min-height: 0;
            overflow: hidden;
        }

        @media (max-width: 1086px) {
            .footer-cta-inner {
                flex-direction: column;
                width: 100%;
                max-width: 100vw;
            }

            .footer-cta-image,
            .footer-cta-card {
                width: 100%;
                max-width: 100%;
                height: 391px;
            }
        }

        .footer-cta-card-title {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 2.5rem;
            font-weight: 600;
            line-height: 2.6rem;
            letter-spacing: -1.05px;
            margin: 0;
        }

        .footer-cta-card-subtitle {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 0.95rem;
            font-weight: 400;
            color: #696969;
            line-height: 1.1rem;
            letter-spacing: -0.55px;
            margin: 0;
        }

        .footer-cta-card-desc {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 0.8rem;
            font-weight: 400;
            color: #fff;
            line-height: 1.3rem;
            letter-spacing: -0.23px;
            margin: 0 0 1.5rem 0;
        }

        .footer-cta-card-btn {
            background: #fff;
            color: #000;
            font-family: 'Inter', Arial, sans-serif;
            font-size: 0.8rem;
            font-weight: 400;
            width: 100%;
            max-width: 307px;
            height: 30px;
            border-radius: 9px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: background 0.2s;
            margin-top: auto;
        }

        .footer-cta-card-btn:hover {
            background: #f3f4f6;
        }

        .footer-cta-card-btn-arrow {
            width: 1rem;
            height: 1rem;
        }

        .footer-links-section {
            border-top: 1px solid #e5e7eb;
            padding: 3rem 0 0 0;
            background: #fff;
        }

        .footer-links-inner {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .footer-links-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            justify-items: center;
        }

        @media (min-width: 768px) {
            .footer-links-grid {
                grid-template-columns: repeat(2, 1fr);
                text-align: left;
                justify-items: start;
            }
        }

        @media (min-width: 1024px) {
            .footer-links-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 2rem;
            }
        }

        .footer-logo {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
        }

        .footer-logo-img {
            height: 3rem;
            width: auto;
            margin-bottom: 1rem;
        }

        .footer-links-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1rem;
        }

        .footer-links-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .footer-link {
            color: #6b7280;
            text-decoration: none;
            transition: color 0.2s;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-link:hover {
            color: #06382F;
        }

        .footer-link-ai {
            background: #06382F;
            color: #fff;
            font-size: 0.75rem;
            padding: 0.1rem 0.5rem;
            border-radius: 0.375rem;
            margin-left: 0.25rem;
        }

        .footer-bottom {
            border-top: 1px solid #e5e7eb;
            padding-top: 2rem;
            padding-bottom: 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            align-items: center;
            justify-content: space-between;
        }

        @media (min-width: 768px) {
            .footer-bottom {
                flex-direction: row;
                gap: 0;
            }
        }

        .footer-bottom-left {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            color: #6b7280;
        }

        @media (min-width: 768px) {
            .footer-bottom-left {
                flex-direction: row;
                align-items: center;
            }
        }

        .footer-bottom-links {
            display: flex;
            gap: 1.5rem;
            margin-left: 0;
        }

        .footer-bottom-link {
            color: #6b7280;
            text-decoration: none;
            transition: color 0.2s;
            font-size: 0.95rem;
        }

        .footer-bottom-link:hover {
            color: #06382F;
        }

        .footer-bottom-social {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .footer-social-icon {
            color: #6b7280;
            transition: color 0.2s;
            display: flex;
            align-items: center;
        }

        .footer-social-icon:hover {
            color: #06382F;
        }

        .footer-social-svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .footer-cta-image-text {
            color: #fff;
            font-family: 'Inter', Arial, sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            text-align: center;
            display: block;
            padding: 0;
            margin: 0 auto;
            box-shadow: none;
            cursor: default;
        }

        .why-choose-note {
            font-size: 0.75rem;
            color: #fff;
            font-style: italic;
            margin-top: 2rem;
        }

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

        .clare-chat-btn.on-green {
            background: #fff;
            color: #07382F;
            border: 1.5px solid #07382F;
        }

        .clare-chat-icon {
            width: 1.75rem;
            height: 1.75rem;
            display: inline-block;
            transition: filter 0.3s;
            user-select: none;
            pointer-events: none;
        }

        .clare-chat-btn.on-green .clare-chat-icon {
            filter: invert(19%) sepia(97%) saturate(749%) hue-rotate(120deg) brightness(95%) contrast(101%);
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
            z-index: 10000;
            background: #f5f7fc;
            box-shadow: -4px 0 24px 0 rgba(7, 56, 47, 0.15);
            border-top-left-radius: 16px;
            border-bottom-left-radius: 16px;
            display: flex;
            flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(.4, 0, .2, 1);
        }

        .clare-chat-drawer.open {
            transform: translateX(0);
        }

        .clare-chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem;
            background: #fff;
            border-top-left-radius: 16px;
        }

        .clare-chat-header-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .clare-chat-logo {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
        }

        .clare-chat-title {
            font-weight: 600;
            font-size: 1.125rem;
            color: #374151;
        }

        .clare-chat-close {
            background: none;
            border: none;
            padding: 0.25rem;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .clare-chat-close:hover {
            background: #f3f4f6;
        }

        .clare-chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 1.25rem 0.5rem 1.25rem;
            background: #f5f7fc;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .clare-chat-message-user {
            align-self: flex-end;
            background: #fff;
            color: #222;
            padding: 0.75rem 1.25rem;
            border-radius: 1.25rem;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.03);
            max-width: 80%;
            font-size: 1rem;
            font-weight: 500;
        }

        .clare-chat-message-bot {
            align-self: flex-start;
            background: #fff;
            color: #222;
            padding: 1rem;
            border-radius: 1rem;
            border: 1px solid #b6e2b6;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.03);
            max-width: 90%;
            display: flex;
            gap: 0.75rem;
            font-size: 1rem;
        }

        .clare-chat-bot-avatar {
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 50%;
            margin-top: 0.25rem;
        }

        .clare-chat-message-bot-content {
            flex: 1;
        }

        .clare-chat-message-bot-link {
            color: #15803d;
            text-decoration: underline;
        }

        .clare-chat-message-typing {
            color: #888;
            font-style: italic;
            opacity: 0.7;
        }

        .clare-chat-input-area {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 1.25rem;
            background: #f5f7fc;
            border-bottom-left-radius: 16px;
        }

        .clare-chat-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border-radius: 1.5rem;
            border: none;
            background: #e9edfa;
            font-size: 1rem;
            color: #374151;
            font-weight: 500;
            outline: none;
        }

        .clare-chat-send {
            background: #fff;
            border: none;
            border-radius: 50%;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
            min-width: 2.5rem;
            min-height: 2.5rem;
        }

        .clare-chat-send:hover {
            background: #f3f4f6;
        }

        .clare-chat-send-icon {
            width: 1.5rem;
            height: 1.5rem;
        }

        .clare-chat-message-user,
        .clare-chat-message-bot {
            word-break: break-word;
            overflow-wrap: anywhere;
            white-space: pre-line;
            max-width: 90%;
            box-sizing: border-box;
        }

        .clare-chat-message-bot-content {
            word-break: break-word;
            overflow-wrap: anywhere;
            white-space: pre-line;
            width: 100%;
            box-sizing: border-box;
        }

        @media (max-width: 600px) {

            .clare-chat-message-user,
            .clare-chat-message-bot {
                max-width: 98%;
            }
        }

        @media (max-width: 600px) {
            .supply-chain-section {
                padding: 2rem 0 3rem 0;
                overflow-x: hidden;
            }

            .supply-chain-header {
                margin-bottom: 2rem;
            }

            .step-cards-container {
                gap: 1.25rem;
            }

            .step-card {
                height: auto !important;
                min-height: 60px;
                /* Only enough for step number */
                border-radius: 20px;
                box-shadow: none;
                width: 100%;
                margin: 0 auto;
                transition: min-height 0.3s;
            }

            .step-card.active {
                min-height: 540px;
            }

            .step-card-inner {
                flex-direction: column !important;
                align-items: flex-start !important;
                padding: 0;
                height: auto !important;
                border-radius: 20px;
            }

            .step-content {
                width: 100%;
                padding: 1.5rem 1rem 0.5rem 1rem;
                align-items: flex-start !important;
                justify-content: flex-start;
            }

            .step-number {
                font-size: 1.3rem !important;
                font-weight: 500;
                margin-bottom: 1.2rem;
                margin-left: 0.1rem;
                color: #06382F;
                letter-spacing: 0.02em;
            }

            .step-title-container {
                margin-bottom: 1.5rem;
                opacity: 1 !important;
                animation: none !important;
            }

            .step-title {
                font-size: 2.3rem !important;
                font-weight: 700;
                line-height: 1.1;
                margin: 0;
                color: #111;
            }

            .step-points {
                gap: 1.2rem;
                margin-bottom: 1.5rem;
                opacity: 1 !important;
                animation: none !important;
            }

            .step-point {
                gap: 0.8rem;
                align-items: flex-start;
            }

            .checkmark {
                width: 1.7rem !important;
                height: 1.7rem !important;
                border-radius: 6px !important;
                margin-top: 0.2rem;
            }

            .checkmark svg {
                width: 1.1rem !important;
                height: 1.1rem !important;
            }

            .point-text {
                font-size: 1.18rem !important;
                line-height: 1.5;
                color: #111 !important;
                margin: 0;
                font-weight: 400;
            }

            .step-image-container {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 2.2rem 0 0 0;
                padding: 0;
            }

            .step-image-wrapper {
                width: 85vw !important;
                max-width: 340px !important;
                height: 200px !important;
                box-sizing: border-box;
                border-radius: 24px !important;
                border: 6px solid #111 !important;
                background: #e6e6e6;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .step-image {
                width: 100%;
                height: 100%;
                object-fit: contain;
                border-radius: 18px !important;
                background: #e6e6e6;
                box-sizing: border-box;
            }

            .step-card-inner.step-2 .step-number,
            .step-card-inner.step-2 .step-title,
            .step-card-inner.step-2 .point-text,
            .step-card-inner.step-3 .step-number,
            .step-card-inner.step-3 .step-title,
            .step-card-inner.step-3 .point-text {
                color: #fff !important;
            }
        }

        @media (max-width: 600px) {
            .footer-cta-image {
                width: 90vw !important;
                max-width: 400px !important;
                margin: 0 auto !important;
            }

            .footer-cta-card {
                width: 90vw !important;
                max-width: 400px !important;
                margin: 0 auto !important;
            }
        }
    </style>
</head>

<body>
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
                    <a href="#why-choose" class="nav-link">Why Choose Us</a>
                    <a href="#testimonials" class="nav-link">Testimonials</a>
                    <a href="{{ route('work_with_us') }}" class="nav-link">Careers</a>
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
                    </div>
                    <div class="nav-icons">
                        <a href="{{ route('buyerDashboard') }}" class="nav-icon" title="Dashboard">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        <a href="{{ route('buyer_new_wizard') }}" class="nav-icon" title="Marketplace">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.7 15.3C4.3 15.7 4.6 16.5 5.1 16.5H17M17 13V17C17 17.6 16.6 18 16 18H8C7.4 18 7 17.6 7 17V13H17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        <div class="cart-icon-container">
                            <a href="{{ route('buyer_cart') }}" class="cart-icon" title="Cart">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                @if(isset($cart_items_count) && $cart_items_count > 0)
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
            <!-- Mobile menu button -->
            <button class="mobile-menu-btn" aria-label="Toggle menu" id="mobileMenuBtn">
                <svg height="24" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <!-- Mobile Dropdown Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <a href="#why-choose" class="mobile-link">Why Choose Us</a>
            <a href="#testimonials" class="mobile-link">Testimonials</a>
            <a href="{{ route('work_with_us') }}" class="mobile-link">Careers</a>
            @if(session('auth_user_tokin') == null)
            <a href="{{ route('login_page') }}" class="mobile-action signin">Sign In</a>
            <a href="#contact" class="mobile-action contact">Get in touch</a>
            @else
            <div class="mobile-user-menu">
                <div class="mobile-profile-name">
                    <span class="mobile-user-name">{{ session('auth_user_name') }}</span>
                </div>
                <div class="mobile-nav-icons">
                    <a href="{{ route('buyerDashboard') }}" class="mobile-nav-icon" title="Dashboard">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('buyer_new_wizard') }}" class="mobile-nav-icon" title="Marketplace">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.7 15.3C4.3 15.7 4.6 16.5 5.1 16.5H17M17 13V17C17 17.6 16.6 18 16 18H8C7.4 18 7 17.6 7 17V13H17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>Marketplace</span>
                    </a>
                    <a href="{{ route('buyer_cart') }}" class="mobile-nav-icon" title="Cart">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>Cart</span>
                    </a>
                    <a href="{{ route('login_page') }}" class="mobile-nav-icon" title="Logout">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-grid">
                <!-- Left Content -->
                <div class="hero-content">
                    <!-- Main Heading -->
                    <h1 class="hero-heading">
                        IDEA TODAY<br />
                        BRAND TOMORROW
                    </h1>
                    <!-- Descriptions -->
                    <div class="hero-descriptions">
                        <p class="description-text">
                            ViaNexta gives you instant access to roasters, warehouses, and ethical sourcing, so you can grow without friction.
                        </p>
                        <p class="description-text">
                            Start earning more from your own premium coffee brand,without the hassle.
                        </p>
                    </div>
                    <!-- CTA Button -->
                    <div class="hero-cta">
                        <a
                            href="{{ route('getStarted') }}"
                            class="hero-button">
                            Get Started Now
                        </a>
                    </div>
                </div>
                <!-- Right Image -->
                <div class="hero-image">
                    <div class="image-container">
                        <img
                            src="{{ asset('new_landing_assets/newhero.svg') }}"
                            alt="ViaNexta Hero Illustration"
                            class="hero-img">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Global Section -->
    <section class="global-section">
        <div class="global-container">
            <div class="global-content" style="flex-direction: column; gap: 3rem;">
                <!-- Content Section -->
                <div class="global-text-and-awards" style="display: flex; flex-direction: row; gap: 2rem; align-items: flex-start; justify-content: flex-start; width: 100%;">
                    <div class="global-text" style="flex: 1 1 0%; min-width: 0;">
                        <!-- Main Heading -->
                        <h2 class="global-heading">
                            VIANEXTA <br />
                            KNOWS NO BOUNDARIES
                        </h2>
                        <!-- Description -->
                        <p class="global-description">
                            We provide the fastest way to build and ship your physical products.
                        </p>
                    </div>
                    <div class="global-awards" style="flex: 0 0 auto; margin-top: 0; align-self: flex-start; max-width: 320px; width: 100%;">
                        <img src="{{ asset('new_landing_assets/awards.png') }}" alt="ViaNexta Awards" style="max-width: 320px; width: 100%; height: auto; display: block;" />
                    </div>
                </div>
                <!-- Map Section -->
                <div class="map-section">
                    <div class="map-container">
                        <img
                            src="{{ asset('new_landing_assets/hero_gif.gif') }}"
                            alt="ViaNexta Global Coffee Network World Map"
                            class="map-image">
                    </div>
                </div>
            </div>
            <style>
                @media (min-width: 900px) {
                    .global-content {
                        flex-direction: column !important;
                        align-items: stretch;
                        gap: 3rem;
                    }

                    .global-text-and-awards {
                        flex-direction: row !important;
                        align-items: flex-start;
                        justify-content: flex-start;
                        width: 100%;
                    }

                    .global-text {
                        flex: 1 1 0%;
                        min-width: 0;
                        max-width: 60%;
                    }

                    .global-awards {
                        flex: 0 0 auto;
                        align-self: flex-start;
                        margin-top: 0;
                        max-width: 320px;
                        width: 100%;
                    }
                }

                @media (max-width: 899px) {
                    .global-text-and-awards {
                        flex-direction: column !important;
                        align-items: flex-start;
                        width: 100%;
                        gap: 1.5rem;
                    }

                    .global-awards {
                        align-self: flex-start;
                        margin-top: 1rem;
                        margin-bottom: 1rem;
                        max-width: 320px;
                        width: 100%;
                    }
                }
            </style>
        </div>
    </section>

    <!-- Why Choose Section -->
    <section id="why-choose" class="why-choose-section">
        <div class="why-choose-container">
            <!-- Header Section -->
            <div class="why-choose-header">
                <h2 class="why-choose-title">
                    Why Brands Choose <span class="highlight">ViaNexta</span>
                </h2>
                <div class="why-choose-subtitle">
                    <p class="subtitle-text">
                        Freshness, quality, and trust define your brand.
                    </p>
                    <p class="subtitle-text">
                        ViaNexta ensures every bag of coffee reflects your high standards with:
                    </p>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="why-choose-grid">

                <!-- Left Image Area -->
                <div class="image-area">
                    <div class="image-container">
                        <img
                            id="featureImage"
                            src="{{ asset('new_landing_assets/why1.jpg') }}"
                            alt="Certified Roasters"
                            class="feature-image">
                    </div>
                </div>

                <!-- Right Features List -->
                <div class="features-list">
                    <div class="features-container">
                        <div class="feature-item active" data-index="0">
                            <h3 class="feature-title">Certified Roasters</h3>
                            <p class="feature-description">
                                Crafted by industry-leading experts to guarantee unmatched flavor, consistency, and quality in every roast.
                            </p>
                            <div class="progress-line">
                                <div class="progress-fill"></div>
                            </div>
                        </div>

                        <div class="feature-item" data-index="1">
                            <h3 class="feature-title">Ethically Sourced Beans</h3>
                            <p class="feature-description">
                                Directly sourced from sustainable farms that prioritize fair trade practices and environmental responsibility.
                            </p>
                            <div class="progress-line">
                                <div class="progress-fill"></div>
                            </div>
                        </div>

                        <div class="feature-item" data-index="2">
                            <h3 class="feature-title">Verified Warehouses</h3>
                            <p class="feature-description">
                                State-of-the-art storage facilities that maintain optimal conditions for freshness and quality preservation.
                            </p>
                            <div class="progress-line">
                                <div class="progress-fill"></div>
                            </div>
                        </div>

                        <div class="feature-item" data-index="3">
                            <h3 class="feature-title">Premium Packaging & Customization</h3>
                            <p class="feature-description">
                                Tailored packaging solutions that reflect your brand identity while preserving coffee quality and freshness.
                            </p>
                            <div class="progress-line">
                                <div class="progress-fill"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Small Description - aligned to bottom, outside grid -->
                    <div class="why-choose-note">
                        *Unlike generic white-label solutions, <span class="highlight">ViaNexta</span> gives you full control and higher margins—while we handle the roasting, packing, and fulfillment with zero hassle.*
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Supply Chain Section -->
    <section id="supply-chain" class="supply-chain-section">
        <div class="supply-chain-container">

            <!-- Header Section -->
            <div class="supply-chain-header">
                <h2 class="supply-chain-title">
                    Your Supply Chain Simplified
                </h2>
                <p class="supply-chain-subtitle">
                    Experience specialty coffee in just three seamless steps—source, craft, deliver.
                </p>
            </div>

            <!-- Step Cards Container -->
            <div class="step-cards-container">

                <!-- Step 01 -->
                <div class="step-card active" data-index="0">
                    <div class="step-card-inner step-1">
                        <div class="step-content">
                            <!-- Step Number -->
                            <span class="step-number">01</span>

                            <!-- Title -->
                            <div class="step-title-container">
                                <h3 class="step-title">Select Your</h3>
                                <h3 class="step-title">Coffee Bean</h3>
                            </div>

                            <!-- Content with Checkboxes -->
                            <div class="step-points">
                                <div class="step-point">
                                    <div class="checkmark step-1-check">
                                        <svg viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="point-text">Browse and select premium, ethically sourced coffee beans, (roasted, green, or wholesale)</p>
                                </div>
                                <div class="step-point">
                                    <div class="checkmark step-1-check">
                                        <svg viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="point-text">Easily filter by country, ratings, and more to find your perfect beans.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right GIF Container -->
                        <div class="step-image-container">
                            <div class="step-image-wrapper">
                                <img src="{{ asset('new_landing_assets/new-1.gif') }}" alt="Select Your Coffee Bean" class="step-image">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 02 -->
                <div class="step-card" data-index="1">
                    <div class="step-card-inner step-2">
                        <div class="step-content">
                            <!-- Step Number -->
                            <span class="step-number">02</span>

                            <!-- Title -->
                            <div class="step-title-container">
                                <h3 class="step-title">Select Your Grind</h3>
                                <h3 class="step-title">& Roast Type</h3>
                            </div>

                            <!-- Content with Checkboxes -->
                            <div class="step-points">
                                <div class="step-point">
                                    <div class="checkmark step-2-check">
                                        <svg viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="point-text">Choose your preferred roast — light, medium, dark, or custom.</p>
                                </div>
                                <div class="step-point">
                                    <div class="checkmark step-2-check">
                                        <svg viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="point-text">Select your grind size — whole bean, coarse, medium, fine, or espresso-ready.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right GIF Container -->
                        <div class="step-image-container">
                            <div class="step-image-wrapper">
                                <img src="{{ asset('new_landing_assets/new-2.gif') }}" alt="Select Your Grind & Roast Type" class="step-image">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 03 -->
                <div class="step-card" data-index="2">
                    <div class="step-card-inner step-3">
                        <div class="step-content">
                            <!-- Step Number -->
                            <span class="step-number">03</span>

                            <!-- Title -->
                            <div class="step-title-container">
                                <h3 class="step-title">Customize Your</h3>
                                <h3 class="step-title">Brand</h3>
                            </div>

                            <!-- Content with Checkboxes -->
                            <div class="step-points">
                                <div class="step-point">
                                    <div class="checkmark step-3-check">
                                        <svg viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="point-text">Upload your logo & brand assets</p>
                                </div>
                                <div class="step-point">
                                    <div class="checkmark step-3-check">
                                        <svg viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="point-text">Preview real-time renders before finalizing</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right GIF Container -->
                        <div class="step-image-container">
                            <div class="step-image-wrapper">
                                <img src="{{ asset('new_landing_assets/new-3.gif') }}" alt="Customize Your Brand" class="step-image">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials-section">
        <div class="testimonials-container">

            <!-- Header Section -->
            <div class="testimonials-header">
                <h2 class="testimonials-title">
                    What Our Customers Are Saying
                </h2>
                <p class="testimonials-subtitle">
                    Hear how coffee lovers around the world experience the taste, quality, and care behind
                    every <span class="highlight-text">ViaNexta</span> cup.
                </p>
            </div>

            <!-- Testimonials Grid -->
            <div class="testimonials-grid">

                <!-- Testimonial 1 -->
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        Ooouuu!!! This is TOP TIER!!!
                    </div>
                    <div class="testimonial-footer">
                        <div class="avatar">
                            <img src="{{ asset('new_landing_assets/danieraezorsharp.png') }}" alt="danieraezorsharp" class="avatar-img">
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <h3 class="name">danieraezorsharp</h3>
                            </div>
                            <p class="username">@danieraezorsharp</p>
                        </div>
                        <div class="social-icon">
                            <img src="{{ asset('new_landing_assets/instagramlogo.svg') }}" alt="Instagram" class="instagram-icon">
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        That's the way you do it! Big things
                    </div>
                    <div class="testimonial-footer">
                        <div class="avatar">
                            <img src="{{ asset('new_landing_assets/mrwld101.png') }}" alt="mrwld101" class="avatar-img">
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <h3 class="name">mrwld101</h3>
                            </div>
                            <p class="username">@mrwld101</p>
                        </div>
                        <div class="social-icon">
                            <img src="{{ asset('new_landing_assets/instagramlogo.svg') }}" alt="Instagram" class="instagram-icon">
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        Was introduced to your coffee thanks to @amplify @bphlfest
                    </div>
                    <div class="testimonial-footer">
                        <div class="avatar">
                            <img src="{{ asset('new_landing_assets/designgym.co.png') }}" alt="designgym.co" class="avatar-img">
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <h3 class="name">designgym.co</h3>
                            </div>
                            <p class="username">@designgym.co</p>
                        </div>
                        <div class="social-icon">
                            <img src="{{ asset('new_landing_assets/instagramlogo.svg') }}" alt="Instagram" class="instagram-icon">
                        </div>
                    </div>
                </div>

                <!-- Testimonial 4 -->
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        Love this! Yes
                    </div>
                    <div class="testimonial-footer">
                        <div class="avatar">
                            <img src="{{ asset('new_landing_assets/rachboogie215.png') }}" alt="rachboogie215" class="avatar-img">
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <h3 class="name">rachboogie215</h3>
                            </div>
                            <p class="username">@rachboogie215</p>
                        </div>
                        <div class="social-icon">
                            <img src="{{ asset('new_landing_assets/instagramlogo.svg') }}" alt="Instagram" class="instagram-icon">
                        </div>
                    </div>
                </div>

                <!-- Testimonial 5 -->
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        OMG!!!!
                    </div>
                    <div class="testimonial-footer">
                        <div class="avatar">
                            <img src="{{ asset('new_landing_assets/angelicmolos.png') }}" alt="angelicmolos" class="avatar-img">
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <h3 class="name">angelicmolos</h3>
                            </div>
                            <p class="username">@angelicmolos</p>
                        </div>
                        <div class="social-icon">
                            <img src="{{ asset('new_landing_assets/instagramlogo.svg') }}" alt="Instagram" class="instagram-icon">
                        </div>
                    </div>
                </div>

                <!-- Testimonial 6 -->
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        It's so goooooddd
                    </div>
                    <div class="testimonial-footer">
                        <div class="avatar">
                            <img src="{{ asset('new_landing_assets/bean2beancoffeeco.png') }}" alt="bean2beancoffeeco" class="avatar-img">
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <h3 class="name">bean2beancoffeeco</h3>
                            </div>
                            <p class="username">@bean2beancoffeeco</p>
                        </div>
                        <div class="social-icon">
                            <img src="{{ asset('new_landing_assets/instagramlogo.svg') }}" alt="Instagram" class="instagram-icon">
                        </div>
                    </div>
                </div>

                <!-- Testimonial 7 -->
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        More of this!!
                    </div>
                    <div class="testimonial-footer">
                        <div class="avatar">
                            <img src="{{ asset('new_landing_assets/thechocolatebarista.png') }}" alt="thechocolatebarista" class="avatar-img">
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <h3 class="name">thechocolatebarista</h3>
                            </div>
                            <p class="username">@thechocolatebarista</p>
                        </div>
                        <div class="social-icon">
                            <img src="{{ asset('new_landing_assets/instagramlogo.svg') }}" alt="Instagram" class="instagram-icon">
                        </div>
                    </div>
                </div>

                <!-- Testimonial 8 -->
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        So dope
                    </div>
                    <div class="testimonial-footer">
                        <div class="avatar">
                            <img src="{{ asset('new_landing_assets/delhibakery.png') }}" alt="delhibakery" class="avatar-img">
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <h3 class="name">delhibakery</h3>
                            </div>
                            <p class="username">@delhibakery</p>
                        </div>
                        <div class="social-icon">
                            <img src="{{ asset('new_landing_assets/instagramlogo.svg') }}" alt="Instagram" class="instagram-icon">
                        </div>
                    </div>
                </div>

                <!-- Testimonial 9 -->
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        #winning
                    </div>
                    <div class="testimonial-footer">
                        <div class="avatar">
                            <img src="{{ asset('new_landing_assets/browngirlsbrew.png') }}" alt="browngirlsbrew" class="avatar-img">
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <h3 class="name">browngirlsbrew</h3>
                            </div>
                            <p class="username">@browngirlsbrew</p>
                        </div>
                        <div class="social-icon">
                            <img src="{{ asset('new_landing_assets/instagramlogo.svg') }}" alt="Instagram" class="instagram-icon">
                        </div>
                    </div>
                </div>

                <!-- Testimonial 10 -->
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        I love this. Can't wait to grab a coffee.
                    </div>
                    <div class="testimonial-footer">
                        <div class="avatar">
                            <img src="{{ asset('new_landing_assets/beijaflornaturals.png') }}" alt="beijaflornaturals" class="avatar-img">
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <h3 class="name">beijaflornaturals</h3>
                            </div>
                            <p class="username">@beijaflornaturals</p>
                        </div>
                        <div class="social-icon">
                            <img src="{{ asset('new_landing_assets/instagramlogo.svg') }}" alt="Instagram" class="instagram-icon">
                        </div>
                    </div>
                </div>

                <!-- Testimonial 11 -->
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        Really amazing and inspiring!
                    </div>
                    <div class="testimonial-footer">
                        <div class="avatar">
                            <img src="{{ asset('new_landing_assets/mznoname82-01.png') }}" alt="mznoname82" class="avatar-img">
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <h3 class="name">mznoname82</h3>
                            </div>
                            <p class="username">@mznoname82</p>
                        </div>
                        <div class="social-icon">
                            <img src="{{ asset('new_landing_assets/instagramlogo.svg') }}" alt="Instagram" class="instagram-icon">
                        </div>
                    </div>
                </div>

                <!-- Testimonial 12 -->
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        Amazing!!! Keep breaking barriers!
                    </div>
                    <div class="testimonial-footer">
                        <div class="avatar">
                            <img src="{{ asset('new_landing_assets/avatar1.png') }}" alt="dachickenshack" class="avatar-img">
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <h3 class="name">dachickenshack</h3>
                            </div>
                            <p class="username">@dachickenshack</p>
                        </div>
                        <div class="social-icon">
                            <img src="{{ asset('new_landing_assets/instagramlogo.svg') }}" alt="Instagram" class="instagram-icon">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Forman Section -->
    <section class="forman-section" style="background: #1d3a32; padding: 64px 0;">
        <div class="forman-container" style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
            <h2 style="text-align: center; font-size: 2.8rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem;">Meet <span style="font-style: italic;">Clare & Forman</span></h2>
            <p style="text-align: center; font-size: 1.5rem; color: #e6e6e6; margin-bottom: 3rem;">Your AI dream team</p>
            <div class="forman-grid" style="display: flex; flex-wrap: wrap; gap: 2.5rem; justify-content: center; align-items: flex-start;">
                <!-- Clare Info -->
                <div class="clare-info" style="flex: 1 1 260px; min-width: 240px; max-width: 340px; color: #fff;">
                    <h3 style="font-size: 2rem; font-weight: 700; margin-bottom: 1.5rem;">Clare</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="display: flex; align-items: center; margin-bottom: 2rem; font-size: 1.25rem;"><img src="{{ asset('new_landing_assets/check.svg') }}" alt="check" style="width: 1.5em; height: 1.5em; margin-right: 0.7rem; vertical-align: middle;">Helps you define and refine your product</li>
                        <li style="display: flex; align-items: center; margin-bottom: 2rem; font-size: 1.25rem;"><img src="{{ asset('new_landing_assets/check.svg') }}" alt="check" style="width: 1.5em; height: 1.5em; margin-right: 0.7rem; vertical-align: middle;">Analyzes your website and brand brief for insights</li>
                        <li style="display: flex; align-items: center; margin-bottom: 2rem; font-size: 1.25rem;"><img src="{{ asset('new_landing_assets/check.svg') }}" alt="check" style="width: 1.5em; height: 1.5em; margin-right: 0.7rem; vertical-align: middle;">Recommends the right specs, packaging, and pricing</li>
                        <li style="display: flex; align-items: center; margin-bottom: 2rem; font-size: 1.25rem;"><img src="{{ asset('new_landing_assets/check.svg') }}" alt="check" style="width: 1.5em; height: 1.5em; margin-right: 0.7rem; vertical-align: middle;">Gathers all the production details needed to proceed</li>
                        <li style="display: flex; align-items: center; margin-bottom: 2rem; font-size: 1.25rem;"><img src="{{ asset('new_landing_assets/check.svg') }}" alt="check" style="width: 1.5em; height: 1.5em; margin-right: 0.7rem; vertical-align: middle;">Coordinates your sales and account information</li>
                        <li style="display: flex; align-items: center; margin-bottom: 2rem; font-size: 1.25rem;"><img src="{{ asset('new_landing_assets/check.svg') }}" alt="check" style="width: 1.5em; height: 1.5em; margin-right: 0.7rem; vertical-align: middle;">Sends your order to Forman, ready for execution</li>
                    </ul>
                </div>
                <!-- Center Illustration -->
                <div class="forman-illustration" style="flex: 1 1 420px; min-width: 300px; max-width: 520px; display: flex; justify-content: center; align-items: center;">
                    <img src="{{ asset('new_landing_assets/forman-clare.png') }}" alt="Clare and Forman Infographic" style="width: 100%; max-width: 420px; height: auto; display: block; margin: 0 auto;" />
                </div>
                <!-- Forman Info -->
                <div class="forman-info" style="flex: 1 1 260px; min-width: 240px; max-width: 340px; color: #fff;">
                    <h3 style="font-size: 2rem; font-weight: 700; margin-bottom: 1.5rem;">Forman</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="display: flex; align-items: center; margin-bottom: 2rem; font-size: 1.25rem;"><img src="{{ asset('new_landing_assets/check.svg') }}" alt="check" style="width: 1.5em; height: 1.5em; margin-right: 0.7rem; vertical-align: middle;">Handles your sourcing, production, and fulfillment</li>
                        <li style="display: flex; align-items: center; margin-bottom: 2rem; font-size: 1.25rem;"><img src="{{ asset('new_landing_assets/check.svg') }}" alt="check" style="width: 1.5em; height: 1.5em; margin-right: 0.7rem; vertical-align: middle;">Manages supplier communication and timelines for you</li>
                        <li style="display: flex; align-items: center; margin-bottom: 2rem; font-size: 1.25rem;"><img src="{{ asset('new_landing_assets/check.svg') }}" alt="check" style="width: 1.5em; height: 1.5em; margin-right: 0.7rem; vertical-align: middle;">Processes the specs Clare collects on your behalf</li>
                        <li style="display: flex; align-items: center; margin-bottom: 2rem; font-size: 1.25rem;"><img src="{{ asset('new_landing_assets/check.svg') }}" alt="check" style="width: 1.5em; height: 1.5em; margin-right: 0.7rem; vertical-align: middle;">Takes care of payments and invoicing automatically</li>
                        <li style="display: flex; align-items: center; margin-bottom: 2rem; font-size: 1.25rem;"><img src="{{ asset('new_landing_assets/check.svg') }}" alt="check" style="width: 1.5em; height: 1.5em; margin-right: 0.7rem; vertical-align: middle;">Tracks your entire order from start to finish</li>
                        <li style="display: flex; align-items: center; margin-bottom: 2rem; font-size: 1.25rem;"><img src="{{ asset('new_landing_assets/check.svg') }}" alt="check" style="width: 1.5em; height: 1.5em; margin-right: 0.7rem; vertical-align: middle;">Keeps Clare updated, so you're always in the loop</li>
                    </ul>
                </div>
            </div>
            <div style="text-align: center; margin-top: 3rem;">
                <button id="clare-forman-section-btn" class="clare-forman-btn" style="background: #ff7849; color: #fff; font-size: 1.2rem; font-weight: 600; border: none; border-radius: 6px; padding: 0.9rem 2.2rem; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: background 0.2s;">Talk to Clare</button>
            </div>
        </div>
        <style>
            @media (max-width: 900px) {
                .forman-grid {
                    flex-direction: column !important;
                    align-items: center !important;
                }

                .clare-info,
                .forman-info,
                .forman-illustration {
                    max-width: 100% !important;
                }
            }

            .clare-forman-btn:hover {
                background: #ff5a1f;
            }
        </style>
    </section>

    <!-- Brands Section -->
    <section class="brands-section">
        <h2 class="brands-title">
            TRUSTED BY BUSINESSES BIG AND SMALL, EVERYWHERE
        </h2>
        <div class="brands-marquee-wrapper">
            <!-- Blurs -->
            <div class="brands-blur brands-blur-left"></div>
            <div class="brands-blur brands-blur-right"></div>
            <!-- Marquee -->
            <div class="brands-marquee-outer">
                <div class="brands-marquee" id="brandsMarquee">
                    <!-- 42 logos (14 x 3 for ultra-smooth seamless loop) -->
                    <img src="{{ asset('new_landing_assets/brands/1.png') }}" alt="Brand logo 1" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/2.png') }}" alt="Brand logo 2" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/3.png') }}" alt="Brand logo 3" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/4.png') }}" alt="Brand logo 4" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/5.png') }}" alt="Brand logo 5" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/6.png') }}" alt="Brand logo 6" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/7.png') }}" alt="Brand logo 7" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/8.png') }}" alt="Brand logo 8" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/9.png') }}" alt="Brand logo 9" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/10.png') }}" alt="Brand logo 10" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/11.png') }}" alt="Brand logo 11" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/12.png') }}" alt="Brand logo 12" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/13.png') }}" alt="Brand logo 13" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/14.png') }}" alt="Brand logo 14" class="brand-logo" draggable="false" />
                    <!-- Second set for seamless loop -->
                    <img src="{{ asset('new_landing_assets/brands/1.png') }}" alt="Brand logo 1" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/2.png') }}" alt="Brand logo 2" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/3.png') }}" alt="Brand logo 3" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/4.png') }}" alt="Brand logo 4" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/5.png') }}" alt="Brand logo 5" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/6.png') }}" alt="Brand logo 6" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/7.png') }}" alt="Brand logo 7" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/8.png') }}" alt="Brand logo 8" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/9.png') }}" alt="Brand logo 9" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/10.png') }}" alt="Brand logo 10" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/11.png') }}" alt="Brand logo 11" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/12.png') }}" alt="Brand logo 12" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/13.png') }}" alt="Brand logo 13" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/14.png') }}" alt="Brand logo 14" class="brand-logo" draggable="false" />
                    <!-- Third set for ultra-smooth seamless loop -->
                    <img src="{{ asset('new_landing_assets/brands/1.png') }}" alt="Brand logo 1" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/2.png') }}" alt="Brand logo 2" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/3.png') }}" alt="Brand logo 3" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/4.png') }}" alt="Brand logo 4" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/5.png') }}" alt="Brand logo 5" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/6.png') }}" alt="Brand logo 6" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/7.png') }}" alt="Brand logo 7" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/8.png') }}" alt="Brand logo 8" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/9.png') }}" alt="Brand logo 9" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/10.png') }}" alt="Brand logo 10" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/11.png') }}" alt="Brand logo 11" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/12.png') }}" alt="Brand logo 12" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/13.png') }}" alt="Brand logo 13" class="brand-logo" draggable="false" />
                    <img src="{{ asset('new_landing_assets/brands/14.png') }}" alt="Brand logo 14" class="brand-logo" draggable="false" />
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="faq-section">
        <div class="faq-container">
            <div class="faq-grid">
                <!-- Left Title -->
                <div class="faq-title-area">
                    <h2 class="faq-title">Frequently asked questions</h2>
                </div>
                <!-- Right FAQ Items -->
                <div class="faq-items" id="faqItems">
                    <div class="faq-item">
                        <button class="faq-question" data-index="0">
                            <span>Curious how we ensure quality?</span>
                            <span class="faq-arrow"><svg class="faq-arrow-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg></span>
                        </button>
                        <div class="faq-answer">
                            We work directly with certified farms and roasters who follow strict quality standards. Every batch is tested for flavor profile, freshness, and consistency. Our verified warehouses maintain optimal storage conditions, and we track every step from farm to your cup to guarantee premium quality.
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" data-index="1">
                            <span>Wondering where your coffee ships from?</span>
                            <span class="faq-arrow"><svg class="faq-arrow-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg></span>
                        </button>
                        <div class="faq-answer">
                            Your coffee ships from our verified warehouse network strategically located across key regions. We automatically select the closest facility to ensure fastest delivery times while maintaining the freshness and quality of your beans.
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" data-index="2">
                            <span>Want to know where your beans come from?</span>
                            <span class="faq-arrow"><svg class="faq-arrow-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg></span>
                        </button>
                        <div class="faq-answer">
                            All our beans are ethically sourced from premium farms in select regions. We ensure full traceability, allowing you to see exactly where your coffee comes from, when it was harvested, and how it was processed. We also prioritize direct trade relationships with the farmers who grow them.
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" data-index="3">
                            <span>Need your coffee fast and on time?</span>
                            <span class="faq-arrow"><svg class="faq-arrow-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg></span>
                        </button>
                        <div class="faq-answer">
                            Yes! We offer expedited shipping options with tracking. Most orders are processed within 24 hours and shipped from our nearest warehouse. You'll receive real-time updates throughout the delivery process, and Forman can help you track your order status anytime.
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" data-index="4">
                            <span>Where does my order get packed and shipped?</span>
                            <span class="faq-arrow"><svg class="faq-arrow-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg></span>
                        </button>
                        <div class="faq-answer">
                            Orders are packed at our state-of-the-art warehouses that maintain optimal temperature and humidity for coffee storage. Each facility follows strict packaging protocols to preserve freshness. Your order ships from the warehouse closest to your location for fastest delivery.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer-section">
        <!-- CTA Section -->
        <div class="footer-cta">
            <div class="footer-cta-inner">
                <!-- Left Image Card -->
                <div class="footer-cta-image">
                    <div class="footer-cta-image-overlay">
                        <div class="footer-cta-image-text">Get Started Today</div>
                    </div>
                </div>
                <!-- Right Content Card -->
                <div class="footer-cta-card">
                    <div>
                        <h3 class="footer-cta-card-title">Your Brand.</h3>
                        <h3 class="footer-cta-card-title">Your Coffee.</h3>
                    </div>
                    <p class="footer-cta-card-subtitle">Backed by Certified Roasters & Warehouses.</p>
                    <p class="footer-cta-card-desc">Launch your premium coffee brand today, without worrying about sourcing, roasting, or fulfillment.</p>
                    <a href="{{ route('getStarted') }}" class="footer-cta-card-btn">
                        Get Started Now
                        <svg class="footer-cta-card-btn-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <!-- Footer Links Section -->
        <div class="footer-links-section">
            <div class="footer-links-inner">
                <div class="footer-links-grid">
                    <!-- Logo -->
                    <div class="footer-logo">
                        <img src="{{ asset('new_landing_assets/logo.png') }}" alt="ViaNexta" class="footer-logo-img" />
                    </div>
                    <!-- Quick Links -->
                    <div>
                        <h4 class="footer-links-title">Quick Links</h4>
                        <ul class="footer-links-list">
                            <li><a href="#why-choose" class="footer-link">Why Choose Us</a></li>
                            <li><a href="#supply-chain" class="footer-link">How It Works</a></li>
                            <li><a href="#testimonials" class="footer-link">Testimonials</a></li>
                            <li><a href="#faq" class="footer-link">FAQ's</a></li>
                            <li><a href="{{ route('marketplace_buyer') }}" class="footer-link">FORMAN <span class="footer-link-ai">AI</span></a></li>
                        </ul>
                    </div>
                    <!-- Company -->
                    <div>
                        <h4 class="footer-links-title">Company</h4>
                        <ul class="footer-links-list">
                            <li><a href="{{ route('work_with_us') }}" class="footer-link">Work With Us</a></li>
                            <li><a href="#contact" class="footer-link">Contact Us</a></li>
                        </ul>
                    </div>
                    <!-- Actions -->
                    <div>
                        <h4 class="footer-links-title">Actions</h4>
                        <ul class="footer-links-list">
                            <li><a href="{{ route('login_page') }}" class="footer-link">Login</a></li>
                            <li><a href="{{ route('languages') }}" class="footer-link">Create An Account</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Bottom Footer -->
                <div class="footer-bottom">
                    <div class="footer-bottom-left">
                        <span>2025 © ViaNexta | All Rights Reserved.</span>
                        <div class="footer-bottom-links">
                            <a href="#" class="footer-bottom-link">Privacy Policy</a>
                            <a href="#" class="footer-bottom-link">Terms of Service</a>
                            <a href="#" class="footer-bottom-link">Get Help</a>
                        </div>
                    </div>
                    <div class="footer-bottom-social">
                        <a href="#" class="footer-social-icon"><img src="{{ asset('new_landing_assets/Twitter.svg') }}" alt="Twitter" class="footer-social-svg"></a>
                        <a href="#" class="footer-social-icon"><img src="{{ asset('new_landing_assets/LinkedIn.svg') }}" alt="LinkedIn" class="footer-social-svg"></a>
                        <a href="#" class="footer-social-icon"><img src="{{ asset('new_landing_assets/Instagram.svg') }}" alt="Instagram" class="footer-social-svg"></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <style>
        /* Hero Section Styles */
        .hero-section {
            position: relative;
            background: linear-gradient(to bottom, #ffffff, #ffffff);
            padding: 4rem 0 6rem 0;
        }

        .hero-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1rem;
            position: relative;
            z-index: 10;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
            align-items: center;
        }

        .hero-content {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .hero-heading {
            font-size: 2.25rem;
            font-weight: 700;
            color: #06382F;
            line-height: 1.2;
            text-align: center;
            margin: 0;
        }

        .hero-descriptions {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            text-align: center;
        }

        .description-text {
            font-size: 1.125rem;
            color: #374151;
            font-weight: 300;
            line-height: 1.6;
            margin: 0;
        }

        .hero-cta {
            display: flex;
            justify-content: center;
        }

        .hero-button {
            display: inline-block;
            background: #06382F;
            color: #ffffff;
            padding: 1rem 2rem;
            font-size: 1.125rem;
            font-weight: 600;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: all 0.3s ease;
            transform: scale(1);
        }

        .hero-button:hover {
            background: #054a3a;
            transform: scale(1.05);
        }

        .hero-image {
            position: relative;
        }

        .image-container {
            position: relative;
            width: 100%;
            height: auto;
        }

        .hero-img {
            width: 100%;
            height: auto;
        }

        /* Responsive Design */
        @media (min-width: 768px) {
            .hero-heading {
                font-size: 3.75rem;
                text-align: left;
            }

            .hero-descriptions {
                text-align: left;
            }

            .hero-cta {
                justify-content: flex-start;
            }
        }

        @media (min-width: 1024px) {
            .hero-section {
                padding: 6rem 0;
            }

            .hero-grid {
                grid-template-columns: 7fr 5fr;
                gap: 4rem;
            }

            .hero-heading {
                font-size: 3.75rem;
            }

            .description-text {
                font-size: 1.25rem;
            }
        }
    </style>

    <script>
        // Navigation functionality
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        let menuOpen = false;
        mobileMenuBtn.addEventListener('click', function() {
            menuOpen = !menuOpen;
            mobileMenu.style.display = menuOpen ? 'block' : 'none';
        });
        // Close menu on link click (for anchors)
        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                menuOpen = false;
                mobileMenu.style.display = 'none';
            });
        });

        // Why Choose Section functionality
        const features = [{
                id: 1,
                title: "Certified Roasters",
                description: "Crafted by industry-leading experts to guarantee unmatched flavor, consistency, and quality in every roast.",
                image: "{{ asset('new_landing_assets/why1.jpg') }}",
                gif: "{{ asset('new_landing_assets/gif1.jpg') }}"
            },
            {
                id: 2,
                title: "Ethically Sourced Beans",
                description: "Directly sourced from sustainable farms that prioritize fair trade practices and environmental responsibility.",
                image: "{{ asset('new_landing_assets/why2.jpg') }}",
                gif: "{{ asset('new_landing_assets/gif2.jpg') }}"
            },
            {
                id: 3,
                title: "Verified Warehouses",
                description: "State-of-the-art storage facilities that maintain optimal conditions for freshness and quality preservation.",
                image: "{{ asset('new_landing_assets/why3.jpg') }}",
                gif: "{{ asset('new_landing_assets/gif3.jpg') }}"
            },
            {
                id: 4,
                title: "Premium Packaging & Customization",
                description: "Tailored packaging solutions that reflect your brand identity while preserving coffee quality and freshness.",
                image: "{{ asset('new_landing_assets/why4.jpg') }}",
                gif: "{{ asset('new_landing_assets/gif4.jpg') }}"
            }
        ];

        let activeIndex = 0;
        let progress = 0;
        let imageSrc = features[0].image;
        let nextImage = 1;
        let intervalRef = null;

        const featureImage = document.getElementById('featureImage');
        const featureItems = document.querySelectorAll('.feature-item');
        const progressFills = document.querySelectorAll('.progress-fill');

        // Preload next image
        function preloadImage(index) {
            const img = new Image();
            img.src = features[index].image;
        }

        // Auto-progression timer
        function startProgress() {
            progress = 0;
            let currentProgress = 0;

            intervalRef = setInterval(() => {
                currentProgress += 2; // 2% every 60ms = 3 seconds total
                progress = currentProgress;

                if (progressFills[activeIndex]) {
                    progressFills[activeIndex].style.width = `${progress}%`;
                }

                if (currentProgress >= 100) {
                    const nextIndex = (activeIndex + 1) % features.length;
                    setActiveIndex(nextIndex);
                    nextImage = (nextIndex + 1) % features.length;
                    currentProgress = 0;
                    progress = 0;
                }
            }, 60);
        }

        // Handle image to gif transition
        function updateImage(index) {
            imageSrc = features[index].image;
            featureImage.src = imageSrc;
            featureImage.alt = features[index].title;

            const timer = setTimeout(() => {
                imageSrc = features[index].gif;
                featureImage.src = imageSrc;
            }, 1000); // 1-second delay before showing GIF
        }

        // Set active index
        function setActiveIndex(index) {
            // Remove active class from all items
            featureItems.forEach(item => item.classList.remove('active'));

            // Add active class to current item
            featureItems[index].classList.add('active');

            // Reset all progress bars
            progressFills.forEach(fill => fill.style.width = '0%');

            activeIndex = index;
            updateImage(index);
            preloadImage(nextImage);

            // Restart progress
            if (intervalRef) {
                clearInterval(intervalRef);
            }
            startProgress();
        }

        // Handle manual item click
        function handleItemClick(index) {
            if (index !== activeIndex) {
                nextImage = (index + 1) % features.length;
                setActiveIndex(index);
            }
        }

        // Add click listeners to feature items
        featureItems.forEach((item, index) => {
            item.addEventListener('click', () => handleItemClick(index));
        });

        // Initialize
        preloadImage(nextImage);
        startProgress();

        // Supply Chain Section functionality
        const stepCards = document.querySelectorAll('.step-card');
        let activeStepIndex = 0;
        let stepIntervalRef = null;

        // Auto-rotation for step cards
        function startStepRotation() {
            if (stepIntervalRef) {
                clearInterval(stepIntervalRef);
            }

            stepIntervalRef = setInterval(() => {
                const nextIndex = (activeStepIndex + 1) % stepCards.length;
                setActiveStep(nextIndex);
            }, 15000); // 15 seconds
        }

        // Set active step
        function setActiveStep(index) {
            // Remove active class from all cards
            stepCards.forEach(card => card.classList.remove('active'));

            // Add active class to current card
            stepCards[index].classList.add('active');

            activeStepIndex = index;
        }

        // Handle step card click
        function handleStepClick(index) {
            if (index !== activeStepIndex) {
                setActiveStep(index);
                // Reset the timer when manually clicking
                if (stepIntervalRef) {
                    clearInterval(stepIntervalRef);
                }
                startStepRotation();
            }
        }

        // Add click listeners to step cards
        stepCards.forEach((card, index) => {
            card.addEventListener('click', () => handleStepClick(index));
        });

        // Initialize step rotation
        startStepRotation();

        // Dynamically set animation duration based on marquee width
        window.addEventListener('DOMContentLoaded', function() {
            var marquee = document.getElementById('brandsMarquee');
            if (marquee) {
                var marqueeWidth = marquee.scrollWidth / 2;
                var speed = 80; // px/sec
                var duration = marqueeWidth / speed;
                marquee.style.animationDuration = duration + 's';
            }
        });

        // FAQ accordion functionality
        document.addEventListener('DOMContentLoaded', function() {
            var faqItems = document.querySelectorAll('.faq-item');
            var faqQuestions = document.querySelectorAll('.faq-question');
            faqQuestions.forEach(function(btn, idx) {
                btn.addEventListener('click', function() {
                    faqItems.forEach(function(item, i) {
                        if (i === idx) {
                            item.classList.toggle('active');
                        } else {
                            item.classList.remove('active');
                        }
                    });
                });
            });
        });
    </script>
    <script>
        // Force the right footer card to match the left card's height
        function matchFooterCardHeights() {
            var left = document.querySelector('.footer-cta-image');
            var right = document.querySelector('.footer-cta-card');
            if (left && right) {
                right.style.height = left.offsetHeight + 'px';
            }
        }
        window.addEventListener('DOMContentLoaded', matchFooterCardHeights);
        window.addEventListener('resize', matchFooterCardHeights);
    </script>
    <!-- Floating Chat Button -->
    <button
        id="clare-chat-btn"
        class="clare-chat-btn"
        aria-label="Talk to Clare"
        type="button">
        <img
            src="{{ asset('new_landing_assets/clare-icon.svg') }}"
            alt="Clare Icon"
            class="clare-chat-icon"
            draggable="false" />
        <span class="clare-chat-text">Talk to Clare</span>
    </button>

    <script>
        const chatBtn = document.getElementById('clare-chat-btn');

        function checkOverlap() {
            const button = chatBtn;
            if (!button) return;
            const buttonRect = button.getBoundingClientRect();
            const greenSections = document.querySelectorAll('.green-section');
            let overlap = false;
            greenSections.forEach(section => {
                const sectionRect = section.getBoundingClientRect();
                if (
                    buttonRect.bottom > sectionRect.top &&
                    buttonRect.top < sectionRect.bottom &&
                    buttonRect.right > sectionRect.left &&
                    buttonRect.left < sectionRect.right
                ) {
                    overlap = true;
                }
            });
            if (overlap) {
                button.classList.add('on-green');
            } else {
                button.classList.remove('on-green');
            }
        }
        window.addEventListener('scroll', checkOverlap);
        window.addEventListener('resize', checkOverlap);
        window.addEventListener('DOMContentLoaded', () => setTimeout(checkOverlap, 100));
    </script>

    <!-- Clare Chat Drawer -->
    <div id="clare-chat-drawer" class="clare-chat-drawer">
        <div class="clare-chat-header">
            <div class="clare-chat-header-left">
                <img src="{{ asset('new_landing_assets/winwin-circle.svg') }}" alt="Clare Logo" class="clare-chat-logo" />
                <span class="clare-chat-title">Clare</span>
            </div>
            <button class="clare-chat-close" id="clare-chat-close" aria-label="Close">
                <svg width="20" height="20" fill="none" stroke="#222" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 6l12 12M6 18L18 6" />
                </svg>
            </button>
        </div>
        <div class="clare-chat-messages" id="clare-chat-messages"></div>
        <div class="clare-chat-input-area">
            <input id="clare-chat-input" type="text" class="clare-chat-input" placeholder="What can I help you with?" />
            <button id="clare-chat-send" class="clare-chat-send" aria-label="Send">
                <img src="{{ asset('new_landing_assets/send-icon.svg') }}" alt="Send" class="clare-chat-send-icon" />
            </button>
        </div>
    </div>

    <script>
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

        // Drawer open/close
        const chatDrawer = document.getElementById('clare-chat-drawer');
        const chatBtn2 = document.getElementById('clare-chat-btn');
        const chatClose = document.getElementById('clare-chat-close');
        const clareFormanSectionBtn = document.getElementById('clare-forman-section-btn');

        chatBtn2.addEventListener('click', () => {
            chatDrawer.classList.add('open');
        });

        clareFormanSectionBtn.addEventListener('click', () => {
            chatDrawer.classList.add('open');
        });

        chatClose.addEventListener('click', () => {
            chatDrawer.classList.remove('open');
        });

        // Chat logic
        const chatInput = document.getElementById('clare-chat-input');
        const chatSend = document.getElementById('clare-chat-send');
        const chatMessages = document.getElementById('clare-chat-messages');

        function addUserMessage(text) {
            const div = document.createElement('div');
            div.className = 'clare-chat-message-user';
            div.textContent = text;
            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function addBotMessage(html) {
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
            const value = chatInput.value.trim();
            if (!value) return;

            // Add user message
            addUserMessage(value);
            chatInput.value = '';
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

        chatSend.addEventListener('click', handleSend);
        chatInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleSend();
            }
        });
    </script>

    <script>
        // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function() {
                    const isVisible = mobileMenu.style.display === 'block';
                    mobileMenu.style.display = isVisible ? 'none' : 'block';

                    // Update button icon
                    const svg = mobileMenuBtn.querySelector('svg');
                    if (svg) {
                        if (isVisible) {
                            // Show hamburger icon
                            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                        } else {
                            // Show close icon
                            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                        }
                    }
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (!mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                        mobileMenu.style.display = 'none';
                        const svg = mobileMenuBtn.querySelector('svg');
                        if (svg) {
                            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>