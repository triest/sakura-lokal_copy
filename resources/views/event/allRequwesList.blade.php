@extends('layouts.blog', ['title' => 'Мои события'])
@section('content')

    <b><a class="btn btn-primary" href="{{route('createevent')}}">Создать событие</a> </b>
    <div id="myeventApp"  class="col-lg-4 col-md-3 col-sm-3 col-xs-9 box-shadow">
        <all-event-requwet-list></all-event-requwet-list>
    </div>

@endsection