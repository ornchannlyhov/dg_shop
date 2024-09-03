<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CartController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Socialite Authentication Routes
Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('registerWithGoogle');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('registerWithGoogle.callback');

// Dashboard Route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated User Routes
Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Seller Routes
    Route::get('seller/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');
    Route::get('seller/stores', [SellerController::class, 'showStores'])->name('seller.stores');

    // Store Routes
    Route::prefix('stores')->group(function () {
        Route::get('/', [StoreController::class, 'showAllForAdmin'])->name('stores.index');
        Route::get('/create', [StoreController::class, 'create'])->name('stores.create');
        Route::post('/', [StoreController::class, 'store'])->name('store.store');
        Route::get('/{id}', [StoreController::class, 'show'])->name('stores.show');
        Route::get('/{id}/owner', [StoreController::class, 'showForOwner'])->name('stores.showForOwner');
        Route::get('/{id}/edit', [StoreController::class, 'edit'])->name('stores.edit');
        Route::put('/{id}', [StoreController::class, 'update'])->name('stores.update');
        Route::delete('/{id}', [StoreController::class, 'destroy'])->name('stores.destroy');
    });

    // Product Routes
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('store/{store_id}/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('store/{store_id}', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Cart Routes
    Route::prefix('carts')->group(function () {
        Route::get('/', [CartController::class, 'viewCarts'])->name('carts');
        Route::post('/add/{product_id}', [CartController::class, 'addToCart'])->name('cart.add');
        Route::get('/{cart_id}/review', [CartController::class, 'reviewCart'])->name('cart.review');
        Route::post('/checkout/{cart_id}', [CartController::class, 'checkout'])->name('checkout');
    });

    // Order Routes
    Route::post('/notify-seller/{order_id}', [NotificationController::class, 'notifySeller'])->name('notify.seller');

    // Payment Routes
    Route::prefix('payment')->group(function () {
        Route::get('/initiate/{order}', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
        Route::get('/success/{order}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
        Route::get('/cancel/{order}', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');
    });
});

require __DIR__ . '/auth.php';
