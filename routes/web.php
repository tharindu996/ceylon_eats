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
});

require __DIR__.'/auth.php';
