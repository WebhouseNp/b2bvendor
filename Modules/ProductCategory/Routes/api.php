<?php

use Illuminate\Support\Facades\Route;
use Modules\ProductCategory\Http\Controllers\ProductCategoryPublicationController;

Route::patch('product-category/{productCategory}/publish', [ProductCategoryPublicationController::class, 'store'])->middleware('auth:api');
Route::patch('product-category/{productCategory}/unpublish', [ProductCategoryPublicationController::class, 'destroy'])->middleware('auth:api');
