@extends('layouts.blog', ['title' => 'Управление анкетой'])

@section('content')
    <div class="card-body" id="myAnketApp">
        Просмотров за день:{{$views_fo_day}} <br>
        Просмотров за неделю:{{$views_fo_week}} <br>
        <myanket :user="{{auth()->user()}}"></myanket>
    </div>
@endsection