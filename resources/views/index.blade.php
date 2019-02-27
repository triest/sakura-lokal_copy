@extends('layouts.blog', ['title' => 'Список анкет'])



@section('content')

    @foreach($girls as $girl)
        <!-- md -комп-->
        <div class="col-lg-12 col-md-10 col-sm-5 col-xs-9 ">
            <a href="{{route('showGirl',['id'=>$girl->id])}}">
                <img height="250" width="250"
                     src="<?php echo asset("/images/upload/$girl->main_image")?>"></a>
            </a>
            <h4 class="card-title">
                <b> <a href="{{route('showGirl',['id'=>$girl->id])}}">{{$girl->name}}</a></b>
            </h4>
        </div>
    @endforeach

    <?php echo $girls->render(); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
    <script>
        baguetteBox.run('.tz-gallery');
    </script>

@endsection