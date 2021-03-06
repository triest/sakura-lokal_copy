@extends('layouts.blog', ['title' => $girl->name])



@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-9 box-shadow">
            <div class="card  border-dark" style="width: 25rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                <img width="200" height="200" src="<?php echo asset("/images/upload/$girl->main_image")?>">
                @if (Auth::guest())
                @else
                    @if($girl->user_id!=auth()->user()->id)
                        <br>
                        <div class="card-body" id="app7">
                            {{$girl->user_id}}
                            <privatepanel :id="{{$girl->id}}" :user_id="{{$girl->user_id}}"></privatepanel>
                        </div>
                    @else
                        <br>
                        <a class="btn btn-primary" href="{{route('girlsEditAuchAnket')}}"> Редактировать анкету</a>
                    @endif
                    @if(auth()->user()->get_id()!=$girl->user_id)
                    @endif
                @endif
                <br>
                <img height="15" alt="просмотров анкеты:" title="просмотров анкеты"
                     src="<?php echo asset("/images/eye.png")?>">
                {{$views}}

                <div class="card-body" id="likesApp">
                    @if (Auth::guest())
                        <likes></likes>
                        Войдите или зарегистрируйтесь
                    @else
                        <likes :user="{{auth()->user()}}" :girlid="{{$girl->id}}"></likes>

                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-9 box-shadow">
            <b>  {{$girl->name}}</b>, {{$girl->age}}
            @if($girl->isOnline())
                <img width="10" src="<?php echo asset("/images/circle-16.ico")?>" title="В сети">
            @endif
            @if($girl->isOnline())
            @else
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
            @endif
            @if ($girl->status!=null)
                <br>
                {{$girl->status}}
            @endif
            <div class="card  border-dark" style="width: 30rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;">


                @if($phone_settings==1 and $phone!=null)
                    <b>Телефон:</b>
                    {{$phone}}
                @elseif($phone_settings==2)
                    @if (Auth::guest())
                        <b><a href="{{ url('/login') }}">Войдите </a></b> или
                        <b><a href="{{ url('/join') }}">зарегистрируйтесь</a></b> что-бы смотреть телефон!
                    @else
                        @if($girl->user_id!=auth()->user()->id)
                            <div id="phoneRequwestApp">
                                <phonerequwest :id="{{$girl->id}}"
                                               :user_id="{{$girl->user_id}}"></phonerequwest>
                            </div>
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
        </div>


    </div>

    <div class="row">
        <div class="card  " style="width: 70rem; background-color: #eeeeee;">
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


        @if ($children!=null)
            <b>Дети:</b> {{$children->name}} <br>
        @endif

        @if ($smoking!=null)
            <b>Отношение к курению:</b> {{$smoking->name}} <br>
        @endif
        <br>
        <div class="col-lg-12 col-md-4 col-xs-6  col-sm-4 thumb">
            {!!$girl->description  !!}
        </div>
    </div>
    <br>
    <div class="container gallery-container">
        <div class="tz-gallery">
            <div class="row">
                @foreach($images as $image)

                    <div class="col-lg-3 col-md-4 col-xs-6  col-sm-4 thumb">
                        <a class="lightbox" href="<?php echo asset("/images/upload/$image->photo_name")?>">
                            <img height="250"
                                 src="<?php echo asset("/images/upload/$image->photo_name")?>">
                        </a>
                    </div>

                @endforeach
            </div>
        </div>
    </div>

    @if($girl->private!=null)
        <label>Приватное сообщение:</label>
        <p class="card-text>">{!!$girl->private  !!}</p>
        @if (empty($privatephotos))
        @else
            <label>Приватные фотографии:</label>
            <div class="container gallery-container">
                <div class="tz-gallery">
                    <div class="row">
                        @foreach($privatephotos as $image)
                            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                                <a class="lightbox" href="<?php echo asset("/images/upload/$image->photo_name")?>">
                                    <img height="200"
                                         src="<?php echo asset("/images/upload/$image->photo_name")?>">
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-4 col-ld"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @else
        <br><br>
        <div class="col-lg-3 col-md-4 col-xs-6  col-sm-4 thumb">
            Вы не может смотреть приватную часть анкеты. Попросите пользователя открыть её.
            <div id="private2App">
                <private2 :id="{{$girl->id}}" :user_id="{{$girl->user_id}}"></private2>
            </div>
        </div>

    @endif
    <br>
    @if($prevesion_page!=null)
        <a class="btn btn-primary" href="{{$prevesion_page}}" role="link">К списку анкет</a>

    @else
        <a class="btn btn-primary" href="{{route('main')}}" role="link" onclick=" relocate_home()">К списку анкет</a>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>


    <script>
        baguetteBox.run('.tz-gallery');
    </script>



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