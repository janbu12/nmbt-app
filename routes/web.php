<?php

use App\Http\Controllers\AdminHistoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserHistoryController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\LandingPageController::class, 'index'])->name('home');

Route::get('/sewa', [App\Http\Controllers\RentsController::class, 'index'])->name('sewa.index');

Route::get('/products', [App\Http\Controllers\ProductsRentController::class, 'index'])->name('products.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/user/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('user.profile.update');
    Route::get('/user/history', [UserHistoryController::class, 'index'])->name('history.index');
    Route::get('/user/history/{id}', [UserHistoryController::class, 'show'])->name('history.show');
    Route::post('/products/{id}/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('product.cart');
    Route::resource('products', App\Http\Controllers\ProductsRentController::class)->except(['index']);

    Route::group([
        'prefix' => 'cart',
    ], function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::delete('/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::patch('/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::post('/invoice', [InvoiceController::class, 'index'])->name('cart.invoice.index')->middleware('verified');
        Route::get('/invoice')->middleware('post');
    });

    Route::post('/payment', [InvoiceController::class, 'pay'])->name('payment')->middleware('verified');
    Route::get('/payment')->middleware('post');
    Route::post('/orders/cancel/{id}', [InvoiceController::class, 'cancel'])->name('orders.cancel')->middleware('verified');
    Route::post('/orders/payment/{id}', [InvoiceController::class, 'getPaymentToken'])->name('orders.payment')->middleware('verified');
    Route::patch('/orders/payment/{id}', [InvoiceController::class, 'updatePaymentMethod'])->name('orders.payment.update')->middleware('verified');

    Route::post('/send-invoice', [InvoiceController::class, 'sendToEmail'])->name('invoice.send');

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'index'])->name('auth.login');
    Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'loginAction'])->name('auth.login.action');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'registerAction'])->name('auth.register.action');
});



Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    // Route::get('/admin/item',[App\Http\Controllers\ProductsRentController::class, 'index'])->name('admin.item');
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/history', [AdminHistoryController::class, 'index'])->name('admin.history');
    Route::get('/admin/history/{id}', [AdminHistoryController::class, 'show'])->name('admin.show');
    Route::get('/admin/history/{id}/change-status', [AdminHistoryController::class, 'status'])->name('admin.status');

});


// Route Email
Route::get('/email/verify', function (Request $request) {
    return view('auth.verify-email');
})->middleware(['auth', 'unverified'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return redirect()->back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/invoice', function() {
    return view('invoice');
});
