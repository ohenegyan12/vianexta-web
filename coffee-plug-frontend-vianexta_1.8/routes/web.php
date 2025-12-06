<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return redirect()->route('welcome');
    return redirect()->route('home_page');
});

Route::get('/check_passcode', function () {
    return redirect()->route('home_page');
});

Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');
Route::post('/check_passcode', [App\Http\Controllers\HomeController::class, 'check_passcode'])->name('check_passcode');
Route::post('/send_invite_code', [App\Http\Controllers\HomeController::class, 'sendInviteCode'])->name('send_invite_code');


Route::get('/home_page', function () {
    return view('new_web_pages.home.new_landing_page');
})->name('home_page');
Route::get('/login', [App\Http\Controllers\HomeController::class, 'get_started'])->name('login');
Route::get('/login_page', [App\Http\Controllers\HomeController::class, 'login_page'])->name('login_page');
Route::get('/languages', [App\Http\Controllers\HomeController::class, 'languages'])->name('languages');
Route::get('/account_type', [App\Http\Controllers\HomeController::class, 'account_type'])->name('account_type');
Route::get('/register_step_1', [App\Http\Controllers\HomeController::class, 'register_step_1'])->name('register_step_1');
Route::get('/register_step_2', [App\Http\Controllers\HomeController::class, 'register_step_2'])->name('register_step_2');
Route::get('/marketplace_buyer', [App\Http\Controllers\BuyerController::class, 'buyer_market_place'])->name('marketplace_buyer');
Route::get('/get_product/{id}', [App\Http\Controllers\HomeController::class, 'get_product'])->name('get_product');
Route::get('/product_details', [App\Http\Controllers\HomeController::class, 'product_details'])->name('product_details');
Route::get('/work_with_us', [App\Http\Controllers\HomeController::class, 'work_with_us'])->name('work_with_us');
Route::get('/join_team', [App\Http\Controllers\HomeController::class, 'join_team'])->name('join_team');
Route::get('/buyer_dashboard', [App\Http\Controllers\HomeController::class, 'buyer_dashboard'])->name('buyer_dashboard');
Route::get('/recommend', [App\Http\Controllers\HomeController::class, 'recommend'])->name('recommend');
Route::post('/saveRecommend', [App\Http\Controllers\HomeController::class, 'save_recommend'])->name('saveRecommend');
//News letter
Route::post('/saveNewLetter', [App\Http\Controllers\HomeController::class, 'saveNewLetter'])->name('saveNewLetter');
Route::post('/logout', [App\Http\Controllers\Auth\ManualLoginController::class, 'logout'])->name('logout');
Route::get('/logout', [App\Http\Controllers\Auth\ManualLoginController::class, 'logout'])->name('logout.get');

//Get Coffee Prices
Route::get('/getCoffeePrice', [App\Http\Controllers\HomeController::class, 'getCoffeePrice'])->name('getCoffeePrice');
Route::get('/priceDashboard', [App\Http\Controllers\HomeController::class, 'priceDashboard'])->name('priceDashboard');
Route::get('/account_dashboard', [App\Http\Controllers\HomeController::class, 'account_dashboard'])->name('account_dashboard');

Route::get('/help', [App\Http\Controllers\HomeController::class, 'help'])->name('help');

Route::get('/chat-with-clare', [App\Http\Controllers\HomeController::class, 'chatWithClare'])->name('chat-with-clare');

Route::get('/process', [App\Http\Controllers\HomeController::class, 'process'])->name('process');
Route::get('/order_history', [App\Http\Controllers\HomeController::class, 'order_history'])->name('order_history');

//Authentication routes
Route::post('/manualLogin', [App\Http\Controllers\Auth\ManualLoginController::class, 'triggerLogin'])->name('manualLogin');
Route::post('/passwordResetEmail', [App\Http\Controllers\Auth\ManualLoginController::class, 'passwordResetEmail'])->name('passwordResetEmail');
Route::post('/new-password', [App\Http\Controllers\Auth\ManualLoginController::class, 'newPassword'])->name('new-password');
Route::get('/reset-password/{link}/{email}', [App\Http\Controllers\Auth\ManualLoginController::class, 'resetPassword'])->name('reset-password');

// Session management route
Route::post('/clear-sessions', function () {
    session()->forget('error');
    session()->forget('success');
    return response()->json(['success' => true]);
})->name('clear-sessions');

