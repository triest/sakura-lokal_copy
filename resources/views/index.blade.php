@extends('layouts.blog', ['title' => 'Список анкет'])

@section('content')

    @foreach($girls as $girl)
        <!-- md -комп-->
        <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
            <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                <div class="card-body">
                    <a href="{{route('showGirl',['id'=>$girl->id])}}">
                        <img height="150" width="150"
                             src="<?php echo asset("/images/small/$girl->main_image")?>">
                    </a>

                    <h4 class="card-title">
                        <a href="{{route('showGirl',['id'=>$girl->id,'utm_source'=>'mainstream'])}}">
                            <b>{{$girl->name}}</b>
                            <small>{{$girl->age}}</small>
                        </a>
                    </h4>

                </div>
            </div>
        </div>
    @endforeach

    <?php echo $girls->render(); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
    <script>
        baguetteBox.run('.tz-gallery');
    </script>

@endsection