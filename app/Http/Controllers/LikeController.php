<?php

namespace App\Http\Controllers;

use App\Girl;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    //
    public function newLike(Request $request)
    {
        $targetGirl = Girl::select([
            'name',
            'id',
            'description',
            'main_image',
            'sex',
            'meet',
            'weight',
            'height',
            'age',
            'country_id',
            'region_id',
            'city_id',
            'banned',
            'user_id',
            'status',
        ])->where('id', $request->girl_id)->first();

        $user = Auth::user();

        $whoGirl = Girl::select([
            'name',
            'id',
            'description',
            'main_image',
            'sex',
            'meet',
            'weight',
            'height',
            'age',
            'country_id',
            'region_id',
            'city_id',
            'banned',
            'user_id',
            'status',
        ])->where('user_id', $user->id)->first();


        $like = new Like();
        $like->target_id = $targetGirl->id;
        $like->who_id = $whoGirl->id;
        $like->save();

        return response()->json(['ok']);
    }

    public function getLikesNumber(Request $request)
    {
        $targetGirl = Girl::select([
            'name',
            'id',
            'description',
            'main_image',
            'sex',
            'meet',
            'weight',
            'height',
            'age',
            'country_id',
            'region_id',
            'city_id',
            'banned',
            'user_id',
            'status',
        ])->where('id', $request->girl_id)->first();
        $nmberLikes = DB::table('likes')->where('target_id', $request->girl_id)->get()->count();

        return response()->json(['likeNumber' => $nmberLikes]);
    }

    public function getLikesNumberAuch(Request $request)
    {
        $targetGirl = Girl::select([
            'name',
            'id',
            'description',
            'main_image',
            'sex',
            'meet',
            'weight',
            'height',
            'age',
            'country_id',
            'region_id',
            'city_id',
            'banned',
            'user_id',
            'status',
        ])->where('id', $request->girl_id)->first();
        $user = Auth::user();  // и если админ
        $id = $user->get_gitl_id();
        if ($id != null) {
            $nmberLikes = DB::table('likes')->where('target_id', $id)->get()->count();

            return response()->json(['likeNumber' => $nmberLikes]);
        } else {
            return response()->json(['null']);
        }
    }

    public function likeSended(Request $request)
    {
        // dump($request);
        $targetGirl = Girl::select([
            'name',
            'id',
        ])->where('id', $request->girl_id)->first();

        $user = Auth::user();

        $whoGirl = Girl::select([
            'name',
            'id',
            'description',
            'main_image',
            'sex',
            'meet',
            'weight',
            'height',
            'age',
            'country_id',
            'region_id',
            'city_id',
            'banned',
            'user_id',
            'status',
        ])->where('user_id', $user->id)->first();

        if ($whoGirl == null) {
            return response()->json(['not']);
        }
        // dump($request);
        // dump($whoGirl);
        // dump($targetGirl);

        $like = Like::select(['id'])->where('who_id', $whoGirl->id)->where('target_id', $targetGirl->id)->first();
        if ($like != null) {
            return response()->json('alredy');
        } else {
            return response()->json('not');
        }
    }

    public function getLikesList(Request $request)
    {
        $user = Auth::user();

        $targetGirl = Girl::select([
            'name',
            'id',
            'description',
            'main_image',
            'sex',
            'meet',
            'weight',
            'height',
            'age',
            'country_id',
            'region_id',
            'city_id',
            'banned',
            'user_id',
            'status',
        ])->where('user_id', $user->id)->first();

        if ($targetGirl != null) {
            $nmberLikes = DB::table('likes')
                ->join('girls', 'likes.who_id', '=', 'girls.id')
                ->where('target_id', $targetGirl->id)
                ->orderBy('likes.updated_at','DESC')
                ->get();

            return response()->json($nmberLikes);
        } else {
            return response()->json(['nolakes']);
        }
    }
}