// Test route for debugging session issues
Route::get('/test-error-session', function () {
    session(['error' => 'Test error message for debugging']);
    return redirect()->route('login_page');
})->name('test-error-session');

Route::post('/saveLanguage', [App\Http\Controllers\Auth\ManualRegistrationController::class, 'saveLanguage'])->name('saveLanguage');
Route::post('/saveAccountType', [App\Http\Controllers\Auth\ManualRegistrationController::class, 'saveAccountType'])->name('saveAccountType');
Route::post('/savePersonalData', [App\Http\Controllers\Auth\ManualRegistrationController::class, 'savePersonalData'])->name('savePersonalData');
Route::post('/saveBusinessData', [App\Http\Controllers\Auth\ManualRegistrationController::class, 'saveBusinessData'])->name('saveBusinessData');
Route::post('/saveAccountDetails', [App\Http\Controllers\Auth\ManualRegistrationController::class, 'saveAccountDetails'])->name('saveAccountDetails');

//Purchase routes
Route::post('/saveCartItem', [App\Http\Controllers\PurchaseController::class, 'saveCartItem'])->name('saveCartItem');
Route::get('/buyer_cart', [App\Http\Controllers\PurchaseController::class, 'buyer_cart'])->name('buyer_cart');
Route::get('/shoppingCart', [App\Http\Controllers\PurchaseController::class, 'buyer_cart'])->name('shoppingCart');
Route::get('/order_tracking', [App\Http\Controllers\PurchaseController::class, 'order_tracking'])->name('order_tracking');
Route::get('/checkout', [App\Http\Controllers\PurchaseController::class, 'checkout'])->name('checkout');
Route::get('/purchases/{id}', [App\Http\Controllers\PurchaseController::class, 'purchases'])->name('purchases');
Route::get('/productPurchasesHistory/{id}', [App\Http\Controllers\PurchaseController::class, 'product_purchases_history'])->name('productPurchasesHistory');
// Route::get('/editOrder/{link}', [App\Http\Controllers\PurchaseController::class, 'edit_order'])->name('editOrder');
Route::post('/editOrder', [App\Http\Controllers\PurchaseController::class, 'edit_order'])->name('editOrder');
Route::get('/editOrderPage', [App\Http\Controllers\PurchaseController::class, 'edit_order_page'])->name('editOrderPage');
Route::post('/updateOrder', [App\Http\Controllers\PurchaseController::class, 'update_order'])->name('updateOrder');
Route::get('/deleteOrder/{id}', [App\Http\Controllers\PurchaseController::class, 'delete_order'])->name('deleteOrder');

// Buyer profile endpoint
Route::get('/buyer-profile', [App\Http\Controllers\BuyerController::class, 'buyer_profile_endpoint'])->name('buyerProfile');
Route::get('/cartCheckout', [App\Http\Controllers\PurchaseController::class, 'show_checkout'])->name('cartCheckout.show');
Route::post('/cartCheckout', [App\Http\Controllers\PurchaseController::class, 'cart_checkout'])->name('cartCheckout');
Route::get('/buyer-delivery-quotes', [App\Http\Controllers\PurchaseController::class, 'buyer_delivery_quotes'])->name('buyerDeliveryQuotes');

// US Cities and Zipcodes endpoints
Route::get('/api/us-cities', [App\Http\Controllers\PurchaseController::class, 'getUSCities'])->name('api.usCities');
Route::get('/api/us-zipcodes', [App\Http\Controllers\PurchaseController::class, 'getUSZipcodes'])->name('api.usZipcodes');

// Orders data table endpoint - moved from api.php to use session authentication
Route::get('/orders/datatable', [App\Http\Controllers\Api\OrderController::class, 'getOrdersDataTable'])->name('api.orders.datatable');

// Coffee suppliers data table endpoint
Route::get('/coffee-suppliers/datatable', [App\Http\Controllers\Api\CoffeeSupplierController::class, 'getCoffeeSuppliersDataTable'])->name('api.coffee-suppliers.datatable');


// Test route to verify session functionality
Route::get('/test-session', function () {
    return response()->json([
        'session_id' => session()->getId(),
        'auth_user_tokin' => session('auth_user_tokin'),
        'auth_user_name' => session('auth_user_name'),
        'session_status' => session()->isStarted(),
        'cookies' => request()->cookies->all()
    ]);
})->name('test.session');

