@extends('layouts.blog', ['title' => $girl->name])



@section('content')
    @if (Auth::guest())
    @else
        @if($girl->user_id!=auth()->user()->id)
            <div class="card-body" id="app2">
                <privatepanel :id="{{$girl->id}}"></privatepanel>
            </div>
        @else
            Редактировать анкету
        @endif
        @if(auth()->user()->get_id()!=$girl->user_id)

        @endif
    @endif
    <br>


    <br>
    <img height="250" width="250" src="<?php echo asset("/images/upload/$girl->main_image")?>">

    <h4 class="card-title">
        {{$girl->name}}
    </h4>

    <b>Пол:</b>
    @if($girl->sex=='famele')
        <b> Женский</b>
    @endif

    @if($girl->sex=='male')
        <b> Мужской</b>
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
    <br>
    <div class="container gallery-container">
        <div class="tz-gallery">

            <div class="row">
                @foreach($images as $image)
                    <div class="col-sm-6 col-md-4">
                        <a class="lightbox" href="<?php echo asset("/images/upload/$image->photo_name")?>">
                            <img height="250" src="<?php echo asset("/images/upload/$image->photo_name")?>">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if($girl->private!=null)
        <label>Приватное сообщение:</label>
        <p class="card-text>"><b>{!!$girl->private  !!}<</b></p>
        @if (empty($privatephotos))
        @else
            <label>Приватные фотографии:</label>
            <div class="container gallery-container">
                <div class="tz-gallery">
                    <div class="row">
                        @foreach($privatephotos as $image)
                            <div class="col-sm-6 col-md-4">
                                <a class="lightbox" href="<?php echo asset("/images/upload/$image->photo_name")?>">
                                    <img height="250" src="<?php echo asset("/images/upload/$image->photo_name")?>">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endif



    <a class="button blue" href="{{route('main')}}" role="link" onclick=" relocate_home()">К списку анкет</a>

@endsection