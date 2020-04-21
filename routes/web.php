<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes();

Route::get('/messages', 'HomeController@index')->name('home');


Route::get('/contacts', 'ContactsController@get');
Route::get('/conversation/{id}', 'ContactsController@getMessagesFor');
Route::post('/conversation/send', 'ContactsController@send');
Route::post('/conversation/sendModal', 'ContactsController@sendModal');

Route::get('/join/', 'CustomUserController@index')->name('join');

Route::get('/', function () {
    return view('welcome2');
})->name('welcome');


Route::get('/anket', 'GirlsController@index')->name('main');

Route::get('/seach', 'SeachController@seach');


//создание анкеты
Route::get('/anket/create', 'AnketController@createGirl')
    ->name('createGirlPage')->middleware('auth');;

Route::post('/anket/create', 'AnketController@Store')->name('storeGirl');
Route::get('/anket/{id}', 'GirlsController@showGirl')->name('showGirl');

//количество непрочитанных сообщений
Route::get('/getCountUnreaded', 'ContactsController@getCountUnreadedMessages')
    ->middleware('auth');

//оличество непрочитанных запросов
Route::get('/getCountUnreadedRequwest',
    'ContactsController@getCountUnreadedRequwest')->middleware('auth');


//заявки на открытия
Route::get('/applications', 'ContactsController@getApplicationPage')
    ->middleware('auth');
//получаем сами заявки
Route::get('/application/get', 'ContactsController@getApplication')
    ->middleware('auth');

Route::get('/application/get/my', 'ContactsController@myApplication')
    ->middleware('auth');
//кто имеет доступ к моеё анкете
Route::get('/whohaveaccesstomyanket',
    'ContactsController@whoHavaAccessToMyAnket')->middleware('auth');
//закрыть доступ
Route::get('/clouseaccess', 'ContactsController@clouseaccess')
    ->middleware('auth');
//заявки на открытие телефон
Route::get('/phone/requwest/open',
    'ContactsController@getrequwesttoopenphone')->middleware('auth');

//предоставление доступа к телефону
Route::get('/phone/requwest/apperance/create',
    'ContactsController@getnewphonaaplication')
    ->middleware('auth');


//отклонить доступ
Route::get('/appilication/denide/', 'ContactsController@denideAccess')
    ->middleware('auth');

Route::get('/application/make', 'ContactsController@makeAccess')
    ->middleware('auth');

Route::get('/req', 'ContactsController@reqTest')->middleware('auth');

//проверяем, есть ли доступ к приватной части или нет
Route::get('/private/status', 'ContactsController@getIsPrivateOrNot')
    ->middleware('auth');

//проверяем, отправляли ли запрос
Route::get('/private/requwest/status', 'ContactsController@sendornot')
    ->middleware('auth');

//отправляем запрос:
Route::get('/private/requwest/send', 'ContactsController@sendreg')
    ->middleware('auth');

//отправляем запрос:
Route::get('/private/requwest/withdraw', 'ContactsController@withdrawreq')
    ->middleware('auth');
//phone
//отправлен ли запрос на открытие телефона
Route::get('/phone/requwest/send/status',
    'ContactsController@getsendregphoneornot')
    ->middleware('auth');

Route::get('/phone/appication/denide',
    'ContactsController@denidephoneaplication')
    ->middleware('auth');

//
Route::get('/phone/requwest/send', 'ContactsController@sendregphone')
    ->middleware('auth');

//endphone
//редактирование галлереи
Route::get('/editimages', function () {
    return view('anket.editimages');
})->middleware('auth');


Route::get('/join/', 'CustomUserController@index')->name('join');
Route::post('/join/new', 'CustomUserController@join')->name('joinStore');
Route::get('/continion/', 'AnketController@createGirl')->name('continion');

//редактировать анке
Route::get('/user/anketa/edit/', 'AnketController@girlsEditAuchAnket')
    ->name('girlsEditAuchAnket');
Route::post('/user/anketa/edit/', 'AnketController@edit')->name('girlsEdit');

//изображения

//обновление главной фотографии
Route::post('/image/main/update', 'AnketController@updateMainImage')
    ->name('updateMainImage');

Route::get('/image/main', 'AnketController@getmainimage')->middleware('auth');
//получаем обычные фотографии
Route::get('/images/', 'AnketController@getImages')->middleware('auth');

Route::get('/image/{id}', 'AlbumController@getImage')->middleware('auth');
//загрузить обычнае фотографии
Route::post('/images/update', 'AnketController@updateGalerayImage')
    ->middleware('auth');

//удалить фотографию
Route::get('/image/delete', 'AnketController@deleteImage')->middleware('auth');

//приватные фотографии
Route::get('/images/private', 'AnketController@getPrivateImages')
    ->middleware('auth');

