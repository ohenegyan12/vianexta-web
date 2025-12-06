@extends('layouts.new_home_layout')
@section('title', 'Delivery Quotes - CoPlug')
@push('css')
<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">
<style>
    .delivery-card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        position: relative;
        cursor: pointer;
    }
    .delivery-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    .delivery-card.selected {
        border: 2px solid #1A4D3A;
        background: linear-gradient(135deg, #f8fff9, #ffffff);
    }
    .delivery-card.featured {
        border: 2px solid #28a745;
        background: linear-gradient(135deg, #f8fff9, #ffffff);
    }
    .delivery-card.featured::before {
        content: "BEST VALUE";
        position: absolute;
        top: -1px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 4px 12px;
        border-radius: 0 0 6px 6px;
        font-size: 10px;
        font-weight: bold;
    }
    .delivery-logo {
        width: 60px;
        height: 60px;
        object-fit: contain;
        margin-bottom: 15px;
        background: white;
        border-radius: 8px;
        padding: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: 1px solid #e0e0e0;
    }
    .carrier-generic {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
        border-radius: 8px;
        padding: 8px 12px;
        font-weight: bold;
        font-size: 12px;
        min-width: 60px;
        text-align: center;
    }
    .price-highlight {
        font-size: 24px;
        font-weight: bold;
        color: #2c5530;
    }
    .service-description {
        color: #666;
        font-size: 14px;
        margin-bottom: 10px;
    }
    .surcharges {
        font-size: 12px;
        color: #888;
    }
    .quote-header {
        background: linear-gradient(135deg, #07382F, #2c5530);
        color: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
    }
    .back-btn {
        background: #6c757d;
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
    }
    .back-btn:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
    }
    .select-quote-btn {
        background: #1A4D3A;
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 6px;
        font-weight: bold;
        transition: all 0.3s ease;
        width: 100%;
    }
    .select-quote-btn:hover {
        background: #0f3d2a;
        transform: translateY(-1px);
    }
    .select-quote-btn:disabled {
        background: #6c757d;
        cursor: not-allowed;
    }
    .no-quotes {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }
    .error-message {
        background: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        border: 1px solid #f5c6cb;
    }
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .loading-spinner {
        background: white;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="wrapper">
    @include('includes.new_home.buyer_sidebar')
    <!-- Page Content  -->
    <div id="content">
        @include('includes.new_home.buyer_nav')

        <div class="container-fluid">
            <a href="{{ route('buyerOrderHistory') }}" class="back-btn">
                <i class="fa fa-arrow-left"></i> Back to Orders
            </a>

            <div class="quote-header">
                <h2><i class="fa fa-truck"></i> Delivery Quotes</h2>
                @if($orderId && isset($weight))
                <p class="mb-0">Order #{{ $orderId }} • Weight: {{ $weight }} lbs • Dimensions: {{ $length }}" × {{ $height }}" • Insurance: ${{ number_format($insuranceAmount, 2) }}</p>
                @endif
            </div>

            @if($sender && $receiver)
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fa fa-map-marker text-danger"></i> Sender Address</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>{{ $sender->city ?? 'N/A' }}</strong></p>
                            <p class="mb-1">{{ $sender->zip ?? 'N/A' }}, {{ $sender->country ?? 'N/A' }}</p>
                            <p class="mb-0 text-muted">{{ $sender->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fa fa-map-marker text-success"></i> Receiver Address</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>{{ $receiver->city ?? 'N/A' }}</strong></p>
                            <p class="mb-1">{{ $receiver->zip ?? 'N/A' }}, {{ $receiver->country ?? 'N/A' }}</p>
                            <p class="mb-0 text-muted">{{ $receiver->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($error)
            <div class="error-message">
                <i class="fa fa-exclamation-triangle"></i> {{ $error }}
            </div>
            @endif

            @if(empty($quotes) && !$error)
            <div class="no-quotes">
                <i class="fa fa-truck" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                <h4>No Quotes Available</h4>
                <p>Please check your order details and try again.</p>
            </div>
            @elseif(!empty($quotes))
            @php
                $cheapestPrice = min(array_column($quotes, 'totalAmount'));
                $totalQuotes = count($quotes);
            @endphp
            
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-success" style="background: linear-gradient(135deg, #d4edda, #c3e6cb); border: 1px solid #c3e6cb;">
                        <i class="fa fa-info-circle"></i> 
                        <strong>Top 3 delivery options</strong> shown, sorted by <strong>best value first</strong>! 
                        Prices range from <strong class="text-success">${{ number_format($cheapestPrice, 2) }}</strong> to 
                        <strong>${{ number_format(max(array_column($quotes, 'totalAmount')), 2) }}</strong>.
                    </div>
                </div>
            </div>
            
            <div class="row">
                @php $index = 0; @endphp
                @foreach($quotes as $quote)
                @php $index++; @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="delivery-card {{ $index == 1 ? 'featured' : '' }}" data-quote-index="{{ $index - 1 }}" data-service-code="{{ $quote->serviceCode ?? '' }}" data-total-amount="{{ $quote->totalAmount }}">
                        <div class="d-flex align-items-center mb-3">
                            @if(isset($quote->carrierCode) && $quote->carrierCode == 'ups')
                            <img src="{{ asset('images/seller/ups.png') }}" alt="UPS" class="delivery-logo me-3">
                            @elseif(isset($quote->carrierCode) && $quote->carrierCode == 'fedex')
                            <img src="{{ asset('images/seller/fedex.png') }}" alt="FedEx" class="delivery-logo me-3">
                            @elseif(isset($quote->carrierCode) && $quote->carrierCode == 'dhl')
                            <img src="{{ asset('images/seller/dhl.png') }}" alt="DHL" class="delivery-logo me-3">
                            @else
                            <div class="carrier-generic me-3">{{ isset($quote->carrierCode) ? strtoupper($quote->carrierCode) : 'CARRIER' }}</div>
                            @endif
                            <div>
                                <h5 class="mb-1">{{ $quote->serviceDescription ?? 'Standard Delivery' }}</h5>
                                <small class="text-muted">{{ isset($quote->carrierCode) ? $quote->carrierCode : 'N/A' }} • Zone {{ $quote->zone ?? 'N/A' }}</small>
                            </div>
                        </div>

                        <div class="service-description">
                            {{ $quote->serviceDescription ?? 'Standard delivery service' }}
                        </div>

                        <div class="text-center mb-3">
                            <div class="price-highlight" style="font-size: 32px; font-weight: bold; color: #2c5530; margin-bottom: 5px;">
                                ${{ number_format($quote->totalAmount, 2) }}
                            </div>
                            <div class="badge bg-success" style="font-size: 12px;">TOTAL COST</div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3" style="background: #f8f9fa; padding: 10px; border-radius: 6px;">
                            <div>
                                <div class="fw-bold text-primary">${{ number_format($quote->baseAmount ?? $quote->totalAmount, 2) }}</div>
                                <small class="text-muted">Base Rate</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-warning">${{ number_format(($quote->totalAmount ?? 0) - ($quote->baseAmount ?? $quote->totalAmount ?? 0), 2) }}</div>
                                <small class="text-muted">Surcharges</small>
                            </div>
                        </div>

                        @if(!empty($quote->surcharges))
                        <div class="surcharges mb-3">
                            <strong>Surcharges:</strong><br>
                            @foreach($quote->surcharges as $surcharge)
                            <small>{{ $surcharge->description ?? 'Surcharge' }}: ${{ number_format($surcharge->amount ?? 0, 2) }}</small><br>
                            @endforeach
                        </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">
                                Weight: {{ $quote->quotedWeight ?? $weight ?? 'N/A' }} {{ $quote->quotedWeightType ?? 'lbs' }}
                            </small>
                        </div>

                        <button class="btn select-quote-btn" onclick="selectQuote({{ $index - 1 }})">
                            Select This Quote
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-3">Processing your selection...</p>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const quotes = @json($quotes ?? []);
    let selectedQuoteId = null;
    let selectedTotalAmount = null;
    const orderId = {{ $orderId ?? 'null' }};
    const totalAmount = {{ $totalAmount ?? 0 }};

    function selectQuote(quoteIndex) {
        // Use the index to directly access the quote from the array
        if (quoteIndex < 0 || quoteIndex >= quotes.length) {
            console.error('Invalid quote index:', quoteIndex, 'Total quotes:', quotes.length);
            alert('Quote not found. Please try again.');
            return;
        }
        
        const quote = quotes[quoteIndex];
        
        if (!quote) {
            console.error('Quote not found at index:', quoteIndex);
            alert('Quote not found. Please try again.');
            return;
        }
        
        console.log('Selected quote:', quote);
        
        // Use the quote's serviceCode as quoteId (required by API)
        // serviceCode is the identifier for the delivery service
        selectedQuoteId = quote.serviceCode ?? quote.quoteId ?? quote.id ?? null;
        selectedTotalAmount = parseFloat(quote.totalAmount ?? 0);
        
        if (!selectedQuoteId) {
            console.error('Service code not found in quote:', quote);
            alert('Quote service code not found. Please try again.');
            return;
        }
        
        console.log('Selected quote ID (serviceCode):', selectedQuoteId);
        console.log('Selected total amount:', selectedTotalAmount);
        
        // Update UI to show selected quote
        $('.delivery-card').removeClass('selected');
        $('.delivery-card').eq(quoteIndex).addClass('selected');
        
        // Show confirmation and proceed
        if (confirm(`You have selected a delivery quote for $${selectedTotalAmount.toFixed(2)}. Continue to payment?`)) {
            proceedWithQuoteSelection();
        }
    }

    function proceedWithQuoteSelection() {
        if (!selectedQuoteId || !orderId || !selectedTotalAmount) {
            alert('Please select a delivery quote');
            return;
        }

        // Show loading overlay
        $('#loadingOverlay').css('display', 'flex');

        // Prepare payload according to API requirements:
        // totalOrderId: orderId from checkout response
        // quoteId: serviceCode from the selected quote
        // totalAmount: totalAmount from the selected quote
        const payload = {
            totalOrderId: parseInt(orderId),
            quoteId: selectedQuoteId.toString(),
            totalAmount: parseFloat(selectedTotalAmount) // Ensure it's a number, not a string
        };
        
        console.log('Sending payload:', payload);

        // Make API call to select delivery quote
        fetch('/api/select-delivery-quote', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            $('#loadingOverlay').css('display', 'none');
            
            if (data.statusCode === 200) {
                // Check if payment link is available
                if (data.data && data.data.paymentLink) {
                    // Redirect to PayPal payment link
                    window.location.href = data.data.paymentLink;
                } else {
                    alert('Quote selected successfully, but payment link is not available. Please contact support.');
                    console.error('Payment link error:', data.data?.paymentLinkError);
                }
            } else {
                alert('Error: ' + (data.message || 'Failed to select delivery quote'));
            }
        })
        .catch(error => {
            $('#loadingOverlay').css('display', 'none');
            console.error('Error:', error);
            alert('An error occurred while processing your request. Please try again.');
        });
    }
</script>
@endsection

