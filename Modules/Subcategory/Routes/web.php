<?php

use Modules\Subcategory\Http\Controllers\SubcategoryController;


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

Route::prefix('subcategory')->group(function() {
    Route::get('/', 'SubcategoryController@index');
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth','Adminrole']], function () {
    Route::get('/subcategory', [SubcategoryController::class, 'index'])->name('subcategory.index');
    Route::get('/subcategory/create', [SubcategoryController::class, 'create'])->name('subcategory.create');
    Route::get('/subcategory/edit/{id}', [SubcategoryController::class, 'edit'])->name('subcategory.edit');
    Route::get('/subcategory/view/{id}', [SubcategoryController::class, 'view'])->name('subcategory.view');
});