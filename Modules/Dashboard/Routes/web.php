<?php

use Modules\Dashboard\Http\Controllers\DashboardController;
use Modules\Dashboard\Http\Controllers\SalesReportController;

// Route::group(['prefix' => 'vendor'], function () {
// 	    Route::get('/dashboard', [DashboardController::class, 'index'])->name('vendor-dashboard');
// 	});

// Route::group(['prefix' => 'admin', 'middleware' => ['auth','Adminrole']], function () {
//     Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });

Route::group(['middleware' => ['auth', 'role:super_admin|admin|vendor']], function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
