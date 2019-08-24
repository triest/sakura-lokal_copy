@extends('layouts.blog', ['title' => 'Мои события'])
@section('content')

    <b><a class="btn btn-primary" href="{{route('createevent')}}">Создать событие</a> </b>
    <div id="myeventApp">
        <all-event-requwet-list></all-event-requwet-list>
    </div>

@endsection