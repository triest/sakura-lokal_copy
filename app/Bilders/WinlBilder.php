<?php
/**
 * Created by PhpStorm.
 * User: triest
 * Date: 20.04.2020
 * Time: 12:12
 */

namespace App\Bilders;


use App\Dialog;
use App\Events\NewMessage;
use App\Girl;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Auth;

class WinlBilder
{

    public function makeWink($id)
    {
        $this->sendMessage($id);
    }

    public function sendMessage($id)
    {
        $user = Auth::user();
        if ($user == null) {
            return \response(404);
        }

        $userAuth = Auth::user();
        $authGirl = $user->anketisExsis();
        if ($authGirl == null || $userAuth == null) {
            return response()->setStatusCode(404);
        }
        $targetGirl = Girl::select(['id', 'user_id', 'name', 'sex'])
            ->where('id', $id)
            ->first();
        $targetUser = User::select(['id', 'name'])
            ->where('id', $targetGirl->user_id)->first();
        //отправляем сообщение

        $text = $targetGirl->name;
        if ($targetGirl->sex == "male") {
            $text .= " подмигнул вам";
        } elseif ($targetGirl->sex == "famele") {
            $text .= " подмигнула вам";
        }


        $message = Message::create([
            'from' => $userAuth->id,
            'to'   => $targetUser->id,
            'text' => $text,
        ]);


        $dialog = Dialog::select(['id', 'my_id', 'other_id'])
            ->where('my_id', $user->id)->where('other_id',
                $user->id)->first();

        if ($dialog == null) {
            $dialog3 = new Dialog();
            $dialog3->my_id = $userAuth->id;
            $dialog3->other_id = $targetUser->id;
            $dialog3->save();
        }

        $dialog2 = Dialog::select(['id', 'my_id', 'other_id'])
            ->where('other_id', $targetUser->id)->where('my_id',
                $userAuth->id)->first();


        if ($dialog2 == null) {
            $dialog4 = new Dialog();
            $dialog4->other_id = $user->id;
            $dialog4->my_id = $userAuth->id;
            $dialog4->save();
        }

        broadcast(new NewMessage($message));
    }

}