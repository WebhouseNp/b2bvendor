<?php

use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\ProductImageController;
use Modules\Product\Http\Controllers\ProductStorageController;

Route::group(['middleware' => ['auth', 'role:super_admin|admin|vendor']], function () {
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductStorageController::class, 'create'])->name('product.create');
    Route::get('/product/edit/{product}', [ProductStorageController::class, 'edit'])->name('product.edit');
    Route::get('/product/view/{id}', [ProductController::class, 'view'])->name('product.view');
    
    Route::get('/product-pricing/{product}', [ProductStorageController::class, 'pricing'])->name('product.pricing');
    Route::post('/product-pricing/{product}', [ProductStorageController::class, 'savePricing'])->name('product.pricing.store');

    Route::get('/product-images/{product}', [ProductImageController::class, 'index'])->name('product-images.index');
    Route::get('/product-images/{product}/listing', [ProductImageController::class, 'listing'])->name('ajax.product-images.listing');
    Route::post('/product-images', [ProductImageController::class, 'store'])->name('ajax.product-images.store');
    Route::delete('/product-images/{productImage}', [ProductImageController::class, 'destroy'])->name('ajax.product-images.destroy');
    
    // Route::get('/product-images/{product}', [ProductController::class, 'productImage'])->name('product-images.index');
    // Route::post('/edit-product-images-details/{id}', 'ProductController@updateProductImage')->name('product-update');
    // Route::post('dropzone/upload/{id}',[ProductImageController::class, 'upload'])->name('dropzone.upload');
    // Route::post('/delete-product-image', [ProductController::class, 'deleteImageById'])->name('deleteImageById');
});
