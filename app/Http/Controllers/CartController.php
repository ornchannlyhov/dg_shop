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
    public function addToCart(Request $request)
    {
        $product_id = $request->input('product_id');
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

        // Get the updated cart count
        $cartCount = CartItem::where('cart_id', $cart->id)->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart.',
            'cartCount' => $cartCount
        ]);
    }


    // View all carts
    public function viewCarts()
    {
        $carts = Cart::with('cartItems.product')->where('user_id', auth()->id())->get();
        return view('carts', compact('carts'));
    }

    // Review a specific cart
    public function reviewCart($cart_id)
    {
        $cart = Cart::with('cartItems.product')->findOrFail($cart_id);
        return view('cart-review', compact('cart'));
    }

    // Checkout a specific cart
    public function checkout($cart_id)
    {
        $cart = Cart::with('cartItems.product')->findOrFail($cart_id);
        $order = Order::create([
            'user_id' => auth()->id(),
            'store_id' => $cart->store_id,
            'total_amount' => $cart->cartItems->sum(function ($item) {
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

        // Clear the cart after checkout
        $cart->cartItems()->delete();

        return redirect()->route('payment.initiate', ['order' => $order->id]);
    }
}
