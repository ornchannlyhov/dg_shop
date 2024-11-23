<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderPlaced;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cart = $this->getCart($user);
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty or does not exist.']);
        }
        $order = $this->createOrder($cart, $request->payment_method);
        $this->createOrderItems($order, $cart);
        $storeOwner = $cart->store->owner;
        Notification::send($storeOwner, new OrderPlaced($order));
        $cart->delete();
        return response()->json([
            'success' => true,
            'redirect_url' => route('payment.process', ['order_id' => $order->id, 'payment_method' => $order->payment_method])
        ]);
    }
    private function getCart($user)
    {
        return Cart::where('user_id', $user->user_id)
            ->with('items.product')
            ->first();
    }
    private function createOrder($cart, $paymentMethod)
    {
        return Order::create([
            'user_id' => $cart->user_id,
            'total_amount' => $cart->items->sum(fn($item) => $item->product->price * $item->quantity),
            'status' => 'pending',
            'payment_method' => $paymentMethod,
        ]);
    }
    private function createOrderItems($order, $cart)
    {
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }
    }
}
