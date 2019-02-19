@extends('layouts.blog', ['title' => $girl->name])

@section('content')
    <!-- анель администратора  -->



    <img height="250" src="<?php echo asset("/images/upload/$girl->main_image")?>"></img></a>
    <div class="card-body">
        <h4 class="card-title">
            <b>{{$girl->name}}</b>
        </h4>
        <b>Пол:</b>
        @if($girl->sex=='famele')
            <b> Женский</b>
        @endif

        @if($girl->sex=='male')
            <b> Мужской</b>
        @endif

        @if($girl->private!=null)
            <label>Приватное сообщение:</label>
            <br>
            <p class="card-text>"><b> Телефон: {!!$girl->phone  !!}</b></p>
        @endif
        <p class="card-text"><b>Рост : {{$girl->height}}</b>
        <p class="card-text"><b>Вес : {{$girl->weight}}</b>
        <p class="card-text"><b>Возраст : {{$girl->age}}</b>

        <p class="card-text"><b>Хочу встретиться с :</b> @if($girl->meet=='famele')
                <b> женщиной</b>
            @endif

            @if($girl->meet=='male')
                <b> мужчиной</b>
        @endif
        <p class="card-text"><b> {!!$girl->description  !!}</b></p>

        @if($girl->private!=null)
            <label>Приватное сообщение:</label>
            <p class="card-text>"><b>{!!$girl->private  !!}<</b></p>
        @endif
    </div>
    <br>
    <div class="container gallery-container">
        <div class="tz-gallery">

            <div class="row">
                @foreach($images as $image)
                    <div class="col-sm-6 col-md-4">
                        <a class="lightbox" href="<?php echo asset("/images/upload/$image->photo_name")?>">
                            <img height="250" src="<?php echo asset("/images/upload/$image->photo_name")?>"
                                 alt="Park">
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <br>

    <a class="button blue" href="{{route('main')}}" role="link" onclick=" relocate_home()">К списку анкет</a>



@endsection