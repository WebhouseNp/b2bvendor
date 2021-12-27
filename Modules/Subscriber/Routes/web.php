<?php
use Modules\Subscriber\Http\Controllers\SubscriberController;

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

// Route::prefix('subscriber')->group(function() {
//     Route::get('/', 'SubscriberController@index');
// });

Route::group(['prefix' => 'admin', 'middleware' => ['auth','Admin']], function () {
    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscriber.index');
    Route::get('/delete-subscriber/{id}', [SubscriberController::class, 'delete'])->name('delete-subscriber');
	Route::get('/edit-subscriber/{id}', [SubscriberController::class, 'edit'])->name('subscriber.edit');
    Route::put('/update-subscriber/{id}', [SubscriberController::class, 'update'])->name('subscriber.update');
});
