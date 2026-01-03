<?php

namespace App\Services;

class MidtransService
{
    public function __construct()
    {
        require_once base_path('vendor/midtrans/midtrans-php/Midtrans.php');

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$clientKey = config('midtrans.client_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized', true);
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds', true);
    }

    public function createTransaction(array $params): string
    {
        return \Midtrans\Snap::getSnapToken($params);
    }

    public function getTransactionStatus(string $orderId): mixed
    {
        return \Midtrans\Transaction::status($orderId);
    }

    public function cancelTransaction(string $orderId): mixed
    {
        return \Midtrans\Transaction::cancel($orderId);
    }

    public function refundTransaction(string $orderId, array $params = []): mixed
    {
        return \Midtrans\Transaction::refund($orderId, $params);
    }
}
