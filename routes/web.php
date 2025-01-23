<?php

use App\Http\Controllers\AdminHistoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
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
    Route::patch('/orders/payment/{id}/success', [InvoiceController::class, 'paymentSuccess'])->name('orders.payment.success')->middleware('verified');

    Route::get('/orders/review/{id}', [ReviewController::class, 'show'])->name('orders.review');
    Route::post('/orders/review/{id}', [ReviewController::class, 'submitReview'])->name('orders.submitReview');

    Route::post('/send-invoice', [InvoiceController::class, 'sendToEmail'])->name('invoice.send');

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'index'])->name('auth.login');
    Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'loginAction'])->name('auth.login.action');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'registerAction'])->name('auth.register.action');
    Route::get('forgot-password', [App\Http\Controllers\AuthController::class, 'forgotPassword'])->name('password.request');
    Route::post('forgot-password', [App\Http\Controllers\AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [App\Http\Controllers\AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [App\Http\Controllers\AuthController::class, 'updatePassword'])->name('password.update');
});



Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    // Route::get('/admin/item',[App\Http\Controllers\ProductsRentController::class, 'index'])->name('admin.item');
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/history', [AdminHistoryController::class, 'index'])->name('admin.history');
    Route::get('/admin/history/history-excel', [AdminHistoryController::class, 'historyExcel'])->name('admin.history.historyExcel');
    Route::get('/admin/history/detail-history-excel', [AdminHistoryController::class, 'detailHistoryExcel'])->name('admin.history.detailHistoryExcel');
    Route::get('/admin/history/{id}', [AdminHistoryController::class, 'show'])->name('admin.show');
    Route::get('/admin/history/{id}/change-status', [AdminHistoryController::class, 'status'])->name('admin.status');
    Route::get('/admin/report', [ReportController::class, 'generateReport'])->name('admin.report');
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

Route::get('/test', function() {
    return view('emails.rent_status_update', [
        'fullName' => 'John Doe',
       'status' => 'Pending',
    ]);
});

Route::get('/test', function() {
    $items = App\Models\RentDetailsModel::with(['product', 'product.images'])->get();
    $rent = App\Models\Rent::all();
    $totalBorrowed = $rent->count();
    $totalIncome = $items->sum('subtotal');

    $quantityRentTotal = Illuminate\Support\Facades\DB::table('rent_details as rd')
            ->join('rents as r', 'rd.rent_id', '=', 'r.id')
            ->whereIn('r.status_rent', ['done', 'renting'])
            ->sum('rd.quantity');
    $data = [
        'name' => 'NMBT App',
        'address' => 'Uber Street Gotham City',
        'phone' => '081234567890',
        'email' => 'admin@example.com',
    ];

    return view('pdf.report', compact('items','totalBorrowed', 'totalIncome', 'quantityRentTotal', 'data'));
});
