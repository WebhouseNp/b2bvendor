<?php

use Illuminate\Http\Request;
use Modules\User\Http\Controllers\ApiUserController;
use Modules\User\Http\Controllers\ProfileController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/createdue', 'ApiUserController@createdue');
Route::prefix('vendor')->name('api.')->group(function(){
    Route::get('/', 'ApiUserController@index')->name('vendor')->middleware('auth:api');
    Route::post('/login','ApiUserController@login')->name('login')->middleware('Vendor');
    Route::post('/register','ApiUserController@register')->name('register');

    Route::get('getVendorFromID/{id}', 'ApiUserController@getVendorFromID')->middleware('auth:api')->name('getVendorFromID');
    
    Route::put('updateVendor/{id}', 'ApiUserController@updateVendor')->middleware('auth:api')->name('updateVendor');
    Route::delete('deleteVendor', 'ApiUserController@deleteVendor')->name('deleteVendor');
    // Route::post('/account-activate', [ApiUserController::class, 'verifyNewAccount'])->name('VerifyAccount');

    Route::post('verification-code/{code}','ApiUserController@verifificationCode')->name('verifificationCode');
    Route::post('send-email-link', 'ApiUserController@sendEmailLink')->name('sendEmailLink');

    Route::post('reset-password', 'ApiUserController@resetPassword')->name('passwordResetForm');
    Route::post('update-password', 'ApiUserController@updatePassword')->name('updatePassword');
    Route::post('change-password', 'ApiUserController@changePassword')->name('changePassword');
    });

    Route::prefix('user')->name('api.')->group(function(){
        Route::post('/login','UserController@login')->name('login');
        Route::post('/register', 'UserController@register')->name('register');
    
        Route::post('verification-code/{code}','UserController@verifificationCode')->name('verifificationCode');
        Route::post('send-email-link', 'UserController@sendEmailLink')->name('sendEmailLink');
        Route::post('reset-password', 'ApiUserController@resetPassword')->name('passwordResetForm');
        Route::post('update-password', 'UserController@updatePassword')->name('updatePassword');
        Route::post('change-password', 'UserController@changePassword')->middleware('auth:api')->name('changePassword');
        Route::get('edit-user-profile/{id}', 'ProfileController@edit')->middleware('auth:api')->name('editUserProfile');
        Route::put('edit-user-profile/{id}', 'ProfileController@update')->middleware('auth:api')->name('updateUserProfile');
        Route::post('add-address/{id}', 'ProfileController@addAddress')->middleware('auth:api')->name('addAddress');
        Route::post('edit-address/{id}', 'ProfileController@editAddress')->middleware('auth:api')->name('editAddress');
        });

        Route::post('changeVendorStatus', 'ApiUserController@changeVendorStatus')->name('api.changeVendorStatus');