Route::post('/images/private/update',
    'AnketController@updatePrivateGalerayImage')->middleware('auth');

Route::get('/images/private/delete', 'AnketController@deletePrivateImage')
    ->middleware('auth');

Route::get('/power', function () {
    return view('power');
})->middleware('auth');


//олучаем состояние счета
Route::get('/getMoney', 'MoneyController@getCurrentMoney')->middleware('auth');

//путь для яндекса
Route::post('/yandex', 'MoneyController@reciverMoney');

//получить цены
Route::get('/getpricestotop', 'MoneyController@getpricestotop')
    ->middleware('auth');

Route::get('/getpricetoseach', 'MoneyController@getpricetoseach')
    ->middleware('auth');

Route::get('/getpricetofirstplace', 'MoneyController@getpricetofirstplase')
    ->middleware('auth');

Route::get('/getpricechangemainimage',
    'MoneyController@getpricechangemainimage')->middleware('auth');

Route::get('/tofirstplaсe', 'MoneyController@toFirstPlase')->middleware('auth');

Route::get('/totop', 'MoneyController@totop')->middleware('auth');

Route::get('/toseach', 'MoneyController@toseach')->middleware('auth');


//получаем картинки для карусели
Route::get('/getdataforcarousel', 'AnketController@getdataforcarousel');


//ути администратора
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin', 'AdminController@adminPanel')->name('adminPanel');
    Route::get('/admin/presentsControll', function () {
        return view('admin.presentsControl');
    })->name('presentsControll');

    Route::get('/admin/targetsControll', function () {
        return view('admin.targetsControl');
    })->name('targetsControll');

    Route::get('/admin/interess', function () {
        return view('admin.interesControl');
    })->name('interetsControll');

    Route::get('/admin/usersControll', function () {
        return view('admin.usersControll');
    })->name('usersControll');

    Route::get('/admin/apperanceControll', function () {
        return view('admin.apperanceControll');
    })->name('apperanceControll');

    //get aperance
    Route::get('/admin/aperance', 'AdminController@getaperancelist');

    Route::post('/admin/aperance', 'AdminController@aperancestore');

    Route::post('/admin/aperance/edit/{id}', 'AdminController@aperanceedit');

    Route::post('/admin/aperance/delete/{id}',
        'AdminController@aperancedelete');

    Route::post('/admin/target/edit/{id}', 'AdminController@targetedit');
    Route::post('/admin/target/delete/{id}', 'AdminController@targetdelete');

    Route::get('/moneyControll', function () {
        return view('admin.moneyControll');
    })->name('moneyControll');

    Route::get('/phoneSettings', function () {
        return view('admin.phoneSettings');
    })->name('phoneSettings');

    // пользователи
    Route::get('/getuserslist', 'AdminController@getuserslist')
        ->middleware('auth', 'admin');
    //конец пользователей
    //получаем список интересов

    Route::get('admin/interes', 'AdminController@getinteresslist')
        ->middleware('auth', 'admin');

    Route::post('admin/interes/create', 'AdminController@createinteress')
        ->middleware('auth', 'admin');

    Route::post('admin/interes/delete/{id}', 'AdminController@deleteinteress')
        ->middleware('auth');


    Route::post('/editinteress', 'AdminController@editinteress')
        ->middleware('auth', 'admin');

    Route::delete('/', 'AdminController@deleteinteress')
        ->middleware('auth', 'admin');

    Route::get('/bannedorNot', 'AdminController@bannedorNot')
        ->middleware('auth', 'admin');
    //работа с анкетами пользовател
    Route::post('/makebunned', 'AdminController@makebunned')
        ->middleware('auth', 'admin');

    Route::get('/seachAdmin', 'AdminController@seachAdmin')
        ->middleware('auth', 'admin');

    Route::get('/bannedorNot', 'AdminController@bannedorNot')
        ->middleware('auth', 'admin');

    Route::get('/seachAdmin', 'AdminController@seachAdmin')
        ->middleware('auth', 'admin');

    Route::get('/getPrices', 'MoneyController@getPrices')
        ->middleware('auth', 'admin');

    //changeprice
    Route::post('/changePrice', 'MoneyController@changePrice')
        ->middleware('auth', 'admin');
});

Route::get('/isAdmin', 'AdminController@isAdmin')->middleware('auth');

Route::get('/getpresents', 'PresentController@getpresents');

Route::post('/createpresent', 'PresentController@storepresent');

Route::post('/delpresent', 'PresentController@delpresent')->middleware('auth');

//подарить подарок
Route::post('/givepresent', 'PresentController@givepresent')
    ->middleware('auth');

Route::get('/presenttest', 'PresentController@presenttest');

//счетчик подаркоа
Route::get('/getCountUnreadedPresents',
    'PresentController@getCountUnreaderPresents')->middleware('auth');

