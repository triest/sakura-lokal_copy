<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Близкие знакомства</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .btn.btn-success.active,
        .btn.btn-success.active:hover {
            color: #ffffff;
            background-color: #27ff5a;
            background-image: linear-gradient(to bottom, #419641, #419641);
            background-position: 0 0;
            border-color: #3E8F3E #3E8F3E #3E8F3E;
        }

        .btn.btn.active:hover {
            color: #ffffff;
            background-color: #27ff5a;
            background-image: linear-gradient(to bottom, #419641, #419641);
            background-position: 0 0;
            border-color: #3E8F3E #3E8F3E #3E8F3E;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .button1 {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 10px 2px;
            cursor: pointer;
            font-size: 24px;
        }

        .button2 {
            font-size: 24px;
            background-color: #4af0fa; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 4px 2px;
            cursor: pointer;
        }

        .
        .m-b-md {
            margin-bottom: 30px;
        }

        <!--
        кнопки

        -->
        /**
* Chunky 3D Web Buttons
*
* Inspiration was taken from:
* - http://www.premiumpixels.com/freebies/chunky-3d-webbuttons-psd/
*/
        /**
         * Shadow
         */
        a.button::before {
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            -webkit-box-shadow: #959595 0 2px 5px;
            -moz-box-shadow: #959595 0 2px 5px;
            border-radius: 3px;
            box-shadow: #959595 0 2px 5px;
            content: "";
            display: block;
            height: 100%;
            left: 0;
            padding: 2px 0 0;
            position: absolute;
            top: 0;
            width: 100%;
        }

        a.button:active::before {
            padding: 1px 0 0;
        }

        /**
         * Grey
         */
        a.button {
            -moz-box-shadow: inset 0 0 0 1px #63ad0d;
            -webkit-box-shadow: inset 0 0 0 1px #63ad0d;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            background: #eee;
            background: -webkit-gradient(linear, 0 0, 0 bottom, from(#eee), to(#e2e2e2));
            background: -moz-linear-gradient(#eee, #e2e2e2);
            background: linear-gradient(#eee, #e2e2e2);
            border: solid 1px #d0d0d0;
            border-bottom: solid 3px #b2b1b1;
            border-radius: 3px;
            box-shadow: inset 0 0 0 1px #f5f5f5;
            color: #555;
            display: inline-block;
            font: bold 12px Arial, Helvetica, Clean, sans-serif;
            margin: 0 25px 25px 0;
            padding: 10px 20px;
            position: relative;
            text-align: center;
            text-decoration: none;
            text-shadow: 0 1px 0 #fafafa;
        }

        a.button:hover {
            background: #e4e4e4;
            background: -webkit-gradient(linear, 0 0, 0 bottom, from(#e4e4e4), to(#ededed));
            background: -moz-linear-gradient(#e4e4e4, #ededed);
            background: linear-gradient(#e4e4e4, #ededed);
            border: solid 1px #c2c2c2;
            border-bottom: solid 3px #b2b1b1;
            box-shadow: inset 0 0 0 1px #efefef;
        }

        a.button:active {
            background: #dfdfdf;
            background: -webkit-gradient(linear, 0 0, 0 bottom, from(#dfdfdf), to(#e3e3e3));
            background: -moz-linear-gradient(#dfdfdf, #e3e3e3);
            background: linear-gradient(#dfdfdf, #e3e3e3);
            border: solid 1px #959595;
            box-shadow: inset 0 10px 15px 0 #c4c4c4;
            top: 2px;
        }

        /**
         * Pink
         */
        a.button.pink {
            background: #f997b0;
            background: -webkit-gradient(linear, 0 0, 0 bottom, from(#f997b0), to(#f56778));
            background: -moz-linear-gradient(#f997b0, #f56778);
            background: linear-gradient(#f997b0, #f56778);
            border: solid 1px #ee8090;
            border-bottom: solid 3px #cb5462;
            box-shadow: inset 0 0 0 1px #fbc1d0;
            color: #913944;
            text-shadow: 0 1px 0 #f9a0ad;
        }

        a.button.pink:hover {
            background: #f57184;
            background: -webkit-gradient(linear, 0 0, 0 bottom, from(#f57184), to(#f78297));
            background: -moz-linear-gradient(#f57184, #f78297);
            background: linear-gradient(#f57184, #f78297);
            border: solid 1px #e26272;
            border-bottom: solid 3px #cb5462;
            box-shadow: inset 0 0 0 1px #f9aab5;
        }

        a.button.pink:active {
            background: #f06a7c;
            background: -webkit-gradient(linear, 0 0, 0 bottom, from(#f06a7c), to(#f56c7e));
            background: -moz-linear-gradient(#f06a7c, #f56c7e);
            background: linear-gradient(#f06a7c, #f56c7e);
            border: solid 1px #a14753;
            box-shadow: inset 0 10px 15px 0 #d45d6d;
        }

        /**
         * Green
         */
        a.button.green {
            background: #cae285;
            background: -webkit-gradient(linear, 0 0, 0 bottom, from(#cae285), to(#a3cd5a));
            background: -moz-linear-gradient(#cae285, #a3cd5a);
            background: linear-gradient(#cae285, #a3cd5a);
            border: solid 1px #aad063;
            border-bottom: solid 3px #799545;
            box-shadow: inset 0 0 0 1px #e0eeb6;
            color: #5d7731;
            text-shadow: 0 1px 0 #d0e5a4;
        }

        a.button.green:hover {
            background: #abd164;
            background: -webkit-gradient(linear, 0 0, 0 bottom, from(#abd164), to(#b9d972));
            background: -moz-linear-gradient(#abd164, #b9d972);
            background: linear-gradient(#abd164, #b9d972);
            border: solid 1px #98b85b;
            border-bottom: solid 3px #799545;
            box-shadow: inset 0 0 0 1px #cce3a1;
        }

        a.button.green:active {
            background: #a4cb5d;
            background: -webkit-gradient(linear, 0 0, 0 bottom, from(#a4cb5d), to(#9ec45a));
            background: -moz-linear-gradient(#a4cb5d, #9ec45a);
            background: linear-gradient(#a4cb5d, #9ec45a);
            border: solid 1px #6e883f;
            box-shadow: inset 0 10px 15px 0 #90b352;
        }

        /**
         * Blue
         */
        a.button.blue {
            background: #abe4f8;
            background: -webkit-gradient(linear, 0 0, 0 bottom, from(#abe4f8), to(#74d0f4));
            background: -moz-linear-gradient(#abe4f8, #74d0f4);
            background: linear-gradient(#abe4f8, #74d0f4);
            border: solid 1px #8cc5d9;
            border-bottom: solid 3px #589cb6;
            box-shadow: inset 0 0 0 1px #cdeffb;
            color: #42788e;
            text-shadow: 0 1px 0 #b6e6f9;
        }

        a.button.blue:hover {
            background: #80d4f5;
            background: -webkit-gradient(linear, 0 0, 0 bottom, from(#80d4f5), to(#92dbf6));
            background: -moz-linear-gradient(#80d4f5, #92dbf6);
            background: linear-gradient(#80d4f5, #92dbf6);
            border: solid 1px #79acbe;
            border-bottom: solid 3px #589cb6;
            box-shadow: inset 0 0 0 1px #b2e6f8;
        }

        a.button.blue:active {
            background: #89d2ee;
            background: -webkit-gradient(linear, 0 0, 0 bottom, from(#89d2ee), to(#84cae6));
            background: -moz-linear-gradient(#89d2ee, #84cae6);
            background: linear-gradient(#89d2ee, #84cae6);
            border: solid 1px #5c8d9f;
            box-shadow: inset 0 10px 15px 0 #79b9d2;
        }
    </style>
    <meta name="yandex-verification" content="af4168af7d682a89"/>
    <!--icon -->
    <link rel="icon" href="<?php echo asset("images/icons/icons/favicon-16x16.png")?>" type="image/x-icon">
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())

            @else
                <a href="{{ url('/login') }}">Войти</a>
                <a href="{{ url('/join') }}">Зарегистрироваться</a>
            @endif
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">

        </div>

        <img height="350" src="<?php echo asset("/images/new.jpeg")?>">
        <div class="links">
            <br>
            <div class="links">
                <br>
                <a class="button green" href="{{route('main')}}" value="Смотреть анкеты" role="link">Смотреть анкеты</a>
                <a class="button blue" href="{{route('createGirlPage')}}" value="Смотреть анкеты" role="link">Разместить
                    анкету</a>
            </div>

        </div>
    </div>
</div>
</body>
</html>