<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Payment Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .test-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .test-section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .btn-test {
            margin: 10px 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="test-container">
            <h1 class="text-center mb-4">PayPal Payment Testing</h1>

            <div class="test-section">
                <h3>🔍 Test PayPal Success Flow</h3>
                <p>Use these buttons to test different aspects of the PayPal payment flow:</p>

                <div class="d-grid gap-2">
                    <a href="{{ route('paypal.test.success') }}" class="btn btn-success btn-test">
                        🧪 Test PayPal Success (Simulated)
                    </a>

                    <a href="{{ route('paypal.test.success.page') }}" class="btn btn-success btn-test">
                        ✨ Test New Success Page
                    </a>

                    <a href="{{ route('paypal.payment.success') }}?token=TEST_TOKEN_123&PayerID=TEST_PAYER_456" class="btn btn-info btn-test">
                        🔗 Test PayPal Success with Mock Parameters
                    </a>

                    <a href="{{ route('paypal.payment.success') }}" class="btn btn-warning btn-test">
                        ⚠️ Test PayPal Success (No Parameters)
                    </a>
                </div>
            </div>

            <div class="test-section">
                <h3>❌ Test PayPal Failure Flow</h3>
                <p>Test the failure and cancellation scenarios:</p>

                <div class="d-grid gap-2">
                    <a href="{{ route('paypal.test.failure.page') }}" class="btn btn-danger btn-test">
                        ✨ Test New Failure Page
                    </a>

                    <a href="{{ route('paypal.test.failed.page') }}" class="btn btn-danger btn-test">
                        🔴 Test New Failed Page
                    </a>

                    <a href="{{ route('paypal.test.error.page') }}" class="btn btn-warning btn-test">
                        ⚠️ Test New Error Page
                    </a>

                    <a href="{{ route('paypal.payment.cancel') }}" class="btn btn-warning btn-test">
                        🚫 Test PayPal Cancel
                    </a>

                    <a href="{{ route('paypal.payment.failed') }}" class="btn btn-outline-danger btn-test">
                        🔗 Test Failed Route
                    </a>

                    <a href="{{ route('paypal.payment.error') }}" class="btn btn-outline-warning btn-test">
                        🔗 Test Error Route
                    </a>
                </div>
            </div>

            <div class="test-section">
                <h3>🔧 Debug & Configuration</h3>
                <p>Check PayPal configuration and connection status:</p>

                <div class="d-grid gap-2">
                    <button onclick="checkPayPalConfig()" class="btn btn-outline-info btn-test">
                        🔍 Check PayPal Configuration
                    </button>

                    <div id="debug-result" class="mt-3" style="display: none;">
                        <div class="alert alert-info">
                            <strong>Debug Result:</strong>
                            <pre id="debug-content" class="mt-2"></pre>
                        </div>
                    </div>
                </div>
            </div>

            <div class="test-section">
                <h3>📋 Current Session Status</h3>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Authentication:</strong><br>
                        @if(session('auth_user_tokin'))
                        <span class="badge bg-success">✅ Logged In</span>
                        @else
                        <span class="badge bg-danger">❌ Not Logged In</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <strong>Success Message:</strong><br>
                        @if(session('success'))
                        <span class="badge bg-success">{{ session('success') }}</span>
                        @else
                        <span class="badge bg-secondary">None</span>
                        @endif
                    </div>
                </div>

                @if(session('test_payment'))
                <div class="mt-2">
                    <span class="badge bg-info">🧪 Test Payment Flag Set</span>
                </div>
                @endif
            </div>

            <div class="test-section">
                <h3>🚀 Quick Actions</h3>
                <div class="d-grid gap-2">
                    <a href="{{ route('cartCheckout.show') }}" class="btn btn-primary btn-test">
                        📋 Go to Cart Checkout
                    </a>

                    <a href="{{ route('buyer_cart') }}" class="btn btn-secondary btn-test">
                        🛒 Go to Shopping Cart
                    </a>

                    <a href="{{ route('home_page') }}" class="btn btn-outline-secondary btn-test">
                        🏠 Go to Home
                    </a>
                </div>
            </div>

            <div class="test-section">
                <h3>📝 Instructions</h3>
                <ol>
                    <li><strong>Test PayPal Success:</strong> Simulates a successful payment without going through PayPal</li>
                    <li><strong>Test with Mock Parameters:</strong> Tests the success route with fake token/PayerID</li>
                    <li><strong>Test No Parameters:</strong> Tests error handling when no payment data is provided</li>
                    <li>Check the logs in <code>storage/logs/laravel.log</code> for detailed debugging information</li>
                </ol>
            </div>

            @if(session('error'))
            <div class="alert alert-danger">
                <strong>Error:</strong> {{ session('error') }}
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">
                <strong>Success:</strong> {{ session('success') }}
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function checkPayPalConfig() {
            const debugResult = document.getElementById('debug-result');
            const debugContent = document.getElementById('debug-content');

            // Show loading state
            debugResult.style.display = 'block';
            debugContent.textContent = 'Checking PayPal configuration...';

            // Make AJAX request to debug endpoint
            fetch('{{ route("paypal.debug") }}')
                .then(response => response.json())
                .then(data => {
                    debugContent.textContent = JSON.stringify(data, null, 2);
                })
                .catch(error => {
                    debugContent.textContent = 'Error: ' + error.message;
                });
        }

        // Auto-refresh session status every 5 seconds
        setInterval(function() {
            // You can add auto-refresh logic here if needed
        }, 5000);
    </script>
</body>

</html>