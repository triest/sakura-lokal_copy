@extends('layouts.blog', ['title' => 'Список анкет'])

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
    @foreach($girls as $girl)
        <!-- md -комп-->

        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-3 thumb">
            <div class="card" style="width:200px" ; border: 1px solid transparent; border-color: #000000;
            ">
            <a href="{{route('showGirl',['id'=>$girl->id])}}">
                <img height="200" width="200"
                     src="<?php echo asset("/images/small/$girl->main_image")?>">
                <br>
                <div class="cell">
                    <div class="cell-overflow">
                        {{$girl->name}}
                    </div>
                    {{$girl->age}}
                </div>

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