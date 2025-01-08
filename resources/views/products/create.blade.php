<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($product) ? 'Update Product' : 'Create Product' }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mx-auto ">
        <h1 class="text-3xl font-bold mb-6 text-white">{{ isset($product) ? 'Update Product' : 'Create Product' }}</h1>

        <!-- Form -->
        <form
            action="{{ isset($product) ? route('products.update', $product->id) : route('products.store', ['store_id' => $store_id]) }}"
            method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @if (isset($product))
                @method('PUT')
            @endif

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control"
                    value="{{ old('name', $product->name ?? '') }}" required>
                @error('name')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description"
                    class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" id="price" name="price" class="form-control"
                    value="{{ old('price', $product->price ?? '') }}" required>
                @error('price')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock Quantity -->
            <div class="mb-3">
                <label for="stock_quantity" class="form-label">Stock Quantity</label>
                <input type="number" id="stock_quantity" name="stock_quantity" class="form-control"
                    value="{{ old('stock_quantity', $product->stock_quantity ?? '') }}" required>
                @error('stock_quantity')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <label for="category_id" class="form-label me-3">Category</label>
            <div class="mb-3 d-flex align-items-center">
                <select id="category_id" name="category_id" class="form-select me-2">
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" {{ old('category_id', $product->category_id ?? '') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Add category button -->
                <button type="button"
                    class="bg-green-500 text-white py-1 px-2 rounded hover:bg-green-600 text-sm sm:text-base sm:py-1 sm:px-4"
                    id="btn-add-category">+</button>
            </div>

            <!-- New Category Input -->
            <div class="mb-3 category-input" style="display: {{ old('new_category') ? 'block' : 'none' }}">
                <label for="new_category" class="form-label">New Category Name</label>
                <input type="text" id="new_category" name="new_category" class="form-control"
                    value="{{ old('new_category') }}" placeholder="Enter new category name">
            </div>

            <!-- Product Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Product Main Image</label>
                <input type="file" id="image" name="image" class="form-control">
                @error('image')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror

                @if (isset($product) && $product->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid"
                            width="100">
                    </div>
                @endif
            </div>

            <!-- Additional Product Images (Multiple) -->
            <div class="mb-3">
                <label for="images" class="form-label">Additional Product Images (Optional)</label>
                <input type="file" id="images" name="images[]" class="form-control" multiple>
                @error('images.*')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-save py-2 px-4 rounded">
                {{ isset($product) ? 'Update' : 'Save' }}
            </button>
        </form>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Show category input if needed
        document.getElementById('btn-add-category').addEventListener('click', function () {
            document.querySelector('.category-input').style.display = 'block';
            this.style.display = 'none'; // Hide the "Add Category" button
        });
    </script>
</body>

</html>