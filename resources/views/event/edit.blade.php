@extends('layouts.blog', ['title' => $event->name])
@section('content')

    <form action="{{route('updateEvent')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" id="id" name="id" value="{{$event->id}}">
        <div class="form-group">
            <div class="col-xs-11">
                <label for="title">Имя:</label><br>
                <input type="text" class="form-control" id="name" name="name" value="{{ $event->name }}"
                       placeholder="Название события"
                       required>
            </div>
            @if($errors->has('name'))
                <font color="red"><p>  {{$errors->first('name')}}</p></font>
            @endif
        </div>
        <div class="form-group">
            <div class="col-xs-17">
                <label for="exampleInputFile">Описание события:</label><br>
                <textarea name="description" rows="2" required>{{$event->description}} </textarea>
            </div>
        </div>
        @if($errors->has('description'))
            <font color="red"><p class="errors">{{$errors->first('description')}}</p></font>
        @endif

        <div class="col-xs-11">

            <label>Город. Начните вводить название, а за тем выберите из списка:</label><br>
            <input name="cityname" id="cityname" value="{{$event->city_name }}"
                   placeholder="Начните вводить название города" oninput="findCity();" type="text"/>

            @if($errors->has('cityname'))
                <font color="red"><p>  {{$errors->first('cityname')}}</p></font>
            @endif


            <label>Выбирите из списка:
                <select id="city" class="city" style="width: 200px" name="city" required>
                    <option value="{{$event->id_city}}">{{$event->city_name}}</option>
                </select>
            </label>
            @if($errors->has('city'))
                <font color="red"><p>  {{$errors->first('city')}}</p></font>
            @endif

            <script>
                function findCity() {
                    var inputcity = document.getElementById('cityname').value;
                    console.log(inputcity);
                    var x = document.getElementById("city");
                    var option = document.createElement("option");
                    axios.get('/findcity/' + inputcity, {
                        params: {}
                    })
                        .then((response) => {
                            var data = response.data;
                            $('#city').empty();
                            for (var i = 0; i <= data[0].length; i++) {
                                $('#city').append('<option value="' + data[0][i].id_city + '">' + data[0][i].name + '</option>');
                            }
                        });
                }

            </script>

            <br>
            <label for="title">Место:</label>
            <input type="text" class="form-control" id="place" name="place" value="{{ $event->place }}"
                   placeholder="место события"
                   required>

            @if($errors->has('place'))
                <font color="red"><p>  {{$errors->first('place')}}</p></font>
            @endif
        </div>
        <div class="col-xs-11">
            <p>
                Дата:
                <input type="date" id="date" name="date" value="{{$date}}" required>
                @if($errors->has('date'))
                    <font color="red">  {{$errors->first('date')}}</font>
                @endif
            </p>
            Время:
            <input type="time" id="time" name="time" value="{{$time }}">
            @if($errors->has('time'))
                <font color="red"><p>  {{$errors->first('time')}}</p></font>
            @endif

            <label for="max">Максимальное число участников (если нет ограничения, оставьте пустым):
                <input type="number" name="max" id="min" min="1" value="{{$event->max_people}}" checked>
            </label><br>

            <label for="min">Минимальное число участников (если нет ограничения, оставьте пустым):
                <input type="number" name="min" id="min" min="1" value="{{$event->min_people}}" checked>
            </label><br>
        </div>


        <button type="submit" class="btn btn-default">Создать событие</button>
    </form>

@endsection