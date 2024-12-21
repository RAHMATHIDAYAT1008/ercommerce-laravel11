<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use App\Models\Admin;
use App\Imports\DistributorImport;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DistributorController;

// Guest Route
Route::middleware(['guest'])->group(function () {
    // Halaman utama
    Route::get('/', function () {
        return view('welcome');
    });

    // Registrasi
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/post-register', [AuthController::class, 'post_register'])->name('post.register');

    // Login
    Route::post('/post-login', [AuthController::class, 'login']);
});

// Admin Route
Route::group(['middleware' => 'admin'], function () {
    // Dashboard Admin
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Routes terkait distributor
    Route::get('/distributor', [DistributorController::class, 'index'])->name('admin.distributor');
    Route::post('/distributor/import', [DistributorController::class, 'import'])->name('distributor.import');
    Route::get('/distributor/export', [DistributorController::class, 'export'])->name('distributor.export');
    Route::get('/admin/distributor/create', [DistributorController::class, 'create'])->name('distributor.create');
    Route::post('/distributor/store', [DistributorController::class, 'store'])->name('distributor.store');
    Route::get('/admin/distributor/edit/{id}', [DistributorController::class, 'edit'])->name('distributor.edit');
    Route::post('/admin/distributor/{id}', [DistributorController::class, 'update'])->name('admin.distributor.update');
    Route::delete('/admin/distributor/delete/{id}', [DistributorController::class, 'delete'])->name('distributor.delete');

    // Routes terkait produk
    Route::get('/product', [ProductController::class, 'index'])->name('admin.product');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/admin/product/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    // Routes untuk diskon
    Route::post('/admin/product/{id}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::post('/admin/product/{productId}/set-discount', [AdminController::class, 'setDiscount'])->name('admin.setDiscount');

    // Flash Sale
    Route::get('/user/flash-sale', [UserController::class, 'flashSale'])->name('user.flashSale');

    // Logout admin
    Route::get('/admin-logout', [AuthController::class, 'admin_logout'])->name('admin.logout');
});

// User Route
Route::group(['middleware' => 'web'], function () {
    // Dashboard User
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');

    // Flash Sale
    Route::get('/user/flashsale', [UserController::class, 'fs'])->name('user.fs');

    // Detail produk untuk pengguna
    Route::get('/user/product/detail/{id}', [UserController::class, 'detail_product'])->name('user.detail.product');

    // Pembelian produk
    Route::get('/product/purchase/{productId}/{userId}', [UserController::class, 'purchase']);

    // Logout user
    Route::get('/user-logout', [AuthController::class, 'user_logout'])->name('user.logout');
});
