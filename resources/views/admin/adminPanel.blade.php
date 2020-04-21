@extends('layouts.blog', ['title' => 'Панель администратора'])
@section('content')
    <a class="button blue" href="{{ URL::previous() }}" role="link"><i class="fa fa-arrow-left"></i>Назад</a>
    <br>
    <div class="col-lg-4 col-md-6 col-sm-4 col-xs-4 box-shadow">
        <b><a class="btn btn-success" href="{{route('presentsControll')}}">Управление подарками</a> </b>
    </div>
    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-9 box-shadow">
        <b><a class="btn btn-primary" href="{{route('targetsControll')}}">Управление целями</a> </b>
    </div>
    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-9 box-shadow">
        <b><a class="btn btn-primary" href="{{route('interetsControll')}}">Управление интересами</a> </b>
    </div>
    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-9 box-shadow">
        <b><a class="btn btn-primary" href="{{route('apperanceControll')}}">Управление внешнестью</a> </b>
    </div>
    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-9 box-shadow">
        <b><a class="btn btn-primary" href="{{route('usersControll')}}">Управление пользователями</a> </b>
    </div>


    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-9 box-shadow">
        <b><a class="btn btn-success" href="{{route('moneyControll')}}">Управление ценами</a> </b>
    </div>
    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-9 box-shadow">
        <b><a class="btn btn-success" href="{{route('moneyControll')}}">Настройки </a> </b>
    </div>
@endsection