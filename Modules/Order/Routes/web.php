<?php

use Modules\Order\Http\Controllers\OrderController;

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

Route::prefix('order')->group(function() {
    // Route::get('/', 'OrderController@index');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::resource('order', 'OrderController');
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
Route::get('/order/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
Route::get('/get-vendor-orders', 'OrderController@getVendorOrders')->name('getVendorOrders');
});