//мои подарки
Route::get('mypresents', function () {
    return view('presents.mypresents');
}

//получение списка моих подарко
)->middleware('auth');
Route::get('/getpresentsforMe', 'PresentController@presentsForMe')
    ->middleware('auth');

Route::get('/getpresentsHistoryforMe',
    'PresentController@getpresentsHistoryforMe')->middleware('auth');


Route::get('/getpresentsFromMe', 'PresentController@getpresentsFromMe')
    ->middleware('auth');

//markpresentasreaded
Route::post('/markpresentasreaded', 'PresentController@markpresentasreaded')
    ->middleware('auth');

//
Route::get('/getDataForChangeMainImage',
    'AnketController@getDataForChangeMainImage')->middleware('auth');;

//получаем id пользователя по

//SMS
Route::get('/sendSMS2', function () {
    $phone = Input::get('phone');
    $user = collect(DB::select('select * from users where phone like ?',
        [$phone]))->first();
    //   dump($user);
    if ($user != null and $user->phone_conferd == 1) {
        //echo 'Phone alredy exist!';
        return response()->json(['result' => 'alredy']);
    }
    $user = Auth::user();
    //если найден,то
    //1)генерируем проль для отправки
    $user->phone = $phone;
    $activeCode = rand(1000, 9999);
    $user->actice_code = $activeCode;
    $user->save();
    //2) отправляем его в смс
    App::call('App\Http\Controllers\GirlsController@sendSMS',
        [$phone, $activeCode]);

    return response()->json(['result' => 'ok']);
}
);
Route::get('/sendCODE2', function () {
    $code = Input::get('code');
    $user = Auth::user();
    if ($user->phone_conferd == 1) {
        return response()->json(['result' => 'alredy']);
    }
    if ($code == $user->actice_code) {
        $user->phone_conferd = 1;
        $user->save();

        return response()->json(['answer' => 'ok']);
    } else {
        return response()->json(['result' => 'fail']);
    }
}
);

Route::get('/myAnket', 'AnketController@myAnket')->name("myAnket")
    ->middleware('auth', 'anketExist');

Route::get('/myAnket/albums/', 'AnketController@albumsPage')
    ->name("albumsPage"); //get albums by yser ud
Route::get('/album/create/', 'AlbumController@albumCreate')
    ->name("albumCreate");

Route::post('/myAnket/{id}/album/store/', 'AlbumController@albumStore')
    ->name("albumStore");


Route::get('/myAnket/{id}/albums/', 'AlbumController@albums')->name('albums');
Route::get('/myAnket/{id}/albums/{albumid}/delete',
    'AlbumController@albumDelete')->name('albumsDelete');
//get albums by yser ud


Route::get('/myAnket/{id}/albums/{albumid}/photos',
    'AlbumController@album')->name('albumItem');

Route::post('/myAnket/albums/{id}/upload',
    'AlbumController@uploadPhotoToAlbum');

//get albums by yser ud


Route::get('/getMyAnketData', 'AnketController@getMyAnketData')
    ->middleware('auth', 'anketExist');

Route::get('/getTopPhotos', 'AnketController@getTopPhotos')
    ->middleware('auth', 'anketExist');

Route::get('/getuserid', 'ContactsController@getUserID');

//
Route::post('/inputPhone', 'GirlsController@inputPhone')->middleware('auth');

Route::post('/inputCode', 'GirlsController@inputCode')->middleware('auth');

//список целей
Route::get('/targets', 'AdminController@gettargetslist')
    ->middleware('auth', 'admin');

Route::post('/createtarget', 'AdminController@createtarget')
    ->middleware('auth', 'admin');

Route::post('/edittarget', 'AdminController@edittarget')
    ->middleware('auth', 'admin');

Route::post('/deletetargret', 'AdminController@deletetargret')
    ->middleware('auth', 'admin');

//поиск города
Route::get('/findcity/{name}',
    'AnketController@findcity');//->middleware('auth');
Route::get('/findcity2/{name}',
    'AnketController@findcity2');//->middleware('auth');

Route::get('/getargetslist', 'AdminController@gettargetslist');

Route::get('/getinterestslist', 'AdminController@getinteresslist');


Route::get('/inseach', 'AnketController@inseach');


//лайки
Route::get('/newlike', 'LikeController@newLike');
Route::get('/getLikesNumber', 'LikeController@getLikesNumber');
Route::get('/getLikesNumberAuch', 'LikeController@getLikesNumberAuch')
    ->middleware('auth');
//likeSendedl
Route::get('/likeSended', 'LikeController@likeSended');
//список тех, кто поставил мне лайки
Route::get('/getLikesList', 'LikeController@getLikesList');


//боковая панель, все данные
//getalldataforsidepanel
Route::get('/getalldataforsidepanel', 'AnketController@getalldataforsidepanel');

