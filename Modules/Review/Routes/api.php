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

Route::middleware('auth:api')->get('/review', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:api')->group(function () {
    Route::post('create-review', 'ReviewController@createReview')->name('review.create');
    Route::get('product-review/{id}', 'ReviewController@productReview')->name('review.product');
    Route::put('reviews/{review}/publish', 'ReviewPublicationController@store')->name('api.reviews.publish');
    Route::delete('reviews/{review}/unpublish', 'ReviewPublicationController@destroy')->name('api.reviews.unpublish');
// });