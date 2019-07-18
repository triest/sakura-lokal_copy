@extends('layouts.blog', ['title' => $girl->name])



@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="card  border-dark" style="width: 25rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                <img width="200" src="<?php echo asset("/images/upload/$girl->main_image")?>">
                {{$girl->status}}
                <br>
                Последний раз была: {{$girl->last_login}}
                @if (Auth::guest())

                @else
                    @if($girl->user_id!=auth()->user()->id)
                        <br>
                        <div class="card-body" id="app7">
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
        <div class="col-sm-4">
            <div class="card  border-dark" style="width: 30rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                <h4 class="card-title">
                    {{$girl->name}}
                </h4>

                <b>Пол:</b>
                @if($girl->sex=='famele')
                    <b> Женский</b>
                @endif

                @if($girl->sex=='male')
                    <b> Мужской</b>
                @endif
                <br>

                <b>Отношения:</b>
                @if ($relation!=null)
                    {{$relation->name}}
                @endif
                <br>

                @if ($children!=null)
                    <b>Дети:</b> {{$children->name}} <br>
                @endif

                @if ($smoking!=null)
                    <b>Отношение к курению:</b> {{$smoking->name}} <br>
                @endif
                <b>Телефон:</b>

                @if($phone_settings==1 and $phone!=null)
                    {{$phone}}
                @elseif($phone_settings==2)
                    @if (Auth::guest())
                        <b><a href="{{ url('/login') }}">Войдите </a></b> или
                        <b><a href="{{ url('/join') }}">зарегистрируйтесь</a></b> что-бы смотреть телефон!
                    @else
                        @if($girl->user_id!=auth()->user()->id)
                            <div id="phoneRequwestApp">
                                <phonerequwest :id="{{$girl->id}}" :user_id="{{$girl->user_id}}"></phonerequwest>
                            </div>
                        @elseif($phone_settings==2 and $girl->user_id=auth()->user()->id)
                            Ваш телефон виден только тем,  вы его откроете
                        @endif
                    @endif
                @endif

                <p class="card-text"><b>Рост :</b> {{$girl->height}}</p>
                <p class="card-text"><b>Вес : </b>{{$girl->weight}}</p>
                <p class="card-text"><b>Возраст :</b> {{$girl->age}}</p>
                <p class="card-text"><b>Внешность :</b></p>
                @if ($aperance!=null)
                    <p> {{$aperance->name}}</p>
                @else
                    Не указана
                @endif


                <p class="card-text"><b>Хочу встретиться с :</b> @if($girl->meet=='famele')
                        женщиной
                    @endif

                    @if($girl->meet=='male')
                        мужчиной
                    @endif
                </p>
                В возрасте от <b>{{$girl->from_age}}</b> до <b>{{$girl->to_age}}</b>
            </div>
        </div>
        <br>


    </div>

    <div class="row">
        <div class="card  border-dark" style="width: 70rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
            <div class="col-sm-4">
                <b>Интересы:</b> <br>
                @if($interes==null)
                    Интересы не указанны
                @else
                    @foreach($interes as $target)
                        {{$target->name}}<br>
                    @endforeach
                @endif
            </div>
            <div class="col-sm-4">
                <b>Цели знакомства:</b> <br>
                @if($targets==null)
                    Цели не указанны
                @else
                    @foreach($targets as $target)
                        {{$target->name}}<br>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <br>
        <br>
        <b>Город:</b> <br>
        @if($city!=null)
            {{$city->name}}
        @else
            Не указан
        @endif
        <br>
        <b>Регион:</b> <br>
        @if($region!=null)
            {{$region->name}}
        @else
            Не указан
        @endif
        <br><br>

        {!!$girl->description  !!}

        <br>
        <div class="container gallery-container">
            <div class="tz-gallery">
                <div class="row">
                    @foreach($images as $image)
                        <div class="col-sm-6 col-md-4 col-ld">
                            <a class="lightbox" href="<?php echo asset("/images/upload/$image->photo_name")?>">
                                <img height="250" src="<?php echo asset("/images/upload/$image->photo_name")?>">
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
                                <div class="col-sm-7 col-md-7 col-ld">
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
        @endif
        <br>
        <a class="btn btn-primary" href="{{route('main')}}" role="link" onclick=" relocate_home()">К списку анкет</a>


        <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script> -->


        <script>
            baguetteBox.run('.tz-gallery');
        </script>
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
