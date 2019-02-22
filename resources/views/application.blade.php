@extends('layouts.blog', ['title' => 'Заявки на открытие анкеты'])
@section('content')

    <div class="card-body" id="app">
        <application  :user="{{auth()->user()}}"></application>
    </div>
@endsection