<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ViaNexta </title>
  <style>
    * {
      box-sizing: border-box;
    }
    html, body { 
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
    .nav-link, .nav-action {
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
    .nav-link:hover, .nav-action:hover {
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
      box-shadow: 0 4px 12px rgba(0,0,0,0.04);
      z-index: 100;
      animation: fade-in 0.2s;
    }
    .mobile-menu .mobile-link, .mobile-menu .mobile-action {
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
    .mobile-menu .mobile-link:hover, .mobile-menu .mobile-action:hover {
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
    }
    @keyframes fade-in {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0);       }
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

    .mobile-user-role {
      color: #6b7280;
      font-size: 12px;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 4px;
    }

    .mobile-user-role.buyer {
      color: #059669;
      background: #d1fae5;
      padding: 3px 8px;
      border-radius: 6px;
      font-size: 11px;
    }

    .mobile-user-role.seller {
      color: #dc2626;
      background: #fee2e2;
      padding: 3px 8px;
      border-radius: 6px;
      font-size: 11px;
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
      width: 80%;
      height: auto;
      margin: 0 auto;
      display: block;
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
      transition: opacity 0.15s ease-in-out;
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
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
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
      .supply-chain-title {
        font-size: 3.75rem;
      }
      .step-cards-container {
        flex-direction: row;
        gap: 1.5rem;
      }
      .step-card {
        width: 140px;
        height: 400px;
        flex-shrink: 0;
      }
      .step-card.active {
        width: 900px;
        height: 400px;
        flex-shrink: 0;
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
        width: 100%;
        max-width: 465px;
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
      background: linear-gradient(to bottom, rgba(6,56,47,0) 0%, #06382F 100%);
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
      max-width: 100%;
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
      0% { transform: translateX(0); }
      100% { transform: translateX(-33.333333%); }
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
      max-width: 1086px;
      width: 100%;
      margin: 0 auto;
      display: flex;
      flex-direction: row;
      gap: 1.5rem;
      justify-content: center;
      align-items: stretch;
      box-sizing: border-box;
      padding: 0 1rem;
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
      width: 100%;
      max-width: 733px;
      height: 391px;
      box-sizing: border-box;
      flex: 1;
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
      background: rgba(0,0,0,0.25);
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
      background: rgba(0,0,0,0.2);
      transition: background 0.2s;
    }
    .footer-cta-image-link:hover {
      background: rgba(0,0,0,0.35);
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
      width: 100%;
      max-width: 353px;
      height: 391px;
      box-sizing: border-box;
      flex: 1;
      gap: 1.25rem;
      min-height: 0;
      overflow: hidden;
    }
    @media (max-width: 768px) {
      .footer-cta-inner {
        flex-direction: column;
        width: 100%;
        padding: 0 1rem;
        gap: 1rem;
      }
      .footer-cta-image,
      .footer-cta-card {
        width: 100%;
        max-width: 100%;
        height: 391px;
        flex: none;
      }
      .footer-cta-image {
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
        background-image: url("{{ asset('new_landing_assets/ctaimage.png') }}") !important;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        order: 1;
      }
      .footer-cta-card {
        order: 2;
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
    
    /* Newsletter Subscription Styles */
    .newsletter-subscription {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    
    .newsletter-description {
      font-size: 0.875rem;
      color: #6b7280;
      margin: 0;
      line-height: 1.5;
    }
    
    .newsletter-form {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }
    
    .newsletter-input-group {
      display: flex;
      gap: 0.5rem;
      align-items: stretch;
    }
    
    .newsletter-input {
      flex: 1;
      padding: 0.75rem;
      border: 1px solid #d1d5db;
      border-radius: 0.375rem;
      font-size: 0.875rem;
      color: #374151;
      background: #ffffff;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    
    .newsletter-input:focus {
      outline: none;
      border-color: #06382F;
      box-shadow: 0 0 0 3px rgba(6, 56, 47, 0.1);
    }
    
    .newsletter-button {
      padding: 0.75rem 1rem;
      background: #06382F;
      color: #ffffff;
      border: none;
      border-radius: 0.375rem;
      font-size: 0.875rem;
      font-weight: 500;
      cursor: pointer;
      transition: background 0.2s;
      white-space: nowrap;
    }
    
    .newsletter-button:hover {
      background: #052a24;
    }
    
    .newsletter-message {
      padding: 0.5rem;
      border-radius: 0.375rem;
      font-size: 0.875rem;
      text-align: center;
    }
    
    .newsletter-message.success {
      background: #d1fae5;
      color: #065f46;
      border: 1px solid #a7f3d0;
    }
    
    .newsletter-message.error {
      background: #fee2e2;
      color: #dc2626;
      border: 1px solid #fecaca;
    }
    
    /* Responsive Design for Newsletter */
    @media (max-width: 768px) {
      .newsletter-input-group {
        flex-direction: column;
      }
      
      .newsletter-button {
        width: 100%;
      }
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
      box-shadow: 0 4px 24px 0 rgba(7,56,47,0.15);
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
      box-shadow: -4px 0 24px 0 rgba(7,56,47,0.15);
      border-top-left-radius: 16px;
      border-bottom-left-radius: 16px;
      display: flex;
      flex-direction: column;
      transform: translateX(100%);
      transition: transform 0.3s cubic-bezier(.4,0,.2,1);
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
      box-shadow: 0 1px 4px 0 rgba(0,0,0,0.03);
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
      box-shadow: 0 1px 4px 0 rgba(0,0,0,0.03);
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
      resize: none;
      min-height: 2.5rem;
      max-height: 7.5rem; /* 3 rows * 2.5rem = 7.5rem */
      overflow-y: auto;
      font-family: inherit;
      line-height: 1.4;
      transition: height 0.2s ease;
      white-space: pre-wrap;
      word-wrap: break-word;
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
    .clare-chat-message-user, .clare-chat-message-bot {
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
    
    .clare-chat-image-card {
      margin: 0.5rem 0;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      border: 1px solid #e5e7eb;
      max-width: 500px;
      height: 300px;
      margin-left: 0;
      margin-right: auto;
    }
    
    .clare-chat-image {
      width: 100%;
      height: 100%;
      display: block;
      object-fit: cover;
      position: absolute;
      top: 0;
      left: 0;
    }
    
    .clare-chat-image-card {
      margin: 0.5rem 0;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      border: 1px solid #e5e7eb;
      max-width: 500px;
      height: 300px;
      margin-left: 0;
      margin-right: auto;
      position: relative;
    }
    
    .clare-chat-image-caption {
      padding: 0.75rem 1rem;
      font-size: 0.875rem;
      color: #374151;
      font-weight: 500;
      text-align: center;
      background: #f9fafb;
      border-top: 1px solid #e5e7eb;
    }

    /* Special styling for bag preview images from Clare */
    .clare-chat-image-card .clare-chat-image {
      border: 2px solid #D8501C;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(216, 80, 28, 0.2);
      object-fit: contain;
      background: #fff;
    }

    /* Ensure bag preview images are properly sized */
    .clare-chat-image-card {
      min-height: 250px;
      max-height: 400px;
      width: 100%;
      max-width: 350px;
      margin: 16px auto;
      display: block;
    }

    /* Logo upload spinner styles */
    .logo-upload-spinner {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 10001;
      justify-content: center;
      align-items: center;
    }

    .logo-upload-spinner-content {
      background: rgba(255, 255, 255, 0.95);
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
      text-align: center;
      min-width: 200px;
      backdrop-filter: blur(10px);
    }

    .logo-upload-spinner.show {
      display: flex;
    }

    .spinner {
      width: 40px;
      height: 40px;
      border: 4px solid #e5e7eb;
      border-top: 4px solid #D8501C;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin: 0 auto 1rem;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .spinner-text {
      color: #374151;
      font-size: 1rem;
      font-weight: 500;
      margin: 0;
    }
    @media (max-width: 600px) {
      .clare-chat-message-user, .clare-chat-message-bot {
        max-width: 98%;
      }
    }

    /* Mobile Responsiveness for Clare Chat */
    @media (max-width: 768px) {
      /* Clare Chat Button Mobile Styles */
      .clare-chat-btn {
        bottom: 1rem;
        right: 1rem;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        gap: 0.5rem;
        border-radius: 50px;
        box-shadow: 0 4px 16px 0 rgba(7,56,47,0.2);
      }

      .clare-chat-icon {
        width: 1.5rem;
        height: 1.5rem;
      }

      .clare-chat-text {
        font-size: 0.875rem;
      }

      /* Clare Chat Drawer Mobile Styles */
      .clare-chat-drawer {
        width: 100%;
        max-width: 100%;
        border-radius: 0;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        transform: translateY(100%);
        transition: transform 0.3s cubic-bezier(.4,0,.2,1);
        display: flex;
        flex-direction: column;
      }

      .clare-chat-drawer.open {
        transform: translateY(0);
      }

      .clare-chat-header {
        border-radius: 0;
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
      }

      .clare-chat-title {
        font-size: 1rem;
      }

      .clare-chat-logo {
        width: 1.75rem;
        height: 1.75rem;
      }

      .clare-chat-messages {
        padding: 0.75rem 1rem 0.5rem 1rem;
        gap: 0.5rem;
        flex: 1;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
      }

      .clare-chat-message-user {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        max-width: 85%;
      }

      .clare-chat-message-bot {
        padding: 0.75rem;
        font-size: 0.875rem;
        max-width: 90%;
        gap: 0.5rem;
      }

      .clare-chat-bot-avatar {
        width: 1.5rem;
        height: 1.5rem;
        margin-top: 0.125rem;
      }

      /* Mobile Chat Input Area - Enhanced for better visibility */
      .clare-chat-input-area {
        padding: 0.75rem 1rem;
        border-top: 1px solid #e5e7eb;
        background: #f5f7fc;
        position: sticky;
        bottom: 0;
        z-index: 10;
        box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .clare-chat-input {
        flex: 1;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        min-height: 2.5rem;
        max-height: 7.5rem; /* 3 rows * 2.5rem = 7.5rem */
        border: 1px solid #e5e7eb;
        border-radius: 1.5rem;
        background: #fff;
        transition: border-color 0.2s ease;
        outline: none;
        font-family: inherit;
        line-height: 1.4;
        -webkit-appearance: none;
        appearance: none;
        display: block;
        width: 100%;
        box-sizing: border-box;
        resize: none;
        overflow-y: auto;
        white-space: pre-wrap;
        word-wrap: break-word;
      }

      .clare-chat-input:focus {
        border-color: #06382F;
        box-shadow: 0 0 0 3px rgba(6, 56, 47, 0.1);
        font-size: 1rem;
      }

      /* Prevent zoom on input focus for mobile */
      .clare-chat-input {
        font-size: 16px !important;
      }

      /* Safari-specific fixes for mobile */
      @supports (-webkit-touch-callout: none) {
        .clare-chat-drawer {
          -webkit-overflow-scrolling: touch !important;
          overflow: hidden !important;
        }
        
        .clare-chat-messages {
          -webkit-overflow-scrolling: touch !important;
          padding-bottom: 80px !important;
        }
        
        .clare-chat-input-area {
          position: fixed !important;
          bottom: 0 !important;
          left: 0 !important;
          right: 0 !important;
          z-index: 10005 !important;
          background: #f5f7fc !important;
          padding: 0.75rem 1rem !important;
          border-top: 1px solid #e5e7eb !important;
          box-shadow: 0 -2px 8px rgba(0,0,0,0.1) !important;
          display: flex !important;
          align-items: center !important;
          gap: 0.5rem !important;
        }
        
        .clare-chat-input {
          -webkit-appearance: none !important;
          -webkit-border-radius: 1.5rem !important;
          border-radius: 1.5rem !important;
          -webkit-box-sizing: border-box !important;
          box-sizing: border-box !important;
          font-size: 16px !important;
          line-height: 1.4 !important;
          padding: 0.75rem 1rem !important;
          min-height: 2.5rem !important;
          max-height: 7.5rem !important;
          resize: none !important;
          overflow-y: auto !important;
          white-space: pre-wrap !important;
          word-wrap: break-word !important;
          border: 1px solid #e5e7eb !important;
          background: #fff !important;
          outline: none !important;
          font-family: inherit !important;
          flex: 1 !important;
          display: block !important;
          width: 100% !important;
          -webkit-transform: translateZ(0) !important;
          transform: translateZ(0) !important;
        }
        
        .clare-chat-send {
          -webkit-appearance: none !important;
          -webkit-border-radius: 50% !important;
          border-radius: 50% !important;
          width: 2.5rem !important;
          min-height: 2.5rem !important;
          max-height: 7.5rem !important;
          resize: none !important;
          overflow-y: auto !important;
          white-space: pre-wrap !important;
          word-wrap: break-word !important;
          min-width: 2.5rem !important;
          min-height: 2.5rem !important;
          background: #06382F !important;
          border: none !important;
          display: flex !important;
          align-items: center !important;
          justify-content: center !important;
          cursor: pointer !important;
          flex-shrink: 0 !important;
          -webkit-transform: translateZ(0) !important;
          transform: translateZ(0) !important;
        }
      }
      
      /* Additional Safari fallbacks */
      @media screen and (-webkit-min-device-pixel-ratio: 0) {
        .clare-chat-input {
          font-size: 16px !important;
          -webkit-appearance: none !important;
          appearance: none !important;
        }
        
        .clare-chat-input-area {
          display: flex !important;
          align-items: center !important;
        }
      }
      
      /* Ultra-aggressive Safari fixes */
      @supports (-webkit-touch-callout: none) {
        .clare-chat-input-area {
          position: fixed !important;
          bottom: 0 !important;
          left: 0 !important;
          right: 0 !important;
          z-index: 10005 !important;
          background: #f5f7fc !important;
          padding: 0.75rem 1rem !important;
          border-top: 1px solid #e5e7eb !important;
          box-shadow: 0 -2px 8px rgba(0,0,0,0.1) !important;
          display: flex !important;
          align-items: center !important;
          gap: 0.5rem !important;
          min-height: 60px !important;
        }
        
        .clare-chat-input {
          -webkit-appearance: none !important;
          -webkit-border-radius: 1.5rem !important;
          border-radius: 1.5rem !important;
          -webkit-box-sizing: border-box !important;
          box-sizing: border-box !important;
          font-size: 16px !important;
          line-height: 1.4 !important;
          padding: 0.75rem 1rem !important;
          min-height: 2.5rem !important;
          max-height: 7.5rem !important;
          resize: none !important;
          overflow-y: auto !important;
          white-space: pre-wrap !important;
          word-wrap: break-word !important;
          border: 1px solid #e5e7eb !important;
          background: #fff !important;
          outline: none !important;
          font-family: inherit !important;
          flex: 1 !important;
          display: block !important;
          width: 100% !important;
          -webkit-transform: translateZ(0) !important;
          transform: translateZ(0) !important;
          opacity: 1 !important;
          visibility: visible !important;
          position: relative !important;
        }
        
        .clare-chat-send {
          -webkit-appearance: none !important;
          -webkit-border-radius: 50% !important;
          border-radius: 50% !important;
          width: 2.5rem !important;
          min-height: 2.5rem !important;
          max-height: 7.5rem !important;
          resize: none !important;
          overflow-y: auto !important;
          white-space: pre-wrap !important;
          word-wrap: break-word !important;
          min-width: 2.5rem !important;
          min-height: 2.5rem !important;
          background: #06382F !important;
          border: none !important;
          display: flex !important;
          align-items: center !important;
          justify-content: center !important;
          cursor: pointer !important;
          flex-shrink: 0 !important;
          -webkit-transform: translateZ(0) !important;
          transform: translateZ(0) !important;
          opacity: 1 !important;
          visibility: visible !important;
        }
      }

      .clare-chat-send {
        width: 2.5rem;
        height: 2.5rem;
        min-width: 2.5rem;
        min-height: 2.5rem;
        background: #06382F;
        border: none;
        border-radius: 50%;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
      }

      .clare-chat-send:hover {
        background: #052a24;
      }

      .clare-chat-send-icon {
        width: 1.25rem;
        height: 1.25rem;
        filter: brightness(0) invert(1);
      }

      /* EULA Button Mobile Styles */
      .eula-view-btn {
        padding: 6px 12px;
        font-size: 12px;
        margin-top: 12px;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 80px;
      }

      /* EULA Modal Mobile Styles */
      .eula-modal-content {
        width: 95%;
        padding: 16px;
        max-height: 85vh;
        margin: 1rem;
      }

      .eula-modal-title {
        font-size: 18px;
      }

      .eula-content {
        font-size: 13px;
        line-height: 1.5;
      }

      .eula-checkbox-item {
        padding: 10px;
        gap: 6px;
      }

      .eula-checkbox {
        width: 16px;
        height: 16px;
      }

      .eula-checkbox-label {
        font-size: 13px;
      }

      .eula-actions {
        flex-direction: column;
        gap: 8px;
      }

      .eula-btn {
        width: 100%;
        padding: 12px 16px;
        font-size: 14px;
      }
    }





    @media (max-width: 480px) {
      .clare-chat-btn {
        bottom: 0.75rem;
        right: 0.75rem;
        padding: 0.625rem 1.25rem;
        font-size: 0.875rem;
      }

      .clare-chat-icon {
        width: 1.25rem;
        height: 1.25rem;
      }

      .clare-chat-text {
        font-size: 0.75rem;
      }

      .clare-chat-messages {
        padding: 0.5rem 0.75rem 0.5rem 0.75rem;
      }

      .clare-chat-message-user {
        padding: 0.5rem 0.75rem;
        font-size: 0.8125rem;
        max-width: 90%;
      }

      .clare-chat-message-bot {
        padding: 0.625rem;
        font-size: 0.8125rem;
        max-width: 95%;
      }

      .clare-chat-input-area {
        padding: 0.5rem 0.75rem;
      }

      .clare-chat-input {
        padding: 0.5rem;
        font-size: 0.8125rem;
      }
    }

    /* EULA Button and Modal Styles */
    .eula-view-btn {
      background: #06382F;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: background 0.2s;
      text-align: center;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 100px;
    }

    .eula-view-btn:hover {
      background: #052a24;
    }

    .eula-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 10001;
      pointer-events: auto;
    }

    /* Ensure chat drawer stays above EULA modal background */
    .clare-chat-drawer {
      z-index: 10004 !important;
    }

    /* EULA modal content should be above chat drawer */
    .eula-modal-content {
      z-index: 10003;
    }

    .eula-modal.show {
      display: flex;
    }

    .eula-modal-content {
      background: white;
      border-radius: 12px;
      padding: 24px;
      max-width: 600px;
      width: 90%;
      max-height: 80vh;
      overflow-y: auto;
      position: relative;
    }

    .eula-modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 16px;
      border-bottom: 1px solid #e5e7eb;
    }

    .eula-modal-title {
      font-family: 'Inter', sans-serif;
      font-size: 20px;
      font-weight: 600;
      color: #111827;
      margin: 0;
    }

    .eula-modal-close {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #6b7280;
      padding: 4px;
      border-radius: 4px;
      transition: background 0.2s;
    }

    .eula-modal-close:hover {
      background: #f3f4f6;
    }

    .eula-content {
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      line-height: 1.6;
      color: #374151;
      margin-bottom: 24px;
    }

    .eula-checkboxes {
      display: flex;
      flex-direction: column;
      gap: 12px;
      margin-bottom: 24px;
    }

    .eula-checkbox-item {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 12px;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      cursor: pointer;
      transition: border-color 0.2s, background 0.2s;
    }

    .eula-checkbox-item:hover {
      border-color: #06382F;
      background: #f9fafb;
    }

    .eula-checkbox-item.selected {
      border-color: #06382F;
      background: #f0f9f6;
    }

    .eula-checkbox {
      width: 18px;
      height: 18px;
      accent-color: #06382F;
    }

    .eula-checkbox-label {
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      font-weight: 500;
      color: #111827;
      cursor: pointer;
      flex: 1;
    }

    .eula-actions {
      display: flex;
      gap: 12px;
      justify-content: flex-end;
    }

    .eula-btn {
      padding: 10px 20px;
      border-radius: 6px;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
      border: none;
    }

    .eula-btn-primary {
      background: #06382F;
      color: white;
    }

    .eula-btn-primary:hover {
      background: #052a24;
    }

    .eula-btn-secondary {
      background: #f3f4f6;
      color: #374151;
      border: 1px solid #d1d5db;
    }

    .eula-btn-secondary:hover {
      background: #e5e7eb;
    }

    @media (max-width: 600px) {
      .eula-modal-content {
        width: 95%;
        padding: 16px;
        max-height: 85vh;
      }

      .eula-modal-title {
        font-size: 18px;
      }

      .eula-actions {
        flex-direction: column;
      }

      .eula-btn {
        width: 100%;
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
        min-height: 60px; /* Only enough for step number */
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
        width: 100% !important;
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
      .step-content, .point-text {
        width: 100%;
        box-sizing: border-box;
      }
      .point-text {
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: normal;
      }
      .step-card-inner {
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding: 0;
      }
    }
    @media (max-width: 600px) {
      .footer-cta-image {
        width: 100% !important;
        max-width: 400px !important;
        margin: 0 auto !important;
      }
      .footer-cta-card {
        width: 100% !important;
        max-width: 400px !important;
        margin: 0 auto !important;
      }
    }
    /* Carousel styles for mobile */
    @media (max-width: 767px) {
      #testimonialsGrid {
        display: none !important;
      }
      #testimonialsCarousel {
        display: flex !important;
        flex-direction: column;
        align-items: center;
        position: relative;
        width: 100%;
        margin: 0 auto 2.25rem auto;
        min-height: 320px;
      }
      .carousel-card-wrapper {
        width: 100%;
        max-width: 400px;
        min-height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .carousel-arrow {
        background: #06382F;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 2.5rem;
        height: 2.5rem;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
        opacity: 0.85;
        cursor: pointer;
      }
      .carousel-arrow.left {
        left: 0.5rem;
      }
      .carousel-arrow.right {
        right: 0.5rem;
      }
      .carousel-dots {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin-top: 1.2rem;
      }
      .carousel-dot {
        width: 0.7rem;
        height: 0.7rem;
        border-radius: 50%;
        background: #d1d5db;
        transition: background 0.2s;
        cursor: pointer;
      }
      .carousel-dot.active {
        background: #06382F;
      }
    }

    /* File Upload Dropzone Styles */
    .file-upload-dropzone {
      border: 2px dashed #d1d5db;
      border-radius: 12px;
      padding: 2rem;
      text-align: center;
      background: #f9fafb;
      transition: all 0.3s ease;
      cursor: pointer;
      margin: 1rem 0;
    }

    .file-upload-dropzone:hover {
      border-color: #06382F;
      background: #f0f9f6;
    }

    .file-upload-dropzone.dragover {
      border-color: #06382F;
      background: #f0f9f6;
      transform: scale(1.02);
    }

    .file-upload-icon {
      width: 3rem;
      height: 3rem;
      margin: 0 auto 1rem;
      color: #6b7280;
    }

    .file-upload-text {
      font-size: 1rem;
      color: #374151;
      margin-bottom: 0.5rem;
      font-weight: 500;
    }

    .file-upload-hint {
      font-size: 0.875rem;
      color: #6b7280;
    }

    .file-upload-input {
      display: none;
    }

    .file-preview-container {
      margin: 1rem 0;
      text-align: center;
    }

    .bag-preview {
      position: relative;
      width: 200px;
      height: 250px;
      margin: 0 auto;
      background: #f8f9fa;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      border: 2px solid #e5e7eb;
    }

    .logo-preview {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 10px;
      background: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .upload-success {
      color: #059669;
      font-weight: 500;
      margin-top: 0.5rem;
    }

    .upload-error {
      color: #dc2626;
      font-weight: 500;
      margin-top: 0.5rem;
    }

    .remove-logo-btn {
      background: #dc2626;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      font-size: 0.875rem;
      cursor: pointer;
      margin-top: 0.5rem;
      transition: background 0.2s;
    }

    .remove-logo-btn:hover {
      background: #b91c1c;
    }

    /* Bag Preview Styles from new_buyer_wizard */
    .bag-preview-container {
      margin: 1rem 0;
      text-align: center;
    }

    .package-preview {
      min-width: 300px;
      min-height: 400px;
      width: 300px;
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f8f9fa;
      border-radius: 16px;
      padding: 20px;
      margin: 0 auto;
      position: relative;
    }

    .package-preview[data-bag-size="5lb"] {
      min-height: 500px;
      height: 500px;
    }

    .package-preview[data-bag-size="12oz"] {
      min-height: 400px;
      height: 400px;
    }

    .package-preview[data-bag-size="10oz"] {
      min-height: 350px;
      height: 350px;
    }

    .package-preview[data-bag-size="kcup"] {
      min-height: 300px;
      height: 300px;
    }

    .package-preview[data-bag-size="frac_pack"] {
      min-height: 380px;
      height: 380px;
    }

    .main-preview {
      position: relative;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .preview-img {
      max-width: 100%;
      max-height: 100%;
      width: auto;
      height: auto;
      object-fit: contain;
      border-radius: 16px;
    }

    /* Design overlay styles for logo positioning */
    .design-overlay-5lb,
    .design-overlay-12oz,
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

    .design-overlay-10oz .design-image {
      top: 52%;
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
      top: 36%;
      left: 50%;
      transform: translateX(-50%);
      max-width: 200px;
      max-height: 120px;
    }

    .bag-details {
      margin-top: 16px;
      text-align: center;
    }

    /* Mobile responsive for file upload */
    @media (max-width: 768px) {
      .file-upload-dropzone {
        padding: 1.5rem;
        margin: 0.75rem 0;
      }

      .file-upload-icon {
        width: 2.5rem;
        height: 2.5rem;
        margin-bottom: 0.75rem;
      }

      .file-upload-text {
        font-size: 0.875rem;
      }

      .file-upload-hint {
        font-size: 0.75rem;
      }

      .bag-preview {
        width: 150px;
        height: 180px;
      }

      .logo-preview {
        max-width: 70%;
        max-height: 50%;
      }

      /* Mobile responsive for bag preview */
      .package-preview {
        min-width: 250px;
        min-height: 300px;
        width: 250px;
        height: 300px;
        padding: 15px;
      }

      .package-preview[data-bag-size="5lb"] {
        min-height: 400px;
        height: 400px;
      }

      .package-preview[data-bag-size="12oz"] {
        min-height: 300px;
        height: 300px;
      }

      .package-preview[data-bag-size="10oz"] {
        min-height: 280px;
        height: 280px;
      }

      .package-preview[data-bag-size="kcup"] {
        min-height: 250px;
        height: 250px;
      }

      .package-preview[data-bag-size="frac_pack"] {
        min-height: 300px;
        height: 300px;
      }

      /* Adjust logo sizes for mobile */
      .design-overlay-5lb .design-image {
        max-width: 200px;
        max-height: 100px;
      }

      .design-overlay-12oz .design-image {
        max-width: 150px;
        max-height: 80px;
      }

      .design-overlay-10oz .design-image {
        max-width: 130px;
        max-height: 70px;
      }

      .design-overlay-kcup .design-image {
        max-width: 100px;
        max-height: 50px;
      }

      .design-overlay-frac_pack .design-image {
        max-width: 120px;
        max-height: 70px;
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
                                @if(session('auth_user_role') == 'Buyer' && isset($cart_items_count) && $cart_items_count > 0)
                                <span class="cart-count">{{ $cart_items_count }}</span>
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
          @if(session('auth_user_tokin') == null)
          <div class="hero-cta">
            <a
              href="{{ route('getStarted') }}"
              target="_blank"
              rel="noopener noreferrer"
              class="hero-button"
            >
              Get Started Now
            </a>
          </div>
          @endif
        </div>
        <!-- Right Image -->
        <div class="hero-image">
          <div class="image-container">
            <img
              src="{{ asset('new_landing_assets/newhero.svg') }}"
              alt="ViaNexta Hero Illustration"
              class="hero-img"
            >
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
              class="map-image"
            >
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
              class="feature-image"
            >
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
  <section class="supply-chain-section">
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
      <div class="testimonials-grid" id="testimonialsGrid">
        
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
      <!-- Mobile Carousel (hidden on desktop/tablet) -->
      <div class="testimonials-carousel" id="testimonialsCarousel" style="display: none;">
        <div class="carousel-card-wrapper">
          <!-- Testimonial cards will be cloned here by JS -->
        </div>
        <div class="carousel-dots" id="carouselDots"></div>
      </div>
    </div>
  </section>

  <!-- Clare & Forman Section -->
  <section id="clare-forman-section" class="clare-forman-section" style="background: #F1F9F6; height: 600px; overflow: hidden; position: relative;">
    <div class="clare-forman-container" style="width: 1200px; height: 600px; margin: 0 auto; padding: 0 24px; overflow-x: hidden;">
      <!-- Main Layout Container -->
      <div style="display: flex; gap: 4rem; align-items: flex-start; margin-top: 2rem;">
        
        <!-- Left Side - Title, Subtitle, and Tabs -->
        <div style="flex: 1; max-width: 400px;">
          <!-- Title -->
          <h2 style="font-family: 'Inter', sans-serif; font-size: 48px; font-weight: 400; color: #000000; line-height: 57px; text-align: left; margin: 0;">
            Meet <span style="font-weight: 700;">Clare</span> &<br>Forman
          </h2>
          
          <!-- Subtitle -->
          <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #000000; margin: 24px 0 0 0; text-align: left;">Your AI dream team</p>
          
          <!-- Tabs -->
          <div style="display: flex; margin: 24px 0 0 0; width: fit-content; background: white; border-radius: 20px; padding: 4px; position: relative; z-index: 10;">
            <button class="tab-btn active" data-tab="clare" style="padding: 8px 16px; border-radius: 16px; border: none; background: #06382F; color: white; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 12px; cursor: pointer; transition: all 0.3s; text-transform: uppercase; position: relative; z-index: 11;">CLARE</button>
            <button class="tab-btn" data-tab="forman" style="padding: 8px 16px; border-radius: 0; border: none; background: transparent; color: #6B7280; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 12px; cursor: pointer; text-transform: uppercase; position: relative; z-index: 11; outline: none; box-shadow: none; transform: none;" onmouseover="this.style.background='transparent'; this.style.boxShadow='none'; this.style.transform='none';" onmouseout="this.style.background='transparent'; this.style.boxShadow='none'; this.style.transform='none';">FORMAN</button>
          </div>
        </div>
        
        <!-- Right Side - Content Grid -->
        <div style="flex: 1; max-width: 600px;">
          <div class="desktop-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        
        <!-- Content 1 -->
        <div style="width: 248.62px; height: 165px; display: flex; flex-direction: column; justify-content: flex-start;">
          <div style="margin-bottom: 19px;">
            <img src="{{ asset('new_landing_assets/left-1.svg') }}" alt="Icon" style="width: 24px; height: 24px;">
          </div>
          <h3 style="font-family: 'Inter', sans-serif; font-size: 16px; font-weight: 600; color: #000000; margin: 0 0 19px 0;">Product Definition</h3>
          <p class="content-description" style="font-family: 'Inter', sans-serif; font-size: 14px; color: #000000; line-height: 1.4; margin: 0;">Clare helps you define and refine your core product concept, transforming your vision into a concrete plan.</p>
        </div>
        
        <!-- Content 2 -->
        <div style="width: 248.62px; height: 165px; display: flex; flex-direction: column; justify-content: flex-start;">
          <div style="margin-bottom: 19px;">
            <img src="{{ asset('new_landing_assets/right-1.svg') }}" alt="Icon" style="width: 24px; height: 24px;">
          </div>
          <h3 style="font-family: 'Inter', sans-serif; font-size: 16px; font-weight: 600; color: #000000; margin: 0 0 19px 0;">Insight Analysis</h3>
          <p class="content-description" style="font-family: 'Inter', sans-serif; font-size: 14px; color: #000000; line-height: 1.4; margin: 0;">Clare analyzes your website and brand brief, extracting insights to ensure your product aligns with your brand identity.</p>
        </div>
        
        <!-- Content 3 -->
        <div style="width: 248.62px; height: 165px; display: flex; flex-direction: column; justify-content: flex-start;">
          <div style="margin-bottom: 19px;">
            <img src="{{ asset('new_landing_assets/left-2.svg') }}" alt="Icon" style="width: 24px; height: 24px;">
          </div>
          <h3 style="font-family: 'Inter', sans-serif; font-size: 16px; font-weight: 600; color: #000000; margin: 0 0 19px 0;">Strategic Recommendations</h3>
          <p class="content-description" style="font-family: 'Inter', sans-serif; font-size: 14px; color: #000000; line-height: 1.4; margin: 0;">Based on Clare's analysis, Clare recommends optimal product specifications, packaging, and pricing.</p>
        </div>
        
        <!-- Content 4 -->
        <div style="width: 248.62px; height: 165px; display: flex; flex-direction: column; justify-content: flex-start;">
          <div style="margin-bottom: 19px;">
            <img src="{{ asset('new_landing_assets/right-2.svg') }}" alt="Icon" style="width: 24px; height: 24px;">
          </div>
          <h3 style="font-family: 'Inter', sans-serif; font-size: 16px; font-weight: 600; color: #000000; margin: 0 0 19px 0;">Detail Consolidation</h3>
          <p class="content-description" style="font-family: 'Inter', sans-serif; font-size: 14px; color: #000000; line-height: 1.4; margin: 0;">Intelligently gathers and organizes all critical production details required to move your project forward.</p>
        </div>
        
        <!-- Content 5 -->
        <div style="width: 248.62px; height: 165px; display: flex; flex-direction: column; justify-content: flex-start;">
          <div style="margin-bottom: 19px;">
            <img src="{{ asset('new_landing_assets/left-3.svg') }}" alt="Icon" style="width: 24px; height: 24px;">
          </div>
          <h3 style="font-family: 'Inter', sans-serif; font-size: 16px; font-weight: 600; color: #000000; margin: 0 0 19px 0;">Information Coordination</h3>
          <p class="content-description" style="font-family: 'Inter', sans-serif; font-size: 14px; color: #000000; line-height: 1.4; margin: 0;">Acts as your central hub, coordinating all sales data and account information in one organized place.</p>
        </div>
        
        <!-- Content 6 -->
        <div style="width: 248.62px; height: 165px; display: flex; flex-direction: column; justify-content: flex-start;">
          <div style="margin-bottom: 19px;">
            <img src="{{ asset('new_landing_assets/right-3.svg') }}" alt="Icon" style="width: 24px; height: 24px;">
          </div>
          <h3 style="font-family: 'Inter', sans-serif; font-size: 16px; font-weight: 600; color: #000000; margin: 0 0 19px 0;">Automated Handoff</h3>
          <p class="content-description" style="font-family: 'Inter', sans-serif; font-size: 14px; color: #000000; line-height: 1.4; margin: 0;">Packages your finalized order with precision and sends it to Forman, making it instantly ready for execution.</p>
        </div>
        </div>
        
        <!-- Mobile Content Cards (Hidden on Desktop) -->
        <div class="mobile-content-card" data-index="0" style="display: none; width: 100%; max-width: 320px; margin: 0 auto;">
          <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;">
            <div style="margin-bottom: 1rem;">
              <img src="{{ asset('new_landing_assets/left-1.svg') }}" alt="Icon" style="width: 32px; height: 32px;">
            </div>
            <h3 style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; color: #000000; margin: 0 0 1rem 0;">Product Definition</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #000000; line-height: 1.5; margin: 0;">Clare helps you define and refine your core product concept, transforming your vision into a concrete plan.</p>
          </div>
        </div>
        
        <div class="mobile-content-card" data-index="1" style="display: none; width: 100%; max-width: 320px; margin: 0 auto;">
          <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;">
            <div style="margin-bottom: 1rem;">
              <img src="{{ asset('new_landing_assets/right-1.svg') }}" alt="Icon" style="width: 32px; height: 32px;">
            </div>
            <h3 style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; color: #000000; margin: 0 0 1rem 0;">Insight Analysis</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #000000; line-height: 1.5; margin: 0;">Clare analyzes your website and brand brief, extracting insights to ensure your product aligns with your brand identity.</p>
          </div>
        </div>
        
        <div class="mobile-content-card" data-index="2" style="display: none; width: 100%; max-width: 320px; margin: 0 auto;">
          <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;">
            <div style="margin-bottom: 1rem;">
              <img src="{{ asset('new_landing_assets/left-2.svg') }}" alt="Icon" style="width: 32px; height: 32px;">
            </div>
            <h3 style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; color: #000000; margin: 0 0 1rem 0;">Strategic Recommendations</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #000000; line-height: 1.5; margin: 0;">Based on Clare's analysis, Clare recommends optimal product specifications, packaging, and pricing.</p>
          </div>
        </div>
        
        <div class="mobile-content-card" data-index="3" style="display: none; width: 100%; max-width: 320px; margin: 0 auto;">
          <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;">
            <div style="margin-bottom: 1rem;">
              <img src="{{ asset('new_landing_assets/right-2.svg') }}" alt="Icon" style="width: 32px; height: 32px;">
            </div>
            <h3 style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; color: #000000; margin: 0 0 1rem 0;">Detail Consolidation</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #000000; line-height: 1.5; margin: 0;">Intelligently gathers and organizes all critical production details required to move your project forward.</p>
          </div>
        </div>
        
        <div class="mobile-content-card" data-index="4" style="display: none; width: 100%; max-width: 320px; margin: 0 auto;">
          <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;">
            <div style="margin-bottom: 1rem;">
              <img src="{{ asset('new_landing_assets/left-3.svg') }}" alt="Icon" style="width: 32px; height: 32px;">
            </div>
            <h3 style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; color: #000000; margin: 0 0 1rem 0;">Information Coordination</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #000000; line-height: 1.5; margin: 0;">Acts as your central hub, coordinating all sales data and account information in one organized place.</p>
          </div>
        </div>
        
        <div class="mobile-content-card" data-index="5" style="display: none; width: 100%; max-width: 320px; margin: 0 auto;">
          <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;">
            <div style="margin-bottom: 1rem;">
              <img src="{{ asset('new_landing_assets/right-3.svg') }}" alt="Icon" style="width: 32px; height: 32px;">
            </div>
            <h3 style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; color: #000000; margin: 0 0 1rem 0;">Automated Handoff</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #000000; line-height: 1.5; margin: 0;">Packages your finalized order with precision and sends it to Forman, making it instantly ready for execution.</p>
          </div>
        </div>
        
        <!-- Forman Mobile Content Cards -->
        <div class="mobile-content-card forman-card" data-index="6" style="display: none; width: 100%; max-width: 320px; margin: 0 auto;">
          <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;">
            <div style="margin-bottom: 1rem;">
              <img src="{{ asset('new_landing_assets/left-1.svg') }}" alt="Icon" style="width: 32px; height: 32px;">
            </div>
            <h3 style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; color: #ffffff; margin: 0 0 1rem 0;">Intelligent Sourcing</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #ffffff; line-height: 1.5; margin: 0;">Forman takes the lead on your supply chain, automatically handling material sourcing and supplier communications.</p>
          </div>
        </div>
        
        <div class="mobile-content-card forman-card" data-index="7" style="display: none; width: 100%; max-width: 320px; margin: 0 auto;">
          <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;">
            <div style="margin-bottom: 1rem;">
              <img src="{{ asset('new_landing_assets/left-2.svg') }}" alt="Icon" style="width: 32px; height: 32px;">
            </div>
            <h3 style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; color: #ffffff; margin: 0 0 1rem 0;">Production Oversight</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #ffffff; line-height: 1.5; margin: 0;">Forman flawlessly processes the specifications from Clare and manages the day-to-day production timelines on your behalf.</p>
          </div>
        </div>
        
        <div class="mobile-content-card forman-card" data-index="8" style="display: none; width: 100%; max-width: 320px; margin: 0 auto;">
          <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;">
            <div style="margin-bottom: 1rem;">
              <img src="{{ asset('new_landing_assets/left-3.svg') }}" alt="Icon" style="width: 32px; height: 32px;">
            </div>
            <h3 style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; color: #ffffff; margin: 0 0 1rem 0;">End-to-End Fulfillment</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #ffffff; line-height: 1.5; margin: 0;">Manages the entire fulfillment process, from final product assembly and packaging to shipping and logistics.</p>
          </div>
        </div>
        
        <div class="mobile-content-card forman-card" data-index="9" style="display: none; width: 100%; max-width: 320px; margin: 0 auto;">
          <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;">
            <div style="margin-bottom: 1rem;">
              <img src="{{ asset('new_landing_assets/right-1.svg') }}" alt="Icon" style="width: 32px; height: 32px;">
            </div>
            <h3 style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; color: #ffffff; margin: 0 0 1rem 0;">Automated Financials</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #ffffff; line-height: 1.5; margin: 0;">Streamlines your finances by automatically taking care of all supplier payments and customer invoicing.</p>
          </div>
        </div>
        
        <div class="mobile-content-card forman-card" data-index="10" style="display: none; width: 100%; max-width: 320px; margin: 0 auto;">
          <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;">
            <div style="margin-bottom: 1rem;">
              <img src="{{ asset('new_landing_assets/right-2.svg') }}" alt="Icon" style="width: 32px; height: 32px;">
            </div>
            <h3 style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; color: #ffffff; margin: 0 0 1rem 0;">Live Order Tracking</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #ffffff; line-height: 1.5; margin: 0;">Provides complete visibility by tracking your entire order from the factory floor to the final delivery address.</p>
          </div>
        </div>
        
        <div class="mobile-content-card forman-card" data-index="11" style="display: none; width: 100%; max-width: 320px; margin: 0 auto;">
          <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;">
            <div style="margin-bottom: 1rem;">
              <img src="{{ asset('new_landing_assets/right-3.svg') }}" alt="Icon" style="width: 32px; height: 32px;">
            </div>
            <h3 style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; color: #ffffff; margin: 0 0 1rem 0;">Synchronized Updates</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #ffffff; line-height: 1.5; margin: 0;">Keeps Clare and your team updated in real-time, ensuring everyone is in the loop from start to finish.</p>
          </div>
        </div>
        
        <!-- Mobile Carousel Dots -->
        <div class="mobile-dots" style="display: none; justify-content: center; margin-top: 2rem; gap: 0.5rem;">
          <div class="dot active" data-index="0"></div>
          <div class="dot" data-index="1"></div>
          <div class="dot" data-index="2"></div>
          <div class="dot" data-index="3"></div>
          <div class="dot" data-index="4"></div>
          <div class="dot" data-index="5"></div>
        </div>
        
      </div>
      

      
      <!-- Illustration at bottom corner of section -->
      <div class="clare-illustration" style="position: absolute; bottom: -5px; left: 0; z-index: 1;">
        <img src="{{ asset('new_landing_assets/clare-side.svg') }}" alt="Clare Illustration" style="width: 300px; height: auto; opacity: 0.8;">
      </div>
    </div>
  </section>
    
    <style>
      /* Switch functionality */
      .clare-forman-section {
        transition: background 0.5s ease;
      }
      
      .forman-state {
        background: #06382F !important;
      }
      
      .clare-state {
        background: #F1F9F6 !important;
      }
      
      /* Tab functionality */
      .tab-btn.active {
        background: #06382F !important;
        color: white !important;
      }
      
      .tab-btn:not(.active) {
        background: transparent !important;
        color: #374151 !important;
      }
      
      .tab-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      }
      
      /* Mobile responsive styling */
      @media (max-width: 768px) {
        .clare-forman-container {
          width: 100% !important;
          padding: 0 16px !important;
          height: 600px !important;
          overflow: hidden !important;
        }
        
        .clare-forman-container > div:first-child {
          flex-direction: column !important;
          gap: 1rem !important;
          align-items: center !important;
          text-align: center !important;
          justify-content: center !important;
          height: 100% !important;
          overflow: hidden !important;
          padding-top: 0 !important;
          padding-bottom: 0 !important;
          transform: translateY(-1rem) !important;
        }
        
        .clare-forman-container > div:first-child > div:first-child {
          max-width: 100% !important;
          width: 100% !important;
          text-align: center !important;
        }
        
        .clare-forman-container > div:first-child > div:first-child h2 {
          text-align: center !important;
          font-size: 48px !important;
          line-height: 57px !important;
        }
        
        .clare-forman-container > div:first-child > div:first-child p {
          text-align: center !important;
        }
        
        .clare-forman-container > div:first-child > div:first-child > div {
          display: flex !important;
          justify-content: center !important;
          margin: 16px auto 0 auto !important;
          width: fit-content !important;
        }
        
        /* Hide the grid on mobile */
        .desktop-grid {
          display: none !important;
        }
        
        /* Hide all grid items */
        .clare-forman-container > div:first-child > div:last-child > div > div[style*="width: 248.62px"] {
          display: none !important;
        }
        
        /* Nuclear option - hide the entire right side content area */
        .clare-forman-container > div:first-child > div:last-child {
          display: flex !important;
          flex-direction: column !important;
          align-items: center !important;
          justify-content: center !important;
          width: 100% !important;
        }
        
        /* Show mobile content */
        .mobile-content-card {
          display: none !important;
          flex-direction: column !important;
          align-items: center !important;
          justify-content: center !important;
          width: 100% !important;
          max-width: 320px !important;
          margin: 0 auto 0 auto !important;
          transform: translateY(-2rem) !important;
        }
        
        .mobile-content-card.active {
          display: flex !important;
        }
        
        .mobile-content-card > div {
          display: flex !important;
          flex-direction: column !important;
          align-items: center !important;
          text-align: center !important;
          padding: 1.5rem !important;
          width: 100% !important;
        }
        
        .mobile-content-card img {
          width: 32px !important;
          height: 32px !important;
          margin-bottom: 1rem !important;
        }
        
        .mobile-content-card h3 {
          font-size: 20px !important;
          margin: 0 0 1rem 0 !important;
          text-align: center !important;
        }
        
        .mobile-content-card p {
          font-size: 16px !important;
          line-height: 1.5 !important;
          margin: 0 !important;
          text-align: center !important;
        }
        
        /* Mobile pagination dots */
        .mobile-dots {
          display: flex !important;
          justify-content: center !important;
          gap: 0.5rem !important;
          margin-top: 0.5rem !important;
          transform: translateY(-1rem) !important;
        }
        
        .dot {
          width: 8px !important;
          height: 8px !important;
          border-radius: 50% !important;
          background: #d1d5db !important;
          cursor: pointer !important;
          transition: background 0.3s !important;
        }
        
        .dot.active {
          background: #06382F !important;
        }
        
        .forman-state .dot.active {
          background: white !important;
        }
        
        /* Forman state styling for mobile */
        .forman-state .mobile-content-card {
          color: white !important;
        }
        
        .forman-state .mobile-content-card h3,
        .forman-state .mobile-content-card p {
          color: white !important;
        }
        
        .forman-state .dot {
          background: rgba(255, 255, 255, 0.3) !important;
        }
        
        .forman-state .dot.active {
          background: white !important;
        }
        
        .clare-illustration {
          display: none !important;
        }
        
        /* Additional rule to ensure illustration is hidden */
        .clare-forman-section .clare-illustration {
          display: none !important;
        }
        
        /* Target the image directly */
        .clare-illustration img {
          display: none !important;
        }
        
        /* Nuclear option - hide the entire illustration container */
        .clare-forman-section .clare-illustration {
          display: none !important;
          visibility: hidden !important;
          opacity: 0 !important;
          position: absolute !important;
          left: -9999px !important;
        }
      }

      /* Experience Clare Section Styles */
      .experience-clare-section {
        background: #F9F7F6;
        width: 100%;
        max-width: 1920px;
        height: 1342px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
      }
      
      .experience-clare-container {
        width: 100%;
        max-width: 1920px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 2rem;
      }
      
      .experience-clare-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 2.5rem;
        width: 100%;
        max-width: 900px;
      }
      
      .experience-clare-title {
        font-family: 'Inter', Arial, sans-serif;
        font-size: 2rem;
        font-weight: 600;
        color: #1F1E1E;
        text-align: center;
        margin: 0;
      }
      
      .experience-clare-gif-container {
        width: 900px;
        height: 480px;
        border-radius: 18.76px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
      }
      
      .experience-clare-btn {
        background: #06382F;
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-family: 'Inter', Arial, sans-serif;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: background 0.2s;
      }
      
      .experience-clare-btn:hover {
        background: #052a24;
      }
      
      .experience-clare-btn-arrow {
        width: 1rem;
        height: 1rem;
      }
      
      /* Video display rules */
      .desktop-video {
        display: block;
      }
      
      .mobile-video {
        display: none;
      }
      
      /* Responsive Design */
      @media (max-width: 1920px) {
        .experience-clare-section {
          height: auto;
          min-height: 100vh;
        }
        
        .experience-clare-gif-container {
          width: 100%;
          max-width: 900px;
          height: auto;
          aspect-ratio: 900 / 480;
        }
      }
      
      @media (max-width: 768px) {
        .experience-clare-section {
          padding: 2rem 1rem;
        }
        
        .experience-clare-title {
          font-size: 2rem;
        }
        
        .experience-clare-gif-container {
          width: 110%;
          max-width: 110%;
          height: 500px;
          border-radius: 12px;
          margin: 0 -5%;
        }
        
        .experience-clare-btn {
          padding: 0.875rem 1.5rem;
          font-size: 0.875rem;
        }
        
        /* Mobile video display */
        .desktop-video {
          display: none;
        }
        
        .mobile-video {
          display: block;
        }
      }

    </style>
  </section>

  <!-- Experience Clare Section -->
  <section class="experience-clare-section">
    <div class="experience-clare-container">
      <div class="experience-clare-content">
        <h2 class="experience-clare-title">Experience Clare</h2>
        <div class="experience-clare-gif-container">
          <video class="desktop-video" autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover; border-radius: 18.76px;">
            <source src="{{ asset('new_landing_assets/gif-normal.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
          </video>
          <video class="mobile-video" autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover; border-radius: 18.76px;">
            <source src="{{ asset('new_landing_assets/clare-forman-mobile.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
        <button class="experience-clare-btn" id="experience-clare-btn">
          Talk to Clare
          <svg class="experience-clare-btn-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>
    </div>
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
  <section class="faq-section">
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
              <span class="faq-arrow"><svg class="faq-arrow-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg></span>
            </button>
            <div class="faq-answer">
              We work directly with certified farms and roasters who follow strict quality standards. Every batch is tested for flavor profile, freshness, and consistency. Our verified warehouses maintain optimal storage conditions, and we track every step from farm to your cup to guarantee premium quality.
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-question" data-index="1">
              <span>Wondering where your coffee ships from?</span>
              <span class="faq-arrow"><svg class="faq-arrow-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg></span>
            </button>
            <div class="faq-answer">
              Your coffee ships from our verified warehouse network strategically located across key regions. We automatically select the closest facility to ensure fastest delivery times while maintaining the freshness and quality of your beans.
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-question" data-index="2">
              <span>Want to know where your beans come from?</span>
              <span class="faq-arrow"><svg class="faq-arrow-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg></span>
            </button>
            <div class="faq-answer">
             All our beans are ethically sourced from premium farms in select regions. We ensure full traceability, allowing you to see exactly where your coffee comes from, when it was harvested, and how it was processed. We also prioritize direct trade relationships with the farmers who grow them.
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-question" data-index="3">
              <span>Need your coffee fast and on time?</span>
              <span class="faq-arrow"><svg class="faq-arrow-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg></span>
            </button>
            <div class="faq-answer">
              Yes! We offer expedited shipping options with tracking. Most orders are processed within 24 hours and shipped from our nearest warehouse. You'll receive real-time updates throughout the delivery process, and Forman can help you track your order status anytime.
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-question" data-index="4">
              <span>Where does my order get packed and shipped?</span>
              <span class="faq-arrow"><svg class="faq-arrow-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg></span>
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
          @if(session('auth_user_tokin') == null)
          <a href="{{ route('getStarted') }}" target="_blank" rel="noopener noreferrer" class="footer-cta-card-btn">
            Get Started Now
            <svg class="footer-cta-card-btn-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </a>
          @endif
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
              <li><a href="#" class="footer-link">How It Works</a></li>
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
          <!-- Newsletter Subscription -->
          <div class="newsletter-subscription" id="newsletter-subscription">
            <h4 class="footer-links-title">Stay Updated</h4>
            <p class="newsletter-description">Get the latest updates and exclusive offers delivered to your inbox.</p>
            <form class="newsletter-form" id="newsletter-form" action="{{ route('saveNewLetter') }}" method="POST">
              @csrf
              <div class="newsletter-input-group">
                <input type="email" name="email" class="newsletter-input" placeholder="Enter your email" required>
                <button type="submit" class="newsletter-button">Subscribe</button>
              </div>
            </form>
            <div class="newsletter-message" id="newsletter-message" style="display: none;"></div>
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
            <a href="#" class="footer-social-icon"><img src="{{ asset('new_landing_assets/twitter.svg') }}" alt="Twitter" class="footer-social-svg"></a>
            <a href="#" class="footer-social-icon"><img src="{{ asset('new_landing_assets/linkedin.svg') }}" alt="LinkedIn" class="footer-social-svg"></a>
            <a href="#" class="footer-social-icon"><img src="{{ asset('new_landing_assets/instagram.svg') }}" alt="Instagram" class="footer-social-svg"></a>
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
    const features = [
      {
        id: 1,
        title: "Certified Roasters",
        description: "Crafted by industry-leading experts to guarantee unmatched flavor, consistency, and quality in every roast.",
        image: "{{ asset('new_landing_assets/why1.jpg') }}",
        gif: "{{ asset('new_landing_assets/New.gif') }}"
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
      // Add fade out effect
      featureImage.style.opacity = '0';
      
      setTimeout(() => {
        imageSrc = features[index].image;
        featureImage.src = imageSrc;
        featureImage.alt = features[index].title;
        
        // Fade back in
        featureImage.style.opacity = '1';
        
        const timer = setTimeout(() => {
          // Fade out for GIF transition
          featureImage.style.opacity = '0';
          
          setTimeout(() => {
            imageSrc = features[index].gif;
            featureImage.src = imageSrc;
            // Fade back in
            featureImage.style.opacity = '1';
          }, 150); // Short delay for smooth transition
        }, 1000); // 1-second delay before showing GIF
      }, 150); // Short delay for smooth transition
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
    type="button"
  >
    <img
      src="{{ asset('new_landing_assets/clare-icon.svg') }}"
      alt="Clare Icon"
      class="clare-chat-icon"
      draggable="false"
    />
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
        <svg width="20" height="20" fill="none" stroke="#222" stroke-width="2" viewBox="0 0 24 24"><path d="M6 6l12 12M6 18L18 6"/></svg>
      </button>
    </div>
    <div class="clare-chat-messages" id="clare-chat-messages"></div>
    <div class="clare-chat-input-area">
      <textarea id="clare-chat-input" class="clare-chat-input" placeholder="What can I help you with?" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" rows="1"></textarea>
      <button id="clare-chat-send" class="clare-chat-send" aria-label="Send">
        <img src="{{ asset('new_landing_assets/send-icon.svg') }}" alt="Send" class="clare-chat-send-icon" />
      </button>
    </div>
  </div>

  <!-- Logo Upload Spinner -->
  <div id="logo-upload-spinner" class="logo-upload-spinner">
    <div class="logo-upload-spinner-content">
      <div class="spinner"></div>
      <p class="spinner-text">Uploading logo ...</p>
    </div>
  </div>

  <!-- EULA Modal -->
  <div id="eula-modal" class="eula-modal">
    <div class="eula-modal-content">
      <div class="eula-modal-header">
        <h2 class="eula-modal-title">End-User License Agreement (EULA)</h2>
        <button class="eula-modal-close" onclick="hideEULA()">&times;</button>
      </div>
      <div class="eula-content">
        <p>This End-User License Agreement ("EULA") is a legal agreement between you and ViaNexta for the use of our services and products.</p>
        
        <h3>1. Acceptance of Terms</h3>
        <p>By using our services, you agree to be bound by the terms and conditions of this EULA.</p>
        
        <h3>2. License Grant</h3>
        <p>ViaNexta grants you a limited, non-exclusive, non-transferable license to use our services in accordance with this EULA.</p>
        
        <h3>3. Restrictions</h3>
        <p>You may not: (a) modify, reverse engineer, or create derivative works; (b) remove or alter any proprietary notices; (c) use the services for any illegal purpose.</p>
        
        <h3>4. Intellectual Property</h3>
        <p>All intellectual property rights in the services remain the property of ViaNexta.</p>
        
        <h3>5. Privacy</h3>
        <p>Your privacy is important to us. Please review our Privacy Policy for information about how we collect and use your data.</p>
        
        <h3>6. Termination</h3>
        <p>This license terminates automatically if you fail to comply with the terms of this EULA.</p>
        
        <h3>7. Disclaimer</h3>
        <p>The services are provided "as is" without warranty of any kind.</p>
        
        <h3>8. Limitation of Liability</h3>
        <p>In no event shall ViaNexta be liable for any indirect, incidental, special, or consequential damages.</p>
      </div>
              <div class="eula-checkboxes">
          <div class="eula-checkbox-item" onclick="selectEULAOption('agree'); event.stopPropagation();">
            <input type="radio" name="eula-choice" value="agree" class="eula-checkbox" id="eula-agree">
            <label for="eula-agree" class="eula-checkbox-label">I agree to the End-User License Agreement</label>
          </div>
          <div class="eula-checkbox-item" onclick="selectEULAOption('disagree'); event.stopPropagation();">
            <input type="radio" name="eula-choice" value="disagree" class="eula-checkbox" id="eula-disagree">
            <label for="eula-disagree" class="eula-checkbox-label">I disagree with the End-User License Agreement</label>
          </div>
        </div>
              <div class="eula-actions">
          <button class="eula-btn eula-btn-secondary" onclick="hideEULA(); event.stopPropagation();">Cancel</button>
          <button class="eula-btn eula-btn-primary" onclick="submitEULAChoice(); event.stopPropagation();" id="eula-submit-btn" disabled>Submit</button>
        </div>
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

  // Clear Clare's cache and conversation on page refresh
  function clearClareCache() {
    console.log('Clearing Clare cache and conversation...');
    
    // Clear all Clare-related localStorage items
    localStorage.removeItem('clare_chat_user_id');
    localStorage.removeItem('logoUploaded');
    localStorage.removeItem('uploadedLogoUrl');
    
    // Clear any global variables
    window.logoUploaded = false;
    window.uploadedLogoUrl = null;
    
    // Clear chat messages
    const chatMessages = document.getElementById('clare-chat-messages');
    if (chatMessages) {
      chatMessages.innerHTML = '';
    }
    
    // Reset logo upload state
    const dropzone = document.querySelector('.file-upload-dropzone');
    if (dropzone) {
      dropzone.style.display = 'block';
    }
    
    // Clear logo preview container
    const logoPreviewContainer = document.getElementById('logo-preview-container');
    if (logoPreviewContainer) {
      logoPreviewContainer.innerHTML = '';
      logoPreviewContainer.style.display = 'none';
    }
    
    console.log('Clare cache and conversation cleared successfully');
  }


  // Drawer open/close
  const chatDrawer = document.getElementById('clare-chat-drawer');
  const chatBtn2 = document.getElementById('clare-chat-btn');
  const chatClose = document.getElementById('clare-chat-close');
  const clareFormanSectionBtn = document.getElementById('clare-forman-section-btn');
  
  if (chatBtn2) {
    chatBtn2.addEventListener('click', () => {
      chatDrawer.classList.add('open');
      toggleBodyScroll(true);
      // Initialize Safari input after drawer opens
      setTimeout(initializeSafariInput, 300);
    });
  }
  
  if (clareFormanSectionBtn) {
    clareFormanSectionBtn.addEventListener('click', () => {
      chatDrawer.classList.add('open');
      toggleBodyScroll(true);
      // Initialize Safari input after drawer opens
      setTimeout(initializeSafariInput, 300);
    });
  }
  
  // Experience Clare button functionality
  const experienceClareBtn = document.getElementById('experience-clare-btn');
  if (experienceClareBtn) {
    experienceClareBtn.addEventListener('click', () => {
      chatDrawer.classList.add('open');
      toggleBodyScroll(true);
      // Initialize Safari input after drawer opens
      setTimeout(initializeSafariInput, 300);
    });
  }
  
  if (chatClose) {
    chatClose.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      chatDrawer.classList.remove('open');
      toggleBodyScroll(false);
    });
  }
  
  // Alternative close method - also close on escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && chatDrawer.classList.contains('open')) {
      chatDrawer.classList.remove('open');
      toggleBodyScroll(false);
    }
  });
  
  // Close on click outside the drawer (desktop only)
  document.addEventListener('click', (e) => {
    if (window.innerWidth > 768 && 
        chatDrawer.classList.contains('open') && 
        !chatDrawer.contains(e.target) && 
        !e.target.closest('.clare-chat-btn') && 
        !e.target.closest('#clare-forman-section-btn') &&
        !e.target.closest('#experience-clare-btn') &&
        !e.target.closest('#eula-modal')) {
      chatDrawer.classList.remove('open');
    }
  });

  // Mobile-specific drawer behavior
  function isMobile() {
    return window.innerWidth <= 768;
  }

  // Prevent body scroll when chat is open on mobile
  function toggleBodyScroll(disable) {
    if (isMobile()) {
      if (disable) {
        document.body.style.overflow = 'hidden';
        document.body.style.position = 'fixed';
        document.body.style.width = '100%';
      } else {
        document.body.style.overflow = '';
        document.body.style.position = '';
        document.body.style.width = '';
      }
    }
  }

  // Update drawer behavior based on screen size
  function updateDrawerBehavior() {
    if (isMobile()) {
      // On mobile, make drawer full screen
      chatDrawer.style.width = '100%';
      chatDrawer.style.maxWidth = '100%';
      chatDrawer.style.borderRadius = '0';
    } else {
      // On desktop, restore original styling
      chatDrawer.style.width = '';
      chatDrawer.style.maxWidth = '';
      chatDrawer.style.borderRadius = '';
    }
  }

  // Call on load and resize
  updateDrawerBehavior();
  window.addEventListener('resize', updateDrawerBehavior);

  // Chat logic
  const chatInput = document.getElementById('clare-chat-input');
  const chatSend = document.getElementById('clare-chat-send');
  const chatMessages = document.getElementById('clare-chat-messages');
  
  // Auto-resize textarea functionality
  function handleInputChange(input) {
    // Reset height to auto to get the correct scrollHeight
    input.style.height = 'auto';
    
    // Calculate the new height based on content
    const newHeight = Math.min(input.scrollHeight, 7.5 * 16); // 7.5rem = 120px (7.5 * 16px)
    
    // Set the new height
    input.style.height = newHeight + 'px';
    
    // Show scrollbar if content exceeds max height
    if (input.scrollHeight > 7.5 * 16) {
      input.style.overflowY = 'auto';
    } else {
      input.style.overflowY = 'hidden';
    }
  }
  
  // Safari-specific fixes
  function isSafari() {
    return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
  }
  
  // Ensure input field is properly initialized on Safari
  function initializeSafariInput() {
    if (isSafari() && chatInput) {
      // Force Safari to recognize the input field
      chatInput.style.display = 'none';
      chatInput.style.opacity = '0';
      chatInput.style.visibility = 'hidden';
      
      setTimeout(() => {
        chatInput.style.display = 'block';
        chatInput.style.opacity = '1';
        chatInput.style.visibility = 'visible';
        chatInput.style.position = 'relative';
        chatInput.style.zIndex = '1000';
        chatInput.focus();
        chatInput.blur();
        
        // Force a reflow
        chatInput.offsetHeight;
        
        // Try to focus again
        setTimeout(() => {
          chatInput.focus();
        }, 50);
        
        // If input is still not visible, create a new one
        setTimeout(() => {
          if (chatInput.offsetHeight === 0 || chatInput.offsetWidth === 0) {
            createSafariInput();
          }
        }, 500);
      }, 100);
    }
  }
  
  // Create a new input field for Safari if the original doesn't work
  function createSafariInput() {
    const inputArea = document.querySelector('.clare-chat-input-area');
    if (inputArea && isSafari()) {
      // Remove the old input
      const oldInput = document.getElementById('clare-chat-input');
      if (oldInput) {
        oldInput.remove();
      }
      
      // Create new textarea
      const newInput = document.createElement('textarea');
      newInput.id = 'clare-chat-input';
      newInput.className = 'clare-chat-input';
      newInput.placeholder = 'What can I help you with?';
      newInput.autocomplete = 'off';
      newInput.autocorrect = 'off';
      newInput.autocapitalize = 'off';
      newInput.spellcheck = 'false';
      newInput.rows = 1;
      
      // Insert before the send button
      const sendButton = document.getElementById('clare-chat-send');
      if (sendButton) {
        inputArea.insertBefore(newInput, sendButton);
      } else {
        inputArea.appendChild(newInput);
      }
      
      // Re-attach event listeners
      const newChatInput = document.getElementById('clare-chat-input');
      if (newChatInput) {
        newChatInput.addEventListener('input', function() {
          handleInputChange(this);
        });
        newChatInput.addEventListener('focus', handleInputEvents);
        newChatInput.addEventListener('keydown', function(e) {
          if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            handleSend();
          }
        });
        
        // Handle paste events to auto-resize
        newChatInput.addEventListener('paste', function() {
          setTimeout(() => {
            handleInputChange(this);
          }, 10);
        });
        
        // Initialize input
        handleInputChange(newChatInput);
        
        // Focus the new input
        setTimeout(() => {
          newChatInput.focus();
        }, 100);
      }
    }
  }
  
  if (chatInput) {
    chatInput.addEventListener('input', function() {
      handleInputChange(this);
    });
    
    chatInput.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        handleSend();
      }
    });
    
    // Handle paste events to auto-resize
    chatInput.addEventListener('paste', function() {
      setTimeout(() => {
        handleInputChange(this);
      }, 10);
    });
    
    // Initialize input
    handleInputChange(chatInput);
  }

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
    
    // Process HTML to detect and convert image URLs to cards
    const processedHtml = processImageUrls(html);
    
    div.innerHTML = `
      <img src="{{ asset('new_landing_assets/winwin-circle.svg') }}" alt="Clare" class="clare-chat-bot-avatar" />
      <div class="clare-chat-message-bot-content">${processedHtml}</div>
    `;
    chatMessages.appendChild(div);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }


  
  // Function to clean Cloudinary URLs from Clare's response
  function cleanCloudinaryUrl(url) {
    try {
      console.log('Original URL:', url);
      
      // Handle the specific malformed URL from Clare's response
      // Pattern: https://res.cloudinary.com/dfovrekgg/image/upload/l<em>coffee</em>plug:bag<em>logos:bag</em>logos:logo<em>image</em>12345.jpg,w<em>270,h</em>350,g<em>center,y</em>80,fl<em>relative/5lb</em>1_ltqjwy.png
      
      let cleanedUrl = url;
      
      // Remove HTML tags like <em> and </em>
      cleanedUrl = cleanedUrl.replace(/<\/?em>/g, '');
      
      // Fix the Cloudinary transformation parameters that got broken
      // Fix l_coffee_plug pattern
      cleanedUrl = cleanedUrl.replace(/lcoffeeplug:baglogos:baglogos:logoimage/g, 'l_coffee_plug:bag_logos:bag_logos:logo_image');
      
      // Fix w_270,h_350 pattern
      cleanedUrl = cleanedUrl.replace(/w270,h350/g, 'w_270,h_350');
      
      // Fix g_center,y_80 pattern
      cleanedUrl = cleanedUrl.replace(/gcenter,y80/g, 'g_center,y_80');
      
      // Fix fl_relative pattern
      cleanedUrl = cleanedUrl.replace(/flrelative/g, 'fl_relative');
      
      // Fix the path separator before 5lb
      cleanedUrl = cleanedUrl.replace(/fl_relative5lb/g, 'fl_relative/5lb');
      
      // Decode HTML entities
      cleanedUrl = cleanedUrl
        .replace(/&lt;/g, '<')
        .replace(/&gt;/g, '>')
        .replace(/&amp;/g, '&')
        .replace(/&quot;/g, '"')
        .replace(/&#x27;/g, "'")
        .replace(/&#x2F;/g, '/');
      
      // Remove any remaining HTML tags or malformed characters
      cleanedUrl = cleanedUrl.replace(/<[^>]*>/g, '');
      cleanedUrl = cleanedUrl.replace(/[^\x20-\x7E]/g, '');
      
      // Ensure the URL starts with https://
      if (!cleanedUrl.startsWith('http://') && !cleanedUrl.startsWith('https://')) {
        cleanedUrl = 'https://' + cleanedUrl;
      }
      
      console.log('Cleaned URL:', cleanedUrl);
      
      return cleanedUrl;
    } catch (error) {
      console.error('Error cleaning Cloudinary URL:', error);
      return url; // Return original URL if cleaning fails
    }
  }
  
  function processImageUrls(html) {
    // Regular expression to match markdown image format: ![alt text](url)
    const markdownImageRegex = /!\[([^\]]*)\]\((https?:\/\/[^\s)]+)\)/gi;
    
    // Regular expression to match image URLs with @ prefix
    const imageUrlRegex = /@(https?:\/\/[^\s]+\.(?:png|jpg|jpeg|gif|webp))/gi;
    
    let processedHtml = html;
    
    // Process markdown image format and clean Cloudinary URLs
    processedHtml = processedHtml.replace(markdownImageRegex, (match, altText, url) => {
      // Clean Cloudinary URL by removing HTML entities and fixing malformed URLs
      const cleanedUrl = cleanCloudinaryUrl(url);
      return `<div class="clare-chat-image-card">
        <img src="${cleanedUrl}" alt="${altText}" class="clare-chat-image" onerror="this.style.display='none'; this.parentElement.style.display='none';" />
      </div>`;
    });
    
    // Process @ prefixed URLs
    processedHtml = processedHtml.replace(imageUrlRegex, (match, url) => {
      const cleanedUrl = cleanCloudinaryUrl(url);
      return `<div class="clare-chat-image-card">
        <img src="${cleanedUrl}" alt="Product Image" class="clare-chat-image" onerror="this.style.display='none'; this.parentElement.style.display='none';" />
      </div>`;
    });
    
    // Check for EULA message and add View EULA button
    if (processedHtml.toLowerCase().includes('eula') && 
        (processedHtml.toLowerCase().includes('agree') || processedHtml.toLowerCase().includes('disagree'))) {
      processedHtml += `
        <div style="margin-top: 16px;">
          <button id="view-eula-btn" class="eula-view-btn" onclick="showEULA()">
            View EULA
          </button>
        </div>
      `;
    }

    // Check for branding/brand question (should appear before EULA)
    const lowerHtml = processedHtml.toLowerCase();
    
    // Check if logo has already been uploaded (prevent showing dropzone again)
    const logoAlreadyUploaded = window.logoUploaded || localStorage.getItem('logoUploaded') === 'true';
    
    // Check for logo URL requests that should be replaced with dropzone
    const logoUrlRequestKeywords = [
      'provide the image url',
      'image url for your logo',
      'logo url',
      'image url',
      'provide.*url.*logo',
      'url.*logo.*bag',
      'logo.*url.*bag',
      'please provide.*url',
      'share.*logo.*url',
      'send.*logo.*url',
      'upload.*logo.*url',
      'logo.*image.*url',
      'image.*url.*logo',
      'upload your logo now'
    ];
    
    const isLogoUrlRequest = logoUrlRequestKeywords.some(keyword => {
      const regex = new RegExp(keyword.toLowerCase(), 'i');
      return regex.test(lowerHtml);
    });
    
    // If it's a logo URL request, replace the message with dropzone
    if (isLogoUrlRequest && !logoAlreadyUploaded) {
      console.log('Logo URL request detected, replacing with dropzone');
      processedHtml = `
        <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
          <p style="margin: 0 0 16px 0; padding: 0; font-size: 15px;">
            Great! Please upload your logo that you'd like on the bags.
          </p>
          <div style="margin-top: 16px; padding: 16px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #06382F;">
            <h4 style="margin: 0 0 12px 0; color: #06382F; font-size: 16px;">🎨 Upload Your Brand Logo</h4>
            <p style="margin: 0 0 16px 0; color: #374151; font-size: 14px;">Upload your logo to customize your coffee packaging with your brand.</p>
            <div class="file-upload-dropzone" onclick="document.getElementById('logo-upload-input').click()">
              <svg class="file-upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
              </svg>
              <div class="file-upload-text">Upload your brand logo</div>
              <div class="file-upload-hint">Click to browse or drag and drop (max 2MB)</div>
              <input type="file" id="logo-upload-input" class="file-upload-input" accept="image/*" onchange="handleLogoUpload(event)">
            </div>
            <div id="logo-preview-container" class="file-preview-container" style="display: none;">
              <div class="bag-preview">
                <img id="logo-preview" class="logo-preview" alt="Logo Preview">
              </div>
              <div id="upload-status"></div>
            </div>
          </div>
        </div>
      `;
    } else {
      // Original branding question detection logic
      // Direct check for the specific branding question
    const specificBrandingQuestion = lowerHtml.includes('packaged with your own branding') && 
                                   lowerHtml.includes('custom branding') &&
                                   lowerHtml.includes('upload your brand logo');
    
    // General branding keywords as fallback
    const brandingKeywords = [
      'your own brand',
      'own brand',
      'custom brand',
      'brand logo',
      'company logo',
      'business logo',
      'branding option',
      'branding',
      'logo on bag',
      'custom logo',
      'personalize',
      'personalization',
      'packaged with your own branding',
      'custom branding',
      'upload your brand logo',
      'own branding',
      'standard packaging'
    ];
    
    const hasBrandingKeywords = brandingKeywords.some(keyword => 
      lowerHtml.includes(keyword.toLowerCase())
    );
    
    // Show logo upload when:
    // 1. It's the specific branding question OR has branding keywords
    // 2. Not yet at EULA stage
    // 3. Logo hasn't been uploaded yet
    const shouldShowLogoUpload = (specificBrandingQuestion || hasBrandingKeywords) && !lowerHtml.includes('eula') && !logoAlreadyUploaded;
    
    if (shouldShowLogoUpload) {
      console.log('Logo upload interface triggered by branding question:', processedHtml);
      console.log('Specific branding question detected:', specificBrandingQuestion);
      console.log('Branding keywords found:', brandingKeywords.filter(keyword => lowerHtml.includes(keyword.toLowerCase())));
      processedHtml += `
        <div style="margin-top: 16px; padding: 16px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #06382F;">
          <h4 style="margin: 0 0 12px 0; color: #06382F; font-size: 16px;">🎨 Add Your Brand</h4>
          <p style="margin: 0 0 16px 0; color: #374151; font-size: 14px;">Would you like to add your own brand logo to your order? Upload your logo to customize your packaging.</p>
          <div class="file-upload-dropzone" onclick="document.getElementById('logo-upload-input').click()">
            <svg class="file-upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <div class="file-upload-text">Upload your brand logo</div>
            <div class="file-upload-hint">Click to browse or drag and drop (max 2MB)</div>
            <input type="file" id="logo-upload-input" class="file-upload-input" accept="image/*" onchange="handleLogoUpload(event)">
          </div>
          <div id="logo-preview-container" class="file-preview-container" style="display: none;">
            <div class="bag-preview">
              <img id="logo-preview" class="logo-preview" alt="Logo Preview">
            </div>
            <div id="upload-status"></div>
          </div>
        </div>
      `;
    }
    }
    
    return processedHtml;
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

  async function sendMessageToAPI(message, logoUrl = null) {
    const userId = getUserId();
    const payload = {
      userId: userId,
      message: message
    };

    // Add logo URL if provided
    if (logoUrl) {
      payload.logoUrl = logoUrl;
      console.log('Including logo URL in API request');
      console.log('Logo URL:', logoUrl);
    }

    try {
      console.log('=== API REQUEST DEBUG ===');
      console.log('Sending payload:', payload);
      console.log('User ID:', userId);
      console.log('Message:', message);
      
      const response = await fetch('https://coffeeplug-api-b982ba0e7659.herokuapp.com/api/voiceflow/chat', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Origin': window.location.origin,
        },
        body: JSON.stringify(payload)
      });

      console.log('=== API RESPONSE DEBUG ===');
      console.log('Response status:', response.status);
      console.log('Response status text:', response.statusText);
      console.log('Response headers:', Object.fromEntries(response.headers.entries()));

      if (!response.ok) {
        console.error('HTTP Error:', response.status, response.statusText);
        throw new Error(`HTTP error! status: ${response.status} - ${response.statusText}`);
      }

      const data = await response.json();
      
      // Log the full response for debugging
      console.log('Full API Response:', JSON.stringify(data, null, 2));
      console.log('Response type:', typeof data);
      console.log('Response keys:', Object.keys(data));
      
      // More comprehensive response handling
      let responseText = null;
      
      // Try all possible response formats
      if (data.success && data.data && data.data.formattedResponse) {
        responseText = data.data.formattedResponse;
        console.log('Found response in: data.data.formattedResponse');
      } else if (data.formattedResponse) {
        responseText = data.formattedResponse;
        console.log('Found response in: data.formattedResponse');
      } else if (data.data && data.data.response) {
        responseText = data.data.response;
        console.log('Found response in: data.data.response');
      } else if (data.response) {
        responseText = data.response;
        console.log('Found response in: data.response');
      } else if (data.message) {
        responseText = data.message;
        console.log('Found response in: data.message');
      } else if (data.text) {
        responseText = data.text;
        console.log('Found response in: data.text');
      } else if (data.content) {
        responseText = data.content;
        console.log('Found response in: data.content');
      } else if (data.answer) {
        responseText = data.answer;
        console.log('Found response in: data.answer');
      } else if (data.reply) {
        responseText = data.reply;
        console.log('Found response in: data.reply');
      } else if (data.error) {
        responseText = data.error;
        console.log('Found error in: data.error');
      } else if (typeof data === 'string') {
        responseText = data;
        console.log('Found response as string');
      } else {
        // If no specific format found, try to extract any text content
        const dataString = JSON.stringify(data);
        console.log('Trying to extract from data string:', dataString);
        
        if (dataString.includes('"text"') || dataString.includes('"message"') || dataString.includes('"response"')) {
          // Try to find any text-like field
          const textMatch = dataString.match(/"text"\s*:\s*"([^"]+)"/);
          const messageMatch = dataString.match(/"message"\s*:\s*"([^"]+)"/);
          const responseMatch = dataString.match(/"response"\s*:\s*"([^"]+)"/);
          
          if (textMatch) {
            responseText = textMatch[1];
            console.log('Extracted response from text field');
          } else if (messageMatch) {
            responseText = messageMatch[1];
            console.log('Extracted response from message field');
          } else if (responseMatch) {
            responseText = responseMatch[1];
            console.log('Extracted response from response field');
          }
        }
      }
      
      if (responseText) {
        console.log('Final response text:', responseText);
        console.log('=== END API DEBUG ===');
        return responseText;
      } else {
        console.error('No response text found in data:', data);
        console.log('=== END API DEBUG ===');
        throw new Error('No response text found in API response');
      }
    } catch (error) {
      console.error('=== API ERROR DEBUG ===');
      console.error('Error sending message to API:', error);
      console.error('Error name:', error.name);
      console.error('Error message:', error.message);
      console.error('Error stack:', error.stack);
      console.log('=== END API ERROR DEBUG ===');
      
      // Return a more specific error message
      return `<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <p style="margin: 0 0 16px 0; padding: 0; color: #dc2626;">
          <strong>API Error:</strong> ${error.message}
        </p>
        <p style="margin: 0 0 16px 0; padding: 0; font-size: 0.875rem; color: #6b7280;">
          Please check the console for more details.
        </p>
      </div>`;
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
      console.error('Error in handleSend:', error);
      
      // Remove typing indicator
      typingDiv.remove();
      
      // Add error message with more details for debugging
      addBotMessage(`<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">Sorry, something went wrong. Error: ${error.message}</p></div>`);
    }
  }

  // Handle sending messages with logo upload context
  async function handleSendWithMessage(message) {
    // Add user message
    addUserMessage(message);
    
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
      console.error('Error in handleSendWithMessage:', error);
      
      // Remove typing indicator
      typingDiv.remove();
      
      // Add error message
      addBotMessage(`<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">Sorry, something went wrong. Error: ${error.message}</p></div>`);
    }
  }


  chatSend.addEventListener('click', handleSend);
  chatInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      handleSend();
    }
  });

  // Input handling (no auto-resize needed for input)
  function handleInputEvents() {
    // Handle input events if needed
  }

  chatInput.addEventListener('input', handleInputEvents);
  chatInput.addEventListener('focus', handleInputEvents);
  



  </script>
  <script>
    // Testimonials Carousel for Mobile
    document.addEventListener('DOMContentLoaded', function() {
      const grid = document.getElementById('testimonialsGrid');
      const carousel = document.getElementById('testimonialsCarousel');
      const wrapper = carousel.querySelector('.carousel-card-wrapper');
      const dotsContainer = document.getElementById('carouselDots');
      let testimonials = [];
      let current = 0;
      let autoScrollInterval;

      // Only run on mobile
      function isMobile() {
        return window.innerWidth <= 767;
      }

      function setupCarousel() {
        // Get all testimonial cards from grid
        testimonials = Array.from(grid.querySelectorAll('.testimonial-card'));
        // Remove any previous children
        wrapper.innerHTML = '';
        dotsContainer.innerHTML = '';
        // Clone the first card for initial display
        if (testimonials.length > 0) {
          wrapper.appendChild(testimonials[0].cloneNode(true));
        }
        // Dots
        testimonials.forEach((_, idx) => {
          const dot = document.createElement('div');
          dot.className = 'carousel-dot' + (idx === 0 ? ' active' : '');
          dot.addEventListener('click', () => {
            goTo(idx);
            restartAutoScroll();
          });
          dotsContainer.appendChild(dot);
        });
        current = 0;
      }

      function goTo(idx) {
        if (idx < 0) idx = testimonials.length - 1;
        if (idx >= testimonials.length) idx = 0;
        wrapper.innerHTML = '';
        wrapper.appendChild(testimonials[idx].cloneNode(true));
        // Update dots
        Array.from(dotsContainer.children).forEach((dot, i) => {
          dot.classList.toggle('active', i === idx);
        });
        current = idx;
      }

      // Auto-scroll logic
      function startAutoScroll() {
        if (autoScrollInterval) clearInterval(autoScrollInterval);
        autoScrollInterval = setInterval(() => {
          goTo(current + 1);
        }, 3000); // 3 seconds per testimonial
      }
      function restartAutoScroll() {
        if (autoScrollInterval) clearInterval(autoScrollInterval);
        startAutoScroll();
      }

      // Swipe support
      let startX = null;
      let isSwiping = false;

      wrapper.addEventListener('touchstart', e => {
        if (e.touches.length === 1) {
          startX = e.touches[0].clientX;
          isSwiping = true;
        }
      });

      wrapper.addEventListener('touchmove', e => {
        // Prevent vertical scroll if horizontal swipe is detected
        if (!isSwiping) return;
        const dx = e.touches[0].clientX - startX;
        if (Math.abs(dx) > 10) {
          e.preventDefault();
        }
      }, { passive: false });

      wrapper.addEventListener('touchend', e => {
        if (!isSwiping || startX === null) return;
        const dx = e.changedTouches[0].clientX - startX;
        if (dx > 40) {
          goTo(current - 1);
          restartAutoScroll();
        } else if (dx < -40) {
          goTo(current + 1);
          restartAutoScroll();
        }
        startX = null;
        isSwiping = false;
      });

      // Responsive: show/hide carousel/grid
      function handleResize() {
        if (isMobile()) {
          grid.style.display = 'none';
          carousel.style.display = 'flex';
          setupCarousel();
          startAutoScroll();
        } else {
          grid.style.display = '';
          carousel.style.display = 'none';
          if (autoScrollInterval) clearInterval(autoScrollInterval);
        }
      }
      window.addEventListener('resize', handleResize);
      handleResize();
    });
  </script>
  
  <!-- Smooth scrolling functionality -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Add smooth scrolling to all navigation links
      const navLinks = document.querySelectorAll('a[href^="#"]');
      navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const targetId = this.getAttribute('href').substring(1);
          const targetElement = document.getElementById(targetId);
          if (targetElement) {
            targetElement.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        });
      });
    });
  </script>
  
  <!-- Tab functionality -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const section = document.getElementById('clare-forman-section');
      const tabButtons = document.querySelectorAll('.tab-btn');
      
      // Mobile functionality
      let currentIndex = 0;
      let isMobile = window.innerWidth <= 768;
      
      function checkMobile() {
        isMobile = window.innerWidth <= 768;
      }
      
      window.addEventListener('resize', checkMobile);
      
      // Auto-rotate content on mobile
      function autoRotateContent() {
        if (isMobile) {
          const mobileCard = section.querySelector('.mobile-content-card');
          const currentContent = section.classList.contains('forman-state') ? formanContent : clareContent;
          
          if (mobileCard && currentContent[currentIndex]) {
            // Update mobile card content
            const iconEl = mobileCard.querySelector('img');
            const titleEl = mobileCard.querySelector('h3');
            const descEl = mobileCard.querySelector('p');
            
            if (iconEl && titleEl && descEl) {
              iconEl.src = currentContent[currentIndex].icon;
              titleEl.textContent = currentContent[currentIndex].title;
              descEl.textContent = currentContent[currentIndex].description;
            }
          }
          
          // Update dots
          updateDots();
          
          // Move to next item
          currentIndex = (currentIndex + 1) % currentContent.length;
        }
      }
      
      // Update pagination dots
      function updateDots() {
        const dotsContainer = section.querySelector('.mobile-dots');
        if (dotsContainer) {
          const dots = dotsContainer.querySelectorAll('.dot');
          dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
          });
        }
      }
      
      // Content data
      const clareContent = [
        { icon: '{{ asset("new_landing_assets/left-1.svg") }}', title: 'Product Definition', description: 'Clare helps you define and refine your core product concept, transforming your vision into a concrete plan.' },
        { icon: '{{ asset("new_landing_assets/right-1.svg") }}', title: 'Insight Analysis', description: 'Clare analyzes your website and brand brief, extracting insights to ensure your product aligns with your brand identity.' },
                 { icon: '{{ asset("new_landing_assets/left-2.svg") }}', title: 'Strategic Recommendations', description: 'Based on Clare\'s analysis, Clare recommends optimal product specifications, packaging, and pricing.' },
        { icon: '{{ asset("new_landing_assets/right-2.svg") }}', title: 'Detail Consolidation', description: 'Intelligently gathers and organizes all critical production details required to move your project forward.' },
        { icon: '{{ asset("new_landing_assets/left-3.svg") }}', title: 'Information Coordination', description: 'Acts as your central hub, coordinating all sales data and account information in one organized place.' },
        { icon: '{{ asset("new_landing_assets/right-3.svg") }}', title: 'Automated Handoff', description: 'Packages your finalized order with precision and sends it to Forman, making it instantly ready for execution.' }
      ];
      
      const formanContent = [
        { icon: '{{ asset("new_landing_assets/left-1.svg") }}', title: 'Intelligent Sourcing', description: 'Forman takes the lead on your supply chain, automatically handling material sourcing and supplier communications.' },
        { icon: '{{ asset("new_landing_assets/left-2.svg") }}', title: 'Production Oversight', description: 'Forman flawlessly processes the specifications from Clare and manages the day-to-day production timelines on your behalf.' },
        { icon: '{{ asset("new_landing_assets/left-3.svg") }}', title: 'End-to-End Fulfillment', description: 'Manages the entire fulfillment process, from final product assembly and packaging to shipping and logistics.' },
        { icon: '{{ asset("new_landing_assets/right-1.svg") }}', title: 'Automated Financials', description: 'Streamlines your finances by automatically taking care of all supplier payments and customer invoicing.' },
        { icon: '{{ asset("new_landing_assets/right-2.svg") }}', title: 'Live Order Tracking', description: 'Provides complete visibility by tracking your entire order from the factory floor to the final delivery address.' },
        { icon: '{{ asset("new_landing_assets/right-3.svg") }}', title: 'Synchronized Updates', description: 'Keeps Clare and your team updated in real-time, ensuring everyone is in the loop from start to finish.' }
      ];
      
      // Start auto-rotation
      if (isMobile) {
        setInterval(autoRotateContent, 3000);
      }
      
      if (tabButtons.length > 0 && section) {
        tabButtons.forEach(button => {
          button.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            
            // Remove active class from all buttons
            tabButtons.forEach(btn => {
              btn.classList.remove('active');
              btn.style.background = 'transparent';
              btn.style.color = '#6B7280';
              btn.style.borderRadius = '0';
            });
            
            // Add active class to clicked button
            this.classList.add('active');
            this.style.background = '#06382F';
            this.style.color = 'white';
            this.style.borderRadius = '16px';
            
            if (tabName === 'clare') {
              section.classList.remove('forman-state');
              section.classList.add('clare-state');
              
              // Change content back to black
              const title = section.querySelector('h2');
              const subtitle = section.querySelector('p');
              const contentTitles = section.querySelectorAll('h3');
              const contentDescriptions = section.querySelectorAll('.content-description');
              const icons = section.querySelectorAll('img[src*=".svg"]:not(.clare-illustration img)');
              
              if (title) {
                title.style.color = '#000000';
                title.innerHTML = 'Meet <span style="font-weight: 700;">Clare</span> &<br>Forman';
              }
              if (subtitle) subtitle.style.color = '#000000';
              contentTitles.forEach(h3 => h3.style.color = '#000000');
              contentDescriptions.forEach(p => p.style.color = '#000000');
              icons.forEach(icon => icon.style.filter = 'none');
              
              // Change content back to Clare's capabilities
              const clareContent = [
                { title: 'Product Definition', description: 'Clare helps you define and refine your core product concept, transforming your vision into a concrete plan.' },
                { title: 'Insight Analysis', description: 'Clare analyzes your website and brand brief, extracting insights to ensure your product aligns with your brand identity.' },
                { title: 'Strategic Recommendations', description: 'Based on Clare\'s analysis, Clare recommends optimal product specifications, packaging, and pricing.' },
                { title: 'Detail Consolidation', description: 'Intelligently gathers and organizes all critical production details required to move your project forward.' },
                { title: 'Information Coordination', description: 'Acts as your central hub, coordinating all sales data and account information in one organized place.' },
                { title: 'Automated Handoff', description: 'Packages your finalized order with precision and sends it to Forman, making it instantly ready for execution.' }
              ];
              
              contentTitles.forEach((h3, index) => {
                if (clareContent[index]) {
                  h3.textContent = clareContent[index].title;
                }
              });
              
              contentDescriptions.forEach((p, index) => {
                if (clareContent[index]) {
                  p.textContent = clareContent[index].description;
                }
              });
              
              // Reset mobile index
              currentIndex = 0;
              
            } else if (tabName === 'forman') {
              section.classList.remove('clare-state');
              section.classList.add('forman-state');
              
              // Change content to white
              const title = section.querySelector('h2');
              const subtitle = section.querySelector('p');
              const contentTitles = section.querySelectorAll('h3');
              const contentDescriptions = section.querySelectorAll('.content-description');
              const icons = section.querySelectorAll('img[src*=".svg"]:not(.clare-illustration img)');
              
              if (title) {
                title.style.color = '#FFFFFF';
                title.innerHTML = 'Meet Clare &<br><span style="font-weight: 700;">Forman</span>';
              }
              if (subtitle) subtitle.style.color = '#FFFFFF';
              contentTitles.forEach(h3 => h3.style.color = '#FFFFFF');
              contentDescriptions.forEach(p => p.style.color = '#FFFFFF');
              icons.forEach(icon => icon.style.filter = 'brightness(0) invert(1)');
              
              // Change content to Forman's capabilities
              const formanContent = [
                { title: 'Intelligent Sourcing', description: 'Forman takes the lead on your supply chain, automatically handling material sourcing and supplier communications.' },
                { title: 'Production Oversight', description: 'Forman flawlessly processes the specifications from Clare and manages the day-to-day production timelines on your behalf.' },
                { title: 'End-to-End Fulfillment', description: 'Manages the entire fulfillment process, from final product assembly and packaging to shipping and logistics.' },
                { title: 'Automated Financials', description: 'Streamlines your finances by automatically taking care of all supplier payments and customer invoicing.' },
                { title: 'Live Order Tracking', description: 'Provides complete visibility by tracking your entire order from the factory floor to the final delivery address.' },
                { title: 'Synchronized Updates', description: 'Keeps Clare and your team updated in real-time, ensuring everyone is in the loop from start to finish.' }
              ];
              
              contentTitles.forEach((h3, index) => {
                if (formanContent[index]) {
                  h3.textContent = formanContent[index].title;
                }
              });
              
              contentDescriptions.forEach((p, index) => {
                if (formanContent[index]) {
                  p.textContent = formanContent[index].description;
                }
              });
              
              // Reset mobile index
              currentIndex = 0;
            }
          });
        });
      }
    });
  </script>
  
  <!-- Clare & Forman Mobile Carousel Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const section = document.getElementById('clare-forman-section');
      if (!section) return;
      
      const mobileCards = section.querySelectorAll('.mobile-content-card');
      const dots = section.querySelectorAll('.dot');
      const tabButtons = section.querySelectorAll('.tab-btn');
      
      if (mobileCards.length === 0 || dots.length === 0) return;
      
      let currentIndex = 0;
      let autoScrollInterval;
      let isFormanState = false;
      
      // Function to show specific mobile card
      function showMobileCard(index) {
        mobileCards.forEach((card, i) => {
          card.classList.toggle('active', i === index);
        });
        updateDots(index);
        currentIndex = index;
      }
      
      // Function to update active dot
      function updateDots(activeIndex) {
        dots.forEach((dot, index) => {
          dot.classList.toggle('active', index === activeIndex);
        });
      }
      
      // Function to switch between Clare and Forman
      function switchToForman() {
        section.classList.add('forman-state');
        section.classList.remove('clare-state');
        isFormanState = true;
        
        // Hide all cards first
        mobileCards.forEach((card, i) => {
          card.classList.remove('active');
        });
        
        // Show only first Forman card (index 6)
        mobileCards[6].classList.add('active');
        currentIndex = 0;
        
        // Update dots for Forman (6 dots)
        updateDots(0); // Reset to first Forman card
      }
      
      function switchToClare() {
        section.classList.add('clare-state');
        section.classList.remove('forman-state');
        isFormanState = false;
        
        // Hide all cards first
        mobileCards.forEach((card, i) => {
          card.classList.remove('active');
        });
        
        // Show only first Clare card (index 0)
        mobileCards[0].classList.add('active');
        currentIndex = 0;
        
        // Update dots for Clare (6 dots)
        updateDots(0); // Reset to first Clare card
      }
      
      // Function to auto-scroll
      function startAutoScroll() {
        autoScrollInterval = setInterval(() => {
          const maxIndex = isFormanState ? 5 : 5; // 6 cards each (0-5)
          currentIndex = (currentIndex + 1) % (maxIndex + 1);
          const actualIndex = isFormanState ? currentIndex + 6 : currentIndex;
          showMobileCard(actualIndex);
        }, 3000); // Change every 3 seconds
      }
      
      // Function to stop auto-scroll
      function stopAutoScroll() {
        if (autoScrollInterval) {
          clearInterval(autoScrollInterval);
        }
      }
      
      // Add click handlers to tabs
      tabButtons.forEach(button => {
        button.addEventListener('click', () => {
          const tab = button.getAttribute('data-tab');
          
          // Update tab buttons
          tabButtons.forEach(btn => btn.classList.remove('active'));
          button.classList.add('active');
          
          if (tab === 'forman') {
            switchToForman();
          } else {
            switchToClare();
          }
          
          // Restart auto-scroll
          stopAutoScroll();
          startAutoScroll();
        });
      });
      
      // Add click handlers to dots
      dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
          stopAutoScroll();
          const actualIndex = isFormanState ? index + 6 : index;
          showMobileCard(actualIndex);
          startAutoScroll(); // Restart auto-scroll
        });
      });
      
      // Initialize - show first Clare card
      section.classList.add('clare-state');
      showMobileCard(0);
      
      // Start auto-scroll on mobile only
      if (window.innerWidth <= 768) {
        startAutoScroll();
      }
      
      // Handle window resize
      window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) {
          if (!autoScrollInterval) {
            startAutoScroll();
          }
        } else {
          stopAutoScroll();
        }
      });
    });

    // EULA Modal Functions
    let selectedEULAChoice = null;

    function showEULA() {
      const modal = document.getElementById('eula-modal');
      modal.classList.add('show');
      // Don't hide body overflow to keep chat visible
      // document.body.style.overflow = 'hidden';
    }

    function hideEULA() {
      const modal = document.getElementById('eula-modal');
      modal.classList.remove('show');
      
      // Ensure chat stays visible and open
      const chatDrawer = document.querySelector('.clare-chat-drawer');
      if (chatDrawer) {
        chatDrawer.classList.add('open');
        // Ensure proper z-index
        chatDrawer.style.zIndex = '10004';
      }
      
      // Don't restore body overflow to keep chat visible
      // document.body.style.overflow = '';
      
      // Reset selection
      selectedEULAChoice = null;
      document.getElementById('eula-submit-btn').disabled = true;
      document.querySelectorAll('.eula-checkbox-item').forEach(item => {
        item.classList.remove('selected');
      });
      document.querySelectorAll('.eula-checkbox').forEach(checkbox => {
        checkbox.checked = false;
      });
    }

    function selectEULAOption(choice) {
      selectedEULAChoice = choice;
      
      // Update visual selection
      document.querySelectorAll('.eula-checkbox-item').forEach(item => {
        item.classList.remove('selected');
      });
      document.querySelectorAll('.eula-checkbox').forEach(checkbox => {
        checkbox.checked = false;
      });
      
      // Select the clicked option
      const selectedItem = choice === 'agree' ? 
        document.getElementById('eula-agree').parentElement : 
        document.getElementById('eula-disagree').parentElement;
      const selectedCheckbox = choice === 'agree' ? 
        document.getElementById('eula-agree') : 
        document.getElementById('eula-disagree');
      
      selectedItem.classList.add('selected');
      selectedCheckbox.checked = true;
      
      // Enable submit button
      document.getElementById('eula-submit-btn').disabled = false;
      
      // Ensure chat stays open
      const chatDrawer = document.querySelector('.clare-chat-drawer');
      if (chatDrawer && !chatDrawer.classList.contains('open')) {
        chatDrawer.classList.add('open');
      }
    }

    function submitEULAChoice() {
      if (!selectedEULAChoice) return;
      
      // Send the choice back to the chat
      const choiceText = selectedEULAChoice === 'agree' ? 'I agree' : 'I disagree';
      addUserMessage(choiceText);
      
      // Hide the modal but keep chat visible
      hideEULA();
      
      // Ensure chat stays open
      const chatDrawer = document.querySelector('.clare-chat-drawer');
      if (chatDrawer && !chatDrawer.classList.contains('open')) {
        chatDrawer.classList.add('open');
      }
      
      // Send the choice to the API
      handleSendWithMessage(choiceText);
    }

    // Modified handleSend function to accept a message parameter
    async function handleSendWithMessage(message) {
      if (!message || !message.trim()) return;

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
        console.error('Error in handleSendWithMessage:', error);
        
        // Remove typing indicator
        typingDiv.remove();
        
        // Add error message
        addBotMessage(`<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">Sorry, something went wrong. Error: ${error.message}</p></div>`);
      }
    }

    // Close modal when clicking outside
    document.getElementById('eula-modal').addEventListener('click', function(e) {
      if (e.target === this) {
        hideEULA();
      }
    });

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && document.getElementById('eula-modal').classList.contains('show')) {
        hideEULA();
      }
    });

    // Test API connectivity on page load
    window.addEventListener('DOMContentLoaded', function() {
      // Clear Clare's cache and conversation on page refresh
      clearClareCache();
      
      console.log('=== API CONNECTIVITY TEST ===');
      console.log('Testing API connectivity...');
      
      // Test the API with a simple message
      setTimeout(() => {
        console.log('Sending test message to API...');
        sendMessageToAPI('test').then(response => {
          console.log('API test successful:', response);
          console.log('=== END API CONNECTIVITY TEST ===');
        }).catch(error => {
          console.error('API test failed:', error);
          console.log('=== END API CONNECTIVITY TEST ===');
        });
      }, 2000);
    });

    // Clear cache when user navigates away from the page
    window.addEventListener('beforeunload', function() {
      clearClareCache();
    });

    // Add a manual test function for debugging
    window.testClareAPI = function(message = 'hello') {
      console.log('=== MANUAL API TEST ===');
      console.log('Testing with message:', message);
      sendMessageToAPI(message).then(response => {
        console.log('Manual test response:', response);
        console.log('=== END MANUAL API TEST ===');
      }).catch(error => {
        console.error('Manual test error:', error);
        console.log('=== END MANUAL API TEST ===');
      });
    };





    // Handle sending message with logo URL
    async function handleSendWithMessageAndLogoUrl(message, logoUrl) {
      // Add user message
      addUserMessage(message);
      
      // Show typing indicator
      const typingDiv = addTypingIndicator();

      try {
        // Send message to API with logo URL
        const response = await sendMessageToAPIWithLogoUrl(message, logoUrl);
        
        // Remove typing indicator
        typingDiv.remove();
        
        // Add bot response
        addBotMessage(response);
      } catch (error) {
        console.error('Error in handleSendWithMessageAndLogoUrl:', error);
        
        // Remove typing indicator
        typingDiv.remove();
        
        // Add error message
        addBotMessage(`<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">Sorry, something went wrong. Error: ${error.message}</p></div>`);
      }
    }

    // Send message to API with logo URL
    async function sendMessageToAPIWithLogoUrl(message, logoUrl) {
      const userId = getUserId();
      const payload = {
        userId: userId,
        message: message,
        logoUrl: logoUrl
      };

      try {
        console.log('=== API REQUEST WITH LOGO URL DEBUG ===');
        console.log('Sending payload:', payload);
        console.log('User ID:', userId);
        console.log('Message:', message);
        console.log('Logo URL:', logoUrl);
        
        const response = await fetch('https://coffeeplug-api-b982ba0e7659.herokuapp.com/api/voiceflow/chat', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Origin': window.location.origin,
          },
          body: JSON.stringify(payload)
        });

        console.log('=== API RESPONSE DEBUG ===');
        console.log('Response status:', response.status);
        console.log('Response status text:', response.statusText);

        if (!response.ok) {
          console.error('HTTP Error:', response.status, response.statusText);
          throw new Error(`HTTP error! status: ${response.status} - ${response.statusText}`);
        }

        const data = await response.json();
        
        // Log the full response for debugging
        console.log('Full API Response:', JSON.stringify(data, null, 2));
        
        // Extract response text using the same logic as the original function
        let responseText = null;
        
        if (data.success && data.data && data.data.formattedResponse) {
          responseText = data.data.formattedResponse;
        } else if (data.formattedResponse) {
          responseText = data.formattedResponse;
        } else if (data.data && data.data.response) {
          responseText = data.data.response;
        } else if (data.response) {
          responseText = data.response;
        } else if (data.message) {
          responseText = data.message;
        } else if (data.text) {
          responseText = data.text;
        } else if (data.content) {
          responseText = data.content;
        } else if (data.answer) {
          responseText = data.answer;
        } else if (data.reply) {
          responseText = data.reply;
        } else if (data.error) {
          responseText = data.error;
        } else if (typeof data === 'string') {
          responseText = data;
        }
        
        if (responseText) {
          console.log('Final response text:', responseText);
          console.log('=== END API DEBUG ===');
          return responseText;
        } else {
          console.error('No response text found in data:', data);
          console.log('=== END API DEBUG ===');
          throw new Error('No response text found in API response');
        }
              } catch (error) {
        console.error('=== API ERROR DEBUG ===');
        console.error('Error sending message to API:', error);
        console.log('=== END API ERROR DEBUG ===');
        
        return `<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
          <p style="margin: 0 0 16px 0; padding: 0; color: #dc2626;">
            <strong>API Error:</strong> ${error.message}
          </p>
          <p style="margin: 0 0 16px 0; padding: 0; font-size: 0.875rem; color: #6b7280;">
            Please check the console for more details.
          </p>
        </div>`;
      }
    }






    function removeLogo() {
      const logoPreview = document.getElementById('logo-preview');
      const previewContainer = document.getElementById('logo-preview-container');
      const dropzone = document.querySelector('.file-upload-dropzone');
      const uploadInput = document.getElementById('logo-upload-input');
      
      if (logoPreview) logoPreview.src = '';
      if (previewContainer) previewContainer.style.display = 'none';
      if (dropzone) dropzone.style.display = 'block';
      if (uploadInput) uploadInput.value = '';
      
      // Reset logo upload state to allow uploading again
      window.logoUploaded = false;
      localStorage.removeItem('logoUploaded');
      localStorage.removeItem('uploadedLogoUrl');
      
    }



    // Drag and drop functionality
    function setupDragAndDrop() {
      document.addEventListener('dragover', function(e) {
        e.preventDefault();
        const dropzone = document.querySelector('.file-upload-dropzone');
        if (dropzone && e.target.closest('.file-upload-dropzone')) {
          dropzone.classList.add('dragover');
        }
      });

      document.addEventListener('dragleave', function(e) {
        const dropzone = document.querySelector('.file-upload-dropzone');
        if (dropzone && !e.target.closest('.file-upload-dropzone')) {
          dropzone.classList.remove('dragover');
        }
      });

      document.addEventListener('drop', function(e) {
        e.preventDefault();
        const dropzone = document.querySelector('.file-upload-dropzone');
        if (dropzone) {
          dropzone.classList.remove('dragover');
        }

        const files = e.dataTransfer.files;
        if (files.length > 0) {
          const file = files[0];
          const event = { target: { files: [file] } };
          handleLogoUpload(event);
        }
      });
    }

    // Initialize drag and drop when page loads
    document.addEventListener('DOMContentLoaded', function() {
      setupDragAndDrop();
      
      
      // Add function to reset logo upload state
      window.resetLogoUpload = function() {
        window.logoUploaded = false;
        localStorage.removeItem('logoUploaded');
        localStorage.removeItem('uploadedLogoUrl');
        console.log('Logo upload state reset. Dropzone will show again on next branding question.');
      };
    });

  </script>

  <!-- Newsletter Subscription Check Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Check if user is logged in
      const isLoggedIn = {{ session('auth_user_tokin') ? 'true' : 'false' }};
      const userEmail = '{{ session("auth_user_email") }}';
      
      if (isLoggedIn && userEmail) {
        checkNewsletterSubscription(userEmail);
      }
      
      // Handle newsletter form submission
      const newsletterForm = document.getElementById('newsletter-form');
      if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
          e.preventDefault();
          handleNewsletterSubmission(this);
        });
      }
    });
    
    async function checkNewsletterSubscription(email) {
      try {
        const response = await fetch(`/api/check-subscription?email=${encodeURIComponent(email)}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
          }
        });
        
        const data = await response.json();
        
        if (data.success && data.subscribed) {
          // User is already subscribed, hide the newsletter section
          hideNewsletterSection();
        }
      } catch (error) {
        console.error('Error checking newsletter subscription:', error);
        // If there's an error, show the newsletter section anyway
      }
    }
    
    function hideNewsletterSection() {
      const newsletterSection = document.getElementById('newsletter-subscription');
      if (newsletterSection) {
        newsletterSection.style.display = 'none';
      }
    }
    
    async function handleNewsletterSubmission(form) {
      const formData = new FormData(form);
      const messageDiv = document.getElementById('newsletter-message');
      
      try {
        const response = await fetch(form.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
          }
        });
        
        if (response.ok) {
          // Success - hide the form and show success message
          form.style.display = 'none';
          showNewsletterMessage('Thank you for subscribing! You will receive our latest updates.', 'success');
        } else {
          // Error - show error message
          showNewsletterMessage('There was an error subscribing. Please try again.', 'error');
        }
      } catch (error) {
        console.error('Newsletter subscription error:', error);
        showNewsletterMessage('There was an error subscribing. Please try again.', 'error');
      }
    }
    
    function showNewsletterMessage(message, type) {
      const messageDiv = document.getElementById('newsletter-message');
      if (messageDiv) {
        messageDiv.textContent = message;
        messageDiv.className = `newsletter-message ${type}`;
        messageDiv.style.display = 'block';
      }
    }
  </script>

</body>
</html> 