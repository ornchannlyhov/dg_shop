<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialiteController;

// use App\Http\Controllers\StoreController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('socialite.callback');

// Route::resource('stores', StoreController::class);
require __DIR__.'/auth.php';  


