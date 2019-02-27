@extends('layouts.blog', ['title' => 'Редактировать галлерею'])

@section('content')
    <div class="card-body" id="app2">
        <editimages :user="{{auth()->user()}}"></editimages>
    </div>
@endsection