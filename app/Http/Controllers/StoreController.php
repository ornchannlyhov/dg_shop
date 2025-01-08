<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Seller;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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
        $store = Store::with('products')->findOrFail($id);
        return view('stores.show', compact('store'));
    }

    // Show store dashboard for owner
    public function showForOwner($id, Request $request)
    {
        $store = Store::findOrFail($id);
        $seller = Auth::user()->sellers()->where('store_id', $store->store_id)->first();

        if (!$seller) {
            abort(403, 'Unauthorized action.');
        }

        $totalSales = $this->calculateTotalSales($store->store_id);
        $mostSoldProduct = $this->getMostSoldProduct($store->store_id);
        $leastSoldProduct = $this->getLeastSoldProduct($store->store_id);
        $pendingOrders = $this->getPendingOrders($store->store_id);

        [$salesData, $weeksLabels, $monthsOptions] = $this->getSalesData($store->store_id, $request);

        return view('stores.owner-dashboard', compact(
            'store',
            'totalSales',
            'mostSoldProduct',
            'leastSoldProduct',
            'pendingOrders',
            'salesData',
            'weeksLabels',
            'monthsOptions'
        ));
    }

    // Product listing for a store
    public function productsListing(Request $request, $id, $categoryId = null)
    {
        $store = Store::findOrFail($id);

        $query = Product::where('store_id', $id)->with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%" . $request->search . "%");
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->paginate(10);

        $categories = Product::where('store_id', $id)
            ->with('category')
            ->get()
            ->groupBy('category_id')
            ->map(fn($products, $categoryId) => [
                'category' => Category::find($categoryId),
                'products' => $products,
            ])->values();

        $selectedCategory = $categoryId ? Category::find($categoryId) : null;

        if ($request->ajax()) {
            return view('stores.products-listing', compact('store', 'categories', 'selectedCategory', 'products', 'request'))->render();
        }

        return view('stores.products-listing', compact('store', 'categories', 'selectedCategory', 'products', 'request'));
    }

    // Redirect to create store form
    public function create()
    {
        return view('stores.create');
    }

    // Create store and seller
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->sellers()->whereNotNull('store_id')->exists()) {
            return back()->with('error', 'You already own a store.');
        }

        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $seller = Seller::create([
            'seller_name' => $user->name,
            'seller_email' => $user->email,
            'phone_number' => $user->phone_number,
            'user_id' => $user->user_id,
            'store_id' => null,
        ]);

        $store = Store::create($validated + ['seller_id' => $seller->seller_id]);
        $seller->update(['store_id' => $store->store_id]);

        return redirect()->route('stores.showForOwner', $store->store_id)->with('success', 'Store created successfully!');
    }

    // Edit store form
    public function edit($id)
    {
        $store = Store::findOrFail($id);
        return view('stores.setting', compact('store'));
    }

    // Update store
    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $store->update($validated);

        return redirect()->route('stores.edit', $store->store_id)->with('success', 'Store updated successfully.');
    }

    // Delete store
    public function destroy($id)
    {
        $store = Store::findOrFail($id);

        if ($store->logo) {
            Storage::disk('public')->delete($store->logo);
        }

        $store->products()->delete();
        $store->delete();

        return redirect()->route('products.index')->with('success', 'Store deleted successfully.');
    }

    // Redirect to store page
    public function redirectToStorePage()
    {
        $store = Auth::user()->sellers()->whereNotNull('store_id')->first();

        if ($store) {
            return redirect()->route('stores.showForOwner', $store->store_id);
        }

        return redirect()->route('stores.create')->with('info', 'Please create a store to proceed.');
    }

    // Helper functions for calculations
    private function calculateTotalSales($storeId)
    {
        return DB::table('orders')
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('products.store_id', $storeId)
            ->where('orders.status', 'shipped')
            ->sum('orders.total_amount');
    }

    private function getMostSoldProduct($storeId)
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('products.store_id', $storeId)
            ->select('products.product_id', 'products.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.product_id', 'products.name')
            ->orderByDesc('total_quantity')
            ->first();
    }

    private function getLeastSoldProduct($storeId)
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('products.store_id', $storeId)
            ->select('products.product_id', 'products.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.product_id', 'products.name')
            ->orderBy('total_quantity')
            ->first();
    }

    private function getPendingOrders($storeId)
    {
        return DB::table('orders')
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('products.store_id', $storeId)
            ->where('orders.status', 'pending')
            ->count();
    }

    private function getSalesData($storeId, $request)
    {
        $selectedMonth = $request->query('month', Carbon::now()->format('Y-m'));
        $startOfMonth = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $selectedMonth)->endOfMonth();

        $weeks = [];
        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addWeek()) {
            $weeks[] = [
                'start' => $date->copy()->startOfWeek()->format('Y-m-d'),
                'end' => $date->copy()->endOfWeek()->format('Y-m-d'),
            ];
        }

        $salesData = [];
        foreach ($weeks as $week) {
            $sales = DB::table('orders')
                ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.product_id')
                ->where('products.store_id', $storeId)
                ->where('orders.status', 'shipped')
                ->whereBetween('orders.created_at', [$week['start'], $week['end']])
                ->sum('orders.total_amount');

            $salesData[] = floatval($sales);
        }

        $monthsOptions = [];
        for ($i = -5; $i <= 0; $i++) {
            $month = Carbon::now()->addMonths($i);
            $monthsOptions[] = [
                'value' => $month->format('Y-m'),
                'label' => $month->format('F Y'),
            ];
        }

        $weeksLabels = array_map(fn($week) => $week['start'] . ' to ' . $week['end'], $weeks);

        return [$salesData, $weeksLabels, $monthsOptions];
    }
}