//gatalldataforpower
Route::get('/gatalldataforpower', 'AnketController@gatalldataforpower');


//тест почты
Route::get('/testmail', 'MailController@testemail');

Route::get('/newsearch', function () {
    return view('search.example');
})->name('newsearch');


//события
Route::get('/myevent', 'MyEventController@myevent')->name('myevent')
    ->middleware('auth', 'anketExist');

//форма с созданием.
Route::get('/myevent/store', 'MyEventController@create')->name('createevent')
    ->middleware('auth', 'anketExist');


Route::post('/myevent/store', 'MyEventController@store')->name('storeEvent')
    ->middleware('auth', 'anketExist');

//get my events list
Route::get('/myevent/list', 'MyEventController@list')->name('myeventslist')
    ->middleware('auth', 'anketExist');

//редактировать событие


//просмотр события
Route::get('/myevent/{id}', 'MyEventController@viewmyevent')
    ->name('viewmyevent')->middleware('auth', 'anketExist');

Route::get('/myevent/{id}/edit', 'MyEventController@edit')
    ->name('editevent')->middleware('auth', 'anketExist');

Route::post('/myevent/edit', 'MyEventController@update')->name('updateEvent')
    ->middleware('auth', 'anketExist');

Route::get('/listrequwest', 'MyEventController@listrequwest')
    ->name('viewmyevent')->middleware('auth',
        'anketExist');

//присоединиться к событию
Route::get('event/singup/{id}', 'MyEventController@singup')->name('viewmyevent')
    ->middleware('auth', 'anketExist');

//события с моим участием
Route::get('event/myparticipation', 'MyEventController@myparticipation')
    ->middleware('auth', 'anketExist');

//Намопинание о событиях, путь для скрипта
Route::get('event/reminders', 'MyEventController@reminders');

Route::get('event/reminders/all', 'MyEventController@remindersAll');

//уведомление полученно
//Для полученных, или напомнить позже
Route::get('event/reminders/recived', 'MyEventController@remindersRecived');

//тест карт
Route::get('/map', function () {
    return view("map");
})->name('map')->middleware('auth');

Route::post('/city/agree', 'GirlsController@agreeCity')->name('agreeCity');

Route::post('/city/new', 'GirlsController@newCity')->name('newCity');

Route::get('/city/change', 'GirlsController@changeCity')->name('changeCity');

Route::get('/events/inmycity', 'MyEventController@inmycity');

Route::get('/event/requwest/create', 'MyEventController@makerequwest');

Route::get('/event/checkrequwest', 'MyEventController@checkrequwest');

Route::get('/event/requwestlist', 'MyEventController@requwestlist');

Route::get('/event/requwestlist/unreaded', 'MyEventController@unreaded');

Route::get('/event/requwestlist/accepted', 'MyEventController@accepted');

Route::get('/event/requwestlist/denided', 'MyEventController@denided');

Route::get('/event/accept', 'MyEventController@accept');

Route::get('/event/requwest/myevent', 'MyEventController@countunreaded');

Route::get('/event/requwest/list', 'MyEventController@requwestMyeventslist')
    ->middleware('anketExist');;

//вск запросы на мои события
Route::get('event/requwest/list/all', 'MyEventController@requwestListAll');


//счетчик заявок на события
Route::get('/event/requwest/count', 'MyEventController@requwestcount');

//события, на которые я подал заявку
Route::get('/event/participation', 'MyEventController@participation')
    ->middleware('auth', 'anketExist');

Route::get('/test', function () {
    return view('test');
});

Route::get('/history', 'AnketController@history');
//Route::get('/history', 'AnketController@historypage');

Route::get('/gethistory', 'AnketController@history');


//подмигивание
Route::get('anket/wink/make', 'AnketController@wink');

Route::get('anket/wink/get', 'AnketController@winkGet');

//карусль
Route::get('like-carusel', 'LikeCaruselController@index');

Route::get('like-carusel/getAnket', 'LikeCaruselController@getAnket');

Route::get('like-carusel/newLike', 'LikeCaruselController@newLike');

Route::get('like-carusel/newDislike', 'LikeCaruselController@newDislike');

Route::get('anket2/getsrttings', 'SeachController@getSettings');

Route::post('anket2/savesettings', 'SeachController@saveSettings');

Route::get('changeFilter', 'AnketController@changeFilter');
Route::get('getfilterenable', 'AnketController@getfilterenable');

Route::get('/anket3/getankets', 'AnketController@getankets')->name('getAnkets');

/*включить фильтр*/

Route::get('/filter_enable', 'GirlsController@filter_enable')
    ->name('filter_enable');


Route::get('/city_test', 'CityController@GetCurrentCity');


Route::get('/mobile', 'MobileController@index');