<!doctype html>
<html>
<head>

</head>
<body>

У вас новое сообщение

<div class="card" style="width:200px" ; border: 1px solid transparent; border-color: #000000;
">
<img width="200" height="200" src="<?php echo asset("/images/upload/$anket->main_image")?>">
<b>{{$anket->name}} , {{$anket->age}}</b>
<br>
{{$text}}
</body>
</html>