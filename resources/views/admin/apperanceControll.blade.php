@extends('layouts.blog', ['title' => 'Управление целями'])
@section('content')
    <div class="card-body" id="aperanceApp">
        <aperance :user="{{auth()->user()}}"></aperance>
    </div>
@endsection