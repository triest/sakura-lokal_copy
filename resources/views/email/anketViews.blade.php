<!doctype html>
<html>
<head>

</head>
<body>

<table>
    Новые просмотры вашей анкеты за сутки
    <br>
    @foreach($ankets as $anket)
        <tr>
            <td>
                <a href="{{route('showGirl',['id'=>$anket->id])}}">
                    <img width="200" height="200" src="<?php echo asset("/images/upload/$anket->main_image")?>">
                </a>
            </td>
            <td>
                <b> <a href="{{route('showGirl',['id'=>$anket->id])}}">{{$anket->name}} </a>, {{$anket->age}}</b>
            </td>
        </tr>
        @endforeach

</table>
</body>
</html>