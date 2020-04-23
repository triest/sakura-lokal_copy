<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$title}}</title>
    <script src="https://getbootstrap.com/docs/3.3/assets/js/ie-emulation-modes-warning.js"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap core CSS -->

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('css/gallery-grid.css')}}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Bootstrap core CSS -->

    <!-- custom buttons -->
    <link href="{{asset('css/buttons.css')}}" rel="stylesheet">

    <!--for galeray -->
    <link href="{{asset('css/gallery-grid.css')}}">
    <link rel="stylesheet" href="{{ asset('js/baguetteBox.min.css') }}">
    <!--end for faleray -->

    <!--My custom style -->
    <link href="{{asset('css/style.css')}}">
    <!-- -->

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css"
          rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
    <!-- Custom styles for this template -->
    <!--  <link href="http://bootstrap-3.ru/examples/offcanvas/offcanvas.css" rel="stylesheet"> -->

    <link rel="icon" href="<?php echo asset("images/icons/icons/favicon-16x16.png")?>" type="image/x-icon">
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>

    <link rel="stylesheet" href="css/app.css">

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

<!-- тут меню -->
<nav class="navbar hidden-sm hidden-md hidden-lg visable-xs">
    @if (Auth::guest())
        <b><a class="button blue" href="{{ url('/login') }}">Войти</a></b>
        <b><a class="button green" href="{{ url('/join') }}">Зарегистрироваться</a></b>
    @else
        @if($girl=Auth::user()->anketisExsis()!=null)
        <!-- {{$girl=Auth::user()->anketisExsis()}} -->
            <div class="navbar-brand" id="sidePanelApp2">
                <side-panel2 :user="{{auth()->user()}}"></side-panel2>

            </div>

        @else
            <b class="navbar-brand"><a class="btn btn-primary" href="{{route('createGirlPage')}}">Создать анкету</a>
            </b>
        @endif
    @endif
</nav>


<div class="card-body" id="app2">
    <div class="row" style="position: center">
        <carusel></carusel>
    </div>
</div>

<div class="col-sm-1">
</div>
<div class="col-sm-2">
    <!--
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
    -->
</div>
<div class="col-sm-8">
    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-sm-8">
            <p class="pull-right visible-xs visible-lg">
                <!--  <button type="button" class="menuButton" data-toggle="offcanvas"><b>Меню</b></button> -->
                <button type="button" class="navbar-toggle collapsed js-offcanvas-btn">
                    <span class="sr-only"><a href="{{ url('/logout') }}">Выйти</a></span>
                    <span class="hiraku-open-btn-line"></span>
                </button>
            </p>

            <div class="row" style="z-index: -100">
                @yield('content')
            </div><!--/row-->
        </div><!--/span-->
        <!--sm- комп -->
        <div class=" col-sm-3 sidebar-offcanvas  hidden-xs" id="sidebar" role="navigation">
            <div class="card-body">
                <!-- <p class="pull-right visible-xs visible-sm">
                     <button type="button" class="menuButton" data-toggle="offcanvas"><b>Закрыть</b></button>
                 </p>
                 -->
                <br>
                <? $city = \App\City::GetCurrentCity();
                if ($city != null) {
                    echo "<b>".$city->name."</b>";
                    echo "<br>";
                }
                ?>
                @if (Auth::guest())
                    <b><a class="button blue" href="{{ url('/login') }}">Войти</a></b><br><br>
                    <b><a class="button green" href="{{ url('/join') }}">Зарегистрироваться</a></b><br>
                    <b><a class="button blue" href="{{route('main')}}">Поиск</a></b><br><br>
                @else
                    <b>{{auth()->user()->name}}</b><br>
                    <b><a href="{{ url('/logout') }}">Выйти</a></b>
                    <br>
                    @if($girl=Auth::user()->anketisExsis()!=null)
                    <!-- {{$girl=Auth::user()->anketisExsis()}} -->
                        <a href="{{route('myAnket')}}">
                            <img height="150" width="150"
                                 src="<?php echo asset("images/small/$girl->main_image")?>">
                        </a>
                        <div id="sidePanelApp">
                            <side-panel :user="{{auth()->user()}}"></side-panel>
                        </div>

                        <b>
                            <button class="btn btn-outline-primary" href="{{route('myevent')}}">Мои события</button>
                        </b>

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

<!--<script src="http://bootstrap-3.ru/dist/js/bootstrap.min.js"></script>-->

<!--<script src="http://bootstrap-3.ru/examples/offcanvas/offcanvas.js"></script>-->
<script src="{{ asset('offcanvas.js') }}"></script>
</body>
</html>
