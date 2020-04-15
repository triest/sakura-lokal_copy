@extends('layouts.blog', ['title' => 'Мои альбомы'])

@section('content')
    <style>
        .cell {
            position: absolute;
            top: 120px;
            right: 0;
            bottom: 30px;
            left: 0;
            box-sizing: border-box;
            display: block;
            padding: 20px;
            width: 100%;
            color: white;
            text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
        }

        .cell-overflow {
            box-sizing: border-box;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: white;
        }
    </style>

    <div class="card-body" id="myAnketApp">
        <a class="button blue" role="link" href="{{route('showGirl',['id'=>$id])}}"><i
                    class="fa fa-arrow-left"></i> Вернуться к анкете</a>
        <br>
        @if($allowEdit==true)
            <form action="{{route('albumStore',['id'=>$id])}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <label>Название</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Имя" rows="10" required>
                <button type="submit" class="btn btn-default">Создать альбом</button>
            </form>
        @endif
        @foreach($albums as $item)
        <!-- md -комп-->
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-3 thumb">
                <a href="{{route('albumItem',['id'=>$id,'albumid'=>$item->id])}}">
                    <img width="200" height="200" src="<?php echo asset("/images/albums/".$item->getCover())?>">
                    <div class="cell">
                        <div class="cell-overflow">
                            {{$item->name}},
                            {{$item->coutPhotos()}} фото
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection