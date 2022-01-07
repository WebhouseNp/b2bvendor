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

Route::middleware('auth:api')->get('/order', function (Request $request) {
    return $request->user();
});
// Route::group([ 'middleware' => ['auth:api','Adminrole']], function () {

Route::post('/createorder', 'OrderController@createorder');
Route::get('/getorders', 'OrderController@getorders');
Route::post('/changeOrderStatus', 'OrderController@changeOrderStatus')->name('api.changeOrderStatus');
Route::get('/editorder', 'OrderController@editorder')->name('editorder');
Route::post('/updateorder', 'OrderController@updateorder')->name('updateorder');
Route::post('/updateorderstatus', 'OrderController@updateOrderStatus')->name('updateorderstatus');
Route::group([ 'middleware' => ['auth:api','Adminrole']], function () {
Route::get('/get-vendor-orders', 'OrderController@getVendorOrders')->name('getVendorOrders');
// // Route::post('/getroleFromID', 'RoleController@getroleFromID');
// Route::get('/view-role', 'RoleController@viewRole')->name('viewRole');
// Route::get('/editrole', 'RoleController@editRole')->name('editRole');
// Route::post('/updaterole', 'RoleController@updateRole');
});