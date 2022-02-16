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

Route::middleware('auth:api')->get('/product', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/createproduct', 'ProductController@createproduct');

    Route::get('/getproducts', 'ProductController@getproducts');
    Route::get('/getcategories', 'ProductController@getcategories');
    Route::get('/getproductattributes', 'ProductController@getproductattributes');
    Route::get('/getoffers', 'ProductController@getoffers');
    Route::get('/allbrands', 'ProductController@allbrands');
    Route::post('/getsubcategory', 'ProductController@getsubcategory')->name('getsubcategory');
    Route::post('/deleteproduct', 'ProductController@deleteproduct')->name('api.deleteproduct');
    Route::post('/approveproduct', 'ProductController@approveproduct')->name('api.approveproduct');
    Route::post('/nonapprovalnote', 'ProductController@nonapprovalnote')->name('api.nonapprovalnote');
    Route::get('/view-product', 'ProductController@viewproduct')->name('viewproduct');
    Route::get('/editproduct', 'ProductController@editproduct')->name('editproduct');
    Route::post('/updateproduct', 'ProductController@updateproduct');
});

Route::put('products/{product}/publish', 'ProductPublicationController@store')->name('api.products.publish');
Route::delete('products/{product}/unpublish', 'ProductPublicationController@destroy')->name('api.products.unpublish');