//product routes
Route::post('/filterProduct', [App\Http\Controllers\ProductController::class, 'filter_product'])->name('filterProduct');
Route::post('/filterMultiProduct', [App\Http\Controllers\ProductController::class, 'filter_multi_product'])->name('filterMultiProduct');

// NEW UI ROUTES
Route::get('/new_home', function () {
    return redirect()->route('home_page');
})->name('new_home');
Route::get('/getStarted', [App\Http\Controllers\HomeController::class, 'get_started'])->name('getStarted');
Route::get('/ourTeam', [App\Http\Controllers\HomeController::class, 'our_team'])->name('ourTeam');
Route::post('/saveProfile', [App\Http\Controllers\HomeController::class, 'save_profile'])->name('saveProfile');
Route::post('/resetPassword', [App\Http\Controllers\HomeController::class, 'reset_password'])->name('resetPassword');

Route::get('/getWheelData', [App\Http\Controllers\HomeController::class, 'getWheelData'])->name('getWheelData');

//Seller Routes
Route::get('/sellers_landing', [App\Http\Controllers\SellerController::class, 'sellers_landing'])->name('sellers_landing');
Route::get('/sellers_add_product', [App\Http\Controllers\SellerController::class, 'sellers_add_product'])->name('sellers_add_product');
Route::get('/sellersProductPreview', [App\Http\Controllers\SellerController::class, 'sellers_product_preview'])->name('sellers_product_preview');
Route::get('/sellersDashboardHome', [App\Http\Controllers\SellerController::class, 'sellers_dashboard_home'])->name('sellersDashboardHome');
Route::get('/sellersProductPage', [App\Http\Controllers\SellerController::class, 'sellers_product_page'])->name('sellersProductPage');
Route::post('/sellersSaveProduct', [App\Http\Controllers\SellerController::class, 'sellers_save_product'])->name('sellersSaveProduct');
Route::get('/sellersOrderDetails/{id}', [App\Http\Controllers\SellerController::class, 'sellers_order_details'])->name('sellersOrderDetails');
Route::get('/sellerAccountPage', [App\Http\Controllers\SellerController::class, 'sellers_account_page'])->name('sellerAccountPage');
Route::get('/deleteProduct/{id}', [App\Http\Controllers\SellerController::class, 'delete_product'])->name('deleteProduct');
Route::get('/deactivateProduct/{id}', [App\Http\Controllers\SellerController::class, 'deactivate_product'])->name('deactivateProduct');
Route::get('/reactivateProduct/{id}', [App\Http\Controllers\SellerController::class, 'reactivate_product'])->name('reactivateProduct');
Route::get('/editProduct/{id}', [App\Http\Controllers\SellerController::class, 'sellers_edit_product'])->name('editProduct');
Route::get('/viewProduct/{id}', [App\Http\Controllers\SellerController::class, 'sellers_view_product'])->name('viewProduct');

// Admin Routes
Route::get('/roastersListPage', [App\Http\Controllers\SellerController::class, 'roasters_list_page'])->name('roastersListPage');
Route::get('/caffeesListPage', [App\Http\Controllers\SellerController::class, 'caffees_list_page'])->name('caffeesListPage');
Route::get('/producersListPage', [App\Http\Controllers\SellerController::class, 'producers_list_page'])->name('producersListPage');
Route::get('/retailersListPage', [App\Http\Controllers\SellerController::class, 'retailers_list_page'])->name('retailersListPage');
Route::get('/coffeeSuppliersListPage', [App\Http\Controllers\SellerController::class, 'coffee_suppliers_list_page'])->name('coffeeSuppliersListPage');
Route::get('/roasterOrdersListPage', [App\Http\Controllers\SellerController::class, 'roast_orders'])->name('roasterOrdersListPage');
Route::get('/delivery-quotes', [App\Http\Controllers\SellerController::class, 'delivery_quotes'])->name('deliveryQuotes');
Route::get('/asignedOrdersListPage', [App\Http\Controllers\SellerController::class, 'asigned_roast_orders'])->name('asignedOrdersListPage');
Route::get('/roasterPendingOrders/{id}', [App\Http\Controllers\SellerController::class, 'roaster_pending_orders'])->name('roasterPendingOrders');
Route::post('/asignOrderToRoaster', [App\Http\Controllers\SellerController::class, 'asign_order_to_roaster'])->name('asignOrderToRoaster');

