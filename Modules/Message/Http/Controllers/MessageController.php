<?php

namespace Modules\Message\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Message\Entities\Message;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Events\MessageEvent;

use DB;
use Modules\Message\Entities\ChatRoom;
use Modules\Message\Events\NewMessageEvent;
use Modules\Message\Transformers\MessageCollection;
use Modules\Message\Transformers\MessageResource;
use Modules\User\Entities\Vendor;

class MessageController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request, ChatRoom $chatRoom)
    {
        $messages = Message::where('chat_room_id', $chatRoom->id)->latest()->paginate(20);

        return new MessageCollection($messages->reverse());

        // older code
        $user = User::find(auth()->user()->id);
        $is_vendor = $user->vendor()->where('status', '1')->first();
        if ($is_vendor) {
            $user = $is_vendor->id;
        } else {
            $user = $user->id;
        }
        $type = $is_vendor ? 'vendor' : 'user';

        $latestMessage = DB::select(DB::raw("SELECT MAX(s.id) as id FROM messages s WHERE (s.from ='$user' AND s.from_type='$type')
            OR  (s.to ='$user' AND s.to_type='$type') GROUP BY (IF(s.from='$user', s.to, s.from))"));
        $ids = [];

        foreach ($latestMessage as $id) {
            $ids[] = $id->id;
        }
        $conversationThread = Message::select('from', 'to', 'from_type', 'to_type', 'message', 'seen', 'created_at', 'updated_at')->whereIn('id', $ids)->orderBy('created_at', 'DESC')->paginate(10);
        $allMessages = [];
        foreach ($conversationThread as $message) {

            $opponent = "";
            if ($type == 'vendor') {
                $opponentId = $message->from == $is_vendor->id ? $message->to : $message->from;
                $unseenMessage = Message::where('seen', 0)->where('to', $user)->where('to_type', $type)->where('from', $opponentId)->where('from_type', 'user')->count();
                $opponent = User::find($opponentId);
                $opponent =
                    (object)['id' => $opponent->id, 'name' => $opponent->name, 'type' => 'user'];
            } else {
                $opponentId = $message->from == $user ? $message->to : $message->from;
                $unseenMessage = Message::where('seen', 0)->where('to', $user)->where('to_type', $type)->where('from', $opponentId)->where('from_type', 'vendor')->count();
                $opponent = Vendor::find($opponentId);
                $opponent =
                    (object)['id' => $opponent->id, 'name' => $opponent->shop_name, 'type' => 'vendor'];
            }

            $allMessages[] = (object)['message' => $message, 'unseen' => $unseenMessage, 'opponent' => $opponent];
        }

        return view('message::message', compact('allMessages', 'type', 'user'));
    }


    public function chat($slug)
    {
        $user = User::find(auth()->user()->id);
        $is_vendor = $user->vendor()->where('status', '1')->first();
        $type = $is_vendor ? 'vendor' : 'user';
        $newUser = "";
        $channelName = "";
        if ($type == 'vendor') {
            $newUser = $is_vendor;
            $user = $is_vendor->id;
        } else {
            $newUser = $user;
            $user = $user->id;
        }

        try {
            $decrypted = Crypt::decryptString($slug);
            $chatAssociateUser = explode('-', $decrypted);
            $opponent = "";
            $opponentType = "";

            if ($type == 'vendor') {
                $opponentId = $chatAssociateUser[1] == $is_vendor->id ? $chatAssociateUser[3] : $chatAssociateUser[1];
                $channelName = 'vendor' . $is_vendor->id . 'user' . $chatAssociateUser[3];

                $opponent = User::select('id', 'name')->where('id', $opponentId)->first();
                $opponentType = 'user';
            } else {
                $opponentId = $chatAssociateUser[1] == $user ? $chatAssociateUser[3] : $chatAssociateUser[1];
                $channelName = 'vendor' . $chatAssociateUser[3] . 'user' . $chatAssociateUser[1];
                $opponent = Vendor::where('id', $opponentId)->first();
                $opponentType = 'vendor';
            }
            $messages = Message::orWhere(function ($query) use ($chatAssociateUser) {
                $query->where('from', $chatAssociateUser[1])->where('to', $chatAssociateUser[3]);
            })->orWhere(function ($query) use ($chatAssociateUser) {
                $query->where('to', $chatAssociateUser[1])->where('from', $chatAssociateUser[3]);
            })->get();
            $formatMessages = [];
            foreach ($messages as $message) {
                if ($message->from == $user && $message->from_type == $type) {
                    $formatMessages[] = (object)['type' => 'self', 'message' => $message->message];
                } else {
                    $formatMessages[] = (object)['type' => 'opponent', 'message' => $message->message];
                }
            }
            return view('message::chat', compact('formatMessages', 'user', 'type', 'opponent', 'opponentType', 'channelName'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
    public function conversionApi(Request $request)
    {
        $user_id = $request->user()->id;
        $user = User::find($user_id);
        $is_vendor = $user->vendor()->where('status', '1')->first();
        if ($is_vendor) {
            $user = $is_vendor->id;
        } else {
            $user = $user->id;
        }
        $type = $is_vendor ? 'vendor' : 'user';

        $latestMessage = DB::select(DB::raw("SELECT MAX(s.id) as id FROM messages s WHERE (s.from ='$user' AND s.from_type='$type')
            OR  (s.to ='$user' AND s.to_type='$type') GROUP BY (IF(s.from='$user', s.to, s.from))"));
        $ids = [];

        foreach ($latestMessage as $id) {
            $ids[] = $id->id;
        }
        $conversationThread = Message::select('from', 'to', 'from_type', 'to_type', 'message', 'seen', 'created_at', 'updated_at')->whereIn('id', $ids)->orderBy('created_at', 'DESC')->paginate(10);
        $allMessages = [];
        foreach ($conversationThread as $message) {

            $opponent = "";
            if ($type == 'vendor') {
                $opponentId = $message->from == $is_vendor->id ? $message->to : $message->from;
                $unseenMessage = Message::where('seen', 0)->where('to', $user)->where('to_type', $type)->where('from', $opponentId)->where('from_type', 'user')->count();
                $opponent = User::find($opponentId);
                $opponent =
                    (object)['id' => $opponent->id, 'name' => $opponent->name, 'type' => 'user'];
            } else {
                $opponentId = $message->from == $user ? $message->to : $message->from;
                $unseenMessage = Message::where('seen', 0)->where('to', $user)->where('to_type', $type)->where('from', $opponentId)->where('from_type', 'vendor')->count();
                $opponent = Vendor::find($opponentId);
                $opponent =
                    (object)['id' => $opponent->id, 'name' => $opponent->shop_name, 'type' => 'vendor'];
            }

            $allMessages[] = (object)['message' => $message, 'unseen' => $unseenMessage, 'opponent' => $opponent];
        }
        return response()->json(['allMessages' => $allMessages, 'user' => $user, 'type' => $type]);
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
            'chat_room_id' => 'required'
        ]);

        // TODO::authorize request

        $chatRoom = ChatRoom::whereId($request->chat_room_id)->firstOrFail();

        $message = Message::create([
            'message' => $request->message,
            'chat_room_id' => $chatRoom->id,
            'sender_id' => auth()->user()->id,
        ]);

        broadcast(new NewMessageEvent($chatRoom, $message))->toOthers();

        return response()->json(['status' => 'success'], 200);
        // return new MessageResource($message);

        // older code
        $this->validate($request, [
            'from' => 'required|integer',
            'to' => 'required|integer',
            'from_type' => 'in:vendor,user',
            'to_type' => 'in:vendor,user',
            'message' => 'required|string|max:200',
        ]);
        $message = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->message);
        $newMessage = new Message;
        $newMessage->from = $request->from;
        $newMessage->type = "text";
        $newMessage->to = $request->to;
        $newMessage->from_type = $request->from_type;
        $newMessage->to_type = $request->to_type;
        $newMessage->message = $message;
        $newMessage->save();
        $channelName = $request->from_type == 'vendor' ? $request->from_type . $request->from . $request->to_type . $request->to : $request->to_type . $request->to . $request->from_type . $request->from;
        broadcast(new MessageEvent($channelName, $message, $request->to, $request->from));
        return response()->json(['message' => 'Message saved successfully'], 200);
    }



    public function sendFileMessage(Request $request)
    {
        // $this->validate($request, [
        //     'from' => 'required|integer',
        //     'to' => 'required|integer',
        //     'from_type' => 'in:vendor,user',
        //     'to_type' => 'in:vendor,user',
        //     'file' => 'required|file',
        // ]);
        // $message = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->message);
        // $newMessage = new Message;
        // $newMessage->from = $request->from;
        // $newMessage->type = "file";
        // $newMessage->to = $request->to;
        // $newMessage->from_type = $request->from_type;
        // $newMessage->to_type = $request->to_type;

        $file =  $request->file;
        $fileName = strtotime(now()) . '.' . $file->getClientOriginalExtension();
        $path =  public_path('uploads/messages/');
        if (!file_exists($path)) {
            mkdir($path, 0757);
        }
        $file->move(public_path('uploads/messages/'), $fileName);
        return url('/uploads/messages') . '/' . $fileName;
        // $newMessage->message = $path . $fileName;
        // $newMessage->save();
        // $channelName = $request->from_type == 'vendor' ? $request->from_type . $request->from . $request->to_type . $request->to : $request->to_type . $request->to . $request->from_type . $request->from;
        // broadcast(new MessageEvent($channelName, $message, $request->to, $request->from));
        // return response()->json(['message' => 'Message saved successfully'], 200);
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
