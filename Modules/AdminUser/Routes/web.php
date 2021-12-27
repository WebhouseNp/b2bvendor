<?php

use Modules\AdminUser\Http\Controllers\AdminUserController;
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

Route::prefix('adminuser')->group(function() {
    // Route::get('/', 'AdminUserController@index');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth','Superadmin']], function () {
    Route::get('/user', [AdminUserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [AdminUserController::class, 'create'])->name('user.create');
    Route::get('/user/edit/{id}', [AdminUserController::class, 'edit'])->name('user.edit');
    Route::get('/user/view/{id}', [AdminUserController::class, 'view'])->name('user.view');
});
