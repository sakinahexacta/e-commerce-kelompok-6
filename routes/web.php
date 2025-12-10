<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ManagementController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/pengguna/home', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('pengguna.home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/product/{id}', [ProductController::class, 'detail'])->name('pengguna.detail');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::get('/admin/verifikasi', function () {
    return view('admin.verifikasi');
})->middleware(['auth', 'verified'])->name('admin.verifikasi');

Route::get('/admin/management', [ManagementController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin.management');

Route::get('/toko/dashboard', function () {
    return view('toko.dashboard');
})->middleware(['auth', 'verified'])->name('toko.dashboard');

Route::get('/pengguna/category', [CategoryController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('pengguna.category');

Route::get('/checkout/{product}', [CheckoutController::class, 'index'])
    ->name('pengguna.cekout')
    ->middleware('auth');

Route::get('/checkout/transaction/{transaction}', [CheckoutController::class, 'show'])
    ->name('pengguna.cekout.show')
    ->middleware('auth');

Route::get('/checkout/{product}/alamat', [CheckoutController::class, 'address'])
    ->name('pengguna.alamat')
    ->middleware('auth');

Route::post('/checkout/{product}/alamat', [CheckoutController::class, 'storeAddress'])
    ->name('pengguna.alamat.store')
    ->middleware('auth');

Route::get('/checkout/{product}/pengiriman', [CheckoutController::class, 'shipping'])
    ->name('pengguna.pengiriman')
    ->middleware('auth');

Route::post('/checkout/{product}/pengiriman', [CheckoutController::class, 'storeShipping'])
    ->name('pengguna.pengiriman.store')
    ->middleware('auth');
    
Route::get('/checkout/{product}/metodepembayaran', [CheckoutController::class, 'payment'])
    ->name('pengguna.metodepembayaran')
    ->middleware('auth');

Route::post('/checkout/{product}/metodepembayaran', [CheckoutController::class, 'storePayment'])
    ->name('pengguna.metodepembayaran.store')
    ->middleware('auth');

Route::post('/checkout/{product}/store', [CheckoutController::class, 'store'])
    ->name('pengguna.cekout.store')
    ->middleware('auth');



require __DIR__.'/auth.php';
