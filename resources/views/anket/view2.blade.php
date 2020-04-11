@extends('layouts.blog', ['title' => $girl->name])



@section('content')
    <div class="row">
        <div id="ankataApp">
            <div class="col-lg-4 col-md-3 col-sm-3 col-xs-9 box-shadow">
                <img width="200" height="200" src="<?php echo asset("/images/upload/$girl->main_image")?>">
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-9 box-shadow">
            <b>  {{$girl->name}}</b>, {{$girl->age}}

            @if($girl->isOnline())
                <img width="10" src="<?php echo asset("/images/circle-16.ico")?>" title="В сети">
            @endif
            @if(!$girl->isOnline())
                <small>
                    @if($girl->lastLoginFormat()!="")
                        @if($girl->sex=='famele')
                            <small>, последний раз была {{$girl->lastLoginFormat()}}</small>
                        @endif

                        @if($girl->sex=='male')
                            <small>, последний раз был {{$girl->lastLoginFormat()}}</small>
                        @endif
                    @endif
                </small>
            @else
                <img width="10" src="<?php echo asset("/images/circle-16.ico")?>" title="В сети">
            @endif
            @if ($girl->status!=null)
                <br>
                {{$girl->status}}
            @endif
        </div>
    </div>
    <div class="row">
        <a href="{{route('albumItem',['id'=>$girl->id])}}"> Фотографии</a>
        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-9 box-shadow">
            @if($phone_settings==1 and $phone!=null)
                <b>Телефон:</b>
                {{$phone}}
            @elseif($phone_settings==2)
                @if (Auth::guest())
                    <b><a href="{{ url('/login') }}">Войдите </a></b> или
                    <b><a href="{{ url('/join') }}">зарегистрируйтесь</a></b> что-бы смотреть телефон!
                @else
                    @if($girl->user_id!=auth()->user()->id)
                    @elseif($phone_settings==2 and $girl->user_id=auth()->user()->id)
                        Ваш телефон виден только тем,  вы его откроете
                    @endif
                @endif
            @endif


            <p class="card-text"><b>Хочу встретиться с :</b> @if($girl->meet=='famele')
                    девушкой
                @endif

                @if($girl->meet=='male')
                    парнем
                @endif
                в возрасте от <b>{{$girl->from_age}}</b> до <b>{{$girl->to_age}}</b>
            </p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-3 col-xs-9 box-shadow">

                @if($interes!=null)
                    <div class="col-lg-4 col-md-3 col-sm-4 col-xs-9 box-shadow">
                        @if($interes!=null)
                            <b>Интересы:</b> <br>
                            @foreach($interes as $target)
                                {{$target->name}}<br>
                            @endforeach
                        @endif
                    </div>
                @endif
                @if($targets!=null)
                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 box-shadow">

                        @if($targets!=null)
                            <b>Цели знакомства:</b> <br>
                            @foreach($targets as $target)
                                {{$target->name}}<br>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            @if($girl->height!=null)
                <p class="card-text"><b>Рост :</b> {{$girl->height}}
                    @endif
                    @if($girl->weight!=null)
                        <b>Вес : </b>{{$girl->weight}}</p>
            @endif
            @if ($aperance!=null)
                <p class="card-text"><b>Внешность :</b></p>
                <p> {{$aperance->name}}</p>
            @endif



            @if($region!=null)
                <b>Регион:</b> <br>
                {{$region->name}}
            @endif
            @if ($relation!=null)
                <b>Отношения:</b>
                {{$relation->name}}
                <br>
            @endif
        </div>
        <div class="row">

            @if ($children!=null)
                <b>Дети:</b> {{$children->name}} <br>
            @endif

            @if ($smoking!=null)
                <b>Отношение к курению:</b> {{$smoking->name}} <br>
            @endif
            <br>
        </div>
        @if(isset($girl->description) && $girl->description!=null)
            {!!$girl->description  !!}
        @endif
        <div class="row">
            <p><b>Приватное сообщение</b></p>
            <p class="card-text>">
                @if($girl->private!=null)
                    <label>Приватное сообщение:</label>
                    {!!$girl->private  !!}
            </p>
            @else
                Вы не можете смотреть приватное сообщение. Попросите пользователя открыть анкету
            @endif
        </div>
    </div>
@endsection
<script>


    import Likes from "./likes";

    export default {
        components: {

            Likes
        }
    }
</script>
<script>
    import Private2 from "../js/components/anket/private2";

    export default {
        components: {Private2}
    }
</script>