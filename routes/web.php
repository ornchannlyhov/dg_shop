<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CartItemController;

//Gusess route
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/products');
    }
    return view('welcome');
});
//login with socailite route
Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('registerWithGoogle');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('registerWithGoogle.callback');

//return to products listing page route
Route::get('/products', function () {
    return view('products.index');
})->middleware(['auth', 'verified'])->name('products');

Route::middleware('auth')->group(function () {

    // Profile Route
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Store Routes
    Route::get('admin/stores', [StoreController::class, 'showAllForAdmin'])->name('stores.index');
    Route::get('store/create', [StoreController::class, 'create'])->name('stores.create');
    Route::post('store', [StoreController::class, 'store'])->name('store.store');
    Route::get('store/{id}', [StoreController::class, 'show'])->name('stores.show');
    Route::get('store/{id}/owner', [StoreController::class, 'showForOwner'])->name('stores.showForOwner');
    Route::get('store/{id}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::put('store/{id}', [StoreController::class, 'update'])->name('stores.update');
    Route::delete('store/{id}', [StoreController::class, 'destroy'])->name('stores.destroy');
    Route::get('redirect-to-store', [StoreController::class, 'redirectToStorePage'])->name('redirect.toStore');
    Route::get('/stores/{id}/products-listing/{categoryId?}', [StoreController::class, 'productsListing'])->name('stores.products-listing');

    //product routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('store/{store_id}/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('store/{store_id}/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');

    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/checkout/{cart_id}', [OrderController::class, 'checkout'])->name('checkout');

    // Cart routes
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::get('/cart/items', [CartController::class, 'getCartItems']);
    Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
    Route::patch('/cart/item/{cartItemId}', [CartItemController::class, 'update'])->name('cart.item.update');
    Route::delete('/cart/item/{cartItemId}', [CartItemController::class, 'destroy'])->name('cart.item.destroy');

    // Checkout routes
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');

    // Payment routes
    Route::get('/payment/{order}/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/payment/{order}/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/{order}/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

    // Notification Routes
    Route::get('/notify-seller/{order_id}', [NotificationController::class, 'notifySeller'])->name('notify.seller');

});

require __DIR__ . '/auth.php';