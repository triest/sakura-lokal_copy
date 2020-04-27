<?php

namespace App\Http\Controllers;


use App\Bilders\WinlBilder;
use App\City;
use App\Dialog;
use App\Events\NewMessage;
use App\GiftAct;
use App\Girl;
use App\Message;
use App\MyRequwest;
use App\PhoneSetting;
use App\Photo;
use App\SeachSettingsType;
use App\Target;
use App\User;
use App\Privatephoto;
use App\Interest;
use App\Aperance;
use App\Relationh;
use App\Children;
use App\Smoking;
use App\SearchSettings;
use App\Wink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use File;
use Carbon\Carbon;


use App\ImageResize;
use Nexmo\Response;
use PhpParser\Node\Expr\Array_;


class AnketController extends Controller
{
    //required
    public $phone_required = false;


    function createGirl()
    {
        $user = Auth::user();

        $girl = $user->girl()->first();
        if ($girl != null) {
            return redirect('/edit');
        }

        $targets = Target::select(['id', 'name'])->get();
        $interests = Interest::select(['id', 'name'])->get();
        $apperance = Aperance::select(['id', 'name'])->get();
        $relations = Relationh::select(['id', 'name'])->get();
        $chidren = Children::select(['id', 'name'])->get();
        $smoking = Smoking::select(['id', 'name'])->get();

        //add check phone is confurnd
        if ($user->phone == null && $user->phone_confirmed == 0
            && $this->phone_required
        ) {
            return view("custom.resetSMS2");
        }

        $phone_setting = PhoneSetting::select(['id', 'name'])->get();


        $phone = $user->phone;

        // dump($phone);
        return view('anket.create')
            ->with(
                [
                    'username'       => $user->name,
                    'tagrets'        => $targets,
                    'interests'      => $interests,
                    'apperance'      => $apperance,
                    'realtions'      => $relations,
                    'childrens'      => $chidren,
                    'smoking'        => $smoking,
                    'phone'          => $phone,
                    'phone_setting'  => $phone_setting,
                    'phone_required' => $this->phone_required,
                ]);
    }

