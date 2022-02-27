<?php

use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\ProductStorageController;

Route::group(['middleware' => ['auth', 'role:super_admin|admin|vendor']], function () {
    Route::get('/productimage/{id}', [ProductController::class, 'productImage'])->name('product.images');
    Route::post('/edit-product-images-details/{id}', 'ProductController@updateProductImage')->name('product-update');
    Route::get('/product/create', [ProductStorageController::class, 'create'])->name('product.create');
    Route::get('/product/edit/{product}', [ProductStorageController::class, 'edit'])->name('product.edit');
    Route::get('/product/view/{id}', [ProductController::class, 'view'])->name('product.view');
    Route::post('/delete-product-image', [ProductController::class, 'deleteImageById'])->name('deleteImageById');
    Route::post('dropzone/upload/{id}',[ProductImageController::class, 'upload'])->name('dropzone.upload');
    // Route::post('/delete-product-image', [ProductImageController::class, 'deleteImageById'])->name('deleteImageById');
});

Route::group(['prefix' => 'product', 'middleware' => ['auth']], function () {
    Route::get('/{type}', [ProductController::class, 'index'])->name('product.index');
});

