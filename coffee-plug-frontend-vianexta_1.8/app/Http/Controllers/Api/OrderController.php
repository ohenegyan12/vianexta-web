<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\Helper;

class OrderController extends Controller
{
    public function getOrdersDataTable(Request $request)
    {
        try {
            $helper = new Helper();

            // Debug session information
            Log::info('OrderController: Session debugging', [
                'session_id' => session()->getId(),
                'auth_user_tokin' => session('auth_user_tokin'),
                'session_status' => session()->isStarted(),
                'request_headers' => $request->headers->all(),
                'request_cookies' => $request->cookies->all(),
                'user_agent' => $request->userAgent()
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
                Log::error('No session token available for API call', [
                    'session_id' => session()->getId(),
                    'request_headers' => $request->headers->all(),
                    'request_cookies' => $request->cookies->all()
                ]);

                return response()->json([
                    'draw' => intval($request->input('draw', 1)),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => 'Authentication required. Please log in again.'
                ], 401);
            }

            // Get all orders using the session token
            $order_list = $helper->hitCoffeePlugGetEndpointWithToken('order-lists', 'GET', $session_token);

            // Check if we have valid data or if the API call failed
            if (!$order_list || !isset($order_list->statusCode) || $order_list->statusCode != 200) {
                Log::warning('Failed to fetch orders from API', [
                    'statusCode' => $order_list->statusCode ?? 'unknown',
                    'response' => $order_list ?? 'null',
                    'endpoint' => env('COFFEEPLUG_BASE_ENDPOINT', 'NOT_SET') . 'order-lists',
                    'session_token_used' => substr($session_token, 0, 10) . '...'
                ]);

                return response()->json([
                    'draw' => intval($request->input('draw', 1)),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => 'Unable to fetch orders at this time. Please check your API configuration.'
                ]);
            }

            $orders = $order_list->data;

            // Combine all order types into one array
            $allOrders = [];

            // Add pending orders
            if (isset($orders->pendingOrderList)) {
                foreach ($orders->pendingOrderList as $order) {
                    $order->status = 'Processing';
                    $order->statusColor = '#058D75';
                    
                    // Debug: Log available fields for the first order
                    if (count($allOrders) === 0) {
                        Log::info('Order data structure (pending order)', [
                            'available_fields' => array_keys((array)$order),
                            'order_data' => $order,
                            'payment_fields_check' => [
                                'paymentStatus' => isset($order->paymentStatus) ? $order->paymentStatus : 'NOT_SET',
                                'payment_status' => isset($order->payment_status) ? $order->payment_status : 'NOT_SET',
                                'paymentDate' => isset($order->paymentDate) ? $order->paymentDate : 'NOT_SET',
                                'payment_date' => isset($order->payment_date) ? $order->payment_date : 'NOT_SET',
                                'paymentMethod' => isset($order->paymentMethod) ? $order->paymentMethod : 'NOT_SET',
                                'payment_method' => isset($order->payment_method) ? $order->payment_method : 'NOT_SET',
                                'paymentType' => isset($order->paymentType) ? $order->paymentType : 'NOT_SET'
                            ]
                        ]);
                    }
                    
                    $allOrders[] = $order;
                }
            }

            // Add completed orders
            if (isset($orders->completedOrderList)) {
                foreach ($orders->completedOrderList as $order) {
                    $order->status = 'Delivered';
                    $order->statusColor = '#07382F';
                    $allOrders[] = $order;
                }
            }

            // Sort by purchase date in descending order (newest first)
            usort($allOrders, function ($a, $b) {
                $dateA = strtotime($a->createdDate);
                $dateB = strtotime($b->createdDate);
                return $dateB - $dateA;
            });

            // Get pagination parameters
            $start = intval($request->input('start', 0));
            $length = intval($request->input('length', 10));
            $search = $request->input('search.value', '');

            // Apply search filter
            $filteredOrders = $allOrders;
            if (!empty($search)) {
                $filteredOrders = array_filter($allOrders, function ($order) use ($search) {
                    return stripos($order->id, $search) !== false ||
                        stripos($order->status, $search) !== false ||
                        stripos($order->createdDate, $search) !== false;
                });
            }

            // Get total count
            $totalRecords = count($allOrders);
            $filteredRecords = count($filteredOrders);

            // Apply pagination
            $paginatedOrders = array_slice($filteredOrders, $start, $length);

            // Format data for DataTables
            $data = [];
            foreach ($paginatedOrders as $order) {
                // Try different possible field names for payment information
                $paymentStatus = $order->paymentStatus ?? $order->payment_status ?? $order->paymentStatus ?? 'PENDING';
                $paymentDate = $order->paymentDate ?? $order->payment_date ?? $order->paymentDate ?? null;
                $paymentMethod = $order->paymentMethod ?? $order->payment_method ?? $order->paymentType ?? 'PAYPAL_CHECKOUT';
                
                // Handle boolean paymentStatus - convert false to PENDING, true to COMPLETED
                if (is_bool($paymentStatus)) {
                    $paymentStatus = $paymentStatus ? 'COMPLETED' : 'PENDING';
                }
                
                // Capture delivery and deliveryAmount fields
                $delivery = $order->delivery ?? false;
                $deliveryAmount = $order->deliveryAmount ?? $order->delivery_amount ?? null;
                
                // Handle boolean delivery field
                if (is_bool($delivery)) {
                    $delivery = $delivery;
                } else {
                    $delivery = filter_var($delivery, FILTER_VALIDATE_BOOLEAN);
                }
                
                $data[] = [
                    'id' => $order->id,
                    'status' => $order->status,
                    'statusColor' => $order->statusColor,
                    'paymentStatus' => $paymentStatus,
                    'paymentDate' => $paymentDate,
                    'paymentMethod' => $paymentMethod,
                    'createdDate' => $order->createdDate,
                    'numBags' => $order->numBags,
                    'totalPrice' => $order->totalPrice,
                    'formattedPrice' => $helper->formatMoney($order->totalPrice),
                    'delivery' => $delivery,
                    'deliveryAmount' => $deliveryAmount,
                    'formattedDeliveryAmount' => $deliveryAmount ? $helper->formatMoney($deliveryAmount) : null,
                    'actions' => [
                        'track' => route('buyerOrderTracking', $helper->encode($order->id)),
                        'details' => route('buyerOrderDetails', $helper->encode($order->id)),
                        'deliveryQuote' => route('buyerDeliveryQuotes', ['orderId' => $order->id])
                    ]
                ];
            }

            Log::info('Orders data table request completed successfully', [
                'totalRecords' => $totalRecords,
                'filteredRecords' => $filteredRecords,
                'returnedRecords' => count($data),
                'searchTerm' => $search,
                'session_token_used' => substr($session_token, 0, 10) . '...'
            ]);

            return response()->json([
                'draw' => intval($request->input('draw', 1)),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error in orders data table API', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'session_id' => session()->getId(),
                'auth_user_tokin' => session('auth_user_tokin')
            ]);

            return response()->json([
                'draw' => intval($request->input('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'An error occurred while fetching orders. Please try again later.'
            ], 500);
        }
    }
}
