<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\Helper;

class CoffeeSupplierController extends Controller
{
    public function getCoffeeSuppliersDataTable(Request $request)
    {
        try {
            $helper = new Helper();

            // Debug session information
            Log::info('CoffeeSupplierController: Session debugging', [
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

            // Get all coffee suppliers using the session token (for fallback and total count)
            $suppliers_list = $helper->hitCoffeePlugGetEndpointWithToken('coffee-suppliers', 'GET', $session_token);

            // Check if we have valid data or if the API call failed
            if (!$suppliers_list || !isset($suppliers_list->statusCode) || $suppliers_list->statusCode != 200) {
                Log::warning('Failed to fetch coffee suppliers from API', [
                    'statusCode' => $suppliers_list->statusCode ?? 'unknown',
                    'response' => $suppliers_list ?? 'null',
                    'endpoint' => env('COFFEEPLUG_BASE_ENDPOINT', 'NOT_SET') . 'coffee-suppliers',
                    'session_token_used' => substr($session_token, 0, 10) . '...'
                ]);

                return response()->json([
                    'draw' => intval($request->input('draw', 1)),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => 'Unable to fetch coffee suppliers at this time. Please check your API configuration.'
                ]);
            }

            // Get pagination parameters
            $start = intval($request->input('start', 0));
            $length = intval($request->input('length', 10));
            $search = $request->input('search.value', '');
            
            // Calculate which page to fetch from the API
            $pageNumber = intval($start / $length);
            $pageSize = $length;
            
            Log::info('DataTable pagination request', [
                'start' => $start,
                'length' => $length,
                'pageNumber' => $pageNumber,
                'pageSize' => $pageSize,
                'search' => $search
            ]);

            // Fetch the specific page from the API based on DataTable pagination
            $apiUrl = 'coffee-suppliers?page=' . $pageNumber . '&size=' . $pageSize;
            Log::info('Fetching specific page from API', ['url' => $apiUrl]);
            
            $pageData = $helper->hitCoffeePlugGetEndpointWithToken($apiUrl, 'GET', $session_token);
            
            if ($pageData && isset($pageData->statusCode) && $pageData->statusCode == 200) {
                if (isset($pageData->data->content) && is_array($pageData->data->content)) {
                    $suppliers = $pageData->data->content;
                    $totalRecords = $pageData->data->totalElements ?? count($suppliers);
                    Log::info('Successfully fetched page ' . $pageNumber, [
                        'suppliersCount' => count($suppliers),
                        'totalRecords' => $totalRecords
                    ]);
                } else {
                    Log::warning('No content in page response', ['response' => $pageData]);
                    $suppliers = [];
                    $totalRecords = 0;
                }
            } else {
                Log::warning('Failed to fetch page ' . $pageNumber, ['response' => $pageData]);
                // Fallback to the first page we already have
                if (isset($suppliers_list->data->content) && is_array($suppliers_list->data->content)) {
                    $suppliers = $suppliers_list->data->content;
                    $totalRecords = $suppliers_list->data->totalElements ?? count($suppliers);
                } else {
                    $suppliers = [];
                    $totalRecords = 0;
                }
            }

            // Apply search filter
            $filteredSuppliers = $suppliers;
            if (!empty($search)) {
                $filteredSuppliers = array_filter($suppliers, function ($supplier) use ($search) {
                    return stripos($supplier->company ?? '', $search) !== false ||
                        stripos($supplier->category ?? '', $search) !== false ||
                        stripos($supplier->city ?? '', $search) !== false ||
                        stripos($supplier->email ?? '', $search) !== false ||
                        stripos($supplier->phone ?? '', $search) !== false;
                });
            }

            // totalRecords is already set from the API response above
            
            // Log what we actually have in suppliers array
            Log::info('Suppliers array details', [
                'suppliers_count' => count($suppliers),
                'suppliers_type' => gettype($suppliers),
                'first_supplier_sample' => isset($suppliers[0]) ? json_encode($suppliers[0]) : 'NO_SUPPLIERS',
                'totalRecords' => $totalRecords,
                'pageNumber' => $pageNumber,
                'pageSize' => $pageSize
            ]);
            
            // For server-side processing, recordsFiltered should be the total number of records that match the search
            // If no search, it should equal recordsTotal
            if (empty($search)) {
                $filteredRecords = $totalRecords;
            } else {
                $filteredRecords = count($filteredSuppliers);
            }

            // For server-side processing, return the current page data
            $paginatedSuppliers = $filteredSuppliers;
            
            // Log pagination details for debugging
            Log::info('Data processing details', [
                'totalRecords' => $totalRecords,
                'filteredRecords' => $filteredRecords,
                'returnedRecords' => count($paginatedSuppliers),
                'searchTerm' => $search,
                'pageNumber' => $pageNumber,
                'pageSize' => $pageSize
            ]);

            // Format data for DataTables
            $data = [];
            foreach ($paginatedSuppliers as $supplier) {
                $data[] = [
                    'id' => $supplier->id ?? 'N/A',
                    'company' => $supplier->company ?? 'N/A',
                    'category' => $supplier->category ?? 'N/A',
                    'street' => $supplier->street ?? '',
                    'city' => $supplier->city ?? '',
                    'state' => $supplier->state ?? '',
                    'zip' => $supplier->zip ?? '',
                    'phone' => $supplier->phone ?? '',
                    'website' => $supplier->website ?? '',
                    'email' => $supplier->email ?? ''
                ];
            }

            Log::info('Coffee suppliers data table request completed successfully', [
                'totalRecords' => $totalRecords,
                'filteredRecords' => $filteredRecords,
                'returnedRecords' => count($data),
                'searchTerm' => $search,
                'session_token_used' => substr($session_token, 0, 10) . '...'
            ]);

            // Prepare the response exactly as DataTables expects for server-side processing
            $response = [
                'draw' => intval($request->input('draw', 1)),
                'recordsTotal' => intval($totalRecords),
                'recordsFiltered' => intval($filteredRecords),
                'data' => $data
            ];

            // Log the final response for debugging
            Log::info('Final DataTable response', [
                'draw' => $response['draw'],
                'recordsTotal' => $response['recordsTotal'],
                'recordsFiltered' => $response['recordsFiltered'],
                'dataCount' => count($response['data']),
                'responseKeys' => array_keys($response)
            ]);

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error in coffee suppliers data table API', [
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
                'error' => 'An error occurred while fetching coffee suppliers. Please try again later.'
            ], 500);
        }
    }
}
