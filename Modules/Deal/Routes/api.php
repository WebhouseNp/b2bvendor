<?php

use Illuminate\Http\Request;

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
Route::delete('/deleteproduct', [DealController::class,'destroy'])->name('api.deletedeal');
Route::put('/updateproduct', [DealController::class,'update'])->name('api.updatedeal');
Route::post('/updateproduct', [DealController::class,'store'])->name('api.storedeal');

