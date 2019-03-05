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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes();

Route::get('/messages', 'HomeController@index')->name('home');

Route::get('/messages2', 'HomeController@index2')->name('home2');


Route::get('/contacts', 'ContactsController@get');
Route::get('/contacts2', 'ContactsController@get2');
Route::get('/conversation/{id}', 'ContactsController@getMessagesFor');
Route::post('/conversation/send', 'ContactsController@send');

Route::get('/join/', 'CustomUserController@index')->name('join');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/anket', 'GirlsController@index')->name('main');
Route::get('/createAnketPage', 'AnketController@createGirl')->name('createGirlPage')->middleware('auth');

//создание анкеты
Route::get('/createAnketPage', 'AnketController@createGirl')->name('createGirlPage')->middleware('auth');;

Route::post('/anket/create', 'AnketController@Store')->name('storeGirl');
Route::get('/anket/{id}', 'GirlsController@showGirl')->name('showGirl');

//количество непрочитанных сообщений
Route::get('/getCountUnreaded', 'ContactsController@getCountUnreadedMessages')->middleware('auth');

//оличество непрочитанных запросов
Route::get('/getCountUnreadedRequwest', 'ContactsController@getCountUnreadedRequwest')->middleware('auth');


//заявки на открытия
Route::get('/applications', 'ContactsController@getApplicationPage')->middleware('auth');
//получаем сами заявки
Route::get('/getapplication', 'ContactsController@getApplication')->middleware('auth');

Route::get('/getmyapplication', 'ContactsController@myApplication')->middleware('auth');
//кто имеет доступ к моеё анкете
Route::get('/whohaveaccesstomyanket', 'ContactsController@whoHavaAccessToMyAnket')->middleware('auth');
//закрыть доступ
Route::get('/clouseaccess', 'ContactsController@clouseaccess')->middleware('auth');

//отклонить доступ
Route::get('/denideaccess', 'ContactsController@denideAccess')->middleware('auth');

Route::get('/geteaccess', 'ContactsController@makeAccess')->middleware('auth');

Route::get('/req', 'ContactsController@reqTest')->middleware('auth');

//проверяем, есть ли доступ к приватной части или нет
Route::get('/getisprivaterrnot', 'ContactsController@getIsPrivateOrNot')->middleware('auth');

//проверяем, отправляли ли запрос
Route::get('/getsendregornot', 'ContactsController@sendornot')->middleware('auth');

//отправляем запрос:
Route::get('/sendreg', 'ContactsController@sendreg')->middleware('auth');

//редактирование галлереи
Route::get('/editimages', function () {
    return view('editimages');
})->middleware('auth');


Route::get('/join/', 'CustomUserController@index')->name('join');
Route::post('/join/new', 'CustomUserController@join')->name('joinStore');
Route::get('/continion/', 'AnketController@createGirl')->name('continion');

//редактировать анке
Route::get('/edit', 'AnketController@girlsEditAuchAnket')->name('girlsEditAuchAnket')->middleware('auth');;
Route::post('/user/anketa/edit/', 'AnketController@edit')->name('girlsEdit');

//обновление главной фотографии
Route::post('/updateMainImage', 'AnketController@updateMainImage')->name('updateMainImage');
Route::get('/getmainImage', 'AnketController@getmainimage')->middleware('auth');
//получаем обычные фотографии
Route::get('/getImages', 'AnketController@getImages')->middleware('auth');
//загрузить обычнае фотографии
Route::post('/updateGalerayImage', 'AnketController@updateGalerayImage')->middleware('auth');

//удалить фотографию
Route::get('/deleteImage', 'AnketController@deleteImage')->middleware('auth');

//приватные фотографии
Route::get('/getPrivateImages', 'AnketController@getPrivateImages')->middleware('auth');

Route::post('/updatePrivateGalerayImage', 'AnketController@updatePrivateGalerayImage')->middleware('auth');

Route::get('/deletePrivateImage', 'AnketController@deletePrivateImage')->middleware('auth');

Route::get('/power', function () {
    return view('power');
})->middleware('auth');


//олучаем состояние счета
Route::get('/getMoney', 'MoneyController@getCurrentMoney')->middleware('auth');

//путь для яндекса
Route::post('/yandex', 'MoneyController@reciverMoney');

//получить цены
Route::get('/getpricestotop', 'MoneyController@getpricestotop')->middleware('auth');

Route::get('/tofirstplaсe','MoneyController@toFirstPlase')->middleware('auth');

Route::get('/totop','MoneyController@totop')->middleware('auth');