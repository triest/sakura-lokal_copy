@extends('layouts.blog', ['title' => 'Управление пользователями'])
@section('content')
    <div class="card-body" id="app4">
        <userscontroll :user="{{auth()->user()}}"></userscontroll>
    </div>
@endsection