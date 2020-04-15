<?php

namespace App\Http\Controllers;

use App\Album;
use App\AlbumPhoto;
use App\Girl;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use File;

class AlbumController extends Controller
{
    //
    public function albumCreate(Request $request)
    {
        return view('anket.albumCreate');
    }

    public function albumStore($id, Request $request)
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

//        return view('anket.albumpage')->with(['album' => $album]);
        return redirect('/myAnket/'.$id.'/albums/');
    }

    public function album($id, $albumid, Request $request)
    {
        $album = Album::select(['id', 'name'])->where('id', $albumid)->first();
        if ($album == null) {
            return redirect('/myAnket/'.$id.'/albums/');
        }


        if ($album != null) {
            $photos = $album->photos()->get();
        } else {
            $photos = null;
        }
        /*ут смотим тип,  и если еадо, то отдаем json*/

        if ($request->get('type') == "json") {

            return response()->json(['photos' => $photos]);
        }

        return view('anket.albumpage')->with([
            'album'  => $album,
            'photos' => $photos,
            'id'     => $id,
        ]);
    }

    public function albums($id, Request $request)
    {
        $anket = Girl::get($id);

        if ($anket == null) {

        }
        $albums = $anket->albums()->get();

        $auth = Auth::user();
        if ($auth != null) {
            $authAnket = $auth->girl()->first();
            if ($authAnket != null && $authAnket->id == $id) {
                $allowEdit = true;
            } else {
                $allowEdit = false;
            }
        } else {
            $allowEdit = false;
        }

        return view('anket.albums')->with([
            'albums'    => $albums,
            'id'        => $id,
            'allowEdit' => $allowEdit,
        ]);
    }


    public function getAlbumPhotos($id, $albumid, Request $request)
    {

        $album = Album::select(['id', 'name'])->where('id', $albumid)->first();

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

    public function albumDelete($id, $albumid, Request $request)
    {
        $user = Auth::user();
        $user = User::select(['id', 'name'])->where('id', $user->id)->first();
        $anket = $user->girl()->first();

        $album = Album::select(['id', 'name', 'girl_id'])->where('id', $albumid)
            ->first();
        dump($album);
        if ($album == null) {
            return response()->json('false');
        }

        if ($album->girl_id != $anket->id) {
            return response()->json('false');
        }


        //получаем все фотографии
        $photos = $album->Photos()->get();
        foreach ($photos as $photo) {
            //     $old_image_name = $girl['main_image'];
            //            $path = base_path().'/public/images/upload/'.$old_image_name;
            //            File::Delete($path);
            $path = base_path().'/public/images/albums/'.$photo->name;
            File::delete($path);
            $photo->delete();
        }

        $album->delete();

        return response()->json('true');
    }
}
