<?php

namespace Modules\Message\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Message\Entities\ChatRoom;
use Modules\Message\Transformers\ChatRoomResource;

class ChatroomController extends Controller
{
    public function index()
    {
        $chatRooms = ChatRoom::myParticipation()->paginate(10);

        return ChatRoomResource::collection($chatRooms);
    }

    public function start(Request $request)
    {
        $request->validate([
            'customer_user_id' => 'required',
            'vendor_user_id' => 'required'
        ]);

        // TODO::authorize

        $chatRoom = ChatRoom::where('customer_user_id', $request->customer_user_id)
            ->where('vendor_user_id', $request->vendor_user_id)
            ->first();

        // Create chat room if not exists
        if (!$chatRoom) {
            return $this->store($request);
        }

        return new ChatRoomResource($chatRoom);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_user_id' => 'required',
            'vendor_user_id' => 'required'
        ]);

        $chatRoom = ChatRoom::create([
            'customer_user_id' => $request->customer_user_id,
            'vendor_user_id' => $request->vendor_user_id,
        ]);

        return new ChatRoomResource($chatRoom);
    }

    public function show(ChatRoom $chatRoom)
    {
        return new ChatRoomResource($chatRoom);
        // return response()->json(['status' => 'success', 'data' => $chatRoom], 200);
    }

    public function destroy(ChatRoom $chatRoom)
    {
        // TODO::authorize
        $chatRoom->delete();

        return response()->json([
            'message' => 'Conversation has been deleted.'
        ], 204);
    }
}
