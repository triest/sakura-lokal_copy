@extends('layouts.blog', ['title' => 'Управление подарками'])
@section('content')
    <div class="card-body" id="app4">
        <mypresents :user="{{auth()->user()}}"></mypresents>
    </div>
@endsection