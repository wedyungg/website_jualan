<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function receive(Request $request)
    {
        // Set config Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            // Create Notification instance from POST data
            $notification = new Notification();
            
            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraud = $notification->fraud_status;

            Log::info('Midtrans Callback Received:', [
                'order_id' => $orderId,
                'status' => $transaction,
                'type' => $type,
                'fraud' => $fraud,
                'payload' => $notification->toArray()
            ]);

            // Extract booking ID from order_id (format: FKS-{id}-{timestamp})
            $parts = explode('-', $orderId);
            if (count($parts) < 2) {
                Log::error('Invalid order_id format: ' . $orderId);
                return response()->json(['message' => 'Invalid order ID format'], 400);
            }

            $bookingId = $parts[1];
            $booking = Booking::find($bookingId);

            if (!$booking) {
                Log::error('Booking not found: ' . $bookingId);
                return response()->json(['message' => 'Booking not found'], 404);
            }

            // Update status berdasarkan notifikasi
            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $booking->update(['status' => Booking::STATUS_PENDING]);
                    } else {
                        $booking->update(['status' => Booking::STATUS_CONFIRMED]);
                    }
                }
            } elseif ($transaction == 'settlement') {
                $booking->update(['status' => Booking::STATUS_CONFIRMED]);
            } elseif ($transaction == 'pending') {
                $booking->update(['status' => Booking::STATUS_PENDING]);
            } elseif ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
                $booking->update(['status' => Booking::STATUS_CANCELLED]);
            } elseif ($transaction == 'refund' || $transaction == 'partial_refund') {
                $booking->update(['status' => Booking::STATUS_REFUNDED]);
            }

            Log::info('Booking status updated:', [
                'booking_id' => $booking->id,
                'old_status' => $booking->getOriginal('status'),
                'new_status' => $booking->status,
                'transaction' => $transaction
            ]);

            return response()->json(['message' => 'Callback processed successfully']);

        } catch (\Exception $e) {
            Log::error('Callback Error: ' . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    // Untuk testing callback (GET request)
    public function testCallback($bookingId)
    {
        $booking = Booking::find($bookingId);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        return view('test_callback', compact('booking'));
    }
}