<x-guest-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Product Details</h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold">{{ $product->name }}</h2>
            <p class="mt-4">{{ $product->description }}</p>
            <p class="mt-2 text-lg font-semibold">Price: ${{ number_format($product->price, 2) }}</p>
            <p class="mt-2">Stock Quantity: {{ $product->stock_quantity }}</p>
        </div>

        <a href="{{ route('stores.showForOwner',['id'=>$product->store_id]) }}" class="text-blue-500 hover:underline mt-6 block">Back to Store</a>
    </div>
</x-guest-layout>
