@extends('layouts.blog', ['title' => 'Кто смотрел мою анкету'])

@section('content')
    @if($today!=null)
        Сегодня
        <br>

        <?php $count = 0 ?>
        @foreach($today as $item)
            <div class="row">
                <div class="col-sm-4">
                    <a href="{{route('showGirl',['id'=>$item->id,'utm_source'=>'who_see'])}}">
                        <img width="200" src="<?php echo asset("/images/upload/$item->main_image")?>">
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="{{route('showGirl',['id'=>$item->id,'utm_source'=>'who_see'])}}">
                        <h2>{{$item->name}}</h2>
                    </a>
                    <h4>{{$item->city_name}}</h4>
                    <h4>{{$item->time}}</h4>

                </div>
            </div>
        @endforeach

    @endif

    <br>


@endsection