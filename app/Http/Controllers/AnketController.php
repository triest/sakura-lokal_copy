<?php

namespace App\Http\Controllers;

use App\Girl;
use App\Photo;
use App\Privatephoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class AnketController extends Controller
{
    //
    function createGirl()
    {
        $user = Auth::user();
        return view('createAnket')->with(['username' => $user->name]);
    }

    function store(Request $request)
    {

        $validatedData = $request->validate([
                'name' => 'required',
                'sex' => 'required',
                'age' => 'required|numeric|min:18',
                'met' => 'required',
                'description' => 'required',
                'private' => 'required',
            // 'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        dump($request);
        $girl = new Girl();
        $girl->name = $request->name;
        $girl->sex = $request->sex;
        $girl->meet = $request->met;
        $girl->age = $request->age;
        $girl->weight = $request->weight;
        $girl->height = $request->height;
        $girl->description = $request->description;
        $girl->private = $request->private;
        $girl->save();


        if (Input::hasFile('file')) {
            $image_extension = $request->file('file')->getClientOriginalExtension();
            $image_new_name = md5(microtime(true));
            $temp_file = base_path() . '/public/images/upload/' . strtolower($image_new_name . '.' . $image_extension);// кладем файл с новыс именем
            $request->file('file')
                    ->move(base_path() . '/public/images/upload/',
                            strtolower($image_new_name . '.' . $image_extension));
            $origin_size = getimagesize($temp_file);
            $girl['main_image'] = $image_new_name . '.' . $image_extension;
        }
        $girl->save();

        if (Auth::guest()) {
            return redirect('/login');
        }

        if (Input::hasFile('images')) {
            $count = 0;
            foreach ($request->images as $key) {
                echo 'image';
                $image_extension = $request->file('file')->getClientOriginalExtension();
                $image_new_name = md5(microtime(true));
                $key->move(public_path() . '/images/upload/', strtolower($image_new_name . '.' . $image_extension));
                $id = $girl['id'];
                $photo = new Photo();
                $photo['photo_name'] = $image_new_name . '.' . $image_extension;
                $photo['girl_id'] = $id;
                $photo->save();
            }
        }

        foreach ($request->privateimages as $key) {
            $image_extension = $request->file('file')->getClientOriginalExtension();
            $image_new_name = md5(microtime(true));
            $key->move(public_path() . '/images/upload/', strtolower($image_new_name . '.' . $image_extension));
            $id = $girl['id'];
            $photo = new Privatephoto();
            $photo['photo_name'] = $image_new_name . '.' . $image_extension;
            $photo['girl_id'] = $id;
            $photo->save();
        }
    }
}
