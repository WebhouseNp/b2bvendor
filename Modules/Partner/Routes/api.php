<?php

use Illuminate\Http\Request;
use Modules\Partner\Http\Controllers\ApiPartnerController;

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

// Route::middleware('auth:api')->get('/partner', function (Request $request) {
//     return $request->user();
// });
Route::get('partners', [ApiPartnerController::class,'index'])->name('api.partners');
Route::get('partner-types', [ApiPartnerController::class,'partnerTypes'])->name('api.partnerTypes');
