<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Settings\ProfileController;

Route::get('/', [HomeController::class, 'index'])->middleware(['restaurantly'])->name('home');
Route::get('order', [OrderController::class, 'index'])->middleware(['restaurantly'])->name('order');
Route::get('checkout', [OrderController::class, 'checkout'])->middleware(['restaurantly'])->name('checkout');
Route::get('cart', [OrderController::class, 'cart'])->middleware(['restaurantly'])->name('cart');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('profile', [ProfileController::class, 'profile'])->middleware(['restaurantly'])->name('profile');
});

require __DIR__.'/settings.php';
