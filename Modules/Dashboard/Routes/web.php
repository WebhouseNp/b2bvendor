<?php

use Modules\Dashboard\Http\Controllers\DashboardController;
use Modules\Dashboard\Http\Controllers\SalesReportController;


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

// Route::prefix('dashboard')->group(function() {
//     Route::get('/', 'DashboardController@index');
// });

Route::group(['prefix' => 'vendor'], function () {
	    Route::get('/dashboard', [DashboardController::class, 'index'])->name('vendor-dashboard');
	});

Route::group(['prefix' => 'admin', 'middleware' => ['auth','Adminrole']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth','Adminrole']], function () {

	// Route::get('sales-report', 'SalesReportController@daily_report')->name('sales_report');
	// Route::get('salesreport/{id}', 'SalesReportController@getVendorReport')->name('getVendorReport');
});

Route::get('sales-report' , [SalesReportController::class, 'getOrderInfo'])->middleware('auth')->name('salesReport');
Route::get('salesreport/{id}', 'SalesReportController@getVendorReport')->name('getVendorReport');


Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

	// Route::get('vendor-sales-report', 'SalesReportController@getVendorOrderReport')->name('getVendorOrderReport');
});
