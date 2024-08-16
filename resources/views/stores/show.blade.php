<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <!-- Store Logo -->
            <div class="flex-shrink-0">
                @if($store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }} Logo" class="w-16 h-16 object-cover rounded-full">
                @else
                    <div class="w-16 h-16 bg-gray-200 rounded-full"></div>
                @endif
            </div>
            <!-- Store Name and Description -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-900">{{ $store->store_name ?? 'No Store Name' }}</h2>
                <p class="text-gray-600">{{ $store->store_description ?? 'No Description' }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Products Listing -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Products</h3>
                @if($store->products->isEmpty())
                    <p class="text-gray-500">No products available.</p>
                @else
                    <ul class="space-y-4">
                        @foreach($store->products as $product)
                            <li class="border-b pb-4">
                                <h4 class="text-lg font-semibold">{{ $product->name ?? 'No Product Name' }}</h4>
                                <p class="text-gray-600">{{ $product->description ?? 'No Product Description' }}</p>
                                <p class="text-gray-800 font-bold">{{ $product->price ?? 'No Price' }} USD</p>
                                <p class="text-gray-500">Stock: {{ $product->stock_quantity ?? 'No Stock Quantity' }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
