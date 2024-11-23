<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
class CartController extends Controller
{

    public function viewCart()
    {
        $userId = auth()->id();
        $carts = Cart::with('items.product')->where('user_id', $userId)->get();

        // return response()->json();

        return view('carts.index', compact('carts'));
    }

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

    public function update(Request $request, $cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }

        $change = $request->input('change');
        $newQuantity = $cartItem->quantity + $change;

        if ($newQuantity < 1) {
            $cartItem->delete();

            $cart = $cartItem->cart;
            $cartItemCount = CartItem::where('cart_id', $cart->cart_id)->count();

            if ($cartItemCount == 0) {
                $cart->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart.',
                    'removed' => true,
                    'cartRemoved' => true,
                    'cartId' => $cart->cart_id
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart.',
                'removed' => true
            ]);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        $totalPrice = $cartItem->quantity * $cartItem->product->price;

        return response()->json([
            'success' => true,
            'quantity' => $cartItem->quantity,
            'total_price' => $totalPrice,
            'removed' => false
        ]);
    }


}
