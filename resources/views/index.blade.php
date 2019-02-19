@extends('layouts.blog', ['title' => 'Список анкет'])



@section('content')

    @foreach($girls as $girl)
        <!--телефон -col-xs-8 -->
        <!-- сol-lg-3 компьютер-->
        <!-- сol-sm-3 планшет в альбомном -->
        <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 ">
            <a href="{{route('showGirl',['id'=>$girl->id])}}">
                <img height="250" width="350"
                     src="<?php echo asset("/images/upload/$girl->main_image")?>"></a>
            </a>
            <h4 class="card-title">
                <b> <a href="{{route('showGirl',['id'=>$girl->id])}}">{{$girl->name}}</a></b>
            </h4>
        </div>
    @endforeach

    <?php echo $girls->render(); ?>
@endsection