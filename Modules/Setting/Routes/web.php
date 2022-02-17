<?php

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

use Modules\Setting\Http\Controllers\SastoWholesaleMallSettingController;

Route::prefix('settings')->group(function() {
    Route::get('sastowholesale-mall', [SastoWholesaleMallSettingController::class, 'index'])->name('settings.sastowholesale-mall.index');
    Route::post('sastowholesale-mall', [SastoWholesaleMallSettingController::class, 'store'])->name('settings.sastowholesale-mall.store');
});
