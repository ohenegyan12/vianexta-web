@extends('layouts.new_home_layout')
@section('title', 'Payment Successful - CoPlug')

@push('css')
<style>
    .payment-success-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem 0;
    }
    
    .success-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(7, 56, 47, 0.1);
        padding: 3rem;
        text-align: center;
        max-width: 600px;
        width: 100%;
        margin: 0 1rem;
        border: 1px solid rgba(7, 56, 47, 0.1);
    }
    
    .success-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        animation: pulse 2s infinite;
    }
    
    .success-icon i {
        font-size: 3rem;
        color: white;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .success-title {
        color: #07382F;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        font-family: 'Inter', sans-serif;
    }
    
    .success-subtitle {
        color: #6c757d;
        font-size: 1.2rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .success-details {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1.5rem;
        margin: 2rem 0;
        border-left: 4px solid #28a745;
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
    
    .celebration-animation {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        overflow: hidden;
    }
    
    .confetti {
        position: absolute;
        width: 10px;
        height: 10px;
        background: #28a745;
        animation: confetti-fall 3s linear infinite;
    }
    
    .confetti:nth-child(2n) {
        background: #07382F;
        animation-delay: 0.5s;
    }
    
    .confetti:nth-child(3n) {
        background: #ffc107;
        animation-delay: 1s;
    }
    
    @keyframes confetti-fall {
        0% {
            transform: translateY(-100vh) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(100vh) rotate(720deg);
            opacity: 0;
        }
    }
    
    .paypal-logo {
        width: 120px;
        height: auto;
        margin: 1rem 0;
        opacity: 0.8;
    }
    
    @media (max-width: 768px) {
        .success-card {
            padding: 2rem 1.5rem;
            margin: 0 0.5rem;
        }
        
        .success-title {
            font-size: 2rem;
        }
        
        .success-icon {
            width: 100px;
            height: 100px;
        }
        
        .success-icon i {
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="payment-success-container">
    <div class="celebration-animation">
        <div class="confetti" style="left: 10%; animation-delay: 0s;"></div>
        <div class="confetti" style="left: 20%; animation-delay: 0.5s;"></div>
        <div class="confetti" style="left: 30%; animation-delay: 1s;"></div>
        <div class="confetti" style="left: 40%; animation-delay: 1.5s;"></div>
        <div class="confetti" style="left: 50%; animation-delay: 2s;"></div>
        <div class="confetti" style="left: 60%; animation-delay: 0.3s;"></div>
        <div class="confetti" style="left: 70%; animation-delay: 0.8s;"></div>
        <div class="confetti" style="left: 80%; animation-delay: 1.3s;"></div>
        <div class="confetti" style="left: 90%; animation-delay: 1.8s;"></div>
    </div>
    
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1 class="success-title">Payment Successful!</h1>
        <p class="success-subtitle">
            Your order has been processed successfully. Thank you for your purchase!
        </p>
        
        <div class="success-details">
            <div class="detail-item">
                <span class="detail-label">Payment Method:</span>
                <span class="detail-value">
                    <i class="fab fa-paypal" style="color: #0070ba; margin-right: 0.5rem;"></i>
                    PayPal
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Status:</span>
                <span class="detail-value" style="color: #28a745;">
                    <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>
                    Completed
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Transaction ID:</span>
                <span class="detail-value">{{ $transactionId ?? 'N/A' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Date:</span>
                <span class="detail-value">{{ date('M d, Y \a\t g:i A') }}</span>
            </div>
        </div>
        
        <div class="mt-4">
            <p class="text-muted mb-4">
                <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                You will receive a confirmation email shortly with your order details.
            </p>
            
            <a href="{{ route('buyerDashboard') }}" class="btn-dashboard">
                <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>
                Return to Dashboard
            </a>
        </div>
        
        <div class="mt-4">
            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" 
                 alt="PayPal" class="paypal-logo">
        </div>
    </div>
</div>

<script>
// Add some interactive effects
document.addEventListener('DOMContentLoaded', function() {
    // Add success sound effect (optional)
    // const audio = new Audio('{{ asset("sounds/success.mp3") }}');
    // audio.play().catch(e => console.log('Audio play failed:', e));
    
    // Add more confetti on click
    const successCard = document.querySelector('.success-card');
    successCard.addEventListener('click', function() {
        createConfetti();
    });
    
    function createConfetti() {
        for (let i = 0; i < 10; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.animationDelay = Math.random() * 2 + 's';
            document.querySelector('.celebration-animation').appendChild(confetti);
            
            // Remove confetti after animation
            setTimeout(() => {
                confetti.remove();
            }, 3000);
        }
    }
});
</script>
@endsection
