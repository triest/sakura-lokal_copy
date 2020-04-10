@extends('layouts.blog', ['title' => 'Мои альбомы'])

@section('content')
    <div class="card-body" id="myAnketApp">
        <form action="{{route('albumStore')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <label>Название</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Имя" rows="10" required>
            <button type="submit" class="btn btn-default">Создать альбом</button>
        </form>
    @foreach($albums as $item)
        <!-- md -комп-->
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-3 thumb">
                <a href="{{route('albumItem',['id'=>$item->id])}}">
                    {{$item->name}}
                </a>
            </div>
    </div>

    @endforeach

    </div>
@endsection