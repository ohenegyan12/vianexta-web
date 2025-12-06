<?php

/**
 * PayPal Testing Script
 * Run this from your project root to test PayPal routes
 * 
 * Usage: php test_paypal.php
 */

echo "🧪 PayPal Payment Testing Script\n";
echo "================================\n\n";

// Test URLs
$baseUrl = 'http://localhost'; // Change this to your local domain
$testUrls = [
    'PayPal Test Page' => $baseUrl . '/paypal/test',
    'PayPal Test Success' => $baseUrl . '/paypal/test-success',
    'PayPal Success Page (New)' => $baseUrl . '/paypal/test-success-page',
    'PayPal Failure Page (New)' => $baseUrl . '/paypal/test-failure-page',
    'PayPal Failed Page (New)' => $baseUrl . '/paypal/test-failed-page',
    'PayPal Error Page (New)' => $baseUrl . '/paypal/test-error-page',
    'PayPal Success with Mock Data' => $baseUrl . '/paypal/payment/success?token=TEST_TOKEN_123&PayerID=TEST_PAYER_456',
    'PayPal Success (No Params)' => $baseUrl . '/paypal/payment/success',
    'PayPal Failed Route' => $baseUrl . '/paypal/payment/failed',
    'PayPal Error Route' => $baseUrl . '/paypal/payment/error',
    'PayPal Debug' => $baseUrl . '/paypal/debug',
    'Cart Checkout' => $baseUrl . '/cartCheckout',
];

echo "📋 Available Test URLs:\n";
echo "------------------------\n";
foreach ($testUrls as $name => $url) {
    echo sprintf("%-30s: %s\n", $name, $url);
}

echo "\n🚀 Quick Test Commands:\n";
echo "------------------------\n";
echo "1. Open PayPal Test Page: " . $testUrls['PayPal Test Page'] . "\n";
echo "2. Test PayPal Success: " . $testUrls['PayPal Test Success'] . "\n";
echo "3. Check PayPal Config: " . $testUrls['PayPal Debug'] . "\n";

echo "\n📝 Testing Instructions:\n";
echo "------------------------\n";
echo "1. Make sure your Laravel app is running\n";
echo "2. Ensure you're logged in (check session)\n";
echo "3. Visit the test page to simulate payments\n";
echo "4. Check logs at storage/logs/laravel.log\n";
echo "5. Monitor browser network tab for redirects\n";

echo "\n🔍 Common Issues to Check:\n";
echo "---------------------------\n";
echo "• User authentication (session 'auth_user_tokin')\n";
echo "• PayPal API credentials in .env file\n";
echo "• Route definitions in web.php\n";
echo "• PayPal configuration in config/paypal.php\n";
echo "• Laravel logs for detailed error messages\n";

echo "\n✅ Ready to test! Open your browser and start with the test page.\n";
