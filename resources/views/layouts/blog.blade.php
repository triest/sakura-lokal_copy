<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <script src="{{ asset('js/jquery-3.4.1.js') }}" type="text/javascript"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title}}</title>


    <!--  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->


    <link href="{{asset('css/gallery-grid.css')}}">
    <!-- Bootstrap core CSS -->


    <!-- galeray -->
    <link href="{{asset('css/baguetteBox.min.css')}}">
    <!--table CSS -->
    <!--   <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet"> -->

    <!-- Bootstrap core CSS -->

    <link href="{{asset('css/gallery-grid.css')}}">

    <!-- Bootstrap core CSS -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css"
          rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
          integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css"
          integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
            integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
            crossorigin="anonymous"></script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!--Yandex -->
    <meta name="yandex-verification" content="af4168af7d682a89"/>
    <style>
        .row.no-gutter {
            margin-left: 0;
            margin-right: 0;
        }

        .row.no-gutter [class*='col-']:not(:first-child),
        .row.no-gutter [class*='col-']:not(:last-child) {
            padding-right: 0;
            padding-left: 0;
        }
        #test{
            position: absolute;
            top: 200px;
            left: 15px;

        }


        .card {
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 6px;
        }
    </style>


    <!-- иконка -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <!-- For apple devices -->
    <!--  <link rel="apple-touch-icon" type="image/png" href="/icon.png"/> -->

    <!--datitimepicher -->
    <!-- Optional theme -->
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <style>

    </style>

    <!--for datepicker -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"/>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>


    <script>
        $(function () {
            $('.dates #arrival').datepicker({
                'format': 'yyyy-mm-dd',
                'autoclose': true
            });
        });

        $(function () {
            $('.dates #departure').datepicker({
                'format': 'yyyy-mm-dd',
                'autoclose': true
            });
        });
    </script>
    <!--end for datepicker -->

    <!-- -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

</head>

<body>


<script src="{{ asset('/js/axios.min.js') }}"></script>

<!--
<div id="events">
    <div class="card " style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
        <div class="card-body">
            События в вашем городе:<br>


-->
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

<div class="container" bg-light>
    <div class="card-body" id="app2">
        <carouseltemp></carouseltemp>
    </div>
    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="menuButton" data-toggle="offcanvas"><b>Меню</b></button>
            </p>
            <a class="btn btn-primary" href="{{route('main2')}}" role="link">Поиск анкет</a>
            <br><br>
            <div class="row">
                @yield('content')
            </div>
        </div>

        <div class="col-xs-3 col-sm-3  sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="card " style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                <div class="card-body" id="app">
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
                            <side-panel :user="{{auth()->user()}}"></side-panel>
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
        </div>
    </div><!--/span-->
</div>

<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="http://bootstrap-3.ru/examples/offcanvas/offcanvas.js"></script>

<!-- скрипт для галлереи -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script src="{{ asset('js/baguetteBox.min.js') }}"></script>


<style type="text/css">

    .datepicker {
        font-size: 0.875em;
    }

    /* solution 2: the original datepicker use 20px so replace with the following:*/

    .datepicker td, .datepicker th {
        width: 1.5em;
        height: 1.5em;
    }

</style>

<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>
<script>
    import Eventmycity from "./eventmycity";

    export default {
        components: {Eventmycity}
    }
</script>