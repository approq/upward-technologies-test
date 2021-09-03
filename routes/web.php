<?php

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


Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index'])
    ->name('home');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Front\HomeController::class, 'dashboard'])
        ->name('dashboard');
    Route::get('/products', [App\Http\Controllers\Front\ProductController::class, 'index'])
        ->name('products.index');
    Route::get('/products/create', [App\Http\Controllers\Front\ProductController::class, 'create'])
        ->name('products.create');
    Route::get('/products/{product}', [App\Http\Controllers\Front\ProductController::class, 'edit'])
        ->name('products.edit');
});
