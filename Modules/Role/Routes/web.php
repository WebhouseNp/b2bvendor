<?php

use Modules\Role\Http\Controllers\RoleController;

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

Route::prefix('role')->group(function() {
    Route::get('/', 'RoleController@index');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth','Admin']], function () {
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::get('/role/view/{id}', [RoleController::class, 'view'])->name('role.view');
});
