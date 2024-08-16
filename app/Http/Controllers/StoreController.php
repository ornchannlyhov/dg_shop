<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    // Show all stores (admin view)
    public function showAllForAdmin()
    {
        $stores = Store::all();
        return view('stores.index', compact('stores'));
    }

    // Show a store for buyers
    public function show($id)
    {
        $store = Store::with('products')->find($id);
        if (!$store) {
            abort(404, 'Store not found');
        }
        return view('stores.show', compact('store'));
    }

    // Show a store for the owner (seller view)
    public function showForOwner($id)
    {
        $store = Store::findOrFail($id);
        $seller = Auth::user()->sellers()->where('store_id', $store->store_id)->first();
        if (!$seller) {
            abort(403, 'Unauthorized action.');
        }
        return view('stores.show-owner', compact('store'));
    }

    // Redirect to create store form
    public function create()
    {
        return view('stores.create');
    }

    // Create seller and store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos');
            $validated['logo'] = $logoPath;
        }

        $user = Auth::user();

        // Create a new seller
        $seller = Seller::create([
            'seller_name' => $user->name,
            'seller_email' => $user->email,
            'phone_number' => $user->phone_number,
            'user_id' => $user->user_id,
            'store_id' => null,
        ]);

        $validated['seller_id'] = $seller->seller_id;
        $store = Store::create($validated);
        $seller->update(['store_id' => $store->store_id]);

        return redirect()->route('stores.showForOwner', ['id' => $store->store_id])->with('success', 'Store and Seller created successfully!');
    }



    // Redirect to edit form
    public function edit($id)
    {
        $store = Store::findOrFail($id);
        return view('stores.edit', compact('store'));
    }

    // Update an existing store
    public function update(Request $request, $id)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $store = Store::findOrFail($id);
        $store->update($request->all());

        return redirect()->route('stores.index')->with('success', 'Store updated successfully.');
    }

    // Delete a store
    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('stores.index')->with('success', 'Store deleted successfully.');
    }
}
