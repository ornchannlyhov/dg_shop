<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Add product to a specific store's cart
    public function addToCart($product_id)
    {
        $product = Product::findOrFail($product_id);
        $store_id = $product->store_id;

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
            'store_id' => $store_id,
        ]);

        CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $product_id],
            ['quantity' => DB::raw('quantity + 1')]
        );

        return redirect()->back()->with('success', 'Product added to cart.');
    }

    // View all carts
    public function viewCarts()
    {
        $carts = Cart::with('items.product')->where('user_id', auth()->id())->get();
        return view('cart.index', compact('carts'));
    }
}
