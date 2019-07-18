@extends('layouts.blog', ['title' => 'Управление подарками'])
@section('content')
    <div class="card-body" id="app4">
        <interes :user="{{auth()->user()}}"></interes>
    </div>
@endsection