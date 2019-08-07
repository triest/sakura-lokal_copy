@extends('layouts.blog', ['title' => 'Присоединиться к событию'])
@section('content')
    <div class="container">
        <p>
            <b>{{$event->name}}</b>
        </p>
        <p>
            {{$day}},
            {{$day_name}} число,
            {{$month_name}} <br>
            Начало:
            {{$time}}
            <br>
            Организатор:
            {{$organizer->name}} <br>

            <a href="{{route('showGirl',['id'=>$organizer->id,'utm_source'=>'event'])}}">
                <b>{{$organizer->name}}</b>
            </a>
        </p>
        <div id="eventregApp">
            <eventrequwest :event={{$event->id}}></eventrequwest>
        </div>
        <p>
            {{$event->description}}
        </p>
        <div class="container gallery-container">
            <div class="tz-gallery">
                <div class="row">
                    @foreach($photo as $image)
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

        <script>
            baguetteBox.run('.tz-gallery');
        </script>
    </div>

@endsection
