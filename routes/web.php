<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/pengguna/home', function () {
    return view('pengguna.home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/pengguna/category', function () {
    return view('pengguna.category');
})->middleware(['auth', 'verified'])->name('category');

Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::get('/toko/dashboard', function () {
    return view('toko.dashboard');
})->middleware(['auth', 'verified'])->name('toko.dashboard');

require __DIR__.'/auth.php';
