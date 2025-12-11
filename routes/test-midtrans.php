<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-midtrans', function () {
    require_once base_path('vendor/midtrans/midtrans-php/Midtrans.php');
    
    $serverKey = config('midtrans.server_key');
    $clientKey = config('midtrans.client_key');
    
    echo "Server Key: " . $serverKey . "<br>";
    echo "Client Key: " . $clientKey . "<br>";
    echo "Is Production: " . (config('midtrans.is_production') ? 'true' : 'false') . "<br><br>";
    
    // Set config
    \Midtrans\Config::$serverKey = $serverKey;
    \Midtrans\Config::$clientKey = $clientKey;
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;
    
    // Test transaction
    $params = [
        'transaction_details' => [
            'order_id' => 'TEST-' . time(),
            'gross_amount' => 10000,
        ],
        'customer_details' => [
            'first_name' => 'Test',
            'email' => 'test@test.com',
            'phone' => '08123456789',
        ],
    ];
    
    try {
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        echo "SUCCESS! Snap Token: " . $snapToken;
    } catch (\Exception $e) {
        echo "ERROR: " . $e->getMessage();
    }
});
