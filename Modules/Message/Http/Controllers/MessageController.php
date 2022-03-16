<?php

namespace Modules\Message\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Message\Entities\Message;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Message\Entities\ChatRoom;
use Modules\Message\Events\NewMessageEvent;
use Modules\Message\Transformers\MessageCollection;
use Modules\Message\Transformers\MessageResource;

class MessageController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ChatRoom $chatRoom)
    {
        $messages = Message::where('chat_room_id', $chatRoom->id)->latest()->limit(50)->get();

        $messages = $messages->reverse()->values();

        return new MessageCollection($messages);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, ChatRoom $chatRoom)
    {
        // TODO::authorize request

        $this->validate($request, [
            'type' => 'nullable',
            'file' => 'nullable|file|max:2048',
            'message' => ['sometimes', 'required_without:file'],
        ]);

        $message = new Message([
            'chat_room_id' => $chatRoom->id,
            'sender_id' => auth()->user()->id,
        ]);

        switch ($request->type) {
            case 'file':
                $message->type = 'file';
                $message->file = $request->file('file')->store('chat_files');
                break;

            case 'product':
                $message->type = 'product';
                $message->key = $request->key;
                break;

            default:
                $message->type = 'text';
                $message->message = $request->message;
        }

        $message->message = $request->message;

        $message->save();

        broadcast(new NewMessageEvent($chatRoom, $message))->toOthers();

        return response()->json([
            'ts' => $request->ts ?? null,
            'data' => new MessageResource($message)
        ], 200);
    }


    public function sendFileMessage(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return response()->json(['status' => 'success'], 204);
    }
}
