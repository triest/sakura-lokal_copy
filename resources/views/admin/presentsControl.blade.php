@extends('layouts.blog', ['title' => 'Управление подарками'])
@section('content')
    <a class="button blue" href="{{ URL::previous() }}" role="link"><i class="fa fa-arrow-left"></i>Назад</a>
    <div class="card-body" id="app4">
        <presents :user="{{auth()->user()}}"></presents>
    </div>
@endsection