Route::get('/manualRegUsers', [App\Http\Controllers\Auth\ManualRegistrationController::class, 'manualRegUsers'])->name('manualRegUsers');


// Buyer Routes
// Route::get('/buyerMarketPlace', [App\Http\Controllers\BuyerController::class, 'buyer_new_wizard'])->name('buyer_market_place');
Route::get('/buyerMarketPlace', [App\Http\Controllers\BuyerController::class, 'new_buyer_wizard'])->name('buyer_market_place');
Route::get('/buyerGreenMarketPlace', [App\Http\Controllers\BuyerController::class, 'buyer_market_place'])->name('buyerGreenMarketPlace');
Route::get('/buyerWholeMarketPlace', [App\Http\Controllers\BuyerController::class, 'buyer_whole_market_place'])->name('buyerWholeMarketPlace');
Route::get('/buyerBrandMarketplace/{id}', [App\Http\Controllers\BuyerController::class, 'buyer_brand_market_place'])->name('buyerBrandMarketplace');

Route::get('/buyers_landing', [App\Http\Controllers\BuyerController::class, 'buyers_landing'])->name('buyers_landing');
Route::get('/productDetails', [App\Http\Controllers\BuyerController::class, 'product_details'])->name('productDetails');
Route::get('/shopingCart', [App\Http\Controllers\BuyerController::class, 'shoping_cart'])->name('shopingCart');
Route::post('/farmerProfile', [App\Http\Controllers\BuyerController::class, 'farmer_profile'])->name('farmerProfile');
Route::get('/buyerOrderTracking/{id}', [App\Http\Controllers\BuyerController::class, 'buyer_order_tracking'])->name('buyerOrderTracking');
Route::get('/buyerAccountPage', [App\Http\Controllers\BuyerController::class, 'buyer_account_page'])->name('buyerAccountPage');
Route::get('/buyerOrderHistory', [App\Http\Controllers\BuyerController::class, 'buyer_order_history'])->name('buyerOrderHistory');
Route::get('/buyerWishlist', [App\Http\Controllers\BuyerController::class, 'buyer_wishlist'])->name('buyerWishlist');
Route::get('/buyerDashboard', [App\Http\Controllers\BuyerController::class, 'buyer_dashboard'])->name('buyerDashboard');
Route::get('/buyerCheckout', [App\Http\Controllers\BuyerController::class, 'buyer_checkout'])->name('buyerCheckout');
Route::get('/buyerOrderDetails/{id}', [App\Http\Controllers\BuyerController::class, 'buyer_order_details'])->name('buyerOrderDetails');
Route::get('/buyerWizardSuccess/{quantity}/{stockpostingid}', [App\Http\Controllers\BuyerController::class, 'buyer_wizard_success'])->name('buyerWizardSuccess');
Route::get('/buyerOrderOptions/{option}/{value}', [App\Http\Controllers\BuyerController::class, 'buyer_order_option_set'])->name('buyerOrderOptions');

// Route::get('/buyerNewWizard', [App\Http\Controllers\BuyerController::class, 'buyer_new_wizard'])->name('buyer_new_wizard');
Route::get('/buyerNewWizard', [App\Http\Controllers\BuyerController::class, 'new_buyer_wizard'])->name('buyer_new_wizard');
Route::get('/new-buyer-wizard', [App\Http\Controllers\BuyerController::class, 'new_buyer_wizard'])->name('new_buyer_wizard');
Route::post('/get-wizard-products', [App\Http\Controllers\BuyerController::class, 'get_wizard_products'])->name('get_wizard_products');
Route::post('/test-wizard-endpoint', [App\Http\Controllers\BuyerController::class, 'test_wizard_endpoint'])->name('test_wizard_endpoint');
Route::post('/save-wholesale-selections', [App\Http\Controllers\BuyerController::class, 'save_wholesale_selections'])->name('save_wholesale_selections');
Route::post('/save-selected-wholesale-product', [App\Http\Controllers\BuyerController::class, 'save_selected_wholesale_product'])->name('save_selected_wholesale_product');
Route::get('/proxy-image', [App\Http\Controllers\BuyerController::class, 'proxyImage'])->name('proxy_image');


