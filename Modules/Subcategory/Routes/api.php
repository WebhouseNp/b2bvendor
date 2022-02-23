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

Route::middleware('auth:api')->get('/subcategory', function (Request $request) {
    return $request->user();
});
Route::group([ 'middleware' => ['auth:api']], function () {
Route::post('/createsubcategory', 'SubcategoryController@store');
Route::get('/getcategory', 'SubcategoryController@getcategories');
Route::get('/getsubcategories', 'SubcategoryController@getsubcategories');
Route::delete('/deletesubcategory/{subcategory}', 'SubcategoryController@deletesubcategory')->name('api.deletesubcategory');
// Route::post('/getsubcategoryFromID', 'subcategoryController@getsubcategoryFromID');
Route::get('/view-subcategory', 'SubcategoryController@viewsubcategory')->name('viewsubcategory');
Route::get('/editsubcategory', 'SubcategoryController@editsubcategory')->name('editsubcategory');
Route::post('/updatesubcategory', 'SubcategoryController@updatesubcategory');
});

Route::put('subcategory/{subcategory}/publish', 'SubcategoryPublicationController@store')->name('api.subcategory.publish');
Route::delete('subcategory/{subcategory}/unpublish', 'SubcategoryPublicationController@destroy')->name('api.subcategory.unpublish');