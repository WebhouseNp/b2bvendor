<?php
use Modules\Front\Http\Controllers\QuotationController;

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

Route::prefix('front')->group(function() {
    Route::get('/', 'FrontController@index');
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth','Adminrole']], function () {
    Route::get('/allquotations', [QuotationController::class, 'index'])->name('allquotations');
});
