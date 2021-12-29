<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Message\Entities\ChatRoom;

class ChatController extends Controller
{
    public function index()
    {
        $chatRooms = ChatRoom::with('customerUser')->where('vendor_user_id', auth()->id())->get();

        $activeChatRoom = $chatRooms->first();
        $activeChatRoom->load('customerUser');

        return view('chat.index', [
            'user' => auth()->user(),
            // 'token' => 
            'chatRooms' => $chatRooms,
            'activeChatRoom' => $activeChatRoom
        ]);
    }
}
