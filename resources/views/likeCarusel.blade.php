@extends('layouts.blog', ['title' => 'Карусель'])

@section('content')
    <div class="card-body" id="caruselApp" style="position: center">
        <like-carusel></like-carusel>
    </div>
@endsection