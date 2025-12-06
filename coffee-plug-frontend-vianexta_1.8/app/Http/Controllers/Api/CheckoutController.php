<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\Helper;
use App\Constants\PaymentTypes;

class CheckoutController extends Controller
{
    /**
     * Checkout cart with payment type
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkoutCart(Request $request)
    {
        try {
            // Validate the required parameters
            $request->validate([
                'billingAddress' => 'required|array',
                'billingAddress.addressLine1' => 'required|string|max:255',
                'billingAddress.addressLine2' => 'nullable|string|max:255',
                'billingAddress.city' => 'required|string|max:100',
                'billingAddress.state' => 'required|string|max:100',
                'billingAddress.country' => 'required|string|max:100',
                'billingAddress.zipCode' => 'required|string|max:20',
                'shippingAddress' => 'required|array',
                'shippingAddress.addressLine1' => 'required|string|max:255',
                'shippingAddress.addressLine2' => 'nullable|string|max:255',
                'shippingAddress.city' => 'required|string|max:100',
                'shippingAddress.state' => 'required|string|max:100',
                'shippingAddress.country' => 'required|string|max:100',
                'shippingAddress.zipCode' => 'required|string|max:20',
                'paymentType' => 'nullable|string|in:' . implode(',', PaymentTypes::getAll()),
            ]);

            $helper = new Helper();

            // Get payment type from request or use default
            $paymentType = $request->input('paymentType', PaymentTypes::getDefault());

            // Build the payload
            $payload = [
                'billingAddress' => $request->billingAddress,
                'shippingAddress' => $request->shippingAddress,
                'paymentType' => $paymentType
            ];

            // Send POST request to cart-checkout endpoint
            $response = $helper->hitCoffeePlugPOSTEndpoint($payload, 'checkout-cart', 'POST');

            if (!isset($response->statusCode) || $response->statusCode != 200) {
                return response()->json([
                    'success' => false,
                    'message' => 'Checkout failed',
                    'error' => $response->message ?? 'Unknown error occurred'
                ], 400);
            }

            // Return success response with approvalUrl if available
            return response()->json([
                'success' => true,
                'message' => 'Checkout successful',
                'data' => [
                    'approvalUrl' => $response->data->approvalUrl ?? null,
                    'paymentType' => $paymentType,
                    'orderId' => $response->data->orderId ?? null
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Checkout cart API error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred during checkout',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Direct order with payment type
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function directOrder(Request $request)
    {
        try {
            // Validate the required parameters
            $request->validate([
                'buyerEmail' => 'required|email|max:255',
                'buyerFirstName' => 'required|string|max:100',
                'buyerLastName' => 'required|string|max:100',
                'buyerBusinessName' => 'nullable|string|max:255',
                'buyerPhoneNumber' => 'required|string|max:20',
                'items' => 'required|array|min:1',
                'billingAddress' => 'required|array',
                'billingAddress.addressLine1' => 'required|string|max:255',
                'billingAddress.addressLine2' => 'nullable|string|max:255',
                'billingAddress.city' => 'required|string|max:100',
                'billingAddress.state' => 'required|string|max:100',
                'billingAddress.country' => 'required|string|max:100',
                'billingAddress.zipCode' => 'required|string|max:20',
                'shippingAddress' => 'required|array',
                'shippingAddress.addressLine1' => 'required|string|max:255',
                'shippingAddress.addressLine2' => 'nullable|string|max:255',
                'shippingAddress.city' => 'required|string|max:100',
                'shippingAddress.state' => 'required|string|max:100',
                'shippingAddress.country' => 'required|string|max:100',
                'shippingAddress.zipCode' => 'required|string|max:20',
                'paymentType' => 'nullable|string|in:' . implode(',', PaymentTypes::getAll()),
            ]);

            $helper = new Helper();

            // Get payment type from request or use default
            $paymentType = $request->input('paymentType', PaymentTypes::getDefault());

            // Build the payload
            $payload = [
                'buyerEmail' => $request->buyerEmail,
                'buyerFirstName' => $request->buyerFirstName,
                'buyerLastName' => $request->buyerLastName,
                'buyerBusinessName' => $request->buyerBusinessName,
                'buyerPhoneNumber' => $request->buyerPhoneNumber,
                'items' => $request->items,
                'billingAddress' => $request->billingAddress,
                'shippingAddress' => $request->shippingAddress,
                'paymentType' => $paymentType
            ];

            // Send POST request to direct-order endpoint
            $response = $helper->hitCoffeePlugPOSTEndpoint($payload, 'direct-order', 'POST');

            if (!isset($response->statusCode) || $response->statusCode != 200) {
                return response()->json([
                    'success' => false,
                    'message' => 'Direct order failed',
                    'error' => $response->message ?? 'Unknown error occurred'
                ], 400);
            }

            // Return success response with approvalUrl if available
            return response()->json([
                'success' => true,
                'message' => 'Direct order successful',
                'data' => [
                    'approvalUrl' => $response->data->approvalUrl ?? null,
                    'paymentType' => $paymentType,
                    'orderId' => $response->data->orderId ?? null
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Direct order API error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred during direct order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Select delivery quote for an order
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectDeliveryQuote(Request $request)
    {
        try {
            // Validate the required parameters
            $request->validate([
                'totalOrderId' => 'required|integer',
                'quoteId' => 'required|string',
                'totalAmount' => 'required|numeric'
            ]);

            $helper = new Helper();

            // Prepare payload
            $payload = [
                'totalOrderId' => $request->totalOrderId,
                'quoteId' => $request->quoteId,
                'totalAmount' => $request->totalAmount
            ];

            // Make API call to select delivery quote
            $response = $helper->hitCoffeePlugPOSTEndpoint($payload, 'select-delivery-quote', 'POST');

            if (!isset($response->statusCode) || $response->statusCode != 200) {
                return response()->json([
                    'statusCode' => $response->statusCode ?? 500,
                    'message' => $response->message ?? 'Failed to select delivery quote',
                    'data' => null
                ], $response->statusCode ?? 500);
            }

            // Return the response with statusCode format (includes paymentLink)
            return response()->json([
                'statusCode' => 200,
                'message' => $response->message ?? 'Delivery quote selected successfully',
                'data' => $response->data ?? null
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'statusCode' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'data' => null
            ], 422);
        } catch (\Exception $e) {
            Log::error('Select delivery quote API error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'statusCode' => 500,
                'message' => 'An error occurred while selecting delivery quote',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
