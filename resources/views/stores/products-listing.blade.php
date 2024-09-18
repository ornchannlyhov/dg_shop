@extends('layouts.dashboard')

@section('title', 'Product List')

@section('content')
<div class="p-6 min-h-screen">
    <!-- Category Section -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
        <a href="{{ route('stores.products-listing', ['id' => $store->store_id]) }}"
            class="bg-gray-800 p-3 rounded-lg shadow-md hover:bg-gray-700 text-white text-center"
            style="background-color: #3f3f46; height: 60px;">
            <h3 class="text-lg font-bold text-left">All Products</h3>
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
        @foreach($categories as $categoryData)
            <a href="{{ route('stores.products-listing', ['id' => $store->store_id, 'categoryId' => $categoryData['category']->category_id]) }}"
                class="bg-gray-800 px-3 py-3 rounded-lg shadow-md hover:bg-gray-700 text-white text-center"
                style="background-color: #3f3f46; height: 60px;">
                <h3 class="text-lg font-bold text-left">{{ $categoryData['category']->name }}</h3>
            </a>
        @endforeach
    </div>
    <!-- Product List Section -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-md" style="background-color: #3f3f46;">
        <div class="flex justify-between items-center mb-4 flex-wrap">
            <div class="flex items-center mb-4 sm:mb-0">
                <!-- Heading -->
                <h2 class="text-2xl font-bold text-white mr-4">
                    @if($selectedCategory)
                        {{ $selectedCategory->name }}
                    @else
                        All Products
                    @endif
                </h2>
                <!-- Add Product Button -->
                <a href="{{ route('products.create', ['store_id' => $store->store_id]) }}"
                    class="bg-green-500 text-white py-1 px-2 rounded hover:bg-green-600 text-sm sm:text-base sm:py-1 sm:px-4"
                    data-action="add-product">
                    +
                </a>
            </div>
            <!-- Search Input -->
            <input type="text" id="searchInput" placeholder="Search Products"
                class="bg-white text-black py-2 px-4 rounded" value="{{ request('search') }}">
        </div>
        <!-- Product Table -->
        <table class="min-w-full text-left border-collapse text-white" style="background-color: #3f3f46;">
            <thead>
                <tr class="bg-gray-700 text-white">
                    <th class="py-3 px-6">Product</th>
                    <th class="py-3 px-6">Price</th>
                    <th class="py-3 px-6">Stock</th>
                    <th class="py-3 px-6">Action</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
                @forelse($products as $product)
                    <tr class="border-b border-gray-600">
                        <td class="py-3 px-6">{{ $product->name }}</td>
                        <td class="py-3 px-6">${{ $product->price }}</td>
                        <td class="py-3 px-6">{{ $product->stock_quantity }}</td>
                        <td class="py-3 px-6">
                            <div class="flex space-x-2">
                                <!-- Edit Button -->
                                <a href="{{ route('products.edit', ['product' => $product->product_id]) }}"
                                    class="bg-yellow-500 text-white rounded-full p-2 hover:bg-yellow-600"
                                    data-action="edit-product"
                                    data-href="{{ route('products.edit', ['product' => $product->product_id]) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <!-- Delete Button -->
                                <form action="{{ route('products.destroy', ['product' => $product->product_id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white rounded-full p-2 hover:bg-red-600">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-3 px-6 text-center text-gray-400">No products available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="mt-4">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>

        <!-- Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content mt-20 w-52">
                    <div class="modal-header mt-0" style="background-color: #27272a; border:none;">
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="background-color: #27272a;">
                        <!-- Form content will be loaded dynamically -->
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                // Handle the "Add Product" button click
                $('a[data-action="add-product"]').on('click', function (e) {
                    e.preventDefault();
                    $('#productModal .modal-body').load($(this).attr('href'), function () {
                        $('#productModal').modal('show');
                    });
                });

                // Handle the "Edit" button click
                $('a[data-action="edit-product"]').on('click', function (e) {
                    e.preventDefault();
                    $('#productModal .modal-body').load($(this).data('href'), function () {
                        $('#productModal').modal('show');
                    });
                });

                // Handle real-time search
                $('#searchInput').on('input', function () {
                    var searchKeyword = $(this).val();
                    $.ajax({
                        url: "{{ route('stores.products-listing', ['id' => $store->store_id]) }}",
                        type: 'GET',
                        data: {
                            search: searchKeyword,
                            @if($selectedCategory)
                                categoryId: {{ $selectedCategory->category_id }},
                            @endif
                },
                    success: function (response) {
                        // Replace the product table body with the new data
                        $('#productTableBody').html($(response).find('#productTableBody').html());
                    },
                    error: function () {
                        console.log('Error fetching data.');
                    }
            });
        });
    });
        </script>
        @endsection