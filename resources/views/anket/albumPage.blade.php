@extends('layouts.blog', ['title' => $album->name])

@section('content')

    <div id="albumApp">
        <album :id="{{$album->id}}"></album>
    </div>

@endsection