<?php

namespace App\Http\Controllers;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Constants\PaymentTypes;


class PayPalController extends Controller

{

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function index()

    {
        return redirect()->route('buyerCheckout');
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function payment(Request $request)

    {
        // First, save the order if billing and shipping data is provided
        if ($request->has('addressLine1') && $request->has('shippingAddressLine1')) {
            try {
                // Validate the required parameters for both billing and shipping
                $request->validate([
                    // Billing address fields
                    'addressLine1' => 'required|string|max:255',
                    'addressLine2' => 'nullable|string|max:255',
                    'city' => 'required|string|max:100',
                    'state' => 'required|string|max:100',
                    'country' => 'required|string|max:100',
                    'zipCode' => 'required|string|max:20',
                    // Shipping address fields
                    'shippingAddressLine1' => 'required|string|max:255',
                    'shippingAddressLine2' => 'nullable|string|max:255',
                    'shippingCity' => 'required|string|max:100',
                    'shippingState' => 'required|string|max:100',
                    'shippingCountry' => 'required|string|max:100',
                    'shippingZipCode' => 'required|string|max:20',
                    // Payment type validation
                    'paymentType' => 'nullable|string|in:' . implode(',', PaymentTypes::getAll()),
                ]);

                // Get payment type from request or use default
                $paymentType = $request->input('paymentType', PaymentTypes::getDefault());

                // Save the order using the new API endpoint
                $helper = new \App\Helpers\Helper();
                
                $payload = array(
                    'billingAddress' => array(
                        'addressLine1' => $request->addressLine1,
                        'addressLine2' => $request->addressLine2,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                        'zipCode' => $request->zipCode
                    ),
                    'shippingAddress' => array(
                        'addressLine1' => $request->shippingAddressLine1,
                        'addressLine2' => $request->shippingAddressLine2,
                        'city' => $request->shippingCity,
                        'state' => $request->shippingState,
                        'country' => $request->shippingCountry,
                        'zipCode' => $request->shippingZipCode
                    ),
                    'paymentType' => $paymentType
                );

                // Send POST request to save the order
                $orderSaveResult = $helper->hitCoffeePlugPOSTEndpoint($payload, 'checkout-cart', 'POST');

                if (!isset($orderSaveResult->statusCode) || $orderSaveResult->statusCode != 200) {
                    Log::error('Failed to save order before PayPal payment', [
                        'payload' => $payload,
                        'response' => $orderSaveResult
                    ]);
                    return redirect()
                        ->route('cartCheckout.show')
                        ->with('error', 'Failed to save order. Please try again.');
                }

                // Check if response contains approvalUrl for payment redirection
                if (isset($orderSaveResult->data->approvalUrl)) {
                    Log::info('Order saved successfully, redirecting to approval URL', [
                        'approvalUrl' => $orderSaveResult->data->approvalUrl,
                        'paymentType' => $paymentType
                    ]);
                    return redirect($orderSaveResult->data->approvalUrl);
                }

                Log::info('Order saved successfully before PayPal payment', [
                    'order_response' => $orderSaveResult,
                    'paymentType' => $paymentType
                ]);

            } catch (\Exception $e) {
                Log::error('Error saving order before PayPal payment: ' . $e->getMessage());
                return redirect()
                    ->route('cartCheckout.show')
                    ->with('error', 'Failed to save order. Please try again.');
            }
        }

        $provider = new PayPalClient;

        $provider->setApiCredentials(config('paypal'));

        $paypalToken = $provider->getAccessToken();

        $total_amount = $request->total_amount;

        // Debug: Log the URLs being generated
        $returnUrl = route('paypal.payment.success');
        $cancelUrl = route('paypal.payment.cancel');
        
        Log::info('PayPal URLs being generated', [
            'return_url' => $returnUrl,
            'cancel_url' => $cancelUrl,
            'app_url' => config('app.url'),
            'current_domain' => request()->getHost(),
            'current_port' => request()->getPort(),
            'route_name' => 'paypal.payment.success',
            'route_parameters' => [],
            'full_request_url' => request()->fullUrl(),
            'base_url' => url('/')
        ]);

        // Also log the raw PayPal order creation data
        $paypalOrderData = [
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => $returnUrl,
                "cancel_url" => $cancelUrl,
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $total_amount
                    ]
                ]
            ]
        ];
        
        Log::info('PayPal Order Creation Data', $paypalOrderData);

        $response = $provider->createOrder([

            "intent" => "CAPTURE",

            "application_context" => [

                "return_url" => $returnUrl,

                "cancel_url" => $cancelUrl,

            ],

            "purchase_units" => [

                0 => [

                    "amount" => [

                        "currency_code" => "USD",

                        "value" => $total_amount

                    ]

                ]

            ]

        ]);



        if (isset($response['id']) && $response['id'] != null) {



            foreach ($response['links'] as $links) {

                if ($links['rel'] == 'approve') {

                    return redirect()->away($links['href']);
                }
            }



            return redirect()

                ->route('cancel.payment')

                ->with('error', 'Something went wrong.');
        } else {

            return redirect()

                ->route('create.payment')

                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function paymentCancel()

    {
        // Log the cancellation
        Log::info('PayPal Payment Cancelled', [
            'user_id' => session('auth_user_id'),
            'timestamp' => now()
        ]);

        return view('payment.paypal_failure', [
            'errorType' => 'cancelled',
            'errorMessage' => 'Payment was cancelled by the user'
        ]);
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function paymentSuccess(Request $request)
    {
        // Log the incoming request for debugging
        Log::info('PayPal Success Callback', [
            'request_data' => $request->all(),
            'query_params' => $request->query(),
            'headers' => $request->headers->all()
        ]);

        // Check if token exists
        if (!$request->has('token') && !$request->has('PayerID')) {
            Log::error('PayPal Success: Missing token or PayerID', $request->all());
            return view('payment.paypal_failure', [
                'errorType' => 'failed',
                'errorMessage' => 'Payment verification failed: Missing payment token.'
            ]);
        }

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            // Use token from request or fallback to PayerID
            $token = $request->get('token') ?? $request->get('PayerID');

            $response = $provider->capturePaymentOrder($token);

            Log::info('PayPal Capture Response', $response);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                // Log successful payment
                Log::info('PayPal Payment Completed Successfully', [
                    'transaction_id' => $response['id'] ?? 'unknown',
                    'status' => $response['status'],
                    'amount' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? 'unknown'
                ]);

                // Reset cart since order is already saved
                $helper = new \App\Helpers\Helper();
                $helper->resetCart();

                return view('payment.paypal_success', [
                    'transactionId' => $response['id'] ?? 'N/A'
                ]);
            } else {
                Log::warning('PayPal Payment Not Completed', $response);
                return view('payment.paypal_failure', [
                    'errorType' => 'failed',
                    'errorMessage' => 'Payment verification failed. Please try again.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('PayPal Payment Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return view('payment.paypal_failure', [
                'errorType' => 'failed',
                'errorMessage' => 'An error occurred while processing your payment. Please try again.'
            ]);
        }
    }

    /**
     * Test method for simulating successful PayPal payment (development/testing only)
     *
     * @return response()
     */
    public function testPaymentSuccess()
    {
        // Log test payment attempt
        Log::info('PayPal Test Payment Success - Manual Test Route Accessed');

        // Check if user is authenticated
        if (session('auth_user_tokin') == null) {
            Log::warning('PayPal Test: User not authenticated');
            return redirect()
                ->route('login_page')
                ->with('error', 'Please login to test payment flow.');
        }

        // Simulate successful payment data
        $mockPaymentData = [
            'status' => 'COMPLETED',
            'id' => 'TEST_' . time(),
            'purchase_units' => [
                [
                    'payments' => [
                        'captures' => [
                            [
                                'amount' => [
                                    'value' => '99.99',
                                    'currency_code' => 'USD'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        Log::info('PayPal Test: Simulating successful payment', $mockPaymentData);

        // Redirect to success page with test data
        return redirect()
            ->route('cartCheckout.show')
            ->with('success', 'Test payment completed successfully! This was a simulation.')
            ->with('test_payment', true);
    }

    /**
     * Debug method to check PayPal configuration and connection (development/testing only)
     *
     * @return response()
     */
    public function debugPayPal()
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));

            // Test API connection
            $token = $provider->getAccessToken();

            $debugInfo = [
                'config' => config('paypal'),
                'mode' => config('paypal.mode'),
                'has_client_id' => !empty(config('paypal.' . config('paypal.mode') . '.client_id')),
                'has_client_secret' => !empty(config('paypal.' . config('paypal.mode') . '.client_secret')),
                'access_token_received' => !empty($token),
                'token_length' => strlen($token),
                'session_auth' => session('auth_user_tokin') ? 'Yes' : 'No',
                'routes_available' => [
                    'paypal.payment.success' => route('paypal.payment.success'),
                    'cartCheckout.show' => route('cartCheckout.show'),
                    'paypal' => route('paypal')
                ]
            ];

            Log::info('PayPal Debug Information', $debugInfo);

            return response()->json([
                'status' => 'success',
                'message' => 'PayPal configuration check completed',
                'debug_info' => $debugInfo
            ]);
        } catch (\Exception $e) {
            Log::error('PayPal Debug Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'PayPal configuration check failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle PayPal payment failed scenarios
     *
     * @return response()
     */
    public function paymentFailed(Request $request)
    {
        // Log the payment failure
        Log::info('PayPal Payment Failed', [
            'user_id' => session('auth_user_id'),
            'request_data' => $request->all(),
            'timestamp' => now()
        ]);

        return view('payment.paypal_failed', [
            'errorMessage' => $request->get('error_message', 'Payment could not be processed. Please try again.')
        ]);
    }

    /**
     * Handle PayPal payment error scenarios
     *
     * @return response()
     */
    public function paymentError(Request $request)
    {
        // Log the payment error
        Log::error('PayPal Payment Error', [
            'user_id' => session('auth_user_id'),
            'request_data' => $request->all(),
            'timestamp' => now()
        ]);

        return view('payment.paypal_error', [
            'errorMessage' => $request->get('error_message', 'A technical error occurred while processing your payment.'),
            'technicalDetails' => $request->get('technical_details', null)
        ]);
    }
}
