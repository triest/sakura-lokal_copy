<!doctype html>
<html>
<head>

</head>
<body>

<table>
    Появились новые анкеты по вашему запросу.
    <tr>
        @foreach($ankets as $anket)
            <td>
                <a href="{{route('showGirl',['id'=>$anket->id])}}">
                    <img width="200" height="200" src="<?php echo asset("/images/upload/$anket->main_image")?>">
                </a>
            </td>
            <td>
                <b> <a href="{{route('showGirl',['id'=>$anket->id])}}">{{$anket->name}} </a>, {{$anket->age}}</b>
            </td>
        @endforeach
    </tr>
</table>
</body>
</html>