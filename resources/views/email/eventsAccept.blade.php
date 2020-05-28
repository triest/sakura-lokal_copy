<!doctype html>
<html>
<head>

</head>
<body>

<table>
    Ваша заявка на событие принята!
    <tr>
        {{$event->title}}
        <a class="btn btn-primary" href="{{route('viewmyevent',['id'=>$event->id])}}" role="link"
           onclick=" relocate_home()">Редактировать</a>

        <h2>{{$event->name}}<br></h2>
        <p> Место: {{$event->place}}</p>
        <p>Начало: {{$event->begin}}</p>

        <p>{{$event->description}} </p>

    </tr>
</table>
</body>
</html>