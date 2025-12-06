<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Log;
use App\Constants\PaymentTypes;

class PurchaseController extends Controller
{
    public function saveCartItem(Request $request)
    {
        if (session('auth_user_tokin') == null) {
            return  redirect()->route('login_page');
        }
        $helper = new Helper();
        $stockPostingId = $helper->decode($request->stockPostingId);
        $products_data = $helper->hitCoffeePlugGetEndpoint('stock-posting/' . $stockPostingId);
        $maxproduct = 0;

        if ($products_data->statusCode == 200)
            $maxproduct = $products_data->data->quantityLeft;

        $this->validate($request, [
            'numBags' => 'required|numeric|max:' . $maxproduct
        ]);
        $num_of_bags = (int) $request->numBags;
        $payload = array(
            "stockPostingId" => $stockPostingId,
            "numBags" => $num_of_bags,
            "isRoast" => false,
            "roastType" => null,
            "grindType" => null,
            "bagSize" => null,
            "bagImage" => null
        );


        if ($request->edit == "yes") {
            $attemptItemSave = $helper->hitCoffeePlugPOSTEndpoint($payload, "cart-item", "PUT");
        } else {
            $attemptItemSave = $helper->hitCoffeePlugEndpoint($payload, "cart-item");
        }

        if (!isset($attemptItemSave->statusCode) && $attemptItemSave->statusCode != 200) {
            return redirect()->back()->with('error', 'Adding Item to cart failed')->withInput();
        } else {

            $donnot_show_footer = true;
            // return view('new_web_pages.buyer_pages.buyer_order_wizard', compact('helper', 'donnot_show_footer', 'num_of_bags', 'stockPostingId'));
            return redirect()->route('buyer_cart')->with('success', 'Item added to cart successfully');
        }
    }

    public function buyer_cart()
    {
        if (session('auth_user_tokin') == null) {
            return  redirect()->route('login_page');
        }
        $helper = new Helper();
        $helper->resetCart();

        $cart_items = array();
        $cart_items = $helper->hitCoffeePlugGetEndpoint("all-cart-items");
        // dd($cart_items);
        if ($cart_items->statusCode == 200)
            $cart_items = $cart_items->data;

        if ($cart_items == null || count($cart_items) < 1) {
            $helper->resetCart();
            return  redirect()->route('buyer_market_place');
        }

        // dd($cart_items);

        return view('new_web_pages.buyer_pages.shoping_cart', compact('helper', 'cart_items'));
    }
    public function checkout()
    {
        return view('checkout');
    }
    public function order_tracking()
    {
        return view('order_tracking');
    }

    public function purchases($type)
    {
        $helper = new Helper();
        $type = $helper->decryptData($type);
        $transactions = array();
        $transactions = $helper->hitCoffeePlugGetEndpoint("order-lists");
        $purchase_title = '';
        if ($transactions->statusCode == 200) {
            if ($type == 'total_purchase') {
                $transactions = $transactions->data->totalPurchasesList;
                $purchase_title = "Total Purchases";
            }
            if ($type == 'pending_orders') {
                $transactions = $transactions->data->pendingOrderList;
                $purchase_title = "Total Pending Orders";
            }
            if ($type == 'completed_orders') {
                $transactions = $transactions->data->completedOrderList;
                $purchase_title = "Total Completed Orders";
            }
        }

        return view('purchases.purchases', compact('helper', 'transactions', 'purchase_title'));
    }

    public function product_purchases_history($product_id)
    {
        $helper = new Helper();
        $product_id = $helper->decode($product_id);
        $transactions = array();
        $transactions = $helper->hitCoffeePlugGetEndpoint("product-history/" . $product_id);
        // dd($transactions,$product_id);
        if (isset($transactions->statusCode) && $transactions->statusCode == 200)
            $transactions = $transactions->data;

        $purchase_title = 'Product Purchase History';

        return view('purchases.product_purchase_history', compact('helper', 'transactions', 'purchase_title'));
    }


    public function edit_order(Request $request)
    {
        $helper = new Helper();
        $product_details = $request->product_data;

        $product_details = json_decode($helper->decryptData($product_details));
        // dd($product_details);
        $product_id = $product_details->stockPostingId;
        $numBags = $product_details->numBags;
        $products_data = array();

        $products_data = $helper->hitCoffeePlugGetEndpoint('stock-posting/' . $product_id);
        if ($products_data != null)
            $products_data = $products_data->data;

        // Redirect to new edit page instead of wizard
        return redirect()->route('editOrderPage', ['product_data' => $request->product_data]);
    }

