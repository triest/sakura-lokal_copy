<!doctype html>
<html>
<head>

</head>
<body>

У вас новое сообщение

<table>
    <tr>
        <td>
            <img width="200" height="200" src="<?php echo asset("/images/upload/$anket->main_image")?>">
        </td>
        <td>
            <b>{{$anket->name}} , {{$anket->age}}</b>
            <p>
                {{$text}}
            </p>
        </td>
    </tr>
</table>
</body>
</html>