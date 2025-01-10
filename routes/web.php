<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\LandingPageController::class, 'index'])->name('home');

Route::get('/sewa', [App\Http\Controllers\RentsController::class, 'index'])->name('sewa.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/user/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('user.profile.update');
    Route::post('/products/{id}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('product.cart');


    Route::group([
        'prefix' => 'cart',
    ], function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::delete('/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::patch('/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    });

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'index'])->name('auth.login');
    Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'loginAction'])->name('auth.login.action');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'registerAction'])->name('auth.register.action');
});

Route::resource('products', App\Http\Controllers\ProductsRentController::class);


Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/item',[App\Http\Controllers\ProductsRentController::class, 'index'])->name('admin.item');
    Route::get('/admin/history', function() {
        return view('admin.history');
    });
});




// Route Email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/invoice', function() {
    return view('invoice');
});
