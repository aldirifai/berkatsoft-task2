<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return to_route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('product', ProductController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('customer', CustomerController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('order', OrderController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('order-detail', OrderDetailController::class)->only(['update', 'destroy']);
});
