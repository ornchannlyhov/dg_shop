<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartItemController extends Controller
{
    // Update the quantity of a cart item
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'integer|min:1'
        ]);

        try {
            $cartItem = CartItem::findOrFail($cartItemId);
            $cartItem->quantity = $request->input('quantity');
            $cartItem->save();

            return response()->json(['success' => true, 'message' => 'Cart item updated']);
        } catch (\Exception $e) {
            Log::error('Failed to update cart item ID ' . $cartItemId . ': ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to update cart item'], 500);
        }
    }

    // Remove a cart item from the cart
    public function destroy($cartItemId)
    {
        try {
            $cartItem = CartItem::findOrFail($cartItemId);
            $cartItem->delete();

            return response()->json(['success' => true, 'message' => 'Cart item removed']);
        } catch (\Exception $e) {
            Log::error('Failed to remove cart item ID ' . $cartItemId . ': ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to remove cart item'], 500);
        }
    }
}
