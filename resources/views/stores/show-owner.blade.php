<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                @if($store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->store_name }} Logo"
                        class="w-16 h-16 object-cover rounded-full">
                @else
                    <div class="w-16 h-16 bg-gray-200 rounded-full"></div>
                @endif
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900">{{ $store->store_name }}</h2>
                    <p class="text-gray-500">{{ $store->store_description }}</p>
                </div>
            </div>
            <div>
                <!-- Dropdown for actions -->
                <div x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="inline-flex justify-center w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Actions
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M6.293 9.293a1 1 0 011.414 0L10 10.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open"
                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <div class="py-1">
                            <a href="{{ route('stores.edit', ['id' => $store->store_id]) }}"
                                class="text-gray-700 block px-4 py-2 text-sm">Edit Store</a>
                            <a href="{{ route('products.create', ['store_id' => $store->store_id]) }}"
                                class="text-gray-700 block px-4 py-2 text-sm">Add Product</a>

                            <form action="{{ route('stores.destroy', ['id' => $store->store_id]) }}" method="POST"
                                role="none">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-gray-700 block px-4 py-2 text-sm w-full text-left">Delete Store</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stock Quantity
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($store->products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $product->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $product->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $product->stock_quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('products.show', ['product' => $product->product_id]) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    <a href="{{ route('products.edit', ['product' => $product->product_id]) }}" class="ml-4 text-yellow-600 hover:text-yellow-900">Edit</a>
                                    <form action="{{ route('products.destroy', ['product' => $product->product_id]) }}" method="POST" class="inline ml-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
