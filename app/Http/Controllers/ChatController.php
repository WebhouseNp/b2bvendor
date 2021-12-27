<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Message\Entities\ChatRoom;

class ChatController extends Controller
{
    public function index()
    {
        $chatRooms = ChatRoom::with('customerUser')->where('vendor_user_id', auth()->id())->get();

        return view('chat.index', [
            'chatRooms' => $chatRooms,
        ]);
    }
}
