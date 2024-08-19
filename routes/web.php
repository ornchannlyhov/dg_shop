<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;

//index route
Route::get('/', function () {
    return view('welcome');
});
//login with socailite route
Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('registerWithGoogle');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('registerWithGoogle.callback');

//return to dashboard page route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile Route
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Seller Routes
    Route::get('seller/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');
    Route::get('seller/stores', [SellerController::class, 'showStores'])->name('seller.stores');

    // Store Routes
    Route::get('admin/stores', [StoreController::class, 'showAllForAdmin'])->name('stores.index');
    Route::get('store/create', [StoreController::class, 'create'])->name('stores.create');
    Route::post('store', [StoreController::class, 'store'])->name('store.store');
    Route::get('store/{id}', [StoreController::class, 'show'])->name('stores.show');
    Route::get('store/{id}/owner', [StoreController::class, 'showForOwner'])->name('stores.showForOwner');
    Route::get('store/{id}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::put('store/{id}', [StoreController::class, 'update'])->name('stores.update');
    Route::delete('store/{id}', [StoreController::class, 'destroy'])->name('stores.destroy');

    //product routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('store/{store_id}/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('store/{store_id}/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');



});


require __DIR__ . '/auth.php';
