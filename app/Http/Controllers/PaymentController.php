<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Notifications\OrderPaidNotification;
use Illuminate\Support\Facades\Notification;

class PaymentController extends Controller
{
    public function initiatePayment($order_id)
    {
        $order = Order::findOrFail($order_id);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // Create a Checkout Session
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Order #' . $order->id,
                    ],
                    'unit_amount' => $order->total_amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['order' => $order_id]),
            'cancel_url' => route('payment.cancel', ['order' => $order_id]),
        ]);

        return redirect($session->url, 303);
    }

    public function paymentSuccess($order_id)
    {
        $order = Order::findOrFail($order_id);
        $order->update(['status' => 'paid']);

        $seller = $order->seller; 
        if ($seller) {
            Notification::send($seller, new OrderPaidNotification($order));
        }

        return redirect()->route('orders.show', $order_id)->with('success', 'Payment successful.');
    }

    public function paymentCancel($order_id)
    {
        return redirect()->route('orders.show', $order_id)->with('error', 'Payment canceled.');
    }
}
