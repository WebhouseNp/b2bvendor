<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/all-categories', 'CategoryController@allCategories');
    Route::post('/createcategory', 'CategoryController@createcategory');
    Route::get('/view-category', 'CategoryController@viewcategory')->name('viewcategory');
    Route::get('/editcategory', 'CategoryController@editcategory')->name('editcategory');
    Route::post('/updatecategory', 'CategoryController@updatecategory');
    Route::delete('/deletecategory/{category}', 'CategoryController@deletecategory')->name('api.deletecategory');
});
