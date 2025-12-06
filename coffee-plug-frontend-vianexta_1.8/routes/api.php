<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\VoiceflowController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/chat', [ChatController::class, 'chat']);

// Voiceflow webhook endpoints
Route::post('/voiceflow/products', [VoiceflowController::class, 'getProducts']);
Route::post('/voiceflow/user-details', [VoiceflowController::class, 'getUserDetails']);
Route::post('/voiceflow/send-email', [VoiceflowController::class, 'sendEmail']);
// Webhook route for product purchase
Route::post('/webhook/product-purchase', [WebhookController::class, 'handleProductPurchase']);
// Webhook route for single order placement
Route::post('/webhook/single-order', [WebhookController::class, 'handleSingleOrder']);

// Orders data table endpoint moved to web.php for session authentication

// Newsletter subscription check endpoint
Route::get('/check-subscription', [App\Http\Controllers\HomeController::class, 'checkSubscription']);

// Checkout API endpoints
Route::post('/checkout-cart', [CheckoutController::class, 'checkoutCart']);
Route::post('/direct-order', [CheckoutController::class, 'directOrder']);

// Payment API endpoints
Route::post('/payment/regenerate-link/{orderId}', [PaymentController::class, 'regeneratePaymentLink']);

// Delivery quote selection endpoint
Route::post('/select-delivery-quote', [CheckoutController::class, 'selectDeliveryQuote']);