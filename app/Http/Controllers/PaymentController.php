<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function processPayment(Request $request, $order_id)
    {
        $order = Order::where('order_id', $order_id)->firstOrFail();

        switch ($order->payment_method) {
            case 'stripe':
                return $this->processStripePayment($order);
            case 'aba':
                return $this->processABA($order);
            case 'cash_on_delivery':
                return $this->processCashOnDelivery($order);
            default:
                return redirect()->back()->with('error', 'Invalid payment method.');
        }
    }

    private function processStripePayment(Order $order)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => 'Order #' . $order->order_id],
                        'unit_amount' => $order->total_amount * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['order_id' => $order->order_id]),
            'cancel_url' => route('payment.cancel', ['order_id' => $order->order_id]),
        ]);

        return redirect($session->url);
    }

    private function processABA(Order $order)
    {
        $order->update(['status' => 'completed']);
        return redirect()->route('payment.success', ['order_id' => $order->order_id]);
    }

    private function processCashOnDelivery(Order $order)
    {
        $order->update(['status' => 'completed']);
        return redirect()->route('payment.success', ['order_id' => $order->order_id]);
    }
}
