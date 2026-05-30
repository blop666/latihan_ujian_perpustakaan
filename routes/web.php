<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});




Route::prefix('dashboard')->group(function() {
    Route::resource('/', App\Http\Controllers\DashboardController::class);
    Route::resource('books', App\Http\Controllers\BooksController::class);
    Route::resource('userBorrow', App\Http\Controllers\UserPeminjamController::class);
    Route::resource('distributor', App\Http\Controllers\DistributorController::class);
    Route::resource('purchase', App\Http\Controllers\PurchaseController::class);
    Route::resource('users', UserController::class);
    Route::resource('borrow', App\Http\Controllers\BorrowController::class);
})->middleware('auth');

// Route untuk proses verifikasi
Route::post('/dashboard/purchase/{id}/verify', [PurchaseController::class, 'verify'])->name('purchase.verify');

// Route::get('/dashboard/purchase/{id}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');

// Login Route

Route::get('/login', function() {
    return view('auth.login');
})->name('login'); 

Route::post('/login', [AuthController::class, 'login'])->name('login.form');



