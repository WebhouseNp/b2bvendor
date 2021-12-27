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

// Route::prefix('review')->group(function() {
//     Route::get('/', 'ReviewController@index');
// });

Route::prefix('admin')->middleware(['auth','Superadmin'])->group(function(){
    Route::get('reviews', 'ReviewController@index')->name('review.index');
});
