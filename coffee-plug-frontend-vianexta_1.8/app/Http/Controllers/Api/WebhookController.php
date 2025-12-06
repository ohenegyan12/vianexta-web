<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WebhookController extends Controller
{
    protected $helper;
    protected $defaultPassword = 'Welcome@123';

    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    public function handleProductPurchase(Request $request)
    {
        try {
            // Validate Voiceflow request structure
            $request->validate([
                'payload' => 'required|array',
                'payload.user' => 'required|array',
                'payload.user.email' => 'required|email',
                'payload.products' => 'required|array',
                'payload.products.*.id' => 'required|string',
                'payload.products.*.quantity' => 'required|integer|min:1',
                'payload.products.*.roastType' => 'nullable|string',
                'payload.products.*.grindType' => 'nullable|string',
                'payload.products.*.bagSize' => 'nullable|string'
            ]);

            $email = $request->payload['user']['email'];
            $products = $request->payload['products'];

            // Check if user is logged in
            if (!Session::has('auth_user_tokin')) {
                // Try to login with default password
                $loginPayload = [
                    'email' => $email,
                    'password' => $this->defaultPassword
                ];

                $loginResponse = $this->helper->hitCoffeePlugEndpoint($loginPayload, 'login');

                if (!$loginResponse || !isset($loginResponse->token)) {
                    // Login failed, proceed with registration
                    $registrationPayload = [
                        'email' => $email,
                        'password' => $this->defaultPassword,
                        'firstName' => explode('@', $email)[0],
                        'lastName' => 'User',
                        'receiveEmailNotifications' => true,
                        'preferredLanguage' => 'en',
                        'phoneNumber' => '',
                        'businessName' => '',
                        'businessType' => '',
                        'userRole' => 'BUYER',
                        'userType' => 'INDIVIDUAL'
                    ];

                    $registerResponse = $this->helper->hitCoffeePlugEndpoint($registrationPayload, 'signup');

                    if (!$registerResponse || !isset($registerResponse->token)) {
                        return response()->json([
                            'version' => '1.0',
                            'response' => [
                                'outputSpeech' => [
                                    'type' => 'PlainText',
                                    'text' => 'Failed to create account. Please try again later.'
                                ],
                                'shouldEndSession' => true
                            ]
                        ]);
                    }

                    Session::put('auth_user_tokin', $registerResponse->token);
                } else {
                    Session::put('auth_user_tokin', $loginResponse->token);
                }
            }

            // Add products to cart
            foreach ($products as $product) {
                $cartPayload = [
                    'stockPostingId' => $product['id'],
                    'numBags' => $product['quantity'],
                    'isRoast' => !empty($product['roastType']), // Set to true if roastType is provided
                    'roastType' => $product['roastType'] ?? null,
                    'grindType' => $product['grindType'] ?? null,
                    'bagSize' => $product['bagSize'] ?? null,
                    'bagImage' => null
                ];

                $cartResponse = $this->helper->hitCoffeePlugEndpoint($cartPayload, 'cart-item');

                if (!$cartResponse) {
                    return response()->json([
                        'version' => '1.0',
                        'response' => [
                            'outputSpeech' => [
                                'type' => 'PlainText',
                                'text' => 'Failed to add product to cart. Please try again later.'
                            ],
                            'shouldEndSession' => true
                        ]
                    ]);
                }
            }

            // Proceed to checkout
            $checkoutPayload = [
                'paymentMethod' => 'CREDIT_CARD',
                'shippingMethod' => 'STANDARD',
                'billingAddress' => [
                    'country' => 'US',
                    'addressLine1' => 'Default Address',
                    'city' => 'Default City',
                    'state' => 'Default State',
                    'zipCode' => '00000'
                ],
                'shippingAddress' => [
                    'country' => 'US',
                    'addressLine1' => 'Default Address',
                    'city' => 'Default City',
                    'state' => 'Default State',
                    'zipCode' => '00000'
                ]
            ];

            $checkoutResponse = $this->helper->hitCoffeePlugEndpoint($checkoutPayload, 'checkout-cart');

            if (!$checkoutResponse) {
                return response()->json([
                    'version' => '1.0',
                    'response' => [
                        'outputSpeech' => [
                            'type' => 'PlainText',
                            'text' => 'Failed to process checkout. Please try again later.'
                        ],
                        'shouldEndSession' => true
                    ]
                ]);
            }

            return response()->json([
                'version' => '1.0',
                'response' => [
                    'outputSpeech' => [
                        'type' => 'PlainText',
                        'text' => 'Your order has been successfully placed! You will receive a confirmation email shortly.'
                    ],
                    'shouldEndSession' => true
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'version' => '1.0',
                'response' => [
                    'outputSpeech' => [
                        'type' => 'PlainText',
                        'text' => 'Sorry, there was an error processing your request. Please try again later.'
                    ],
                    'shouldEndSession' => true
                ]
            ]);
        }
    }

    public function handleSingleOrder(Request $request)
    {
        try {
            // Validate Voiceflow request structure
            $validator = Validator::make($request->all(), [
                'buyerEmail' => 'required|email',
                'stockPostingId' => 'required|integer',
                'quantity' => 'required|integer|min:1',
                'bagSize' => 'nullable|string',
                'grindType' => 'nullable|string',
                'roastType' => 'nullable|string',
                'bagImage' => 'nullable|string',
                'isRoast' => 'required|boolean',
                'billingAddress' => 'required|string',
                'billingCountry' => 'required|string',
                'billingZipCode' => 'required|string',
                'shippingAddress' => 'required|string',
                'shippingCountry' => 'required|string',
                'shippingCity' => 'required|string',
                'shippingState' => 'required|string',
                'shippingZipCode' => 'required|string',
                'billingState' => 'required|string',
                'billingCity' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $email = $request->buyerEmail;

            // Check if user is logged in
            // if (!Session::has('auth_user_tokin')) {
            //     // Try to login with default password
            //     $loginPayload = [
            //         'email' => $email,
            //         'password' => $this->defaultPassword
            //     ];

            //     $loginResponse = $this->helper->hitCoffeePlugEndpoint($loginPayload, 'login');

            //     if (!$loginResponse || !isset($loginResponse->token)) {
            //         // Login failed, proceed with registration
            //         $registrationPayload = [
            //             'email' => $email,
            //             'password' => $this->defaultPassword,
            //             'firstName' => explode('@', $email)[0],
            //             'lastName' => 'User',
            //             'receiveEmailNotifications' => true,
            //             'preferredLanguage' => 'en',
            //             'phoneNumber' => '',
            //             'businessName' => '',
            //             'businessType' => '',
            //             'userRole' => 'BUYER',
            //             'userType' => 'INDIVIDUAL'
            //         ];

            //         $registerResponse = $this->helper->hitCoffeePlugEndpoint($registrationPayload, 'signup');

            //         if (!$registerResponse || !isset($registerResponse->token)) {
            //             return response()->json([
            //                 'error' => 'Account creation failed',
            //                 'message' => 'Failed to create account. Please try again later.'
            //             ], 500);
            //         }

            //         Session::put('auth_user_tokin', $registerResponse->token);
            //     } else {
            //         Session::put('auth_user_tokin', $loginResponse->token);
            //     }
            // }

            // Format payload for direct order endpoint
            $directOrderPayload = [
                'buyerEmail' => $request->buyerEmail,
                'buyerFirstName' => $request->buyerFirstName ?? null,
                'buyerLastName' => $request->buyerLastName ?? null,
                'buyerBusinessName' => $request->buyerBusinessName ?? null,
                'buyerPhoneNumber' => $request->buyerPhoneNumber ?? null,
                'items' => [
                    [
                        'stockPostingId' => $request->stockPostingId,
                        'quantity' => $request->quantity,
                        'bagSize' => $request->bagSize ?? '',
                        'grindType' => $request->grindType ?? '',
                        'roastType' => $request->roastType ?? '',
                        'bagImage' => $request->bagImage ?? '',
                        'isRoast' => $request->isRoast
                    ]
                ],
                'billingAddress' => [
                    'addressLine1' => $request->billingAddress,
                    'city' => $request->billingCity,
                    'state' => $request->billingState,
                    'country' => $request->billingCountry,
                    'zipCode' => $request->billingZipCode
                ],
                'shippingAddress' => [
                    'addressLine1' => $request->shippingAddress,
                    'city' => $request->shippingCity,
                    'state' => $request->shippingState,
                    'country' => $request->shippingCountry,
                    'zipCode' => $request->shippingZipCode
                ]
            ];

            // Make direct API call to the backend server
            $curl = curl_init();
            $url = 'https://coffeeplug-api-b982ba0e7659.herokuapp.com/api/direct-order';
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($directOrderPayload),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                )
            ));

            $response = curl_exec($curl);
            $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            $body = substr($response, $header_size);
            $err = curl_error($curl);
            curl_close($curl);
        //  dd(json_encode($directOrderPayload));

            if ($err) {
                return response()->json([
                    'error' => 'Connection failed',
                    'message' => 'Failed to connect to the server. Please try again later.'
                ], 500);
            }

            $responseData = json_decode($body, true);

            // Check if the order was successful
            if (isset($responseData['statusCode']) && $responseData['statusCode']==200) {
                // Return the new response format with PayPal payment information
                return response()->json([
                    'statusCode' => 200,
                    'message' => 'Order created successfully. Payment link generated.',
                    'data' => [
                        'approvalUrl' => $responseData['data']['approvalUrl'] ?? null,
                        'paypalOrderId' => $responseData['data']['paypalOrderId'] ?? null,
                        'orderId' => $responseData['data']['orderId'] ?? null,
                        'status' => $responseData['data']['status'] ?? 'PENDING',
                        'message' => $responseData['data']['message'] ?? 'Payment link created successfully'
                    ]
                ]);
            } else {
                $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'Failed to place order. Please try again later.';
                return response()->json([
                    'error' => 'Order placement failed',
                    'message' => $errorMessage
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => 'Sorry, there was an error processing your request. Please try again later.'
            ], 500);
        }
    }
} 