@extends('layouts.blog', ['title' => 'Панель администратора'])
@section('content')
    <a class="button blue" href="{{ URL::previous() }}" role="link"><i class="fa fa-arrow-left"></i>Назад</a>
    <div class="card-body" id="moneyApp">
        <moneycontroll></moneycontroll>
    </div>
@endsection