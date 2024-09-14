<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Notifications\OrderPaidNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Notify the seller about an order.
     *
     * @param  int  $order_id
     * @return \Illuminate\Http\Response
     */
    public function notifySeller($order_id)
    {
        try {
            // Find the order
            $order = Order::findOrFail($order_id);

            // Find the seller associated with the order
            $store = $order->store; // Assuming `store` has a relationship with `Order`
            if ($store && $store->owner) {
                $seller = $store->owner; // Assuming `owner` is the seller

                // Send notification
                Notification::send($seller, new OrderPaidNotification($order));

                return response()->json(['message' => 'Notification sent successfully.']);
            } else {
                return response()->json(['message' => 'Seller not found.'], 404);
            }
        } catch (\Exception $e) {
            // Log any exceptions
            Log::error('Notification failed: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to send notification.'], 500);
        }
    }
}