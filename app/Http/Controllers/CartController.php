<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Add product to a specific store's cart
    public function addToCart($product_id, Request $request)
    {
        $product = Product::findOrFail($product_id);
        $store_id = $product->store_id;

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
            'store_id' => $store_id,
        ]);

        CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $product_id],
            ['quantity' => DB::raw('quantity + ' . $request->input('quantity', 1))]
        );

        return redirect()->back()->with('success', 'Product added to cart.');
    }

    // View all carts
    public function viewCarts()
    {
        $carts = Cart::with('items.product')->where('user_id', auth()->id())->get();
        return view('carts', compact('carts'));
    }

    // Review a specific cart
    public function reviewCart($cart_id)
    {
        $cart = Cart::with('items.product')->findOrFail($cart_id);
        return view('cart-review', compact('cart'));
    }

    // Checkout a specific cart
    public function checkout($cart_id)
    {
        $cart = Cart::with('items.product')->findOrFail($cart_id);
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

        // Clear the cart after checkout
        $cart->items()->delete();

        return redirect()->route('payment.initiate', ['order' => $order->id]);
    }
}
