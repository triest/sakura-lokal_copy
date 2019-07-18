<?php

namespace App\Http\Controllers;

use App\Events\newApplication;
use App\Girl;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\DB;

class MoneyController extends Controller
{
    //
    public function getCurrentMoney(Request $request)
    {
        $user = Auth::user();
        $money = $user->money;

        return response()->json(['money' => $money]);
    }

    public function reciverMoney(Request $request)
    {
        //secret 66zzO9164xWnEsNEX6K73nFo


        $date = Carbon::now();
        File::append(base_path().'/public/file.txt', 'data2'.PHP_EOL);
        File::append(base_path().'/public/file.txt',
            'oprration_id:'.$request['operation_id'].','.'datetime: '.$request['datetime'].','.$request['sha1_hash'].','.$request['withdraw_amount'].',label:'.$request['label'].','.$date.PHP_EOL);


        $str = $_POST['notification_type'].'&'.
            $_POST['operation_id'].'&'.
            $_POST['amount'].'&'.
            $_POST['currency'].'&'.
            $_POST['datetime'].'&'.
            $_POST['sender'].'&'.
            $_POST['codepro'].'&66zzO9164xWnEsNEX6K73nFo&'.
            $_POST['label'];

         /*       if (sha1($str) != $_POST['sha1_hash']) {
                    return null;
                }
        */

        $operation_id = $request['operation_id'];
        if ($operation_id == 'test-notification') {
            try {
                $rez = DB::table('money_history')->insert([
                    'date' => $request->datetime,
                    'lable' => $request->lable,
                    'amount' => $request->amount,
                ]);
            } catch (IOException $exceptione) {
                echo $exceptione;
            }
        }


        $user = User::select(['id', 'email', 'name', 'money'])->where(['account' => $request->label])->first();
        if ($user == null) {
            return null;
        }
        $ammount = $request->amount;
        $user_money = $user->money;
       // dump($user);
        //dump($user);
        //dump($user_money);
        if ($user != null and $user_money >= 0) {
            $user_money_database = $user->money;
            $user_money_database += $ammount;
            $user->money = $user_money_database;
            $user->save();
        }

        // вставляем историю
        try {
            DB::table('money_history')->insert([
                'date' => $date,
                'user_email' => $user->email,
                'received' => $ammount,
                'operation_id' => $operation_id,
                'user_name'=>$user->name
            ]);
        } catch (IOException $exceptione) {
            echo $exceptione;
        }

        return response('OK', 200);
    }

    public function getpricestotop(Request $request)
    {
        $toTop = DB::table('prices')->where('price_name', 'to_top')->first();

        return response()->json([
            $toTop->price
            //  ["tofirstplace" => $toFirstPlase],
        ]);
    }

    public function getpricetofirstplase(Request $request)
    {
        $toFirstPlase = DB::table('prices')->where('price_name', 'to_first_place')->first();

        return response()->json([
            $toFirstPlase->price,
        ]);
    }

    public function getpricetoseach()
    {
        $toFirstPlase = DB::table('prices')->where('price_name', 'seach')->first();

        return response()->json([
            $toFirstPlase->price,

        ]);
    }

    public function getpricechangemainimage()
    {
        $toFirstPlase = DB::table('prices')->where('price_name', 'change_main_image')->first();

        return response()->json([
            $toFirstPlase->price,

        ]);
    }

    public function toFirstPlase(Request $request)
    {
        $user = Auth::user();
        $girl = Girl::select([

            'id',
            'user_id',
            'biginvip',
            'endvip',
        ])->where('user_id', $user->id)->first();
        $money = $user->money;
        $toFirstPlase = collect(DB::select('select price from prices where price_name = :price_name',
            ['price_name' => 'to_first_plase']))->first();
        $toFirstPlase->price;
        if ($toFirstPlase->price > $money) {
            return response('lowMoney');
        }
        $current_date = Carbon::now();// текушая дата
        $girl->created_at = $current_date;
        $girl->save();
        $money = $money - $toFirstPlase->price;
        $user->money = $money;
        $user->save();

        return response('ok');
    }

    public function totop(Request $request)
    {
        $user = Auth::user();
        $girl = Girl::select([
            'id',
            'user_id',
            'biginvip',
            'endvip',
        ])->where('user_id', $user->id)->first();

        $money = $user->money;
        $toTop = collect(DB::select('select price from prices where price_name = :price_name',
            ['price_name' => 'to_top']))->first();

        $days = $request->days;
        $days = floor($days);

        if ($toTop->price * $days > $money) {
            return response('lowMoney');
        }
        $current_date = Carbon::now();// текушая дата
        $end_vip = $user->endvip;
        $days = $request->days;
        $days = floor($days); //кругляем полученнаы дни
        //

        if ($end_vip == null or $end_vip < $current_date) {  //есть ли сейчас vip статусэ
            echo "endvip";
            $end_vip = $current_date;
            $begin_vip = $current_date;
            $end_vip = $this->addDayswithdate($end_vip, $days);
        } else {
            $begin_vip = $user->beginvip;
            $end_vip = $this->addDayswithdate($end_vip, $days);
        }


        $user->endvip = $end_vip;
        $user->beginvip = $begin_vip;
        $user->save();

        $new_money = $user->money - $toTop->price * $days;
        DB::table('users')->where('id', $user->id)->update(['money' => $new_money]);

        return response('top');
    }

    //добавляет дни к дате
    private function addDayswithdate($date, $days)
    {
        $date = strtotime("+".$days." days", strtotime($date));

        return date("Y-m-d H:i:s", $date);
    }

    public function toseach(Request $request)
    {
        $user = Auth::user();
        $girl = Girl::select([
            'id',
            'user_id',
            'biginvip',
            'endvip',
        ])->where('user_id', $user->id)->first();

        $money = $user->money;
        $toTop = collect(DB::select('select price from prices where price_name = :price_name',
            ['price_name' => 'seach']))->first();

        $days = $request->days;
        $days = floor($days);

        if ($toTop->price * $days > $money) {
            return response('lowMoney');
        }
        $current_date = Carbon::now();// текушая дата
        $end_vip = $user->end_search;
        $days = $request->days;
        $days = floor($days); //кругляем полученнаы дни
        //

        if ($end_vip == null or $end_vip < $current_date) {  //есть ли сейчас vip статусэ
            echo "endvip";
            $end_vip = $current_date;
            $begin_vip = $current_date;
            $end_vip = $this->addDayswithdate($end_vip, $days);
        } else {
            $begin_vip = $girl->begin_search;
            $end_vip = $this->addDayswithdate($end_vip, $days);
        }


        $girl->end_search = $end_vip;
        $girl->begin_search = $begin_vip;
        $girl->save();

        $new_money = $user->money - $toTop->price * $days;
        DB::table('users')->where('id', $user->id)->update(['money' => $new_money]);

        return response('seach');
    }

    public function changePrice(Request $request)
    {
        dump($request);
    }


}
