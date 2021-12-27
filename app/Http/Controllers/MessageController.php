<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageEvent;

class MessageController extends Controller
{
    public function message(Request $request)
    {
        $message = $request->message;
        broadcast(new MessageEvent(1, $message))->toOthers();
        return response()->json("Message Sent Successfully");
    }
}
