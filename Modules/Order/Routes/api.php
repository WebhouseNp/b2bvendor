<?php

use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/order', function (Request $request) {
//     return $request->user();
// });

Route::post('/createorder', 'OrderController@createorder');
Route::get('/getorders', 'OrderController@getorders');
Route::post('/changeOrderStatus', 'OrderController@changeOrderStatus')->name('api.changeOrderStatus');
Route::get('/editorder', 'OrderController@editorder')->name('editorder');

Route::group(['middleware' => ['auth:api', 'Adminrole']], function () {
    Route::get('/get-vendor-orders', 'OrderController@getVendorOrders')->name('getVendorOrders');
    // // Route::post('/getroleFromID', 'RoleController@getroleFromID');
    // Route::get('/view-role', 'RoleController@viewRole')->name('viewRole');
    // Route::get('/editrole', 'RoleController@editRole')->name('editRole');
    // Route::post('/updaterole', 'RoleController@updateRole');
});
