@extends('layouts.blog', ['title' => 'Список анкет'])

@section('content')

    @foreach($girls as $girl)
        <!-- md -комп-->
        <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
            <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                <div class="card-body">
                    <div class="container">
                        <a href="{{route('showGirl',['id'=>$girl->id])}}">
                            <img height="150" width="150"
                                 src="<?php echo asset("/images/small/$girl->main_image")?>">

                        </a>
                        <div class="content">
                            @if($girl->isOnline())
                                <span class="circle" alt="пользователь в сети"></span>
                            @endif
                        </div>
                    </div>
                    <h4 class="card-title">
                        <a href="{{route('showGirl',['id'=>$girl->id,'utm_source'=>'mainstream'])}}">
                            <b>{{$girl->name}}</b>,
                            <small>{{$girl->age}}</small>
                        </a>
                    </h4>

                </div>
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
    <?php echo $girls->render(); ?>

@endsection