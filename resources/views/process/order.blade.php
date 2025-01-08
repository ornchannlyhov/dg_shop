<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Your Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="dark:bg-zinc-900 text-white">

    <div class="container mx-auto p-8">
        <h2 class="text-3xl font-semibold text-center mb-8">Your Orders</h2>

        @if($orders->count() > 0)
            @foreach($orders as $order)
                <div class="bg-zinc-700 p-6 mb-8 rounded-lg shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-medium">{{ $order->store->store_name }}</h4>
                        <p class="text-gray-400 text-sm">{{ ucfirst($order->status) }}</p>
                    </div>

                    @foreach($order->items as $item)
                        <div class="flex items-center mb-4">
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                class="w-20 h-20 object-cover rounded-lg">

                            <div class="ml-4 flex-grow">
                                <p class="font-bold">{{ $item->product->name }}</p>
                                <p class="text-gray-400">Price: ${{ $item->price }}</p>
                                <p class="text-gray-400">Quantity: {{ $item->quantity }}</p>
                                <p class="text-gray-300">Total: ${{ $item->quantity * $item->price }}</p>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-between items-center mt-4">
                        <p class="text-gray-400">Order Total: ${{ $order->total_amount }}</p>
                        @if(strtolower($order->status) === 'pending')
                            <button class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600"
                                onclick="cancelOrder({{ $order->order_id }})">
                                Cancel
                            </button>
                        @endif
                    </div>

                </div>
            @endforeach
        @else
            <p class="text-center text-lg mt-8">You have no orders.</p>
        @endif
    </div>

</body>
<script>
    function cancelOrder(orderId) {
        if (confirm('Are you sure you want to cancel this order?')) {
            fetch(`/order/cancel/${orderId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    alert('An error occurred. Please try again later.');
                    console.error(error);
                });
        }
    }
</script>

</html>
