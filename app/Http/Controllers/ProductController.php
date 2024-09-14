<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        $products = Product::all();
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
        $validated=$request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,category_id',
        ]);
        

        $store = Store::findOrFail($store_id);

        $store->products()->create($validated);

        return redirect()->route('stores.showForOwner', ['id' => $store_id])
            ->with('success', 'Product created successfully!');
    }

    // Display a specific product
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Show the form to edit a product
    public function edit(Product $product)
    {
        $categories = Category::all(); // Fetch categories if needed

        return view('products.edit', compact('product', 'categories'));
    }

    // Update a specific product
    public function update(Request $request, Product $product)
    {
        $validated=$request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        $product->update($validated);

        return redirect()->route('stores.showForOwner', ['id' => $product->store_id])
            ->with('success', 'Product updated successfully!');
    }

    // Remove a specific product
    public function destroy(Product $product)
    {
        $store_id = $product->store_id;
        $product->delete();

        return redirect()->route('stores.showForOwner', ['id' => $store_id])
            ->with('success', 'Product deleted successfully!');
    }
}
