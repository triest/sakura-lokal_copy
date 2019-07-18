@extends('layouts.blog', ['title' => 'Мои события'])
@section('content')
    <div class="row">
        <div class="card  border-dark" <!--style="width: 60rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869; -->
">
            <div class="card-body">
                <a class="btn btn-primary"  href="{{route('editevent',['id'=>$event->id])}}" role="link" onclick=" relocate_home()">Редактировать</a>

                <h2>{{$event->name}}<br></h2>
                Место: {{$event->place}}<br>
                Начало: {{$event->begin}}<br>
                Заявки принимаються до: {{$event->end_applications}}<br>
                Описание: {{$event->description}} <br>
                Статус: {{$event->status_name}} <br>

                Список подавших заявку:
                <div id="requwesteventlistapp">
                    <requwesteventlist eventid="{{$event->id}}"></requwesteventlist>
                    
                </div>
            </div>
        </div>
    </div>



@endsection