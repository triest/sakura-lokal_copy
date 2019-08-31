@extends('layouts.blog', ['title' => 'Присоединиться к событию'])
@section('content')
    <div class="container">
        <p>
            <b>{{$event->name}}</b>
        </p>
        <p>
            {{$day}}, {{$month_name}}
            {{$day_name}} ,
        </p>
        <p>
            Начало:
            {{$time}}
        </p>
        <p>
        Организатор:
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
                            <a class="lightbox" href="<?php echo asset("/images/events/$image->photo_name")?>">
                                <img height="200"
                                     src="<?php echo asset("/images/events/$image->photo_name")?>">
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-4 col-ld"></div>
                    @endforeach
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>

        <script>
            baguetteBox.run('.tz-gallery');
        </script>
    </div>

@endsection
