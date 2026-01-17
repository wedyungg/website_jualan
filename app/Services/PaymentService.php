<?php

namespace App\Services;

use App\Models\Booking;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public static function createPayment(Booking $booking)
    {
        // Setup Midtrans
        self::setupMidtrans();
        
        // Prepare transaction params
        $params = self::prepareTransactionParams($booking);
        
        // Debug: Log the params
        Log::debug('Midtrans Payment Params:', $params);
        
        try {
            $snapToken = Snap::getSnapToken($params);
            Log::info('Snap Token generated for booking: ' . $booking->id);
            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans Error Details:', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
                'params' => $params,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    
    private static function setupMidtrans()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
        
        if (!Config::$isProduction) {
            Config::$curlOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ];
        }
    }
    
    private static function prepareTransactionParams(Booking $booking)
    {
        $user = auth()->user();
        
        // Format harga harus integer tanpa desimal
        $grossAmount = (int) round($booking->total_price);
        
        // Clean item name
        $itemName = preg_replace('/[^\w\s\-]/', '', $booking->package->name);
        $itemName = substr($itemName, 0, 50);
        
        // Pastikan semua field required ada
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $booking->id . '-' . time(),
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => substr($user->name, 0, 100),
                'email' => $user->email,
                'phone' => $user->phone ?? '08123456789',
            ],
            'item_details' => [
                [
                    'id' => 'ITEM-' . $booking->package->id,
                    'price' => $grossAmount,
                    'quantity' => 1,
                    'name' => $itemName ?: 'Photography Package',
                ]
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
                'error' => route('payment.error'),
                'pending' => route('payment.pending'),
            ]
        ];
        
        // Validasi: gross_amount harus sama dengan price * quantity
        $totalItems = 0;
        foreach ($params['item_details'] as $item) {
            $totalItems += ($item['price'] * $item['quantity']);
        }
        
        if ($params['transaction_details']['gross_amount'] != $totalItems) {
            Log::warning('Gross amount mismatch', [
                'gross_amount' => $params['transaction_details']['gross_amount'],
                'items_total' => $totalItems
            ]);
            // Adjust gross amount
            $params['transaction_details']['gross_amount'] = $totalItems;
        }
        
        return $params;
    }
}