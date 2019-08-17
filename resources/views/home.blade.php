@extends('layouts.blog', ['title' => 'Диалоги'])

@section('content')

        <div class="card">
            <div class="card-body" id="app3">
                <chat-app :user="{{auth()->user()}}"></chat-app>
            </div>
        </div>

        <a class="btn btn-primary" href="{{route('main')}}" role="link" onclick=" relocate_home()">К списку анкет</a>

@endsection