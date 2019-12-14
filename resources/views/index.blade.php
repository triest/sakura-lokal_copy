@extends('layouts.blog', ['title' => 'Список анкет'])

@section('content')

    @foreach($girls as $girl)
        <!-- md -комп-->

        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
            <div class="card" style="  border: 1px solid transparent;   border-color: #000000;">
                <a href="{{route('showGirl',['id'=>$girl->id])}}">
                    <img height="150" width="150"
                         src="<?php echo asset("/images/small/$girl->main_image")?>">
                    <b>  {{$girl->name}}</b>, {{$girl->age}}
                </a>
            </div>
        </div>
    @endforeach

    <style>
        * {
            box-sizing: border-box;
        }

        .circle:before {
            content: ' \25CF';
            font-size: 20px;
            max-width: 0px;
            margin: 0 auto;
            position: absolute;
            bottom: 0;
            background: rgb(0, 0, 0); /* Fallback color */
            background: rgba(145, 100, 153, 0); /* Black background with 0.5 opacity */
            color: #20f100;
            width: 100%;
            padding: 10px;
        }

        body {
            font-family: Arial;
            font-size: 17px;
        }

        .container {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
        }

        .container img {
            vertical-align: middle;
        }

        .container .content {
            position: absolute;
            bottom: 0;
            background: rgb(0, 0, 0); /* Fallback color */
            background: rgba(0, 0, 0, 0); /* Black background with 0.5 opacity */
            color: #f1f1f1;
            width: 100%;
            padding: 0px;
            margin: 115px;
        }
    </style>
    <br><br><br>    <br><br><br>
    <?php echo $girls->render(); ?>

@endsection