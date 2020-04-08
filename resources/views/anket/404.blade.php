@extends('layouts.blog', ['title' => "Анкета не найдена"])


@section('content')

    <style>
        .container4 {
            height: 10em;
            position: relative
        }

        .container4 p {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%)
        }
    </style>
    <div class="container4">
        <font size="5px">
            <p>
            <div class="col-sm-7">
                Анкета не найдена. Скорее всего она удалена или не существовала
            </div>
            </p>
            <p>
            <div class="col-sm-7">
                <a class="btn btn-success" href="{{route('main')}}">На главную</a>
            </div>
            </p>
        </font>
    </div>
@endsection
