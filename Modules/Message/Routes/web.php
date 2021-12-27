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

use Illuminate\Support\Facades\Event;

Route::get('chat', function () {
    return view('message::chat.index');
});

Route::get('trigger-event/{chatRoom}', function(\Modules\Message\Entities\ChatRoom $chatRoom) {
    $message = new \Modules\Message\Entities\Message([
        'chat_room_id' => $chatRoom->id,
        'sender_id' => 1,
        'message' => 'test message',
        'type' => 'text',
    ]);

    $message->save();
    
    Event::dispatch(new \Modules\Message\Events\NewMessageEvent($chatRoom, $message));

    return 'fired';
});

Route::prefix('message')->group(function () {
    // Route::get('/', 'MessageController@index');
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/message', 'MessageController@index');
    Route::get('/chat/{slug}', 'MessageController@chat')->name('admin.chat');
    Route::post('/message', 'MessageController@store')->name('admin.message.store');
});