    public function edit_order_page(Request $request)
    {
        $helper = new Helper();

        // Validate that product_data is provided
        if (!$request->has('product_data')) {
            return redirect()->route('shoppingCart')->with('error', 'Invalid product data provided');
        }

        $encrypted_data = $request->product_data;

        try {
            $decrypted_data = json_decode($helper->decryptData($encrypted_data));

            if (!$decrypted_data || !isset($decrypted_data->stockPostingId)) {
                return redirect()->route('shoppingCart')->with('error', 'Invalid product data format');
            }

            $product_id = $decrypted_data->stockPostingId;
            $numBags = $decrypted_data->numBags ?? 1;

            // Get product details from API
            $product_details = $helper->hitCoffeePlugGetEndpoint('stock-posting/' . $product_id);
            if ($product_details != null && $product_details->statusCode == 200) {
                $product_details = $product_details->data;
            } else {
                return redirect()->route('shoppingCart')->with('error', 'An error occurred while fetching the product details to add to cart');
            }

            // Prepare edit data
            $edit_data = (object) [
                'product' => $product_id,
                'num_of_bags' => $numBags,
                'roast_type' => $decrypted_data->roastType ?? null,
                'grind_type' => $decrypted_data->grindType ?? null,
                'bag_size' => $decrypted_data->bagSize ?? '12oz',
                'bag_image' => $decrypted_data->bagImage ?? '10oz_1.png',
                'is_roast' => $decrypted_data->isRoast ?? false
            ];

            return view('new_web_pages.buyer_pages.wizard.edit_order', compact('helper', 'product_details', 'edit_data'));
        } catch (\Exception $e) {
            Log::error('Error in edit_order_page: ' . $e->getMessage());
            return redirect()->route('shoppingCart')->with('error', 'An error occurred while loading the edit page');
        }
    }

