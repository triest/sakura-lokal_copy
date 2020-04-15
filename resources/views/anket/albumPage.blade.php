@extends('layouts.blog', ['title' =>"dssd"])

@section('content')
    <div class="row">
        <div id="albumApp">
            <a class="btn btn-primary" href="{{route('albums',$id)}}">Назад</a>
            <a class="btn btn-danger" onclick="deleteAlbum({{$album->id}})">Удалить альбом</a>
            <album :id="{{$id}}" :album="{{$album->id}}"></album>
        </div>
    </div>
    <script>
        function deleteAlbum(id) {
            console.log("delete");
            let confurm = confirm("Удалить альбом?");
            if (confurm) {
                $.get("delete", function (data) {

                }).then(function (response) {
                    if (response.data == "true") {
                        alert("Альбом и фотографии удалены")
                    }
                });
            }

        }

    </script>
@endsection