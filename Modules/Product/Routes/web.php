<?php

use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\ProductStorageController;

Route::group(['middleware' => ['auth', 'role:super_admin|admin|vendor']], function () {
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductStorageController::class, 'create'])->name('product.create');
    Route::get('/product/edit/{product}', [ProductStorageController::class, 'edit'])->name('product.edit');
    Route::get('/product/view/{id}', [ProductController::class, 'view'])->name('product.view');
    
    Route::get('/product-images/{product}', [ProductController::class, 'productImage'])->name('product-images.index');
    Route::post('/edit-product-images-details/{id}', 'ProductController@updateProductImage')->name('product-update');
    Route::post('dropzone/upload/{id}',[ProductImageController::class, 'upload'])->name('dropzone.upload');
    Route::post('/delete-product-image', [ProductController::class, 'deleteImageById'])->name('deleteImageById');
});
