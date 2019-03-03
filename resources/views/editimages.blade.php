@extends('layouts.blog', ['title' => 'Редактировать галлерею'])

@section('content')
    <div class="card-body" id="app2">
        <editimages :user="{{auth()->user()}}"></editimages>
    </div>
    <a class="button blue" href="{{route('main')}}" role="link" onclick=" relocate_home()">Назад</a>
@endsection