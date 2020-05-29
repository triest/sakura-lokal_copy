@extends('layouts.blog', ['title' => 'Мои события'])
@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-3 col-xs-9 box-shadow">
            <div class="card  border-dark" <!--style="width: 60rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869; -->
            >
            <div class="card-body">
                <a class="btn btn-primary" href="{{route('editevent',['id'=>$event->id])}}" role="link"
                   onclick=" relocate_home()">Редактировать</a>

                <h2>{{$event->name}}<br></h2>
                <p> Место: {{$event->place}}</p>
                <p>Начало: {{$event->begin}}</p>
                <p>Заявки принимаються до: {{$event->end_applications}}</p>
                Статус: {{$event->status_name}} <br>
                <p>Описание:< {{$event->description}} </p>
                <div id="requwesteventlistapp">
                    <requwesteventlist eventid="{{$event->id}}"></requwesteventlist>
                </div>
            </div>
        </div>
    </div>
@endsection