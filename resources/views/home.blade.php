@extends('layouts.blog', ['title' => 'Диалоги'])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body" id="app3">
                        <chat-app :user="{{auth()->user()}}"></chat-app>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn btn-primary" href="{{route('main')}}" role="link" onclick=" relocate_home()">К списку анкет</a>
    </div>
@endsection