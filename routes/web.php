<?php

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

Route::get('/', 'IndexController@indexPage')->name('index.page');
Route::get('/checkout', 'MercadoPagoController@checkoutPage')->name('checkout.page');

Route::post('process-payment', 'MercadoPagoController@processPayment')->name('process-payment');