Route::post('/uploadbaglogo', [App\Http\Controllers\BuyerController::class, 'buyer_upload_bag_logo'])->name('uploadbaglogo');
Route::get('/get-bag-image-url', [App\Http\Controllers\BuyerController::class, 'get_bag_image_url'])->name('get_bag_image_url');
Route::get('/logoSuccessUpload', [App\Http\Controllers\BuyerController::class, 'buyer_logo_success_upload'])->name('logoSuccessUpload');


Route::get('paypal', [App\Http\Controllers\PayPalController::class, 'index'])->name('paypal');
Route::post('paypal/payment', [App\Http\Controllers\PayPalController::class, 'payment'])->name('paypal.payment');
Route::get('paypal/payment/success', [App\Http\Controllers\PayPalController::class, 'paymentSuccess'])->name('paypal.payment.success');
Route::get('paypal/payment/cancel', [App\Http\Controllers\PayPalController::class, 'paymentCancel'])->name('paypal.payment/cancel');
Route::get('paypal/payment/failed', [App\Http\Controllers\PayPalController::class, 'paymentFailed'])->name('paypal.payment.failed');
Route::get('paypal/payment/error', [App\Http\Controllers\PayPalController::class, 'paymentError'])->name('paypal.payment.error');

// Test route for simulating PayPal success (for development/testing only)
Route::get('paypal/test-success', [App\Http\Controllers\PayPalController::class, 'testPaymentSuccess'])->name('paypal.test.success');

// Test routes for new payment pages
Route::get('paypal/test-success-page', function () {
    return view('payment.paypal_success', ['transactionId' => 'TEST_' . time()]);
})->name('paypal.test.success.page');

Route::get('paypal/test-failure-page', function () {
    return view('payment.paypal_failure', [
        'errorType' => 'failed',
        'errorMessage' => 'This is a test failure page'
    ]);
})->name('paypal.test.failure.page');

Route::get('paypal/test-failed-page', function () {
    return view('payment.paypal_failed', [
        'errorMessage' => 'This is a test failed page'
    ]);
})->name('paypal.test.failed.page');

Route::get('paypal/test-error-page', function () {
    return view('payment.paypal_error', [
        'errorMessage' => 'This is a test error page',
        'technicalDetails' => 'Error Code: TEST_001\nTimestamp: ' . now() . '\nUser Agent: ' . request()->userAgent()
    ]);
})->name('paypal.test.error.page');

// PayPal testing page
Route::get('paypal/test', function () {
    return view('test_paypal');
})->name('paypal.test.page');

// PayPal debug route (development/testing only)
Route::get('paypal/debug', [App\Http\Controllers\PayPalController::class, 'debugPayPal'])->name('paypal.debug');

// Debug route to test URL generation
Route::get('paypal/debug-urls', function () {
    return response()->json([
        'return_url' => route('paypal.payment.success'),
        'cancel_url' => route('paypal.payment.cancel'),
        'app_url' => config('app.url'),
        'current_domain' => request()->getHost(),
        'current_port' => request()->getPort(),
        'current_scheme' => request()->getScheme(),
        'full_url' => request()->fullUrl(),
        'base_url' => url('/'),
        'route_url' => url('paypal/payment/success')
    ]);
})->name('paypal.debug.urls');

// Simple test route to show PayPal URLs
Route::get('paypal/test-urls', function () {
    echo "<h2>PayPal URL Test</h2>";
    echo "<p><strong>Return URL:</strong> " . route('paypal.payment.success') . "</p>";
    echo "<p><strong>Cancel URL:</strong> " . route('paypal.payment.cancel') . "</p>";
    echo "<p><strong>App URL:</strong> " . config('app.url') . "</p>";
    echo "<p><strong>Current Domain:</strong> " . request()->getHost() . "</p>";
    echo "<p><strong>Current Port:</strong> " . request()->getPort() . "</p>";
    echo "<p><strong>Base URL:</strong> " . url('/') . "</p>";
    echo "<p><strong>Full Request URL:</strong> " . request()->fullUrl() . "</p>";
});

// CoffeePLUG Routes
// Route::get('/coffee-plug', function () {
//     return view('new_web_pages.home.coffee_plug');
// })->name('coffee_plug');

// Add after other new UI routes
Route::get('/new_landing', [App\Http\Controllers\HomeController::class, 'new_landing'])->name('new_landing');

// New Landing Page Route
Route::get('/new_landing_page', function () {
    return view('new_web_pages.home.new_landing_page');
})->name('new_landing_page');

// Test Route
Route::get('/test', function () {
    return view('test');
})->name('test');

