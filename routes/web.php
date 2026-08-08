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
use App\Http\Controllers\Admin\AdminFoodBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\MenuViewController;
use App\Http\Controllers\TegalChatbotController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\Umkm\UmkmOrderController;
use App\Http\Controllers\Umkm\UmkmReportController;
use App\Http\Controllers\Admin\AdminReportController;





Route::get('/', function () {
    return redirect('/welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
});
/*
|--------------------------------------------------------------------------
| USER AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login-user',
    [AuthController::class,'showLoginUser'])
    ->name('user.login');

Route::post('/login-user',
    [AuthController::class,'authenticateUser'])
    ->name('user.login.process');

Route::get('/register-user',
    [AuthController::class,'showRegisterUser'])
    ->name('user.register');

Route::post('/register-user',
    [AuthController::class,'registerUser'])
    ->name('user.register.store');

Route::post('/logout-user',
    [AuthController::class,'logoutUser'])
    ->name('user.logout');

Route::get('/auth/user/google',
    [AuthController::class,'redirectUserGoogle'])
    ->name('user.google.redirect');

Route::get('/auth/user/google/callback',
    [AuthController::class,'handleUserGoogleCallback'])
    ->name('user.google.callback');

    //ROUTE UMKM
Route::middleware(['auth:umkm', 'role:umkm'])->group(function () {
    
    Route::get('/umkm/manage-orders', [UmkmOrderController::class, 'index'])->name('umkm.manage-orders.index');

    Route::get('/umkm/manage-orders/{id}', [UmkmOrderController::class, 'show'])->name('umkm.manage-orders.show');

    Route::post('/umkm/manage-orders/{id}/status', [UmkmOrderController::class, 'updateStatus'])->name('umkm.manage-orders.updateStatus');

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

    Route::patch('/products/{id}/toggle-availability', [ProductController::class, 'toggleAvailability'])
        ->name('umkm.products.toggle-availability');

    Route::delete('/products/{id}',[ProductController::class,'destroy'])
        ->name('umkm.products.destroy');

    Route::get('/umkm/report', [UmkmReportController::class, 'index'])
        ->name('umkm.report');

    Route::get(
    '/umkm/report/pdf',
    [UmkmReportController::class,'exportPdf']
        )->name('umkm.report.pdf');
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

// GOOGLE LOGIN UMKM
Route::get('/auth/umkm/google', [AuthController::class, 'redirectToGoogle'])
    ->name('umkm.google.redirect');
Route::get('/auth/umkm/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('umkm.google.callback');




/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/umkm/{id}', [UmkmController::class, 'show'])
    ->whereNumber('id')
    ->name('umkm.show');

Route::get('/mitra-umkm', [MitraUmkmController::class, 'index'])->name('mitra.umkm');
Route::get('/mitra-umkm/search', [MitraUmkmController::class, 'search'])->name('mitra.umkm.search');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/menu/{makanan}/view', [MenuViewController::class, 'store'])->name('menu.view.store');
Route::get('/chatbot/context', [TegalChatbotController::class, 'context'])->name('chatbot.context');
Route::post('/chatbot', [TegalChatbotController::class, 'chat'])->name('chatbot.chat');
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
        Route::get('/reports', [AdminReportController::class, 'index'])
            ->name('report.index');
    });


Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [HomeController::class, 'dashboard'])
        ->name('dashboard');

    Route::post('/cart/add/{makanan}',
        [CartController::class, 'add'])
        ->name('cart.add');

    Route::get('/cart',
        [CartController::class, 'index'])
        ->name('cart.index');

    Route::delete('/cart/{cart}',
        [CartController::class, 'destroy'])
        ->name('cart.delete');
    Route::get('/checkout',
        [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout',
        [CheckoutController::class, 'store'])
        ->name('checkout.store');
    Route::get(
        '/payment/{order}',
        [PaymentController::class, 'show']
        )->name('payment.show');

    Route::post(
        '/payment/{order}',
        [PaymentController::class, 'upload']
        )->name('payment.upload');
      
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');

    Route::put('/profile/update',[UserProfileController::class,'update'])
        ->name('profile.update');

});

// FORGOT PASSWORD USER + UMKM
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])
    ->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->name('password.update');
