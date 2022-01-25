<?php

use Modules\Product\Http\Controllers\ProductController;
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

Route::prefix('product')->group(function () {
    // Route::get('/', 'ProductController@index');
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'Adminrole']], function () {
    Route::get('/productimage/{id}', [ProductController::class, 'productImage'])->name('product.images');
    Route::post('/edit-product-images-details/{id}', 'ProductController@updateProductImage')->name('product-update');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::get('/product/view/{id}', [ProductController::class, 'view'])->name('product.view');
    Route::post('/delete-product-image', [ProductController::class, 'deleteImageById'])->name('deleteImageById');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'Superadmin']], function () {
    Route::get('/product/request', [ProductController::class, 'productRequest'])->name('product.request');
});
Route::group(['prefix' => 'product', 'middleware' => ['auth']], function () {
    Route::get('/{type}', [ProductController::class, 'index'])->name('product.index');
});
