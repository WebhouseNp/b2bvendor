<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Modules\Message\Http\Controllers\ChatroomController;
use Modules\Message\Http\Controllers\MessageController;

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

// Route::middleware('auth:api')->get('/message', 'MessageController@conversionApi');

// Route::middleware('auth:api')->get('/message', function (Request $request) {
//     return $request->user();
// });
// Route::post('/sendfile', "MessageController@sendFileMessage");

Route::middleware('auth:api')->group(function () {
    Route::get('chats/start', [ChatroomController::class, 'start']);
    Route::get('chats/{chatRoom}', [ChatroomController::class, 'show']);
    Route::delete('chats/{chatRoom}', [ChatroomController::class, 'destroy']);

    Route::get('chats/{chatRoom}/messages', [MessageController::class, 'index']);
    Route::post('messages', [MessageController::class, 'store']);
    Route::delete('messages', [MessageController::class, 'destroy']);
});
