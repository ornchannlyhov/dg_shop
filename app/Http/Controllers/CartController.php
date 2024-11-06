<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'integer|min:1'
        ]);

        try {
            $product = Product::findOrFail($productId);
            $store = $product->store;

            $cart = Cart::firstOrCreate([
                'store_id' => $store->store_id,
                'user_id' => auth()->id()
            ]);

            $cartItem = CartItem::where('cart_id', $cart->cart_id)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $request->input('quantity', 1);
                $cartItem->save();
            } else {
                CartItem::create([
                    'cart_id' => $cart->cart_id,
                    'product_id' => $productId,
                    'quantity' => $request->input('quantity', 1)
                ]);
            }

            $cartCount = CartItem::where('cart_id', $cart->cart_id)->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cartCount' => $cartCount
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to add product to cart'], 500);
        }
    }
    public function update(Request $request, $productId)
    {
        $change = $request->input('change');
        $userId = auth()->id();

        $storeId = Product::findOrFail($productId)->store->store_id;

        $cart = Cart::where('user_id', $userId)
            ->where('store_id', $storeId)
            ->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found.']);
        }

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += $change;

            if ($cartItem->quantity <= 0) {
                $cartItem->delete();
            } else {
                $cartItem->save();
            }

            return response()->json(['success' => true, 'message' => 'Cart item updated.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Cart item not found.']);
        }
    }

    public function getCartItems()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();
        return response()->json(['items' => $cart->items]);
    }
}
