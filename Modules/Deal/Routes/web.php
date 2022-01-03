<?php

// use Modules\Deal\Http\Controllers\DealController;

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

// Route::prefix('deal')->group(function() {
//     Route::get('/', 'DealController@index');
// });
Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {
    Route::resource('deals', DealController::class);
});