<?php

use App\Http\Controllers\Masterfiles\ProductController;
use App\Http\Controllers\Masterfiles\UserController;
use App\Http\Controllers\Modules\OrderController;
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

/**
 * ----------------------------------------------------------------
 * Redirect `/` to `/users`
 * ----------------------------------------------------------------
 */
Route::get('/', function() {
    return redirect('/users');
});

Route::get('/users/dataList', [UserController::class, 'dataList'])->name('users.dataList');
Route::resource('/users', UserController::class);
Route::get('/products/dataList', [ProductController::class, 'dataList'])->name('products.dataList');
Route::resource('/products', ProductController::class);
Route::resource('/orders', OrderController::class);