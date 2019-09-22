@extends('layouts.blog', ['title' => 'Диалоги'])

@section('content')

        <div class="card">
            <div class="card-body" id="app3">
                <chat-app :user="{{auth()->user()}}"></chat-app>
            </div>
        </div>


@endsection