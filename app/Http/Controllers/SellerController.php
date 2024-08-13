<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    // Show all sellers (admin view)
    public function index()
    {
        $sellers = Seller::all();
        return view('sellers.index', compact('sellers'));
    }

    // Show a seller's profile
    public function show($id)
    {
        $seller = Seller::findOrFail($id);
        return view('sellers.show', compact('seller'));
    }

    // Show the authenticated seller's profile
    public function showForUser()
    {
        $seller = Auth::user()->sellers()->first();
        if (!$seller) {
            return redirect()->route('home')->with('error', 'You are not a seller.');
        }
        return view('sellers.show_for_user', compact('seller'));
    }
    // Show form for editing a seller's profile
    public function edit($id)
    {
        $seller = Seller::findOrFail($id);
        return view('sellers.edit', compact('seller'));
    }

    // Update a seller's profile
    public function update(Request $request, $id)
    {
        $request->validate([
            'seller_name' => 'required|string|max:255',
            'seller_email' => 'required|string|email|max:255',
            'seller_phoneNumber' => 'nullable|string',
        ]);

        $seller = Seller::findOrFail($id);
        $seller->update($request->all());

        return redirect()->route('sellers.index')->with('success', 'Seller updated successfully.');
    }

    // Delete a seller
    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->delete();
        return redirect()->route('sellers.index')->with('success', 'Seller and associated stores/products deleted successfully.');
    }
}
