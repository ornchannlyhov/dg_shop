<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderPlaced;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product')->firstOrFail();
        $order = Order::create([
            'user_id' => auth()->id(),
            'store_id' => $cart->store_id,
            'total_amount' => $cart->items->sum(function($item) {
                return $item->product->price * $item->quantity;
            }),
            'status' => 'pending',
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $cart->items()->delete();

        // Notify the seller
        $storeOwner = $cart->store->owner;
        Notification::send($storeOwner, new OrderPlaced($order));

        return redirect()->route('payment.initiate', ['order' => $order->id]);
    }
}

