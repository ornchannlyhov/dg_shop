<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display listing of the products
    public function index()
    {
        $products = Product::with('category', 'store')->get();
        return view('products.index', compact('products'));
    }

    // Show the form to create a new product
    public function create($store_id)
    {
        $store = Store::findOrFail($store_id);
        $categories = Category::all();
        return view('products.create', compact('store_id', 'categories'));
    }

    // Store a newly created product
    public function store(Request $request, $store_id)
    {
        $validated = $this->validateProduct($request);

        // Handle new category creation if provided
        if ($request->filled('new_category')) {
            $category = Category::firstOrCreate(['name' => $request->new_category]);
            $validated['category_id'] = $category->category_id;
        }

        // Validate category or return error
        if (!$request->filled('category_id') && !$request->filled('new_category')) {
            return redirect()->back()->withErrors(['category_id' => 'Please select or create a category.'])->withInput();
        }

        // Handle main image upload
        $mainImagePath = $this->handleImageUpload($request, 'image', 'products');
        if ($mainImagePath) {
            $validated['image'] = $mainImagePath;
        }

        // Store product
        $store = Store::findOrFail($store_id);
        $product = $store->products()->create($validated);

        // Handle additional images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->product_id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('stores.products-listing', $store_id)
            ->with('success', 'Product created successfully!');
    }

    // Display a specific product
    public function show(Product $product)
    {
        $product->load('images', 'category', 'store');
        return view('products.show', compact('product'));
    }

    // Show the form to edit a product
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Update a specific product
    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request);

        // Handle main image upload
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $mainImagePath = $this->handleImageUpload($request, 'image', 'products');
            $validated['image'] = $mainImagePath;
        }

        $product->update($validated);

        // Handle additional images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->product_id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('stores.products-listing', $product->store_id)
            ->with('success', 'Product updated successfully!');
    }

    // Remove a specific product
    public function destroy(Product $product)
    {
        $store_id = $product->store_id;

        // Delete associated images
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('stores.products-listing', $store_id)
            ->with('success', 'Product deleted successfully!');
    }

    // Search products
    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('categoryId')) {
            $query->where('category_id', $request->categoryId);
        }

        $products = $query->with('category', 'store')->get();

        return response()->json(['products' => $products]);
    }

    // Helper method to validate product data
    private function validateProduct(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'nullable|exists:categories,category_id',
            'new_category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    }

    // Helper method to handle image uploads
    private function handleImageUpload(Request $request, $key, $directory)
    {
        if ($request->hasFile($key)) {
            return $request->file($key)->store($directory, 'public');
        }
        return null;
    }
}
