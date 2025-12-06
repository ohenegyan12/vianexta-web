<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class VoiceflowController extends Controller
{
    public function getProducts(Request $request)
    {
        // dd("Testing the endpoint ");
        // Validate the request
        $validator = Validator::make($request->all(), [
            'productType' => 'required|string|in:roasted_blend,roasted_single_origin,whole_sale_brands,green'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid product type',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $helper = new Helper();
            $products = $helper->hitCoffeePlugGetEndpoint('stock-postings?productType=' . $request->productType);

            if (!isset($products->statusCode)) {
                return response()->json([
                    'error' => 'Failed to fetch products',
                    'message' => 'Unable to connect to the product service'
                ], 500);
            }

            if ($products->statusCode != 200) {
                return response()->json([
                    'error' => 'Failed to fetch products',
                    'message' => $products->message ?? 'Unknown error occurred'
                ], $products->statusCode);
            }

            return response()->json([
                'success' => true,
                'data' => $products->data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserDetails(Request $request)
    {
        try {
            // Check if user is logged in
            if (!session()->has('auth_user_tokin')) {
                return response()->json([
                    'error' => 'User not logged in',
                    'message' => 'No active session found'
                ], 401);
            }

            // Return user details from session
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => session('auth_user_id'),
                    'email' => session('auth_user_email'),
                    'role' => session('auth_user_role'),
                    'type' => session('auth_user_type'),
                    'name' => session('auth_user_name')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function sendEmail(Request $request)
    {
        // Get the raw request content
        $rawData = $request->getContent();

        // Try to get data from Laravel's JSON handling first
        $requestData = $request->json()->all();

        // If that's empty, try manual parsing
        if (empty($requestData)) {
            // Remove problematic control characters (if any)
            $cleanedInput = preg_replace('/[\x00-\x1F\x7F]/u', '', $rawData);
            $cleanedData = trim($cleanedInput);
            $requestData = json_decode($cleanedData, true);

            // Check if JSON parsing failed
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'error' => 'Invalid JSON format',
                    'message' => 'Failed to parse request data: ' . json_last_error_msg(),
                    'raw_data' => $rawData,
                    'cleaned_data' => $cleanedData,
                    'json_error' => json_last_error()
                ], 400);
            }
        }

        // Log the incoming request for debugging
        Log::info('Voiceflow Email Request', [
            'raw_data' => $rawData,
            'parsed_data' => $requestData,
            'headers' => $request->headers->all()
        ]);

        // Validate the request using parsed data
        $validator = Validator::make($requestData, [
            'recipientEmail' => 'required|email',
            'subject' => 'required|string',
            'messageContent' => 'required|string',
            'name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid email data',
                'message' => $validator->errors()->first(),
                'payload' => $requestData,
                'raw_data' => $rawData,
                'validation_errors' => $validator->errors()->toArray()
            ], 422);
        }

        try {
            $helper = new Helper();

            // Auto-detect if content is HTML
            $contentType = $helper->detectContentType($requestData['messageContent']);

            // Send email directly using SendGrid with auto-detected content type
            $response = $helper->sendEmailWithContentType(
                $requestData['recipientEmail'],
                $requestData['messageContent'],
                $requestData['subject'],
                $contentType
            );

            // Check if the response is empty (error occurred)
            if (empty($response) || is_array($response)) {
                return response()->json([
                    'error' => 'Failed to send email',
                    'message' => 'Unable to connect to the email service'
                ], 500);
            }

            // Parse the response to check for errors
            $responseData = json_decode($response, true);
            if (isset($responseData['errors']) && !empty($responseData['errors'])) {
                return response()->json([
                    'error' => 'Failed to send email',
                    'message' => 'SendGrid error: ' . json_encode($responseData['errors'])
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'message' => 'Email sent successfully'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
