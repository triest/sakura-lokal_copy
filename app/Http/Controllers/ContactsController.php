<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Events\newApplication;
use App\Girl;
use App\MyRequwest;
use App\Useruser;
use App\Dialog;
use Illuminate\Http\Request;
use App\User;
use App\Message;
use App\Phonerequwest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nexmo\Response;
use Symfony\Component\HttpFoundation\Tests\NewRequest;


class ContactsController extends Controller
{
    public function get()
    {
        // get all users except the authenticated one
        //   $contacts = User::where('id', '!=', auth()->id())->get();
        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $dialogs = Dialog::select('id', 'my_id', 'other_id')->where('my_id', Auth::user()->id)->get();

        //  dump($dialogs);
        $contacts = [];
        foreach ($dialogs as $dialog) {
            $other = $dialog->other_id;
            $user = DB::table('users')->join('girls', 'girls.user_id', '=', 'users.id')
                ->select('users.id', 'users.name', 'girls.main_image')
                ->where('users.id', $other)->first();
            // $user=DB::table('users')->join('gitls')
            array_push($contacts, $user);
        }

        return response()->json($contacts);
    }

    public function get2()
    {
        // get all users except the authenticated one
        // $contacts = User::where('id', '!=', auth()->id())->get();
        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        //  $contacts = null;
        $contacts = DB::select('select * from conversation con left join girls gl on gl.user_id=con.user_two where con.user_one=?',
            [Auth::user()->id]);

        return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {
        Message::where('from', $id)->where('to', auth()->id())->update(['readed' => true]);
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
            'text' => $request->text,
        ]);


        $user = Auth::user();
        $id2 = $request->contact_id;
        $dialog = Dialog::select(['id', 'my_id', 'other_id'])->where('my_id', $user->id)->where('other_id',
            $id2)->first();
        if ($dialog == null) {
            $dialog3 = new Dialog();
            $dialog3->my_id = $user->id;
            $dialog3->other_id = $id2;
            $dialog3->save();
        }
        $dialog2 = Dialog::select(['id', 'my_id', 'other_id'])->where('other_id', $user->id)->where('my_id',
            $id2)->first();
        if ($dialog2 == null) {
            $dialog4 = new Dialog();
            $dialog4->other_id = $user->id;
            $dialog4->my_id = $id2;
            $dialog4->save();
        }
        broadcast(new NewMessage($message));

