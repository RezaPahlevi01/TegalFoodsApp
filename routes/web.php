<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\Admin\AdminFoodBlogController;
use App\Http\Controllers\BlogController;
use App\Models\FoodBlog;

Route::middleware(['auth:umkm', 'role:umkm'])->group(function () {

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
// LOGIN VIEW
Route::get('/login-admin', function () {
    return view('auth.login-admin');
})->name('admin.login');

Route::get('/login-umkm', function () {
    return view('auth.login-umkm');
})->name('umkm.login');

// LOGIN PROCESS
Route::post('/login-admin', [AuthController::class, 'authenticateAdmin'])
    ->name('admin.login.process');

Route::post('/login-umkm', [AuthController::class, 'authenticateUmkm'])
    ->name('umkm.login.process');

Route::post('/logout-admin', [AuthController::class, 'logoutAdmin'])
    ->name('admin.logout');

Route::post('/logout-umkm', [AuthController::class, 'logoutUmkm'])
    ->name('umkm.logout');

// REGISTER UMKM
Route::get('/register-umkm', [AuthController::class, 'showRegisterUmkm'])
    ->name('umkm.register');

Route::post('/register-umkm', [AuthController::class, 'registerUmkm'])
    ->name('umkm.register.store');

// OTP
Route::get('/verify-otp', [AuthController::class, 'otpForm'])->name('otp.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');

// RESEND OTP
Route::get('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');




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

Route::get('/blog/{slug}', function ($slug) {
    $blog = FoodBlog::where('slug',$slug)->where('status','published')->firstOrFail();
    return view('blog.show', compact('blog'));
});
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth:admin', 'role:admin'])
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

        //ACTIVATE UMKM
        Route::put('/umkm/activate/{id}', [AdminUmkmController::class, 'activate'])->name('umkm.activate');
        Route::put('/umkm/deactivate/{id}', [AdminUmkmController::class, 'deactivate'])->name('umkm.deactivate');

        // FOOD BLOG
        Route::resource('foodblog', AdminFoodBlogController::class);
        Route::delete('/foodblog/{foodblog}', [AdminFoodBlogController::class, 'destroy'])
            ->name('foodblog.destroy');
        Route::put('/foodblog/published/{id}', [AdminFoodBlogController::class, 'published'])->name('foodblog.published');
        Route::put('/foodblog/draft/{id}', [AdminFoodBlogController::class, 'draft'])->name('foodblog.draft');
        Route::patch('/admin/foodblog/{id}/toggle-status',
            [AdminFoodBlogController::class, 'toggleStatus']
        );
    });

