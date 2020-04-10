<?php

namespace App\Http\Controllers;

use App\Album;
use App\AlbumPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class AlbumController extends Controller
{
    //
    public function albumCreate(Request $request)
    {
        return view('anket.albumCreate');
    }

    public function albumStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $album = new Album();
        $album->name = $request->name;
        $user = Auth::user();
        $user = $user->getautch();
        $anket = $user->girl()->first();

        $anket->albums()->save($album);

        return view('anket.albumpage')->with(['album' => $album]);
    }

    public function album($id, Request $request)
    {
        $album = Album::select(['id', 'name'])->where('id', $id)->first();

        $photos = $album->photos()->get();

        return view('anket.albumpage')->with([
            'album'  => $album,
            'photos' => $photos,
        ]);
    }

    public function getAlbumPhotos($id, Request $request)
    {

        $album = Album::select(['id', 'name'])->where('id', $id)->first();

        $photos = $album->photos()->get();

        //  dump($request);


        if ($request->get('type') == "json") {
            return response()->json(['photos' => $photos]);
        }

        return $photos;
    }

    public function uploadPhotoToAlbum($id, Request $request)
    {
        $album = Album::select(['id', 'name'])->where('id', $id)->first();
        //dump($request);
        if (Input::hasFile('file')) {
            $image_extension = $request->file('file')
                ->getClientOriginalExtension();
            $image_new_name = md5(microtime(true));
            $temp_file = base_path().'/public/images/albums/'
                .strtolower($image_new_name.'.'
                    .$image_extension);// кладем файл с новыс именем
            $request->file('file')
                ->move(base_path().'/public/images/albums/',
                    strtolower($image_new_name.'.'.$image_extension));

            $albumPhoto = new AlbumPhoto();
            $albumPhoto->photo_name = $image_new_name.'.'.$image_extension;
            $albumPhoto->save();
            $album->Photos()->save($albumPhoto);
        }

        return response()->json();
    }

    public function getImage($id, Request $request)
    {

        $photo = AlbumPhoto::select(['*'])->where('id', $id)->first();

        $type = $request->get('type');
        if ($type == "json") {
            return response()->json(['photo' => $photo]);
        } else {
            return $photo;
        }


    }
}