        return response()->json($message);
    }


    public function sendModal(Request $request)
    {
        $girl = Girl::select(['id', 'user_id'])->where('id', $request->contact_id)->first();


        /*  $message = Message::create([
              'from' => auth()->id(),
              'to' => $girl->user_id,
              'text' => $request->text,
          ]);
        */
        $message = new Message();
        $message->from = auth()->id();
        $message->to = $girl->user_id;
        $message->text = $request->text;
        $message->save();
        broadcast(new NewMessage($message));


        $user = Auth::user();
        $id2 = $girl->user_id;
        $dialog = Dialog::select(['id', 'my_id', 'other_id'])->where('my_id', auth()->id())->where('other_id',
            $id2)->first();

        if ($dialog == null) {
            $dialog3 = new Dialog();
            $dialog3->my_id = $user->id;
            $dialog3->other_id = $id2;
            $dialog3->save();
        }
        $dialog2 = Dialog::select(['id', 'my_id', 'other_id'])->where('other_id', auth()->id())->where('my_id',
            $id2)->first();
        if ($dialog2 == null) {
            $dialog4 = new Dialog();
            $dialog4->other_id = $user->id;
            $dialog4->my_id = $id2;
            $dialog4->save();
        }


        broadcast($message);

        return response()->json($message);
    }

    public function getCountUnreadedMessages(Request $request)
    {
        $user = Auth::user();
        $messages = Message::where('to', $user->id)->where('readed', 0)->get();
        $count = count($messages);

        return $count;
    }

    //get application page
    public function getApplicationPage()
    {
        return view('application');
    }


    public function getApplication()
    {
        //просмотр запросов

        $user = Auth::user();
        //  $request = collect(DB::select('select * from requwest where target_id=?', [$user->id]));
        $request = MyRequwest::select('id',
            'who_id',
            'target_id')->where('target_id', $user->id)
            ->where('readed', 0)
            ->get();
        $array = [];
        foreach ($request as $item) {
            $girl = Girl::select(['id', 'name', 'main_image'])->where('user_id', $item->who_id)->first();
            array_push($array, $girl);
        }

        return $array;
    }

    //запросы для меня
    public function myApplication()
    {
        //просмотр запросов

        $user = Auth::user();
        //  $request = collect(DB::select('select * from requwest where target_id=?', [$user->id]));
        /* $request = MyRequwest::select('id',
             'who_id',
             'target_id', 'who_name', 'image', 'status', 'readed')->where('who_id', $user->id)
             //->where('readed', 0)
             ->get();*/

        /* $request = DB::table('requwest')->join('girls', 'girls.user_id', '=', 'users.id')
             ->select('users.id','users.name','girls.main_image')
             ->where('who_id', $user->id)->first();*/
        $requwest = collect(DB::select('select r.id,r.status,r.created_at,u.name,g.main_image from requwest r 
                    left join users u on u.id=r.target_id
                    left join girls g on u.id=g.user_id
                      where r.who_id=?', [$user->id]));

        // $array = [];

        //  return response()->json(, $request);
        return $requwest;
    }

    public function denideAccess(Request $request)
    {
        $id = $request->input('id');

        $auth = Auth::user();
        $girl = Girl::select(['id', 'user_id'])->where('id', $id)->first();


        $user_id = $girl->user_id;
        //получаем запрос
        $myrequest = MyRequwest::select('id',
            'who_id',
            'target_id', 'status', 'readed')->where('target_id', $auth->id)
            ->where('who_id', $user_id)
            ->first();

        //ставим статус закрыто
        $myrequest->readed = 1;
        $myrequest->status = 'rejected';
        $myrequest->save();

        return response()->json(['ok']);
    }

    public function makeAccess(Request $request)
    {
        $id = $request->input('id');
        $auth = Auth::user();
        $girl = Girl::select(['id', 'user_id'])->where('id', $id)->first();
        $id = $girl->user_id;
        //получаем запрос
        $myrequest = MyRequwest::select('id',
            'who_id',
            'target_id', 'status', 'readed')->where('target_id', $auth->id)
            ->where('who_id', $id)
            ->first();
        //ставим статус закрыто
        $myrequest->readed = 1;
        $myrequest->status = 'confirmed';
        $myrequest->save();
        DB::table('user_user')
            ->insert(['other_id' => $auth->id, 'my_id' => $id]);

        return response()->json(['ok']);
    }

    public function reqTest(Request $request)
    {
        $auth = Auth::user();
        $myrequest = MyRequwest::select('id',
            'who_id',
            'target_id', 'status', 'readed')->where('target_id', 16)
            ->where('who_id', 1)
            ->first();

        broadcast(new newApplication($myrequest));
    }

    public function getCountUnreadedRequwest(Request $request)
    {
        $auth = Auth::user();
        $myrequest = MyRequwest::select('id',
            'who_id',
            'target_id', 'status', 'readed')->where('target_id', $auth->id)
            ->where('readed', 0)
            ->get();
        $count = count($myrequest);

        return $count;
    }

    public function getIsPrivateOrNot(Request $request)
    {
        // dump($request);
        $id = $request->input('id');
        $auth = Auth::user();
        $private = DB::table('user_user')
            ->where('my_id', $auth->id)
            ->where('other_id', $id)
            ->first();
        if ($private == null) {
            return response()->json('false');  //
        } else {
            return response()->json('true');
        }
    }

    public function sendornot(Request $request)
    {
        $id = $request->input('id');
        $girl = Girl::select('id', 'user_id')->where('id', $id)->first();
        $auth = Auth::user();

        $myrequest = MyRequwest::select('id',
            'who_id',
            'target_id', 'status', 'readed')->where('target_id', $girl->user_id)
            ->where('who_id', $auth->id)->first();
        //  dump($myrequest);
        if ($myrequest != null) {
            return $myrequest;
        } else {
            return response()->json('not');
        }

    }

    //отправляет запрос на открытие анкеты
    public function sendreg(Request $request)
    {
        $id = $request->input('id');
        $girl = Girl::select(['id', 'user_id'])->where('id', $id)->first();

        $id = $girl->user_id;
        $auth = Auth::user();

        $girl2 = Girl::select(['name', 'main_image'])->where('user_id', $auth->id)->first();
        $myrequest = new MyRequwest();
        $myrequest->who_id = $auth->id;
        $myrequest->target_id = $id;
        $myrequest->who_name = $girl2->name;
        $myrequest->image = $girl2->main_image;
        $myrequest->save();
        broadcast(new newApplication($myrequest));

        return response()->json('ok');
    }

    public function whoHavaAccessToMyAnket(Request $request)
    {
        $auth = Auth::user();

        $users_id = Useruser::select('id', 'my_id', 'other_id')->where(
            'other_id',
            $auth->id
        )->get();//поулчаем список пользоваьедей, у которых доступ к моей анкете

        //   dump($users_id);
        $array = [];
        foreach ($users_id as $item) {
            $girl = Girl::select(['id', 'name', 'main_image'])->where('user_id', $item->my_id)->first();
            array_push($array, $girl);
        }

        return $array;
    }

    //закрыть доступ
    public function clouseaccess(Request $request)
    {
        $id = $request->input('id');
        $auth = Auth::user();
        $girl = Girl::select(['id', 'user_id'])->where('id', $id)->first();
        $id = $girl->user_id;
        //dump($id);
        DB::table('user_user')->where('my_id', '=', $id)->where('other_id', $auth->id)->delete();
        DB::table('requwest')->where('who_id', '=', $id)->where('target_id', $auth->id)->delete();

        return response()->json('ok');
    }

    public function getUserID(Request $request)
    {
        $id = $request->input('id');
        //dump($id);
        $girl = Girl::select('id', 'user_id')->where('id', $id)->first();
        if ($girl != null) {
            return \response()->json($girl->user_id);
        } else {
            return null;
        }
        // return  response()->json($id);
    }

    public function getsendregphoneornot(Request $request)
    {
        //phonerequwest ссылаеться на girl
        $id = $request->input('id');
        $auth = Auth::user();
        // dump($auth);
        $girlAuth = Girl::select(['id', 'name'])->where('user_id', $auth->id)->first();
        //  dump($girlAuth);
        $targetGirl = Girl::select(['id', 'name'])->where('id', $id)->first();
        // dump($targetGirl);


        $myrequest = Phonerequwest::select(
            'who_id',
            'target_id', 'status', 'readed')->where('who_id', $girlAuth->id)
            ->where('target_id', $targetGirl->id)->first();
        if ($myrequest == null) {
            return response()->json('not');
        } elseif ($myrequest->readed == 0) {
            return response()->json(['notreaded']);
        } elseif ($myrequest->status == 'notreaded') {
            return response()->json(['readed' => 1]);
        } elseif ($myrequest->readed == 1) {
            return response()->json(['status' => $myrequest->status]);
        }


    }

    public function sendregphone(Request $request)
    {

        $id = $request->input('id');
        $girl = Girl::select(['id', 'user_id'])->where('id', $id)->first();

        $id = $girl->user_id;


        $AythUser = Auth::user();

        // dump($AythUser);
        $girl2 = Girl::select(['id', 'name', 'main_image'])->where('user_id', $AythUser['id'])->first();
        $myrequest = new PhoneRequwest();

        //  dump($girl2);
        $myrequest->who_id = $girl2->id;

        $myrequest->target_id = $girl->id;
        $myrequest->who_name = $girl2->name;
        $myrequest->image = $girl2->main_image;
        $myrequest->save();

        //broadcast(new newApplication($myrequest));

        return response()->json('ok');
    }

    //список заявок на открытие телефон
    public function getrequwesttoopenphone(Request $request)
    {
        $AythUser = Auth::user();
        //  dump($AythUser);
        $girl = Girl::select(['id', 'user_id'])->where('user_id', $AythUser->id)->first();
         if ($girl == null) {
             return \response()->json('error');
         }
     

        $req = Phonerequwest::select()->where('target_id', $girl->id)->where('readed', 0)->get();

        // dump($req);

        return response()->json($req);
    }


    //доступ к телефону черкез user_id
    public function getnewphonaaplication(Request $request)
    {
        $user = Auth();
        $user = Auth::user();
        $application = Phonerequwest::select('id', 'who_id', 'target_id', 'readed', 'status', 'who_name', 'image',
            'created_at', 'updated_at')
            ->where('id', $request->id)->first();
        if ($application == null) {
            return null;
        }
        //иныуке

        //girl-open_phone_girl ссылаетьс нв girl_id, а из запроса приходит user_id
        $girl = Girl::select('id', 'user_id')->where('user_id', $user->getAuthIdentifier())->first();
        $target = Girl::select('id', 'user_id')->where('user_id', $request->id)->first();
        if ($girl == null) {
            return response()->json('fail');
        } else {

            $application->readed = 1;
            $application->status = 'accepted';
            $application->save();
            DB::table('girl_open_phone_girl')->insert(['target_id' => $girl->id, 'girl_id' => $target->id]);

            return response()->json('ok');
        }
    }

    public function denidephoneaplication(Request $request)
    {
        $application = Phonerequwest::select('id', 'who_id', 'target_id', 'readed', 'status', 'who_name', 'image',
            'created_at', 'updated_at')
            ->where('id', $request->id)->first();
        if ($application == null) {
            return null;
        }
        $application->readed = 1;
        $application->status = 'rejected';
        $application->save();

    }

}