<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        $products = Product::with('store', 'category')->get();
        return view('products.index', compact('products'));
    }

    // Show form for creating a new product
    public function create()
    {
        $seller = Auth::user()->sellers()->first();
        if (!$seller) {
            return redirect()->route('products.index')->with('error', 'You need to have a store to create products.');
        }

        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $seller = Auth::user()->sellers()->first();
        if (!$seller) {
            return redirect()->route('products.index')->with('error', 'You need to have a store to create products.');
        }

        $store = Store::where('seller_id', $seller->id)->firstOrFail();

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'store_id' => $store->id,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Display a specific product
    public function show($id)
    {
        $product = Product::with('store', 'category')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    // Show form for editing a product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $seller = Auth::user()->sellers()->first();

        if (!$seller || $product->store->seller_id !== $seller->id) {
            return redirect()->route('products.index')->with('error', 'You do not have permission to edit this product.');
        }

        return view('products.edit', compact('product', 'categories'));
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::findOrFail($id);
        $seller = Auth::user()->sellers()->first();

        if (!$seller || $product->store->seller_id !== $seller->id) {
            return redirect()->route('products.index')->with('error', 'You do not have permission to update this product.');
        }

        $product->update($request->only(['name', 'description', 'price', 'stock_quantity', 'category_id']));

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $seller = Auth::user()->sellers()->first();

        if (!$seller || $product->store->seller_id !== $seller->id) {
            return redirect()->route('products.index')->with('error', 'You do not have permission to delete this product.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
