<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PaymentController extends Controller
{
    public function initiate(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Order #' . $order->id,
                        ],
                        'unit_amount' => $order->total_amount * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['order' => $order->id]),
            'cancel_url' => route('payment.cancel', ['order' => $order->id]),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $order->update(['status' => 'completed']);

        return view('payment.success', compact('order'));
    }

    public function cancel(Request $request, $order_id)
    {
        return view('payment.cancel');
    }
}

