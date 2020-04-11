@extends('layouts.blog', ['title' => $album->name])

@section('content')

    <div id="albumApp">
        <album :id="{{$id}}" :album="{{$album->id}}"></album>
    </div>

@endsection