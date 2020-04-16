@extends('layouts.blog', ['title' => 'Диалоги'])

@section('content')
    <a class="button blue" href="{{route('main')}}" role="link"><i class="fa fa-arrow-left"></i> К списку анкет</a>
    <div class="card">
        <div class="card-body" id="app3">
            @if ($agent->isMobile())
                Show mobile stuff...
                <chat-app-mobile :user="{{auth()->user()}}"></chat-app-mobile>
            @else
                <chat-app :user="{{auth()->user()}}"></chat-app>
            @endif
        </div>
    </div>


@endsection