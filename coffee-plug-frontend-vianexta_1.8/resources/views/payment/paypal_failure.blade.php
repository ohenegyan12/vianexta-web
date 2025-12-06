@extends('layouts.new_home_layout')
@section('title', 'Payment Failed - CoPlug')

@push('css')
<style>
    .payment-failure-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem 0;
    }
    
    .failure-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(220, 53, 69, 0.1);
        padding: 3rem;
        text-align: center;
        max-width: 600px;
        width: 100%;
        margin: 0 1rem;
        border: 1px solid rgba(220, 53, 69, 0.1);
    }
    
    .failure-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #dc3545, #fd7e14);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        animation: shake 0.5s ease-in-out;
    }
    
    .failure-icon i {
        font-size: 3rem;
        color: white;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .failure-title {
        color: #07382F;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        font-family: 'Inter', sans-serif;
    }
    
    .failure-subtitle {
        color: #6c757d;
        font-size: 1.2rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .failure-details {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1.5rem;
        margin: 2rem 0;
        border-left: 4px solid #dc3545;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #495057;
    }
    
    .detail-value {
        color: #07382F;
        font-weight: 500;
    }
    
    .error-message {
        background: #f8d7da;
        color: #721c24;
        padding: 1rem;
        border-radius: 10px;
        margin: 1rem 0;
        border: 1px solid #f5c6cb;
    }
    
    .btn-dashboard {
        background: linear-gradient(135deg, #07382F, #0d4d3a);
        border: none;
        color: white;
        padding: 1rem 2.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(7, 56, 47, 0.3);
        margin: 0.5rem;
    }
    
    .btn-dashboard:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(7, 56, 47, 0.4);
        color: white;
        text-decoration: none;
    }
    
    .btn-dashboard:active {
        transform: translateY(0);
    }
    
    .btn-retry {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        color: white;
        padding: 1rem 2.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        margin: 0.5rem;
    }
    
    .btn-retry:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
        color: white;
        text-decoration: none;
    }
    
    .btn-retry:active {
        transform: translateY(0);
    }
    
    .help-section {
        background: #e7f3ff;
        border-radius: 15px;
        padding: 1.5rem;
        margin: 2rem 0;
        border-left: 4px solid #007bff;
    }
    
    .help-title {
        color: #07382F;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .help-list {
        text-align: left;
        margin: 0;
        padding-left: 1.5rem;
    }
    
    .help-list li {
        margin-bottom: 0.5rem;
        color: #495057;
    }
    
    .paypal-logo {
        width: 120px;
        height: auto;
        margin: 1rem 0;
        opacity: 0.8;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .status-failed {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .status-cancelled {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    
    @media (max-width: 768px) {
        .failure-card {
            padding: 2rem 1.5rem;
            margin: 0 0.5rem;
        }
        
        .failure-title {
            font-size: 2rem;
        }
        
        .failure-icon {
            width: 100px;
            height: 100px;
        }
        
        .failure-icon i {
            font-size: 2.5rem;
        }
        
        .btn-dashboard, .btn-retry {
            display: block;
            width: 100%;
            margin: 0.5rem 0;
        }
    }
</style>
@endpush

@section('content')
<div class="payment-failure-container">
    <div class="failure-card">
        <div class="failure-icon">
            <i class="fas fa-times"></i>
        </div>
        
        <h1 class="failure-title">Payment Failed</h1>
        <p class="failure-subtitle">
            We're sorry, but your payment could not be processed at this time.
        </p>
        
        <div class="failure-details">
            <div class="detail-item">
                <span class="detail-label">Payment Method:</span>
                <span class="detail-value">
                    <i class="fab fa-paypal" style="color: #0070ba; margin-right: 0.5rem;"></i>
                    PayPal
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    @if($errorType === 'cancelled')
                        <span class="status-badge status-cancelled">
                            <i class="fas fa-times-circle" style="margin-right: 0.5rem;"></i>
                            Cancelled
                        </span>
                    @else
                        <span class="status-badge status-failed">
                            <i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>
                            Failed
                        </span>
                    @endif
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Date:</span>
                <span class="detail-value">{{ date('M d, Y \a\t g:i A') }}</span>
            </div>
        </div>
        
        @if($errorMessage)
        <div class="error-message">
            <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i>
            <strong>Error Details:</strong> {{ $errorMessage }}
        </div>
        @endif
        
        <div class="help-section">
            <h5 class="help-title">
                <i class="fas fa-question-circle" style="margin-right: 0.5rem;"></i>
                What can you do?
            </h5>
            <ul class="help-list">
                <li>Check your PayPal account balance and payment methods</li>
                <li>Ensure your billing information is correct</li>
                <li>Try using a different payment method</li>
                <li>Contact PayPal support if the issue persists</li>
                <li>Your order has been saved and you can retry payment</li>
            </ul>
        </div>
        
        <div class="mt-4">
            <p class="text-muted mb-4">
                <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                Don't worry, your order has been saved and you can complete payment later.
            </p>
            
            <div class="d-flex flex-wrap justify-content-center">
                <a href="{{ route('buyerDashboard') }}" class="btn-dashboard">
                    <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>
                    Return to Dashboard
                </a>
                
                <a href="{{ route('cartCheckout.show') }}" class="btn-retry">
                    <i class="fas fa-redo" style="margin-right: 0.5rem;"></i>
                    Try Again
                </a>
            </div>
        </div>
        
        <div class="mt-4">
            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" 
                 alt="PayPal" class="paypal-logo">
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add subtle animation to the failure icon
    const failureIcon = document.querySelector('.failure-icon');
    
    // Add click effect to retry button
    const retryButton = document.querySelector('.btn-retry');
    if (retryButton) {
        retryButton.addEventListener('click', function(e) {
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 0.5rem;"></i>Redirecting...';
            this.style.pointerEvents = 'none';
            
            // Reset after a short delay
            setTimeout(() => {
                this.innerHTML = originalText;
                this.style.pointerEvents = 'auto';
            }, 2000);
        });
    }
});
</script>
@endsection
