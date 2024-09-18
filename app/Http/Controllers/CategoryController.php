<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        $categories = Category::all();
        return view('admin.addmin-pandel', compact('categories'));
    }

    // Show the form for creating a new category
    public function create()
    {
        return view('');
    }
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('')->with('success', 'Category created successfully.');
    }
    // Show the form for editing the specified category
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
    // Update the specified category in storage
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.addmin-pandel')->with('success', 'Category updated successfully.');
    }

    // Remove the specified category from storage
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.addmin-pandel')->with('success', 'Category deleted successfully.');
    }
}
