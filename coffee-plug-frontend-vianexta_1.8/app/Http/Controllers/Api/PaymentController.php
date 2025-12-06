<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\Helper;
use App\Constants\PaymentTypes;

class PaymentController extends Controller
{
    /**
     * Regenerate payment link for an order
     *
     * @param Request $request
     * @param string $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function regeneratePaymentLink(Request $request, $orderId)
    {
        try {
            $helper = new Helper();

            // Debug session information
            Log::info('PaymentController: Regenerate payment link request', [
                'order_id' => $orderId,
                'session_id' => session()->getId(),
                'auth_user_tokin' => session('auth_user_tokin'),
                'request_headers' => $request->headers->all()
            ]);

            // Get session token from multiple sources
            $session_token = null;

            // Try to get from session first
            if (session('auth_user_tokin')) {
                $session_token = session('auth_user_tokin');
                Log::info('Session token found in session', ['token' => substr($session_token, 0, 10) . '...']);
            }

            // Try to get from request headers
            if (!$session_token && $request->header('X-Session-Token')) {
                $session_token = $request->header('X-Session-Token');
                Log::info('Session token found in X-Session-Token header', ['token' => substr($session_token, 0, 10) . '...']);
            }

            // Try to get from request cookies
            if (!$session_token && $request->cookie('SESSION')) {
                $session_token = $request->cookie('SESSION');
                Log::info('Session token found in SESSION cookie', ['token' => substr($session_token, 0, 10) . '...']);
            }

            // Try to get from auth_user_tokin cookie
            if (!$session_token && $request->cookie('auth_user_tokin')) {
                $session_token = $request->cookie('auth_user_tokin');
                Log::info('Session token found in auth_user_tokin cookie', ['token' => substr($session_token, 0, 10) . '...']);
            }

            if (!$session_token) {
                Log::error('No session token available for payment link regeneration', [
                    'order_id' => $orderId,
                    'session_id' => session()->getId(),
                    'request_headers' => $request->headers->all(),
                    'request_cookies' => $request->cookies->all()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required. Please log in again.'
                ], 401);
            }

            // Validate order ID
            if (empty($orderId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order ID is required.'
                ], 400);
            }

            // Get payment type from request or use default
            $paymentType = $request->input('paymentType', PaymentTypes::getDefault());
            
            // Validate payment type
            if (!PaymentTypes::isValid($paymentType)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment type specified.'
                ], 400);
            }

            // Prepare payload with payment type
            $payload = [
                'paymentType' => $paymentType
            ];

            // Call the API to regenerate payment link with payment type
            $apiUrl = 'payment/regenerate-link/' . $orderId;
            $response = $helper->hitCoffeePlugPOSTEndpoint($payload, $apiUrl, 'POST');

            // Check if the API call was successful
            if (!$response || !isset($response->statusCode) || $response->statusCode != 200) {
                Log::warning('Failed to regenerate payment link from API', [
                    'order_id' => $orderId,
                    'statusCode' => $response->statusCode ?? 'unknown',
                    'response' => $response ?? 'null',
                    'endpoint' => env('COFFEEPLUG_BASE_ENDPOINT', 'NOT_SET') . $apiUrl,
                    'session_token_used' => substr($session_token, 0, 10) . '...'
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $response->message ?? 'Unable to regenerate payment link at this time. Please try again later.'
                ], 400);
            }

            Log::info('Payment link regenerated successfully', [
                'order_id' => $orderId,
                'response' => $response,
                'session_token_used' => substr($session_token, 0, 10) . '...'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment link regenerated successfully.',
                'data' => [
                    'approvalUrl' => $response->data->approvalUrl ?? null,
                    'orderId' => $orderId,
                    'status' => $response->data->status ?? 'PENDING'
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in payment link regeneration', [
                'order_id' => $orderId,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'session_id' => session()->getId(),
                'auth_user_tokin' => session('auth_user_tokin')
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while regenerating the payment link. Please try again later.'
            ], 500);
        }
    }
}
