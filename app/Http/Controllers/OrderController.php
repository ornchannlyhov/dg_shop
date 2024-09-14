<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // Checkout process for a specific cart
    public function index()
    {
        // Fetch all orders (or add any specific logic you need)
        $orders = Order::all(); 

        // Return the view with orders data
        return view('orders.index', compact('orders'));
    }
    public function checkout($cart_id)
    {
        $cart = Cart::with('items.product')->findOrFail($cart_id);

        $order = Order::create([
            'user_id' => auth()->id(),
            'store_id' => $cart->store_id,
            'total_amount' => $cart->cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            }),
            'status' => 'pending',
        ]);

        foreach ($cart->cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $cart->items()->delete();

        return redirect()->route('payment.initiate', ['order' => $order->id]);
    }
}