    public function update_order(Request $request)
    {
        $helper = new Helper();

        try {
            // Validate request
            $request->validate([
                'product_id' => 'required',
                'num_of_bags' => 'required|numeric|min:1',
                'roast_type' => 'nullable',
                'grind_type' => 'nullable',
                'bag_size' => 'nullable',
                'bag_image' => 'nullable'
            ]);

            // Decode the product_id like other methods do
            $stockPostingId = $helper->decode($request->product_id);

            // Prepare payload for cart item update
            $payload = [
                "stockPostingId" => $stockPostingId,
                "numBags" => (int) $request->num_of_bags,
                "isRoast" => !empty($request->roast_type),
                "roastType" => $request->roast_type,
                "grindType" => $request->grind_type,
                "bagSize" => $request->bag_size,
                "bagImage" => $request->bag_image
            ];

            // Update cart item
            $attemptItemSave = $helper->hitCoffeePlugPOSTEndpoint($payload, "cart-item", "PUT");

            if (!isset($attemptItemSave->statusCode) || $attemptItemSave->statusCode != 200) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update order'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the order'
            ], 500);
        }
    }

    public function setProductSession($product_details)
    {
        session(['roast' => $product_details->isRoast ? 'yes' : 'no']);
        session(['roast_type' => $product_details->roastType]);
        session(['grind_type' => $product_details->grindType]);
        session(['bag_size' => $product_details->bagSize]);
        session(['bag_image' => $product_details->bagImage]);
        session(['product' => $product_details->stockPostingId]);
        session(['num_of_bags' => $product_details->numBags]);
        session(['is_roast' => $product_details->isRoast]);

        // Debug: Log session data
        Log::info('Edit mode session data set:', [
            'product' => $product_details->stockPostingId,
            'num_of_bags' => $product_details->numBags,
            'roast_type' => $product_details->roastType,
            'grind_type' => $product_details->grindType,
            'bag_size' => $product_details->bagSize,
            'bag_image' => $product_details->bagImage,
            'is_roast' => $product_details->isRoast
        ]);
    }

    public function delete_order($product_id)
    {
        $helper = new Helper();

        $stock_posting_id = $helper->decode($product_id);
        $attemptItemSave = $helper->hitCoffeePlugGetEndpoint('cart-item/' . $stock_posting_id, 'DELETE');
        //   dd($products_data);
        if ($attemptItemSave != true) {
            return redirect()->back()->with('error', 'Deleting Item from cart failed')->withInput();
        } else {
            return redirect()->route('buyer_cart')->with('success', 'Cart item deleted successfully');
        }
    }

    public function show_checkout()
    {
        if (session('auth_user_tokin') == null) {
            return redirect()->route('login_page');
        }

        $helper = new Helper();
        $cart_items = array();
        $price_breakdown = array();
        $profile_data = array();

        $cart_items = $helper->hitCoffeePlugGetEndpoint("all-cart-items");
        $fetch_price_breakdown = $helper->hitCoffeePlugGetEndpoint("get-cart-price-breakdown");

        // Fetch buyer profile data for prepopulating billing form
        $profile_response = $helper->hitCoffeePlugGetEndpoint('buyer-profile');
        if (isset($profile_response->statusCode) && $profile_response->statusCode == 200) {
            $profile_data = $profile_response->data;
        }

        if (isset($cart_items->statusCode) && $cart_items->statusCode == 200)
            $cart_items = $cart_items->data;

        if (isset($fetch_price_breakdown->statusCode) && $fetch_price_breakdown->statusCode == 200)
            $price_breakdown = $fetch_price_breakdown->data;

        if ($cart_items == null || count($cart_items) < 1) {
            $helper->resetCart();
            return redirect()->route('buyer_market_place');
        }

        $donnot_show_footer = true;
        return view('new_web_pages.buyer_pages.buyer_checkout', compact('helper', 'cart_items', 'price_breakdown', 'donnot_show_footer', 'profile_data'));
    }

    public function cart_checkout(Request $request)
    {
        if (session('auth_user_tokin') == null) {
            return redirect()->route('login_page');
        }

        // Validate the required parameters for both billing and shipping
        $this->validate($request, [
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

        $helper = new Helper();

        // Get payment type from request or use default
        $paymentType = $request->input('paymentType', PaymentTypes::getDefault());
        
        // Get delivery option (default to false if not provided)
        $delivery = $request->has('delivery') && $request->input('delivery') == '1';

        // Build the payload with the required parameters
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
            'paymentType' => $paymentType,
            'delivery' => $delivery
        );

        //  dd( json_encode($payload));

        // Send POST request to cart-checkout endpoint
        $attemptItemSave = $helper->hitCoffeePlugPOSTEndpoint($payload, 'checkout-cart', 'POST');

        // dd($attemptItemSave, $payload);

        if (!isset($attemptItemSave->statusCode) || $attemptItemSave->statusCode != 200) {
            return redirect()->back()->with('error', 'Checkout failed')->withInput();
        } else {
            // If delivery is selected, redirect to delivery quotes page
            if ($delivery && isset($attemptItemSave->data->orderId)) {
                // Store order data in session for delivery quotes page
                session([
                    'checkout_order_id' => $attemptItemSave->data->orderId,
                    'checkout_total_amount' => $attemptItemSave->data->totalPrice ?? 0,
                    'checkout_payment_type' => $paymentType,
                    'checkout_insurance_amount' => $attemptItemSave->data->insuranceAmount ?? ($attemptItemSave->data->totalPrice ?? 0) * 0.01
                ]);
                
                // Redirect to delivery quotes page
                return redirect()->route('buyerDeliveryQuotes', [
                    'orderId' => $attemptItemSave->data->orderId
                ]);
            }
            
            // Check if response contains approvalUrl for payment redirection
            if (isset($attemptItemSave->data->approvalUrl)) {
                return redirect($attemptItemSave->data->approvalUrl);
            }
            
            $helper->resetCart();
            return redirect()->route('buyerOrderHistory')->with('success', 'Checkout successful');
        }
    }

    public function buyer_delivery_quotes(Request $request)
    {
        if (session('auth_user_tokin') == null) {
            return redirect()->route('login_page');
        }

        $helper = new Helper();
        $orderId = $request->get('orderId') ?? session('checkout_order_id');
        $quotes = [];
        $sender = null;
        $receiver = null;
        $error = null;
        $totalAmount = session('checkout_total_amount', 0);
        $paymentType = session('checkout_payment_type', 'PAYPAL_CHECKOUT');

        // Default values for weight, dimensions, and insurance
        $weight = 10;
        $length = 12;
        $height = 8;
        // Get insuranceAmount from checkout response (stored in session) or use default
        $insuranceAmount = session('checkout_insurance_amount', $totalAmount * 0.01);

        if ($orderId) {
            // First, try to get order details to fetch weight, dimensions, etc.
            $orderResponse = $helper->hitCoffeePlugGetEndpoint('order/' . $orderId);
            
            if (isset($orderResponse->statusCode) && $orderResponse->statusCode == 200) {
                $orderData = $orderResponse->data ?? null;
                
                // Extract order details for delivery quotes
                // Note: Adjust these field names based on actual API response structure
                if ($orderData) {
                    $weight = $orderData->totalWeight ?? $orderData->weight ?? $weight;
                    $length = $orderData->length ?? $length;
                    $height = $orderData->height ?? $height;
                    // Use insuranceAmount from checkout response (session) if available, otherwise from order data
                    $insuranceAmount = session('checkout_insurance_amount', $orderData->insuranceAmount ?? $insuranceAmount);
                }
            }
            
            // Prepare payload for delivery quotes API
            $payload = [
                "orderId" => (int)$orderId,
                "totalWeight" => (float)$weight,
                "length" => (float)$length,
                "height" => (float)$height,
                "insuranceAmount" => (float)$insuranceAmount
            ];

            // Make API call to get delivery quotes
            $response = $helper->hitCoffeePlugEndpoint($payload, 'delivery-quotes');

            if (isset($response->statusCode) && $response->statusCode == 200) {
                $quotes = $response->data->quotes ?? [];
                $sender = $response->data->sender ?? null;
                $receiver = $response->data->receiver ?? null;
                
                // Sort quotes by totalAmount (best value/lowest price first)
                if (!empty($quotes)) {
                    usort($quotes, function($a, $b) {
                        $priceA = floatval($a->totalAmount ?? 0);
                        $priceB = floatval($b->totalAmount ?? 0);
                        return $priceA <=> $priceB;
                    });
                    
                    // Limit to top 3 best quotes
                    $quotes = array_slice($quotes, 0, 3);
                }
            } else {
                $error = $response->message ?? 'Failed to get delivery quotes';
            }
        } else {
            $error = 'Order ID is required';
        }

        $donnot_show_footer = true;
        return view('new_web_pages.buyer_pages.buyer_delivery_quotes', compact(
            'helper', 
            'quotes', 
            'orderId', 
            'weight', 
            'length', 
            'height', 
            'insuranceAmount', 
            'sender', 
            'receiver', 
            'error',
            'totalAmount',
            'paymentType',
            'donnot_show_footer'
        ));
    }

    public function selectDeliveryQuote(Request $request)
    {
        if (session('auth_user_tokin') == null) {
            return response()->json([
                'statusCode' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Validate the request
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

        // Return the response as-is (includes paymentLink)
        return response()->json($response);
    }

    public function checkout_payload()
    {
        return '{
            "billingAddress": {
                "addressLine1": "123 Main St",
                "addressLine2": "Apt 4",
                "city": "Anytown",
                "state": "Anystate",
                "country": "Anycountry",
                "zipCode": "12345"
            },
            "shippingAddress": {
                "addressLine1": "456 Elm St",
                "addressLine2": "Suite 5",
                "city": "Othertown",
                "state": "Otherstate",
                "country": "Othercountry",
                "zipCode": "67890"
            }
            }';
    }

    public function save_history_cart_items() {}

    /**
     * Get cities for a US state
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUSCities(Request $request)
    {
        $request->validate([
            'state' => 'required|string'
        ]);

        $state = $request->input('state');
        
        try {
            // Use countriesnow.space API for US cities
            $url = 'https://countriesnow.space/api/v0.1/countries/state/cities';
            $payload = [
                'country' => 'United States',
                'state' => $state
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode == 200) {
                $data = json_decode($response, true);
                if (isset($data['error']) && $data['error'] === false && isset($data['data']) && is_array($data['data'])) {
                    // Sort cities alphabetically
                    $cities = $data['data'];
                    sort($cities);
                    
                    return response()->json([
                        'success' => true,
                        'cities' => $cities
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch cities',
                'cities' => []
            ], 400);

        } catch (\Exception $e) {
            Log::error('Error fetching US cities: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching cities',
                'cities' => []
            ], 500);
        }
    }

    /**
     * Get zipcodes for a US state
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUSZipcodes(Request $request)
    {
        $request->validate([
            'state' => 'required|string'
        ]);

        $state = $request->input('state');
        
        try {
            // State to state code mapping
            $stateCodes = [
                'Alabama' => 'AL', 'Alaska' => 'AK', 'Arizona' => 'AZ', 'Arkansas' => 'AR',
                'California' => 'CA', 'Colorado' => 'CO', 'Connecticut' => 'CT', 'Delaware' => 'DE',
                'Florida' => 'FL', 'Georgia' => 'GA', 'Hawaii' => 'HI', 'Idaho' => 'ID',
                'Illinois' => 'IL', 'Indiana' => 'IN', 'Iowa' => 'IA', 'Kansas' => 'KS',
                'Kentucky' => 'KY', 'Louisiana' => 'LA', 'Maine' => 'ME', 'Maryland' => 'MD',
                'Massachusetts' => 'MA', 'Michigan' => 'MI', 'Minnesota' => 'MN', 'Mississippi' => 'MS',
                'Missouri' => 'MO', 'Montana' => 'MT', 'Nebraska' => 'NE', 'Nevada' => 'NV',
                'New Hampshire' => 'NH', 'New Jersey' => 'NJ', 'New Mexico' => 'NM', 'New York' => 'NY',
                'North Carolina' => 'NC', 'North Dakota' => 'ND', 'Ohio' => 'OH', 'Oklahoma' => 'OK',
                'Oregon' => 'OR', 'Pennsylvania' => 'PA', 'Rhode Island' => 'RI', 'South Carolina' => 'SC',
                'South Dakota' => 'SD', 'Tennessee' => 'TN', 'Texas' => 'TX', 'Utah' => 'UT',
                'Vermont' => 'VT', 'Virginia' => 'VA', 'Washington' => 'WA', 'West Virginia' => 'WV',
                'Wisconsin' => 'WI', 'Wyoming' => 'WY', 'District of Columbia' => 'DC'
            ];

            $stateCode = $stateCodes[$state] ?? null;
            if (!$stateCode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid state',
                    'zipcodes' => []
                ], 400);
            }

            // Get cities for the state first
            $citiesUrl = 'https://countriesnow.space/api/v0.1/countries/state/cities';
            $citiesPayload = [
                'country' => 'United States',
                'state' => $state
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $citiesUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($citiesPayload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            $citiesResponse = curl_exec($ch);
            $citiesHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $zipcodes = [];
            if ($citiesHttpCode == 200) {
                $citiesData = json_decode($citiesResponse, true);
                if (isset($citiesData['data']) && is_array($citiesData['data']) && count($citiesData['data']) > 0) {
                    // Get zipcodes for first 10 cities (to get a good sample)
                    $sampleCities = array_slice($citiesData['data'], 0, min(10, count($citiesData['data'])));
                    
                    foreach ($sampleCities as $city) {
                        $zipUrl = "https://api.zippopotam.us/us/{$stateCode}/" . urlencode($city);
                        $zipCh = curl_init();
                        curl_setopt($zipCh, CURLOPT_URL, $zipUrl);
                        curl_setopt($zipCh, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($zipCh, CURLOPT_TIMEOUT, 3);
                        $zipResponse = curl_exec($zipCh);
                        $zipHttpCode = curl_getinfo($zipCh, CURLINFO_HTTP_CODE);
                        curl_close($zipCh);

                        if ($zipHttpCode == 200) {
                            $zipData = json_decode($zipResponse, true);
                            if (isset($zipData['places']) && is_array($zipData['places'])) {
                                foreach ($zipData['places'] as $place) {
                                    if (isset($place['post code']) && !in_array($place['post code'], $zipcodes)) {
                                        $zipcodes[] = $place['post code'];
                                    }
                                }
                            }
                        }
                        // Small delay to avoid rate limiting
                        usleep(200000); // 0.2 seconds
                    }
                }
            }

            // If we didn't get enough zipcodes, use fallback
            if (count($zipcodes) < 5) {
                $fallbackZipcodes = $this->getFallbackZipcodes($stateCode);
                $zipcodes = array_merge($zipcodes, $fallbackZipcodes);
            }

            // Remove duplicates and sort
            $zipcodes = array_unique($zipcodes);
            sort($zipcodes);
            
            if (!empty($zipcodes)) {
                return response()->json([
                    'success' => true,
                    'zipcodes' => array_values($zipcodes) // Re-index array
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch zipcodes',
                'zipcodes' => []
            ], 400);

        } catch (\Exception $e) {
            Log::error('Error fetching US zipcodes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching zipcodes',
                'zipcodes' => []
            ], 500);
        }
    }


    /**
     * Fallback zipcodes for states (common zipcode ranges)
     */
    private function getFallbackZipcodes($stateCode)
    {
        // This is a simplified fallback - in production, use a comprehensive database
        $fallbackZipcodes = [
            'CA' => ['90001', '90002', '90003', '90004', '90005', '90006', '90007', '90008', '90009', '90010', '90011', '90012', '90013', '90014', '90015', '90016', '90017', '90018', '90019', '90020', '90021', '90022', '90023', '90024', '90025', '90026', '90027', '90028', '90029', '90030', '90031', '90032', '90033', '90034', '90035', '90036', '90037', '90038', '90039', '90040', '90041', '90042', '90043', '90044', '90045', '90046', '90047', '90048', '90049', '90050', '94102', '94103', '94104', '94105', '94107', '94108', '94109', '94110', '94111', '94112', '94114', '94115', '94116', '94117', '94118', '94121', '94122', '94123', '94124', '94127', '94129', '94130', '94131', '94132', '94133', '94134', '94158'],
            'NY' => ['10001', '10002', '10003', '10004', '10005', '10006', '10007', '10009', '10010', '10011', '10012', '10013', '10014', '10016', '10017', '10018', '10019', '10020', '10021', '10022', '10023', '10024', '10025', '10026', '10027', '10028', '10029', '10030', '10031', '10032', '10033', '10034', '10035', '10036', '10037', '10038', '10039', '10040', '10044', '10065', '10069', '10075', '10128', '10280', '10282'],
            'TX' => ['75001', '75002', '75006', '75007', '75009', '75010', '75011', '75013', '75014', '75015', '75019', '75020', '75021', '75022', '75023', '75024', '75025', '75028', '75030', '75032', '75033', '75034', '75035', '75038', '75039', '75040', '75041', '75042', '75043', '75044', '75046', '75047', '75048', '75049', '75050', '75051', '75052', '75053', '75054', '75056', '75057', '75058', '75060', '75061', '75062', '75063', '75065', '75067', '75068', '75069', '75070', '75071', '75074', '75075', '75076', '75077', '75078', '75080', '75081', '75082', '75083', '75085', '75086', '75087', '75088', '75089', '75090', '75091', '75092', '75093', '75094', '75098', '75099', '77001', '77002', '77003', '77004', '77005', '77006', '77007', '77008', '77009', '77010', '77011', '77012', '77013', '77014', '77015', '77016', '77017', '77018', '77019', '77020', '77021', '77022', '77023', '77024', '77025', '77026', '77027', '77028', '77029', '77030', '77031', '77032', '77033', '77034', '77035', '77036', '77037', '77038', '77039', '77040', '77041', '77042', '77043', '77044', '77045', '77046', '77047', '77048', '77049', '77050', '77051', '77052', '77053', '77054', '77055', '77056', '77057', '77058', '77059', '77060', '77061', '77062', '77063', '77064', '77065', '77066', '77067', '77068', '77069', '77070', '77071', '77072', '77073', '77074', '77075', '77076', '77077', '77078', '77079', '77080', '77081', '77082', '77083', '77084', '77085', '77086', '77087', '77088', '77089', '77090', '77091', '77092', '77093', '77094', '77095', '77096', '77098', '77099'],
            'FL' => ['32003', '32004', '32006', '32007', '32008', '32009', '32011', '32013', '32024', '32025', '32026', '32034', '32035', '32038', '32040', '32043', '32044', '32046', '32050', '32052', '32053', '32054', '32055', '32056', '32058', '32060', '32061', '32062', '32063', '32064', '32065', '32066', '32067', '32068', '32071', '32073', '32080', '32081', '32082', '32083', '32084', '32085', '32086', '32087', '32091', '32092', '32094', '32095', '32096', '32097', '32099', '32102', '32110', '32111', '32112', '32113', '32114', '32115', '32116', '32117', '32118', '32119', '32120', '32121', '32122', '32123', '32124', '32125', '32126', '32127', '32128', '32129', '32130', '32131', '32132', '32133', '32134', '32135', '32136', '32137', '32138', '32139', '32140', '32141', '32142', '32145', '32147', '32148', '32149', '32157', '32158', '32159', '32160', '32162', '32163', '32164', '32168', '32169', '32170', '32173', '32174', '32175', '32176', '32177', '32178', '32179', '32180', '32181', '32182', '32183', '32185', '32187', '32189', '32190', '32192', '32193', '32195', '32198', '32201', '32202', '32203', '32204', '32205', '32206', '32207', '32208', '32209', '32210', '32211', '32212', '32216', '32217', '32218', '32219', '32220', '32221', '32222', '32223', '32224', '32225', '32226', '32227', '32228', '32229', '32231', '32232', '32233', '32234', '32235', '32236', '32237', '32238', '32239', '32240', '32241', '32244', '32245', '32246', '32247', '32250', '32254', '32255', '32256', '32257', '32258', '32259', '32260', '32266', '32267', '32277', '32290', '32501', '32502', '32503', '32504', '32505', '32506', '32507', '32508', '32509', '32511', '32512', '32513', '32514', '32516', '32520', '32521', '32522', '32523', '32524', '32526', '32530', '32531', '32533', '32534', '32535', '32536', '32537', '32538', '32539', '32540', '32541', '32542', '32544', '32547', '32548', '32549', '32550', '32559', '32561', '32562', '32563', '32564', '32565', '32566', '32567', '32568', '32569', '32570', '32571', '32572', '32577', '32578', '32579', '32580', '32581', '32582', '32583', '32588', '32591', '32592', '32601', '32602', '32603', '32604', '32605', '32606', '32607', '32608', '32609', '32610', '32611', '32612', '32613', '32614', '32615', '32616', '32617', '32618', '32619', '32621', '32622', '32625', '32626', '32627', '32628', '32631', '32633', '32634', '32635', '32639', '32640', '32641', '32643', '32644', '32648', '32653', '32654', '32655', '32656', '32658', '32662', '32663', '32664', '32666', '32667', '32668', '32669', '32680', '32681', '32683', '32686', '32692', '32693', '32694', '32696', '32697', '32701', '32702', '32703', '32704', '32707', '32708', '32709', '32710', '32712', '32713', '32714', '32715', '32716', '32718', '32719', '32720', '32721', '32722', '32723', '32724', '32725', '32726', '32727', '32728', '32730', '32732', '32733', '32735', '32736', '32738', '32739', '32744', '32745', '32746', '32747', '32750', '32751', '32752', '32753', '32754', '32756', '32757', '32759', '32763', '32764', '32765', '32766', '32767', '32768', '32771', '32772', '32773', '32774', '32775', '32776', '32777', '32778', '32779', '32780', '32781', '32782', '32783', '32784', '32789', '32790', '32791', '32792', '32793', '32794', '32795', '32796', '32798', '32799', '32801', '32802', '32803', '32804', '32805', '32806', '32807', '32808', '32809', '32810', '32811', '32812', '32814', '32815', '32816', '32817', '32818', '32819', '32820', '32821', '32822', '32824', '32825', '32826', '32827', '32828', '32829', '32830', '32831', '32832', '32833', '32834', '32835', '32836', '32837', '32839', '32853', '32854', '32855', '32856', '32857', '32858', '32859', '32860', '32861', '32862', '32867', '32868', '32869', '32872', '32877', '32878', '32885', '32886', '32887', '32891', '32896', '32897', '32898', '32899', '32901', '32902', '32903', '32904', '32905', '32906', '32907', '32908', '32909', '32910', '32911', '32912', '32919', '32920', '32922', '32923', '32924', '32925', '32926', '32927', '32931', '32932', '32934', '32935', '32936', '32937', '32940', '32941', '32948', '32949', '32950', '32951', '32952', '32953', '32954', '32955', '32956', '32957', '32958', '32959', '32960', '32961', '32962', '32963', '32964', '32965', '32966', '32967', '32968', '32969', '32970', '32971', '32976', '32978', '33101', '33102', '33106', '33109', '33111', '33112', '33114', '33116', '33119', '33121', '33122', '33124', '33125', '33126', '33127', '33128', '33129', '33130', '33131', '33132', '33133', '33134', '33135', '33136', '33137', '33138', '33139', '33140', '33141', '33142', '33143', '33144', '33145', '33146', '33147', '33149', '33150', '33151', '33152', '33153', '33154', '33155', '33156', '33157', '33158', '33159', '33160', '33161', '33162', '33163', '33164', '33165', '33166', '33167', '33168', '33169', '33170', '33172', '33173', '33174', '33175', '33176', '33177', '33178', '33179', '33180', '33181', '33182', '33183', '33184', '33185', '33186', '33187', '33188', '33189', '33190', '33193', '33194', '33195', '33196', '33197', '33199', '33231', '33233', '33234', '33238', '33239', '33242', '33243', '33245', '33247', '33255', '33256', '33257', '33261', '33265', '33266', '33269', '33280', '33283', '33296', '33299', '33301', '33302', '33303', '33304', '33305', '33306', '33307', '33308', '33309', '33310', '33311', '33312', '33313', '33314', '33315', '33316', '33317', '33318', '33319', '33320', '33321', '33322', '33323', '33324', '33325', '33326', '33327', '33328', '33329', '33330', '33331', '33332', '33333', '33334', '33335', '33336', '33337', '33338', '33339', '33340', '33345', '33346', '33348', '33349', '33351', '33355', '33359', '33388', '33394', '33401', '33402', '33403', '33404', '33405', '33406', '33407', '33408', '33409', '33410', '33411', '33412', '33413', '33414', '33415', '33416', '33417', '33418', '33419', '33420', '33421', '33422', '33424', '33425', '33426', '33427', '33428', '33429', '33430', '33431', '33432', '33433', '33434', '33435', '33436', '33437', '33438', '33440', '33441', '33442', '33444', '33445', '33446', '33448', '33449', '33454', '33455', '33458', '33459', '33460', '33461', '33462', '33463', '33464', '33465', '33466', '33467', '33468', '33469', '33470', '33471', '33472', '33473', '33474', '33475', '33476', '33477', '33478', '33480', '33481', '33482', '33483', '33484', '33486', '33487', '33488', '33493', '33494', '33496', '33497', '33498', '33499', '33503', '33508', '33509', '33510', '33511', '33513', '33514', '33521', '33523', '33524', '33525', '33526', '33527', '33530', '33534', '33537', '33538', '33539', '33540', '33541', '33542', '33543', '33544', '33545', '33547', '33548', '33549', '33550', '33556', '33558', '33559', '33563', '33564', '33565', '33566', '33567', '33568', '33569', '33570', '33571', '33572', '33573', '33574', '33575', '33576', '33578', '33579', '33583', '33584', '33585', '33586', '33587', '33592', '33593', '33594', '33595', '33596', '33597', '33598', '33601', '33602', '33603', '33604', '33605', '33606', '33607', '33608', '33609', '33610', '33611', '33612', '33613', '33614', '33615', '33616', '33617', '33618', '33619', '33620', '33621', '33622', '33623', '33624', '33625', '33626', '33629', '33630', '33631', '33633', '33634', '33635', '33637', '33646', '33647', '33650', '33655', '33660', '33661', '33662', '33663', '33664', '33672', '33673', '33674', '33675', '33677', '33679', '33680', '33681', '33682', '33684', '33685', '33686', '33687', '33688', '33689', '33694', '33697', '33701', '33702', '33703', '33704', '33705', '33706', '33707', '33708', '33709', '33710', '33711', '33712', '33713', '33714', '33715', '33716', '33729', '33730', '33731', '33732', '33733', '33734', '33736', '33737', '33738', '33740', '33741', '33742', '33743', '33744', '33747', '33755', '33756', '33757', '33758', '33759', '33760', '33761', '33762', '33763', '33764', '33765', '33766', '33767', '33769', '33770', '33771', '33772', '33773', '33774', '33775', '33776', '33777', '33778', '33779', '33780', '33781', '33782', '33784', '33785', '33786', '33801', '33802', '33803', '33804', '33805', '33806', '33807', '33809', '33810', '33811', '33812', '33813', '33815', '33820', '33823', '33825', '33826', '33827', '33830', '33834', '33835', '33836', '33837', '33838', '33839', '33840', '33841', '33843', '33844', '33845', '33846', '33847', '33848', '33849', '33850', '33851', '33852', '33853', '33854', '33855', '33856', '33857', '33858', '33859', '33860', '33862', '33863', '33865', '33867', '33868', '33870', '33871', '33872', '33873', '33875', '33876', '33877', '33880', '33881', '33882', '33883', '33884', '33885', '33888', '33890', '33896', '33897', '33898', '33901', '33902', '33903', '33904', '33905', '33906', '33907', '33908', '33909', '33910', '33911', '33912', '33913', '33914', '33915', '33916', '33917', '33918', '33919', '33920', '33921', '33922', '33924', '33927', '33928', '33929', '33930', '33931', '33932', '33935', '33936', '33938', '33940', '33941', '33942', '33943', '33944', '33945', '33946', '33947', '33948', '33949', '33950', '33951', '33952', '33953', '33954', '33955', '33956', '33957', '33960', '33965', '33966', '33967', '33970', '33971', '33972', '33973', '33974', '33975', '33976', '33977', '33980', '33981', '33982', '33983', '33990', '33991', '33993', '33994', '33995', '34101', '34102', '34103', '34104', '34105', '34108', '34109', '34110', '34112', '34113', '34114', '34116', '34117', '34119', '34120', '34133', '34134', '34135', '34136', '34137', '34138', '34139', '34140', '34141', '34142', '34143', '34145', '34146', '34201', '34202', '34203', '34204', '34205', '34206', '34207', '34208', '34209', '34210', '34211', '34212', '34215', '34216', '34217', '34218', '34219', '34220', '34221', '34222', '34223', '34224', '34228', '34229', '34230', '34231', '34232', '34233', '34234', '34235', '34236', '34237', '34238', '34239', '34240', '34241', '34242', '34243', '34250', '34251', '34260', '34264', '34265', '34266', '34267', '34268', '34269', '34270', '34272', '34274', '34275', '34276', '34277', '34278', '34280', '34281', '34282', '34284', '34285', '34286', '34287', '34288', '34289', '34290', '34291', '34292', '34293', '34295', '34420', '34421', '34428', '34429', '34430', '34431', '34432', '34433', '34434', '34436', '34442', '34445', '34446', '34447', '34448', '34449', '34450', '34451', '34452', '34453', '34461', '34464', '34465', '34470', '34471', '34472', '34473', '34474', '34475', '34476', '34477', '34478', '34479', '34480', '34481', '34482', '34483', '34484', '34487', '34488', '34489', '34491', '34492', '34498', '34601', '34602', '34603', '34604', '34605', '34606', '34607', '34608', '34609', '34610', '34611', '34613', '34614', '34615', '34616', '34617', '34618', '34619', '34620', '34621', '34622', '34623', '34624', '34625', '34629', '34630', '34636', '34637', '34638', '34639', '34652', '34653', '34654', '34655', '34656', '34660', '34661', '34667', '34668', '34669', '34673', '34674', '34677', '34679', '34680', '34681', '34682', '34683', '34684', '34685', '34688', '34689', '34690', '34691', '34692', '34695', '34697', '34698', '34705', '34711', '34712', '34713', '34714', '34715', '34729', '34731', '34734', '34736', '34737', '34739', '34740', '34741', '34742', '34743', '34744', '34745', '34746', '34747', '34748', '34749', '34753', '34755', '34756', '34758', '34759', '34760', '34761', '34762', '34769', '34770', '34771', '34772', '34773', '34777', '34778', '34785', '34786', '34787', '34788', '34789', '34797', '34945', '34946', '34947', '34948', '34949', '34950', '34951', '34952', '34953', '34954', '34956', '34957', '34958', '34972', '34973', '34974', '34979', '34981', '34982', '34983', '34984', '34985', '34986', '34987', '34988', '34990', '34991', '34992', '34994', '34995', '34996', '34997']
        ];

        return $fallbackZipcodes[$stateCode] ?? [];
    }
}
