<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Http\Request;
use App\User;
use App\Message;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    public function get()
    {
        // get all users except the authenticated one
        $contacts = User::where('id', '!=', auth()->id())->get();
        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him


        return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {
        // mark all messages with the selected contact as read
        Message::where('from', $id)->where('to', auth()->id());
        // get all messages between the authenticated user and the selected user
        $messages = Message::where('from', $id)->orWhere('to', $id)->get();
        return response()->json($messages);
    }


    public function send(Request $request)
    {
        $message = Message::create([
            'from' => auth()->id(),
            'to' => $request->contact_id,
            'text' => $request->text
        ]);
        broadcast(new NewMessage($message));
        return response()->json($message);
    }

    public function getCountUnreadedMessages(Request $request)
    {
        $user=Auth::user();
        $messages = Message::where('to', $user->id)->where('readed',0)->get();
        $count=count($messages);
        return $count;
    }
}