<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
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
    return view('welcome');
});

Route::get('products/{product}/add-to-cart/', [ProductController::class, 'addToCart'])
    ->name('products.add-to-cart');
Route::resource('products', ProductController::class)->only('index', 'show');
Route::resource('cart', CartController::class)->only('index');
