<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function createTransaction(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|string',
            'gross_amount' => 'required|numeric|min:1',
            'first_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'item_details' => 'required|array',
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $request->order_id,
                'gross_amount' => $request->gross_amount,
            ],
            'customer_details' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name ?? '',
                'email' => $request->email,
                'phone' => $request->phone,
            ],
            'item_details' => $request->item_details,
        ];

        try {
            $snapToken = $this->midtransService->createTransaction($params);
            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function handleCallback(Request $request): JsonResponse
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;
        $fraudStatus = $request->fraud_status ?? null;

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                // Payment successful
            }
        } elseif ($transactionStatus == 'settlement') {
            // Payment successful
        } elseif ($transactionStatus == 'pending') {
            // Payment pending
        } elseif ($transactionStatus == 'deny') {
            // Payment denied
        } elseif ($transactionStatus == 'expire') {
            // Payment expired
        } elseif ($transactionStatus == 'cancel') {
            // Payment cancelled
        }

        return response()->json(['message' => 'OK']);
    }

    public function getTransactionStatus(string $orderId): JsonResponse
    {
        try {
            $status = $this->midtransService->getTransactionStatus($orderId);
            return response()->json([
                'success' => true,
                'data' => $status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
