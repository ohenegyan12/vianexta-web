@extends('layouts.new_home_layout')
@section('title', 'Delivery Quotes')
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
    }
    .delivery-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
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
    .carrier-ups {
        background: linear-gradient(135deg, #7B0000, #FF0000);
        color: white;
        border-radius: 8px;
        padding: 8px 12px;
        font-weight: bold;
        font-size: 12px;
    }
    .carrier-fedex {
        background: linear-gradient(135deg, #4B0082, #8A2BE2);
        color: white;
        border-radius: 8px;
        padding: 8px 12px;
        font-weight: bold;
        font-size: 12px;
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
    .select-service-btn {
        background: #28a745;
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 6px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    .select-service-btn:hover {
        background: #218838;
        transform: translateY(-1px);
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
</style>
@endpush

@section('content')
<div class="wrapper">
    @include('includes.new_home.new_sidebar')
    <!-- Page Content  -->
    <div id="content">
        @include('includes.new_home.seller_nav')

        <div class="container-fluid">
            <a href="{{ route('roasterOrdersListPage') }}" class="back-btn">
                <i class="fa fa-arrow-left"></i> Back to Orders
            </a>

            <div class="quote-header">
                <h2><i class="fa fa-truck"></i> Delivery Quotes</h2>
                @if($orderId && $weight)
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
                        <strong>{{ $totalQuotes }} delivery options</strong> found, sorted by <strong>best value first</strong>! 
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
                    <div class="delivery-card {{ $index == 1 ? 'featured' : '' }}">
                        <div class="d-flex align-items-center mb-3">
                            @if($quote->carrierCode == 'ups')
                            <img src="{{ asset('images/seller/ups.png') }}" alt="UPS" class="delivery-logo me-3">
                            @elseif($quote->carrierCode == 'fedex')
                            <img src="{{ asset('images/seller/fedex.png') }}" alt="FedEx" class="delivery-logo me-3">
                            @elseif($quote->carrierCode == 'dhl')
                            <img src="{{ asset('images/seller/dhl.png') }}" alt="DHL" class="delivery-logo me-3">
                            @else
                            <div class="carrier-generic me-3">{{ strtoupper($quote->carrierCode) }}</div>
                            @endif
                            <div>
                                <h5 class="mb-1">{{ $quote->serviceDescription }}</h5>
                                <small class="text-muted">{{ $quote->carrierCode }} • Zone {{ $quote->zone }}</small>
                            </div>
                        </div>

                        <div class="service-description">
                            {{ $quote->serviceDescription }}
                            @if($quote->serviceCode == 'ups_ground')
                                <br><small class="text-muted"><i class="fa fa-clock-o"></i> 1-5 business days</small>
                            @elseif($quote->serviceCode == 'ups_second_day_air')
                                <br><small class="text-muted"><i class="fa fa-clock-o"></i> 2 business days</small>
                            @elseif($quote->serviceCode == 'ups_next_day_air')
                                <br><small class="text-muted"><i class="fa fa-clock-o"></i> Next business day</small>
                            @elseif($quote->serviceCode == 'ups_next_day_air_saver')
                                <br><small class="text-muted"><i class="fa fa-clock-o"></i> Next business day (end of day)</small>
                            @elseif($quote->serviceCode == 'ups_three_day_select')
                                <br><small class="text-muted"><i class="fa fa-clock-o"></i> 3 business days</small>
                            @elseif($quote->serviceCode == 'fedex_ground')
                                <br><small class="text-muted"><i class="fa fa-clock-o"></i> 1-5 business days</small>
                            @elseif($quote->serviceCode == 'fedex_2_day')
                                <br><small class="text-muted"><i class="fa fa-clock-o"></i> 2 business days</small>
                            @elseif($quote->serviceCode == 'dhl_express')
                                <br><small class="text-muted"><i class="fa fa-clock-o"></i> 1-3 business days</small>
                            @elseif($quote->serviceCode == 'usps_priority')
                                <br><small class="text-muted"><i class="fa fa-clock-o"></i> 1-3 business days</small>
                            @endif
                        </div>

                        <div class="text-center mb-3">
                            <div class="price-highlight" style="font-size: 32px; font-weight: bold; color: #2c5530; margin-bottom: 5px;">
                                ${{ number_format($quote->totalAmount, 2) }}
                            </div>
                            <div class="badge bg-success" style="font-size: 12px;">TOTAL COST</div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3" style="background: #f8f9fa; padding: 10px; border-radius: 6px;">
                            <div>
                                <div class="fw-bold text-primary">${{ number_format($quote->baseAmount, 2) }}</div>
                                <small class="text-muted">Base Rate</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-warning">${{ number_format($quote->totalAmount - $quote->baseAmount, 2) }}</div>
                                <small class="text-muted">Surcharges</small>
                            </div>
                        </div>

                        @if(!empty($quote->surcharges))
                        <div class="surcharges mb-3">
                            <strong>Surcharges:</strong><br>
                            @foreach($quote->surcharges as $surcharge)
                            <small>{{ $surcharge->description }}: ${{ number_format($surcharge->amount, 2) }}</small><br>
                            @endforeach
                        </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Weight: {{ $quote->quotedWeight }} {{ $quote->quotedWeightType }}
                            </small>
                            <button class="btn select-service-btn" onclick="selectService({{ $quote->carrierCode }}, '{{ $quote->serviceCode }}', {{ $quote->totalAmount }})">
                                Select Service
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Service Selection Modal -->
<div class="modal fade" id="serviceSelectionModal" tabindex="-1" aria-labelledby="serviceSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceSelectionModalLabel">Confirm Delivery Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="selectedServiceDetails"></div>
                <p class="mt-3">Are you sure you want to proceed with this delivery service?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmServiceBtn">Confirm & Request Shipment</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });

    function selectService(carrierCode, serviceCode, totalAmount) {
        // Find the selected quote details
        const quotes = @json($quotes);
        const selectedQuote = quotes.find(q => q.carrierCode === carrierCode && q.serviceCode === serviceCode);
        
        if (selectedQuote) {
            let details = `
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">${selectedQuote.serviceDescription}</h6>
                        <p class="card-text">
                            <strong>Carrier:</strong> ${selectedQuote.carrierCode.toUpperCase()}<br>
                            <strong>Service:</strong> ${selectedQuote.serviceCode}<br>
                            <strong>Total Cost:</strong> $${parseFloat(selectedQuote.totalAmount).toFixed(2)}<br>
                            <strong>Base Rate:</strong> $${parseFloat(selectedQuote.baseAmount).toFixed(2)}<br>
                            <strong>Weight:</strong> ${selectedQuote.quotedWeight} ${selectedQuote.quotedWeightType}
                        </p>
                    </div>
                </div>
            `;
            
            $('#selectedServiceDetails').html(details);
            $('#serviceSelectionModal').modal('show');
            
            // Store selected service data
            $('#confirmServiceBtn').data('carrier', carrierCode);
            $('#confirmServiceBtn').data('service', serviceCode);
            $('#confirmServiceBtn').data('amount', totalAmount);
        }
    }

    $('#confirmServiceBtn').on('click', function() {
        const carrier = $(this).data('carrier');
        const service = $(this).data('service');
        const amount = $(this).data('amount');
        
        // Here you would typically make an API call to request the shipment
        // For now, we'll show a success message
        alert(`Service selected: ${carrier} - ${service}\nTotal Cost: $${amount}\n\nShipment request will be processed.`);
        
        $('#serviceSelectionModal').modal('hide');
        
        // You could redirect back to orders or show a success page
        // window.location.href = "{{ route('roasterOrdersListPage') }}";
    });
</script>
@endsection
