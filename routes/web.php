<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/login', [App\Http\Controllers\AuthController::class, 'index'])->name('auth.login');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('auth.register');
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');

Route::get('/sewa', [App\Http\Controllers\RentsController::class, 'index'])->name(name: 'sewa.index');
