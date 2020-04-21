@extends('layouts.blog', ['title' => 'Управление целями'])
@section('content')
    <a class="button blue" href="{{ URL::previous() }}" role="link"><i class="fa fa-arrow-left"></i>Назад</a>
    <div class="card-body" id="aperanceApp">
        <aperance :user="{{auth()->user()}}"></aperance>
    </div>
@endsection