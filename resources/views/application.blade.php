@extends('layouts.blog', ['title' => 'Заявки на открытие анкеты'])
@section('content')

    <div class="card-body" id="app">
        <application  :user="{{auth()->user()}}"></application>
    </div>
    <a class="button blue" href="{{route('main')}}" role="link" onclick=" relocate_home()">К списку анкет</a>
@endsection