<?php

use Modules\User\Http\Controllers\ApiUserController;
use Modules\User\Http\Controllers\UserController;


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

Route::prefix('user')->group(function() {
    // Route::get('/', 'UserController@index');
});
Route::post('/vendor/update-password', 'ApiUserController@updatePassword')->name('updatePassword');
Route::post('/vendor/login','ApiUserController@login')->name('vendor.login');
Route::get('account-activate/{activation_token}', [ApiUserController::class, 'verifyNewAccount'])->name('verifyNewAccount');
Route::get('reset-password/{token}', 'PasswordResetController@passwordResetForm')->name('passwordResetForm');

Route::prefix('admin')->name('vendor.')->middleware(['auth','Superadmin'])->group(function(){
Route::get('approved-vendors', 'VendorManagementController@getApprovedVendors')->name('getApprovedVendors');
Route::get('suspended-vendors', 'VendorManagementController@getSuspendedVendors')->name('getSuspendedVendors');
Route::get('new-vendors', 'VendorManagementController@getNewVendors')->name('getNewVendors');
Route::get('vendorprofile/{username}', 'VendorManagementController@getVendorProfile')->name('getVendorProfile');
Route::get('vendorproducts/{username}', 'VendorManagementController@getVendorProducts')->name('getVendorProducts');
Route::get('report/{id}', 'VendorManagementController@getReport')->name('getReport');

});
Route::prefix('vendor')->middleware(['auth','Vendor'])->group(function(){
Route::get('profile', 'VendorController@profile')->name('vendor.profile');
Route::get('editprofile/{id}', 'VendorController@editVendorProfile')->name('editVendorProfile');
Route::post('updateprofile/{id}', 'VendorController@updateVendorProfile')->name('updateVendorProfile');

Route::get('report', 'VendorController@getVendorPaymentReport')->name('getVendorPaymentReport');
});
Route::post('updatevendordesc/{id}', 'VendorController@updateVendorDesc')->name('updateVendorDesc');


Route::group([
    'namespace' => 'User',
    'as' => 'user.'
], function () {
Route::get('user-account-activate/{activation_token}', [UserController::class, 'verifyNewAccount'])->name('verifyNewAccount');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth','Superadmin']], function () {
    Route::get('/vendor/view/{id}', 'VendorController@view')->name('vendor.view');
});