<?php

use Illuminate\Http\Request;
use Modules\Deal\Http\Controllers\DealApiController;
use Modules\Deal\Http\Controllers\DealController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/deal', function (Request $request) {
    return $request->user();
});
Route::delete('/deals', [DealController::class,'destroy'])->name('api.deletedeal');
Route::put('/deals', [DealController::class,'update'])->name('api.updatedeal');
Route::post('/deals', [DealController::class,'store'])->name('api.storedeal');

Route::get('deals/customer-search', [DealApiController::class,'customerSearch'])->name('api.productsearch');
Route::get('deals/product-search', [DealApiController::class,'productSearch'])->name('api.productsearch');

