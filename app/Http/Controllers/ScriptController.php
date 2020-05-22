<?php

namespace App\Http\Controllers;

use App\SearchSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScriptController extends Controller
{
    //

    public function newInMySeach(Request $request)
    {
        /*
         *  1) Выбираем все настройк
         * */
        $seach_settings = SearchSettings::select(['*'])->get();

        //   $anketsWhoSeach = $seach_settings->girls()->get(); // получаем анкеты

        $whoSeachArray = array();

        foreach ($seach_settings as $item) {
            $whoSeachArray[] = $item->girl()->first();
        }

        // теперь по очениди ищим

        $result_array = array();

        foreach ($seach_settings as $seachSettings) {
            $girls = DB::table('girls');

            $interest = $seachSettings->interest()->get();


            if ($interest->isNotEmpty()) {
                $girls->leftJoin('girl_interess', 'girl_interess.girl_id', '=',
                    'girls.id');
                // надо плдучить массив id штеукуыщцж
                $interest_array = array();
                foreach ($interest as $item) {
                    array_push($interest_array, $item->id);
                }

                $girls->whereIn('girl_interess.interest_id', $interest_array);
            }

            $targets = $seachSettings->target()->get();

            if ($targets->isNotEmpty()) {
                $girls->leftJoin('girl_target', 'girl_target.girl_id', '=',
                    'girls.id');
                // надо плдучить массив id штеукуыщцж
                $interest_array = array();
                foreach ($targets as $item) {
                    array_push($interest_array, $item->id);
                }

                $girls->whereIn('girl_target.target_id', $interest_array);
            }


            if ($seachSettings->children != null
                || $seachSettings->children != 0
            ) {
                $girls->where('children_id', '=', $seachSettings->children);
            }


            if ($seachSettings->age_from != null) {
                $girls->where('age', '>=', $seachSettings->age_from);
            }


            if ($seachSettings->age_to != null) {
                $girls->where('age', '<=', $seachSettings->age_to);
            }

            if ($seachSettings->meet != null
                && $seachSettings->meet != "nomatter"
            ) {
                $girls->where('sex', '=', $seachSettings->meet);
            }

            if (isset($seachSettings) && $seachSettings->relation != 0) {
                $girls->where('relation_id', '=', $seachSettings->relation);
            }

            if (isset($Autchgirls) && $Autchgirls != null) {
                $girls->where('girls.id', '!=', $Autchgirls->id);
            }

            $who = $seachSettings->girl()->first();


            if ($who->city_id != null) {
                $girls->where('city_id', $who->city_id);
            }

            /*
             * обавляем зарегистрированных или обновленных с последнего визита
             *
             * */

            $girls->where('created_at', '>=', $who->last_login);
            $girls->orWhere('updated_at', '>=', $who->last_login);


            $girls->select('girls.*');


            $girls->orderByDesc('created_at');

            $girls = $girls->get();

            /*
             * тут массив для  отправки
             * */


            $array = array(["ankets" => $girls, "who" => $who]);
            $result_array[] = $array;
        }

        // В цикле отправляем

        foreach ($result_array as $item) {

            if ($item[0]["ankets"]->isEmpty()) {
                continue;              //пропускаем если нет новых анкет
            }

            $user = $item[0]["who"]->user()->first();

            if ($user == null) {
                continue;
            }
            $user->sendmail('Новые анкеты по вашему запросу', null, null,
                'newAnkets', $item[0]["ankets"]);
        }


    }
}
