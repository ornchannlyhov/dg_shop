<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Store;
use App\Models\Seller;
use App\Models\Product;
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
            'redirect_url' => route('payment.process', ['order_id' => $order->order_id, 'payment_method' => $order->payment_method])
        ]);
    }
    public function cancelOrder($orderId)
    {
        $user = auth()->user();
        $order = Order::where('order_id', $orderId)
            ->where('user_id', $user->user_id)
            ->first();
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
        }
        if ($order->status === 'shipped') {
            return response()->json(['success' => false, 'message' => 'Cannot cancel a shipped order.'], 400);
        }
        $order->status = 'canceled';
        $order->save();
        return response()->json(['success' => true, 'message' => 'Order cancelled successfully.']);
    }
    public function confirmOrder($orderId)
    {
        $user = auth()->user();
        $storeOwner = Seller::where('user_id', $user->user_id)->first();
        if (!$storeOwner) {
            return response()->json(['success' => false, 'message' => 'You are not authorized to manage this store.'], 403);
        }
        $ordersForStore = Order::where('store_id', $storeOwner->store_id)->get();
        $order = $ordersForStore->firstWhere('order_id', $orderId);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found or you do not have permission to manage it.'], 404);
        }
        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Only pending orders can be accepted.'], 400);
        }
        $order->status = 'shipped';
        $order->save();
        foreach ($order->items as $orderItem) {
            $product = Product::find($orderItem->product_id);
            if ($product) {
                $product->stock_quantity -= $orderItem->quantity;
                if ($product->quantity < 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Not enough stock available for the product: ' . $product->name
                    ], 400);
                }
                $product->save();
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Order has been accepted and products quantities updated successfully.',
            'store_orders' => $ordersForStore,
        ]);
    }

    public function getOrderForUser()
    {
        $user = auth()->user();
        $orders = Order::with(['items.product', 'store'])
            ->where('user_id', $user->user_id)
            ->get();

        return view('process.order', compact('orders'));
    }
    public function getOrdersForStore(Request $request, $storeId)
    {
        $query = Order::where('store_id', $storeId);
        $status = $request->query('status');
        if ($status) {
            $query->where('status', $status);
        }
        $ordersForStore = $query->get();
        $store = Store::findOrFail($storeId);

        return view('stores.orders', compact('ordersForStore', 'store', 'status'));
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
            'store_id' => $cart->store_id,
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
