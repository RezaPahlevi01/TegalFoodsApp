<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\MitraUmkmController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUmkmController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Umkm\DashboardController;
use App\Http\Controllers\Umkm\ProductController;
use App\Http\Controllers\Umkm\ProfileController;






Route::middleware(['auth','umkm'])->group(function () {

    Route::get('/umkm/dashboard',
        [DashboardController::class,'index']
    )->name('umkm.dashboard');

    Route::get('/umkm/profile/edit',
        [DashboardController::class,'editProfile']
    )->name('umkm.profile.edit');

    Route::post('/umkm/profile/update',
        [DashboardController::class,'updateProfile']
    )->name('umkm.profile.update');
    
    Route::get('/products',[ProductController::class,'index'])
        ->name('umkm.products.index');

    Route::get('/products/create',[ProductController::class,'create'])
        ->name('umkm.products.create');

    Route::post('/products',[ProductController::class,'store'])
        ->name('umkm.products.store');

    Route::get('/products/{id}/edit',[ProductController::class,'edit'])
        ->name('umkm.products.edit');

    Route::put('/products/{id}',[ProductController::class,'update'])
        ->name('umkm.products.update');

    Route::delete('/products/{id}',[ProductController::class,'destroy'])
        ->name('umkm.products.destroy');

});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::get('/umkm/{id}', [UmkmController::class, 'show'])
    ->whereNumber('id')
    ->name('umkm.show');

Route::get('/mitra-umkm', [MitraUmkmController::class, 'index'])->name('mitra.umkm');
Route::get('/mitra-umkm/search', [MitraUmkmController::class, 'search'])->name('mitra.umkm.search');

/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // UMKM
        Route::get('/umkm', [AdminUmkmController::class, 'index'])->name('umkm.index');
        Route::post('/umkm', [AdminUmkmController::class, 'store'])->name('umkm.store');
        Route::get('/umkm/create', [AdminUmkmController::class, 'create'])->name('umkm.create');
        Route::put('/umkm/{umkm}', [AdminUmkmController::class, 'update'])->name('umkm.update');
        Route::get('/umkm/{umkm}/edit', [AdminUmkmController::class, 'edit'])->name('umkm.edit');
        Route::delete('/umkm/{umkm}', [AdminUmkmController::class, 'destroy'])->name('umkm.destroy');

        // SLIDER
        Route::get('/slider', [AdminSliderController::class, 'index'])->name('slider.index');
        Route::get('/slider/create', [AdminSliderController::class, 'create'])->name('slider.create');
        Route::post('/slider', [AdminSliderController::class, 'store'])->name('slider.store');
        Route::delete('/slider/{slider}', [AdminSliderController::class, 'destroy'])->name('slider.destroy');
    });