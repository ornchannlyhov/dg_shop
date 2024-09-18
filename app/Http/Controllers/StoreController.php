<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Seller;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
    //show store for owner with dashboard 
    public function showForOwner($id, Request $request)
    {
        $store = Store::findOrFail($id);
        $seller = Auth::user()->sellers()->where('store_id', $store->store_id)->first();
        if (!$seller) {
            abort(403, 'Unauthorized action.');
        }

        // Existing calculations
        $totalSales = DB::table('orders')
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('products.store_id', $store->store_id)
            ->where('orders.status', 'delivered')
            ->sum('orders.total_amount');

        $mostSoldProduct = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('products.store_id', $store->store_id)
            ->select('products.product_id', 'products.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.product_id', 'products.name')
            ->orderBy('total_quantity', 'DESC')
            ->first();

        $pendingOrders = DB::table('orders')
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('products.store_id', $store->store_id)
            ->where('orders.status', 'pending')
            ->count();

        $profit = DB::table('orders')
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('products.store_id', $store->store_id)
            ->where('orders.status', 'delivered')
            ->select(DB::raw('SUM(order_items.quantity * products.price) as total_profit'))
            ->value('total_profit');

        $leastSoldProduct = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('products.store_id', $store->store_id)
            ->select('products.product_id', 'products.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.product_id', 'products.name')
            ->orderBy('total_quantity', 'ASC')
            ->first();

        // Handle month selection
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
                ->where('products.store_id', $store->store_id)
                ->where('orders.status', 'delivered')
                ->whereBetween('orders.created_at', [$week['start'], $week['end']])
                ->sum('orders.total_amount');

            $salesData[] = floatval($sales);
        }

        $monthsOptions = [];
        for ($i = -5; $i <= 0; $i++) {
            $month = Carbon::now()->addMonths($i);
            $monthsOptions[] = [
                'value' => $month->format('Y-m'),
                'label' => $month->format('F Y')
            ];
        }

        $weeksLabels = array_map(fn($week) => $week['start'] . ' to ' . $week['end'], $weeks);

        return view('stores.owner-dashboard', compact('store', 'totalSales', 'mostSoldProduct', 'pendingOrders', 'profit', 'leastSoldProduct', 'weeks', 'salesData', 'monthsOptions', 'weeksLabels'));
    }

    // fecth product and category for product listing in a store
    public function productsListing(Request $request, $id, $categoryId = null)
    {
        $store = Store::findOrFail($id);

        $query = Product::where('store_id', $id)->with('category');

        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->paginate(10);

        $categories = Product::where('store_id', $id)->with('category')->get()
            ->groupBy('category_id')
            ->map(function ($products, $categoryId) {
                return [
                    'category' => Category::find($categoryId),
                    'products' => $products
                ];
            })->values();

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

    // Create seller and store
    public function store(Request $request)
    {
        // Check if the authenticated user already has a store
        $user = Auth::user();
        $existingStore = $user->sellers()->whereNotNull('store_id')->first();

        if ($existingStore) {
            return back()->with('error', 'You already own a store.');
        }

        // Validate and create a new store
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos');
            $validated['logo'] = $logoPath;
        }

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
        return view('stores.setting', compact('store'));
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

        return redirect()->route('stores.owner-dashboard')->with('success', 'Store updated successfully.');
    }

    // Delete a store
    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('stores.index')->with('success', 'Store deleted successfully.');
    }
    public function redirectToStorePage()
    {
        $user = Auth::user();
        $store = $user->sellers()->whereNotNull('store_id')->first();

        if ($store) {
            return redirect()->route('stores.showForOwner', ['id' => $store->store_id]);
        } else {
            return redirect()->route('stores.create')->with('info', 'You do not own a store yet. Please create one to proceed.');
        }
    }
}
