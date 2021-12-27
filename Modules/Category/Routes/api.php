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

Route::middleware('auth:api')->get('/category', function (Request $request) {
    return $request->user();
});
Route::group([ 'middleware' => ['auth:api']], function () {
Route::post('/createcategory', 'CategoryController@createcategory');
Route::get('/all-categories', 'CategoryController@allCategories');
Route::post('/deletecategory', 'CategoryController@deletecategory')->name('api.deletecategory');
Route::get('/view-category', 'CategoryController@viewcategory')->name('viewcategory');
Route::get('/editcategory', 'CategoryController@editcategory')->name('editcategory');
Route::post('/updatecategory', 'CategoryController@updatecategory');
});