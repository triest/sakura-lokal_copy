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

Auth::routes();

Route::get('/messages', 'HomeController@index')->name('home');


Route::get('/contacts', 'ContactsController@get');
Route::get('/conversation/{id}', 'ContactsController@getMessagesFor');
Route::post('/conversation/send', 'ContactsController@send');

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
Route::get('/getCountUnreaded','ContactsController@getCountUnreadedMessages')->middleware('auth');



//заявки на открытия
Route::get('/applications','ContactsController@getApplicationPage')->middleware('auth');
//получаем сами заявки
Route::get('/getapplication','ContactsController@getApplication')->middleware('auth');

Route::get('/getmyapplication','ContactsController@myApplication')->middleware('auth');

//отклонить доступ
Route::get('/denideaccess','ContactsController@denideAccess')->middleware('auth');

Route::get('/geteaccess','ContactsController@makeAccess')->middleware('auth');

Route::get('/req','ContactsController@reqTest')->middleware('auth');