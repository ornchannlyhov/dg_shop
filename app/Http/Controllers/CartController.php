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
        return view('process.cart', compact('carts'));
    }

    public function addToCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'integer|min:1'
        ]);

        try {
            $product = Product::findOrFail($productId);
            $requestedQuantity = $request->input('quantity', 1);

            // Check stock availability
            if ($product->stock_quantity < $requestedQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available.'
                ], 400);
            }

            $store = $product->store;
            $cart = Cart::firstOrCreate([
                'store_id' => $store->store_id,
                'user_id' => auth()->id()
            ]);

            $cartItem = CartItem::where('cart_id', $cart->cart_id)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $requestedQuantity;
                if ($product->stock_quantity < $newQuantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Not enough stock available for the updated quantity.'
                    ], 400);
                }
                $cartItem->quantity = $newQuantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'cart_id' => $cart->cart_id,
                    'product_id' => $productId,
                    'quantity' => $requestedQuantity
                ]);
            }

            $cartCount = CartItem::where('cart_id', $cart->cart_id)->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully.',
                'cartCount' => $cartCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart. Please try again later.'
            ], 500);
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
        $product = $cartItem->product;

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

        if ($product->stock_quantity < $newQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available for the requested quantity.'
            ], 400);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        $totalPrice = $cartItem->quantity * $cartItem->product->price;

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully.',
            'quantity' => $cartItem->quantity,
            'total_price' => $totalPrice,
            'removed' => false
        ]);
    }

}
