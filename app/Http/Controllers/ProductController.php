<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display listing of the products
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'nullable|exists:categories,category_id',
            'new_category' => 'nullable|string|max:255',
        ]);

        if ($request->filled('new_category')) {
            $category = Category::where('name', $request->input('new_category'))->first();

            if ($category) {
                $validated['category_id'] = $category->category_id;
            } else {
                $category = Category::create([
                    'name' => $request->input('new_category'),
                ]);

                $validated['category_id'] = $category->category_id;
            }
        }

        if (!$request->filled('new_category') && !$request->filled('category_id')) {
            return redirect()->back()->withErrors(['category_id' => 'Please select a category or add a new one.'])->withInput();
        }

        $store = Store::findOrFail($store_id);

        $store->products()->create($validated);

        return redirect()->route('stores.products-listing', ['id' => $store_id])
            ->with('success', 'Product and category created successfully!');
    }


    // Display a specific product
    public function show(Product $product)
    {
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        $product->update($validated);

        return redirect()->route('stores.products-listing', ['id' => $product->store_id])
            ->with('success', 'Product updated successfully!');
    }

    // Remove a specific product
    public function destroy(Product $product)
    {
        $store_id = $product->store_id;
        $product->delete();

        return redirect()->route('stores.products-listing', ['id' => $store_id])
            ->with('success', 'Product deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('categoryId')) {
            $selectedCategory = Category::find($request->input('categoryId'));
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        $products = $query->get();

        return response()->json([
            'products' => $products
        ]);
    }


}
