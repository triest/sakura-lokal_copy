@extends('layouts.blog', ['title' => 'Управление целями'])
@section('content')
    <div class="card-body" id="app4">
        <targets :user="{{auth()->user()}}"></targets>
    </div>
@endsection