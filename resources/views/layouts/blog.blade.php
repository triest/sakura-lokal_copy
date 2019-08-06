<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$title}}</title>
    <script src="https://getbootstrap.com/docs/3.3/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('css/gallery-grid.css')}}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Bootstrap core CSS -->

    <!--for galeray -->
    <link href="{{asset('css/gallery-grid.css')}}">
    <link rel="stylesheet" href="{{ asset('js/baguetteBox.min.css') }}">
    <!--end for faleray -->

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css"
          rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
    <!-- Custom styles for this template -->
    <link href="http://bootstrap-3.ru/examples/offcanvas/offcanvas.css" rel="stylesheet">
    <link rel="icon" href="<?php echo asset("public/images/sakura.jpg")?>">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">

    <meta name="generator" content="Bootply"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Bootstrap twitter bootstrap slider with carousel navigation example."/>


    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
        .container {
            max-width: 1170px;
            margin: auto;
        }

        img {
            max-width: 100%;
        }

        .received_withd_msg p {
            background: #ebebeb none repeat scroll 0 0;
            border-radius: 3px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

    </style>
    <style type="text/css">
        .selected img {
            opacity: 0.5;
        }

        .carousel-inner > .item > img, .carousel-inner > .item > a > img {
            height: 150px;
            weight: 250px;
            margin: 0 auto;
        }

        .slider {

            width: 100px;

        }

        .center-div {
            position: absolute;
            margin: auto;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 100px;
            background-color: #ccc;
            border-radius: 3px;
        }
    </style>

</head>

<body>
<script src="{{ asset('/js/axios.min.js') }}"></script>
<div class="card-body" id="app2">
    <carouseltemp></carouseltemp>
</div>

<div class="col-sm-1">
</div>
<div class="col-sm-2">
    <div id="test">
        <div class="card " style="width: 25rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
            <div id="eventinmycityapp">
                <eventinmycityside></eventinmycityside>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-8">
    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-5 col-sm-7">
            <p class="pull-right visible-xs">
                <button type="button" class="menuButton" data-toggle="offcanvas"><b>Меню</b></button>
            </p>

            <div class="row">
                @yield('content')
            </div><!--/row-->
        </div><!--/span-->
        <!--sm- планшет -->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="card-body">
                <p class="pull-right visible-xs visible-sm">
                    <button type="button" class="menuButton" data-toggle="offcanvas"><b>Закрыть</b></button>
                </p>
                <br>
                @if (Auth::guest())
                    <b><a href="{{ url('/login') }}">Войти</a></b><br>
                    <b><a href="{{ url('/join') }}">Зарегистрироваться</a></b>
                @else
                    <b>{{auth()->user()->name}}</b><br>
                    <b><a href="{{ url('/logout') }}">Выйти</a></b>
                    <br>
                    @if($girl=Auth::user()->anketisExsis()!=null)
                    <!-- {{$girl=Auth::user()->anketisExsis()}} -->
                        <img height="150" width="150"
                             src="<?php echo asset("images/small/$girl->main_image")?>">
                        <div id="sidePanelApp">
                            <side-panel :user="{{auth()->user()}}"></side-panel>
                        </div>
                        <br>
                        <b><a class="btn btn-primary" href="{{route('myAnket')}}">Моя анкета</a> </b>
                        <br><br>
                        <b><a class="btn btn-secondary" href="{{route('myevent')}}">Мои события</a> </b>

                    @else
                        <br>
                        <b><a class="btn btn-primary" href="{{route('createGirlPage')}}">Создать анкету</a> </b>
                        <br>
                    @endif
                    <br>
                    <!--check is admin -->
                    @if(Auth::user()->is_admin==1)
                        <b><a class="btn btn-success" href="{{route('adminPanel')}}">Панель администратора</a> </b>
                        <br>
                    @endif
                    <br>
                    <b><a class="btn btn-success" href="{{route('main')}}">На главную</a> </b>

                @endif
            </div>
        </div>
    </div><!--/span-->
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://bootstrap-3.ru/dist/js/bootstrap.min.js"></script>
<script src="http://bootstrap-3.ru/examples/offcanvas/offcanvas.js"></script>
</body>
</html>