    function store(Request $request)
    {

        $validatedData = $request->validate([
            'name'        => 'required',
            'sex'         => 'required',
            'age'         => 'required|numeric|min:18',
            'from'        => 'required|numeric|min:18',
            'to'          => 'required|numeric|min:18',
            'met'         => 'required',
            'description' => 'required',
            'private'     => 'required',

            // 'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if (Auth::guest()) {
            return redirect('/login');
        }

        $user = Auth::user();

        $girl = $user->girl()->first();
        if ($girl != null) {
            return redirect('/edit');
        }

        $girl = new Girl();
        $girl->name = $request->name;
        $girl->sex = $request->sex;
        $girl->meet = $request->met;
        $girl->age = $request->age;
        $girl->weight = $request->weight;
        $girl->height = $request->height;
        $girl->description = $request->description;
        $girl->private = $request->private;
        $girl->user_id = $user->id;
        $girl->phone_settings = $request->phone_settings;
        $girl->phone = $request->phone;
        $girl->from_age = $request->from;
        $girl->to_age = $request->age;
        $girl->save();


        if (Input::hasFile('file')) {
            $girl->updateMainImage($request);
        }
        $girl->save();


        if (Input::hasFile('images')) {

            $count = 0;
            foreach ($request->images as $key) {
                $image_extension = $request->file('file')
                    ->getClientOriginalExtension();
                $image_new_name = md5(microtime(true));
                $key->move(public_path().'/images/upload/',
                    strtolower($image_new_name.'.'.$image_extension));
                $id = $girl['id'];
                $photo = new Photo();
                $photo['photo_name'] = $image_new_name.'.'.$image_extension;
                $photo['girl_id'] = $id;
                $photo->save();
            }
        }


        if (Input::hasFile('privateimages')) {
            foreach ($request->privateimages as $key) {
                $image_extension = $request->file('file')
                    ->getClientOriginalExtension();
                $image_new_name = md5(microtime(true));
                $key->move(public_path().'/images/upload/',
                    strtolower($image_new_name.'.'.$image_extension));
                $id = $girl['id'];
                $photo = new Privatephoto();
                $photo['photo_name'] = $image_new_name.'.'.$image_extension;
                $photo['girl_id'] = $id;
                $photo->save();
            }
        }

        //цели
        if ($request->has('target')) {
            foreach ($request->target as $item) {
                $target = Target::select(['id', 'name'])->where('id', $item)
                    ->first();
                if ($target != null) {
                    $girl->target()->attach($target);
                }
            }
        }

        //цели
        if ($request->has('aperance')) {
            $target = Aperance::select(['id', 'name'])
                ->where('id', $request->aperance)->first();
            if ($target != null) {
                $girl->apperance_id = $target->id;
                $girl->save();
            }
        }


        if ($request->has('realtion')) {
            $target = Relationh::select(['id', 'name'])
                ->where('id', $request->realtion)->first();
            if ($target != null) {
                $girl->relation_id = $target->id;
                $girl->save();
            }
        }

        if ($request->has('childrens')) {
            $target = Children::select(['id', 'name'])
                ->where('id', $request->childrens)->first();
            if ($target != null) {
                $girl->children_id = $target->id;
                $girl->save();
            }
        }

        if ($request->has('smoking')) {
            $target = Smoking::select(['id', 'name'])
                ->where('id', $request->childrens)->first();
            if ($target != null) {
                $girl->smoking_id = $target->id;
                $girl->save();
            }
        }


        if ($request->has('city') && is_numeric($request->city)) {
            $girl->city_id = $request->city;
        }
        $girl->save();

        if ($request->has('interest')) {
            foreach ($request->interest as $item) {
                $target = Interest::select(['id', 'name'])->where('id', $item)
                    ->first();
                if ($target != null) {
                    $girl->interest()->attach($target);
                }
            }
        }

        return redirect('/anket');
    }

    public function girlsEditAuchAnket()
    {
        if (Auth::guest()) {
            return redirect('/login');
        }
        $user = Auth::user();
        if ($user == null) {
            return redirect('/login');
        }
        $girl = $user->girl()->first();
        if ($girl == null) {
            //  return $this->index();
            return view('anket.404');
        }
        $phone = $user->phone;

        //цели
        $targets = Target::select(['id', 'name'])->get();
        $allTarget = [];
        foreach ($targets as $tag) {
            array_push($allTarget, $tag->name);
        }
        $targets = $girl->target()->get();
        $anketTarget = [];
        foreach ($targets as $tag) {
            array_push($anketTarget, $tag->name);
        }

        //интересы
        $interests = Interest::select(['id', 'name'])->get();


        $allInterests = [];
        foreach ($interests as $tag) {
            array_push($allInterests, $tag->name);
        }


        $interests = $girl->interest()->get();

        $anketInterest = [];
        foreach ($interests as $item) {
            array_push($anketInterest, $item->name);
        }


        if ($girl->city_id != null) {
            $city = City::get($girl->city_id);
        } else {
            $city = null;
        }

        //внешность
        $selected_aperance = Aperance::select('id', 'name')
            ->where('id', $girl->apperance_id)->first();
        $aperance = Aperance::select(['id', 'name'])->get();


        //тут настройки телефона
        $select_phone_settings = DB::table('phone_settings')
            ->where('id', $girl->phone_settings)->first();
        //   $phone_setting = collect(DB::select('select * from phone_settings'))->get();
        $phone_setting = PhoneSetting::select(['id', 'name'])->get();


        $relations = Relationh::select(['id', 'name'])->get();


        return view('anket.edit')->with([
            'username'              => $user->name,
            'girl'                  => $girl,
            'phone'                 => $phone,
            'targets'               => $targets,
            'allTarget'             => $allTarget,
            'anketTarget'           => $anketTarget,
            'interests'             => $interests,
            'anketInterests'        => $anketInterest,
            'allInterests'          => $allInterests,
            'city'                  => $city,
            'phone_settings'        => $phone_setting,
            'select_phone_settings' => $select_phone_settings,
            'aperance'              => $aperance,
            'selected_aperance'     => $selected_aperance,
            'relations'             => $relations,
        ]);
    }

    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'name'        => 'required',
            'sex'         => 'required',
            'age'         => 'required|numeric|min:18',
            'met'         => 'required',
            'private'     => 'required',
            'description' => 'required',
            'file'        => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'from'        => 'required|numeric|min:18',
            'to'          => 'required|numeric|min:18',
            'status'      => 'min:5',
        ]);

        $user = Auth::user();
        if ($user == null) {
            return redirect('/login');
        }


        $girl = $user->girl()->first();
        if ($girl == null) {
            return redirect('/index');
        }
        $girl->age = $request->age;
        $girl->description = $request->description;
        $girl->private = $request->private;
        $girl->from_age = $request->from;
        $girl->to_age = $request->to;
        $girl->status_message = $request->status;
        $girl->save();
        if ($request->has('famele')) {
            $sex = 'famele';
        }
        if ($request->has('male')) {
            $sex = 'male';
        }
        /*
                if ($request->has('city')) {
                    if ($request->city != "-") {
                        $girl->city_id = $request->city;
                    }
                }
        */
        $girl->age = $request->age;
        $girl->sex = $request->sex;
        $girl->meet = $request->met;
        $girl->description = $request->description;
        $girl->status = $request->status;


        if (Input::hasFile('file')) {
            $old_image_name = $girl['main_image'];
            $path = base_path().'/public/images/upload/'.$old_image_name;
            File::Delete($path);
            $image_extension = $request->file('file')
                ->getClientOriginalExtension();
            $image_new_name = md5(microtime(true));
            $temp_file = base_path().'/public/images/upload/'
                .strtolower($image_new_name.'.'
                    .$image_extension);// кладем файл с новыс именем
            $new_name = $image_new_name.'.'.$image_extension;
            $request->file('file')
                ->move(base_path().'/public/images/upload/',
                    strtolower($image_new_name.'.'.$image_extension));
            $girl->main_image = $new_name;
            $origin_size = getimagesize($temp_file);
        }
        //тут местоположее
        $girl->save();

        //переделываем цели
        $girl->target()->detach();
        $target_requwest = $request->input('tags');
        if ($target_requwest != null) {
            $targets = Target::select('id',
                'name',
                'created_at',
                'updated_at')->whereIn('name', $target_requwest)->get();

            foreach ($targets as $target) {
                $girl->target()->attach($target);
            }
        }


        //тут интерексы
        $girl->interest()->detach();
        $interest_requwest = $request->input('interests');
        if ($interest_requwest != null) {
            $interests = Interest::select('id',
                'name',
                'created_at',
                'updated_at')->whereIn('name', $interest_requwest)->get();

            foreach ($interests as $interest) {
                $girl->interest()->attach($interest);
            }
        }

        if ($request->has('aperance')) {
            $target = Aperance::select(['id', 'name'])
                ->where('id', $request->aperance)->first();
            if ($target != null) {
                $girl->apperance_id = $target->id;
                $girl->save();
            }
        }


        $girl->save();

        $girl->relation_id = $request->realtion;
        //тут сохраняем телефон
        $girl->phone_settings = $request->phone_settings;
        $girl->save();

        return redirect('/anket');
    }

    //получаем главное изображение
    public function getmainImage()
    {
        $auth = Auth::user();
        $girl = $auth->girl()->first();

        return response()->json($girl->main_image);
    }

    public function updateGalerayImage(Request $request)
    {
        $user = Auth::user();
        if (Input::hasFile('file')) {

            $image_extension = $request->file('file')
                ->getClientOriginalExtension();
            $image_new_name = md5(microtime(true));
            $temp_file = base_path().'/public/images/upload/'
                .strtolower($image_new_name.'.'
                    .$image_extension);// кладем файл с новыс именем
            $request->file('file')
                ->move(base_path().'/public/images/upload/',
                    strtolower($image_new_name.'.'.$image_extension));
            $photo = new Photo();
            $girl = Girl::select(['id', 'user_id'])
                ->where('user_id', $user->get_id())->first();
            $photo['photo_name'] = $image_new_name.'.'.$image_extension;
            $photo = new Photo();
            $photo['photo_name'] = $image_new_name.'.'.$image_extension;
            $photo['girl_id'] = $girl->id;
            $photo->save();
        }

        return response()->json(['ok']);
    }

    public function deleteImage(Request $request)
    {

        $imagename = $request->imagename;
        try {
            $temp_file = base_path().'/public/images/upload/'.$imagename;
            File::Delete($temp_file);
            // тут будем удалять из таблицы
            $photo = Photo::select('id')->where('photo_name', $imagename)
                ->get();
            $photo->delete();
        } catch (\Exception $e) {
            echo "delete error";
        }
        $image = Photo::select(['id', 'photo_name'])
            ->where('photo_name', $imagename)->first();
        try {
            File::delete($imagename);
        } catch (IOException $e) {
        }
        $image->delete();

        return response()->json(['ok']);
    }

    public function getPrivateImages(Request $request)
    {
        $user = Auth::user();
        $girl = $user->girl()->first();
        $images = $girl->privatephotos()->get();

        return response()->json($images);
    }

    public function updatePrivateGalerayImage(Request $request)
    {
        $user = Auth::user();
        if (Input::hasFile('file')) {
            $image_extension = $request->file('file')
                ->getClientOriginalExtension();
            $image_new_name = md5(microtime(true));
            $temp_file = base_path().'/public/images/upload/'
                .strtolower($image_new_name.'.'
                    .$image_extension);// кладем файл с новыс именем
            $request->file('file')
                ->move(base_path().'/public/images/upload/',
                    strtolower($image_new_name.'.'.$image_extension));
            $photo = new Privatephoto();
            $girl = $user->girl()->first();
            $photo['photo_name'] = $image_new_name.'.'.$image_extension;
            $photo = new Privatephoto();
            $photo['photo_name'] = $image_new_name.'.'.$image_extension;
            $photo['girl_id'] = $girl->id;
            $photo->save();
        }

        return response()->json(['ok']);
    }

    public function deletePrivateImage(Request $request)
    {

        $imagename = $request->imagename;
        $user = Auth::user();
        try {
            $temp_file = base_path().'/public/images/upload/'.$imagename;
            File::Delete($temp_file);
            // тут будем удалять из таблицы
            $photo = Privatephoto::select('id')->where('photo_name', $imagename)
                ->get();
            $photo->delete();
        } catch (\Exception $e) {
            echo "delete errod";
        }
        $image = Privatephoto::select(['id', 'photo_name'])
            ->where('photo_name', $imagename)->first();
        try {
            File::delete($imagename);
        } catch (IOException $e) {
        }
        $image->delete();

        return response()->json(['ok']);
    }

    function image_resize(
        $source_path,
        $destination_path,
        $newwidth,
        $newheight = false,
        $quality = false // качество для формата jpeg
    )
    {

        ini_set("gd.jpeg_ignore_warning",
            1); // иначе на некотоых jpeg-файлах не работает

        list($oldwidth, $oldheight, $type) = getimagesize($source_path);

        switch ($type) {
            case IMAGETYPE_JPEG:
                $typestr = 'jpeg';
                break;
            case IMAGETYPE_GIF:
                $typestr = 'gif';
                break;
            case IMAGETYPE_PNG:
                $typestr = 'png';
                break;
        }
        $function = "imagecreatefrom$typestr";
        $src_resource = $function($source_path);

        if (!$newheight) {
            $newheight = round($newwidth * $oldheight / $oldwidth);
        } elseif (!$newwidth) {
            $newwidth = round($newheight * $oldwidth / $oldheight);
        }
        $destination_resource = imagecreatetruecolor($newwidth, $newheight);

        imagecopyresampled($destination_resource, $src_resource, 0, 0, 0, 0,
            $newwidth, $newheight, $oldwidth,
            $oldheight);

        if ($type = 2) { # jpeg
            imageinterlace($destination_resource,
                1); // чересстрочное формирование изображение
            imagejpeg($destination_resource, $destination_path, $quality);
        } else { # gif, png
            $function = "image$typestr";
            $function($destination_resource, $destination_path);
        }

        imagedestroy($destination_resource);
        imagedestroy($src_resource);
    }

    function resize_image($file, $w, $h, $crop = false)
    {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * abs($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * abs($r - $w / $h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight,
            $width, $height);

        return $dst;
    }

    //получаем обьекты для карусели
    public function getdataforcarousel()
    {
        $current_date = Carbon::now();
        $users = User::select([                 //получаем пользователей
                                                'id',
                                                'name',
                                                'beginvip',
                                                'endvip',
        ])
            //  ->where('vip','=','1')
            ->where('beginvip', '<', $current_date)
            ->where('endvip', '>', $current_date)
            ->orderBy('created_at', 'DESC')->get();
        $ankets = [];
        foreach ($users as $user) {
            $girl = Girl::select(['id', 'name', 'main_image', 'age'])
                ->where('user_id', $user->id)->first();
            array_push($ankets, $girl);
        }

        return response()->json(['ankets' => $ankets]);
    }

    public function getDataForChangeMainImage(Request $request)
    {
        $user = Auth::user();
        $updateMainImagePrice = DB::table('prices')
            ->where('price_name', '=', 'update_main_image')->get();

        return response()->json([
            'update_main_image' => $updateMainImagePrice,
            'user_money'        => $user->money,
        ]);
    }

    public function myAnket(Request $request)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect("\login");
        }


        $girl = $user->girl()->first();


        if ($girl == null) {
            return view('anket.404');
        }
        $images = $girl->photos()->get();

        $AythUser = Auth::user();

        $privatephoto = null;

        $targets = $girl->target()->get();
        if (count($targets) == 0) {
            $targets = null;
        }


        //интересы
        $interes = $girl->interest()->get();

        //get parametr
        $utm_source = null;
        if (request()->has('utm_source')) {
            $utm_source = Input::get('utm_source');
        }

        //проверяем, что просматривающий пользователь зареген.

        $phone_settings = $girl->phone_settings;

        $phone = null;
        if ($phone_settings == 1) {
            $phone = $girl->phone;
        } else {
            if ($AythUser != null) {
                $auth_girl = Girl::select('id', 'user_id')
                    ->where('user_id', $AythUser->id)->first();
                if ($auth_girl != null) {
                    $girl_in_table = DB::table('girl_open_phone_girl')
                        ->where('girl_id', $auth_girl->id)
                        ->where('target_id', $girl->id)->first();
                    if ($girl_in_table != null) {
                        $girl2 = Girl::select([
                            'id',
                            'phone',
                        ])->where('id', $id)->first();;
                        $phone = $girl2->phone;
                    } else {
                        $phone = null;
                    }
                } else {
                    $phone = null;
                }
            }
        }

        if (count($interes) == 0) {
            $interes = null;
        }


        //время псоледнего захода

        //авв сшен
        if ($girl->city_id != null) {
            $city = $girl->city();

            $region = null;
        } else {
            $city = null;
            $region = null;
        }

        $views = $girl->views_all;
        $views = $views + 1;
        $girl->views_all = $views;

        $girl->save();

        $aperance = $girl->aperance()->first();
        if (empty ($aperance)) {
            $aperance = null;
        }


        $relation = $girl->relation()->first();
        if (empty ($relation)) {
            $relation = null;
        }

        $children = $girl->children()->first();
        if (empty ($children)) {
            $children = null;
        }

        $smoking = Smoking::select(['id', 'name'])
            ->where('id', $girl->smoking_id)->first();
        if (empty ($smoking)) {
            $smoking = null;
        }

        $last_login = $girl->lastLoginFormat();

        $url = $request->header('referer');

        return view('anket.myAnket')->with([
            'girl'           => $girl,
            'images'         => $images,
            'privatephotos'  => $privatephoto,
            'targets'        => $targets,
            'city'           => $city,
            'region'         => $region,
            'interes'        => $interes,
            'phone_settings' => $phone_settings,
            'phone'          => $phone,
            'last_login'     => $last_login,
            'views'          => $views,
            'aperance'       => $aperance,
            'relation'       => $relation,
            'children'       => $children,
            'smoking'        => $smoking,
            'prevesion_page' => $url,
        ]);
    }

    public function getMyAnketData()
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect("\login");
        }
        $anket = $user->girl()->first();

        $anketTarget = [];
        $targets = $anket->target()->get();
        foreach ($targets as $tag) {
            array_push($anketTarget, $tag);
        }
        $targets = Target::select(['id', 'name'])->get();
        $allTarget = [];
        foreach ($targets as $tag) {
            array_push($allTarget, $tag);
        }

        return response()->json([
            "anket" => $anket,
        ]);
    }

    public function getTopPhotos()
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect("\login");
        }
        $anket = $user->girl()->first();

        $photos = $anket->photos()->take(5)->get();

        return response()->json([
            $photos,
        ]);
    }


    public function inseach(Request $request)
    {
        $user = Auth::user();
        $girl = $user->girl()->first();
        $current_date = Carbon::now();
        if ($current_date >= $girl->begin_search and $current_date
            <= $girl->end_search
        ) {
            return response()->json("true");
        } else {
            return response()->json("false");
        }
    }

    //получить все данные для боковой панели
    public function getalldataforsidepanel(Request $request)
    {
        $user = Auth::user();
        //число непрочитанных сообщения
        $messages = Message::where('to', $user->id)->where('readed', 0)->get();
        $countMessage = count($messages);
        // подарка
        $gift = GiftAct::select('id')->where('target_id', $user->id)
            ->where('readed', 0)->get();
        $countGift = count($gift);
        //запросы
        $myrequest = MyRequwest::select('id',
            'who_id',
            'target_id', 'status', 'readed')->where('target_id', $user->id)
            ->where('readed', 0)
            ->get();
        $countRequwest = count($myrequest);
        $id = $user->get_girl_id();
        $nmberLikes = DB::table('likes')->where('target_id', $id)->get()
            ->count();

        $filter = Girl::select('filter_enable')->where('id', $id)
            ->first();

        return response()->json([
            "countMessages" => $countMessage,
            "countGift"     => $countGift,
            "countRequwest" => $countRequwest,
            "likeNumber"    => $nmberLikes,
            "filter"        => $filter->filter_enable,
        ]);
    }

    //все данныые для power
    public function gatalldataforpower(Request $request)
    {
        //деньги
        $user = Auth::user();
        $money = $user->money;
        $toTop = DB::table('prices')->where('price_name', 'to_top')->first();
        $toFirstPlase = DB::table('prices')
            ->where('price_name', 'to_first_place')->first();
        $toseachPlase = DB::table('prices')->where('price_name', 'seach')
            ->first();
        $chageMainImage = DB::table('prices')
            ->where('price_name', 'change_main_image')->first();

        return response()->json([
            'money'           => $money,
            'toTop'           => $toTop,
            'toFirstPlase'    => $toFirstPlase,
            'toseachPlase'    => $toseachPlase,
            'changeMainImage' => $chageMainImage,
        ]);
    }

    //история просмотров моеё анкеты
    public function history(Request $request)
    {
        $user = Auth::user();

        if ($user == null) {
            return redirect('/anket');
        }
        $girl = Girl::select('id', 'user_id')->where('user_id', $user->id)
            ->first();
        if ($girl == null) {
            return redirect('/anket');
        }

        $history_today
            = DB::select('select  gl.id,gl.name,gl.age,gl.main_image,his.time,gl.city_id,citye.name as `city_name` from view_history his left JOIN girls gl on gl.id=his.who_id left join cities citye on citye.id_city=gl.city_id where girl_id=:girl_id and who_id!=:girl_id2 ORDER BY his.time DESC',
            ['girl_id' => $girl->id, 'girl_id2' => $girl->id]);


        if (!empty($history_today)) {
            $history_today2 = array();
            array_push($history_today2, $history_today[0]);
            //тут удаляем повторяющиеся записб, идушие последовательно
            for ($i = 1; $i < count($history_today) - 1; $i++) {
                if ($history_today[$i - 1]->id != $history_today[$i]->id) {
                    array_push($history_today2, $history_today[$i]);
                }
            }

            return view('viewhistory')->with(['today' => $history_today2]);
        }

        return view('viewhistory')->with(['today' => $history_today]);
    }

    //история просмотров моеё анкеты
    public function historypage(Request $request)
    {
        $user = Auth::user();

        if ($user == null) {
            return redirect('/anket');
        }
        $girl = Girl::select('id', 'user_id')->where('user_id', $user->id)
            ->first();
        if ($girl == null) {
            return redirect('/anket');
        }

        $history_today = DB::select('select * from view_history');


        return response()->json($history_today);
    }

    public function wink(Request $request)
    {
        if (!isset($_GET["id"])) {
            return response("true", 500);
        }
        $id = $_GET["id"];
        $winkBilder = new WinlBilder();
        $winkBilder->makeWink($id);

        return response("true", 200);
    }

    public function winkGet(Request $request)
    {
        if (!isset($_GET["id"])) {
            return \response()->json("false");
        }
        $id = $_GET["id"];

        $user = Auth::user();
        if ($user == null) {
            return \response(404);
        }

        $userAuth = Auth::user();
        $authGirl = $user->anketisExsis();
        if ($authGirl == null || $userAuth == null) {
            return \response()->json("false");
        }
        $wink = $authGirl->WinkMakeMe()->get();
        foreach ($wink as $item) {
            if ($item->target_id == $id) {                    //подмигнул ли я
                return \response()->json("true");
            }
        }

        return \response()->json("false");
    }


    public static function randomString($length = 64)
    {
        $chars
            = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = "";

        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        $str = substr(base64_encode(sha1(mt_rand())), 0, $length);

        return $str;
    }

    public function albumsPage($id = null)
    {
        if ($id != null) {
            $girl = Girl::get($id);
            $albums = $girl->albums()->get();
        } else {
            $userAuth = Auth::user();
            $user = User::select(['id'])->where('id', $userAuth->id)->first();
            $girl = $user->anketisExsis();
            $albums = $girl->albums()->get();
        }

        return view('anket.albums')->with([
            'albums' => $albums,
        ]);
    }


}


