<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});




Route::prefix('dashboard')->group(function() {
    Route::resource('/', App\Http\Controllers\DashboardController::class);
    Route::resource('books', App\Http\Controllers\BooksController::class);
    Route::resource('userBorrow', App\Http\Controllers\UserPeminjamController::class);
    Route::resource('distributor', App\Http\Controllers\DistributorController::class);
    Route::resource('purchase', App\Http\Controllers\PurchaseController::class);
    Route::resource('borrow', App\Http\Controllers\BorrowController::class);
})->middleware('auth');


// Login Route

Route::get('/login', function() {
    return view('auth.login');
})->name('login.index');

Route::post('/login', [AuthController::class, 'login'])->name('login.form');



