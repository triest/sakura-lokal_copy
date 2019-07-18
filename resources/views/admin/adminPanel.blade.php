@extends('layouts.blog', ['title' => 'Панель администратора'])
@section('content')

    <br><br>
    <b><a class="btn btn-success" href="{{route('presentsControll')}}">Управление подарками</a> </b>

    <b><a class="btn btn-primary" href="{{route('targetsControll')}}">Управление целями</a> </b>

    <b><a class="btn btn-primary" href="{{route('interetsControll')}}">Управление интересами</a> </b>

    <b><a class="btn btn-primary" href="{{route('apperanceControll')}}">Управление внешнестью</a> </b>

    <b><a class="btn btn-primary" href="{{route('usersControll')}}">Управление пользователями</a> </b>



    <br><br>

    <b><a class="btn btn-success" href="{{route('moneyControll')}}">Управление ценами</a> </b>

    <b><a class="btn btn-success" href="{{route('moneyControll')}}">Настройки </a> </b>
@endsection