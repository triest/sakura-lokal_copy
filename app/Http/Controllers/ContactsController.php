<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Message;

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
       $messages=Message::where('from',$id)->orWhere('to',$id)->get();
        return response()->json($messages);
    }

}