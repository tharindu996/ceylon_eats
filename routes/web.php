<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Vendor Management
    Route::resource('vendors', \App\Http\Controllers\Admin\VendorController::class);
    Route::post('vendors/{vendor}/toggle-verification', [\App\Http\Controllers\Admin\VendorController::class, 'toggleVerification'])->name('vendors.toggle-verification');
    Route::post('vendors/{vendor}/toggle-status', [\App\Http\Controllers\Admin\VendorController::class, 'toggleStatus'])->name('vendors.toggle-status');

    // Commission Management
    Route::get('commissions', [\App\Http\Controllers\Admin\CommissionController::class, 'index'])->name('commissions.index');
    Route::post('commissions', [\App\Http\Controllers\Admin\CommissionController::class, 'update'])->name('commissions.update');

    // Bookings
    Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class)->only(['index', 'show']);

    // Moderation (Phase 4)
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('policies', \App\Http\Controllers\Admin\PolicyController::class);

    Route::resource('listings', \App\Http\Controllers\Admin\ListingController::class)->only(['index', 'show']);
    Route::post('listings/{listing}/approve', [\App\Http\Controllers\Admin\ListingController::class, 'approve'])->name('listings.approve');
    Route::post('listings/{listing}/reject', [\App\Http\Controllers\Admin\ListingController::class, 'reject'])->name('listings.reject');

    Route::resource('promotions', \App\Http\Controllers\Admin\PromotionController::class)->only(['index']);
    Route::post('promotions/{promotion}/approve', [\App\Http\Controllers\Admin\PromotionController::class, 'approve'])->name('promotions.approve');
    Route::post('promotions/{promotion}/reject', [\App\Http\Controllers\Admin\PromotionController::class, 'reject'])->name('promotions.reject');
});

require __DIR__.'/auth.php';
