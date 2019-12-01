<?php

namespace App\Http\Controllers;

use App\Girl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeCaruselController extends Controller
{
    //
    public function index()
    {
        return view('likeCarusel');
    }

    public function getAnket()
    {
        $userAuth = Auth::user();
        if ($userAuth == null) {
            return redirect('login');
        }
        $authGirl = $userAuth->anketisExsis();
        /*
         * 1. Получаем анкеты, которые меня интересуют.
         * 2. ПОлучаем тех, кому еще не поставил лайк
         * 3. Вывыжим
         *
         * Таблица с лайками- likes
         * */

        //    $ankets = Girl::select()->where('sex', $authGirl->meet)->get();
        //
        //  dump($ankets);
        if ($authGirl->meet != null) {
            $results = DB::table('girls')->where('sex', $authGirl->meet);
        }

        if ($authGirl->from_age != null) {
            $results = DB::table('girls')
                ->where('age', '>=', $authGirl->from_age);
        }

        if ($authGirl->to_age != null) {
            $results = DB::table('girls')
                ->where('age', '<=', $authGirl->to_age);
        }


        $girls = $results->get();
        $girl = $results->first();

        //теперь смотрим лайки
        $hasLike = DB::table('like_caruse')->where('who_id', $authGirl->id)
            ->get();
        $rezultArray = Array();
        //хз, как быстро это сделать, попробую в циклт удалить тех, кому уже поставили лайк
        foreach ($girls as $girl => $key) {
            foreach ($hasLike as $like) {

                if ($like->target_id == $key->id) {

                } else {
                    array_push($rezultArray, $key);
                }
            }
        }

//        dump($rezultArray);

        //тут нежно дату просмотра вставлять, в likeCarusel;
        DB::table('like_caruse')->insert(
            ['who_id' => $authGirl->id, 'target_id' => $girl]
        );

        $girl = Girl::select(['id', 'name', 'main_image'])
            ->where('id', $girl)->first();

        return $girl;

    }

    public function newLike(Request $request)
    {

        $girl = Girl::select(['id', 'name', 'main_image'])
            ->where('id', $request->girl_id)->first();
        $userAuth = Auth::user();
        if ($userAuth == null) {
            return redirect('login');
        }
        $authGirl = $userAuth->anketisExsis();

        DB::table('like_caruse')->where(
            ['who_id' => $authGirl->id, 'target_id' => $girl->id]
        )->update(['like' => 1]);

        return response()->json(['ok']);
    }
}
