@extends('layouts.blog', ['title' => 'Создать событие'])
@section('content')

    <form action="{{route('storeEvent')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <br>
        <div class="form-group">
            <label for="title">Имя:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                   placeholder="Название события"
                   required>
        </div>
        @if($errors->has('name'))
            <font color="red"><p>  {{$errors->first('name')}}</p></font>
        @endif

        <div class="form-group">
            <label for="exampleInputFile">Описание события:</label><br>
            <textarea name="description" required> </textarea>
        </div>
        @if($errors->has('description'))
            <font color="red"><p class="errors">{{$errors->first('description')}}</p></font>
        @endif

        <div id="country">
            <label>Город. Начните вводить название, а за тем выберите из списка</label>
            <input name="cityname" id="cityname" value="{{ old('cityname') }}" oninput="findCity();" type="text"/>
        </div>
        @if($errors->has('cityname'))
            <font color="red"><p>  {{$errors->first('cityname')}}</p></font>
        @endif


        <label>Выбирите из списка:
            <select id="city" class="city" style="width: 200px" name="city">
                <option value="-">-</option>
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

        <div class="form-group">
            <label for="title">Место:</label>
            <input type="text" class="form-control" id="place" name="place" value="{{ old('place') }}"
                   placeholder="место события"
                   required>
        </div>
        



        <strong>Дата : </strong>



        <input type="text" class="form-control" id="datetimepicker5">

        <script type="text/javascript">
            $(function () {
                $('#datetimepicker5').datetimepicker(
                    {locale: 'ru'}
                );
            });
        </script>

        <label for="max">Максимальное число участников (если нет ограничения, оставьте пустым):
            <input type="number" name="max" id="min" min="1" checked>
        </label><br>

        <label for="min">Минимальное число участников (если нет ограничения, оставьте пустым):
            <input type="number" name="min" id="min" min="1" checked>
        </label><br>


        Фотографии события
        <input type="file" id="images" accept="image/*" name="file[]" value="{{ old('file')}}">
        @if($errors->has('file'))
            <font color="red"><p>  {{$errors->first('file')}}</p></font>
        @endif


        <button type="submit" class="btn btn-default">Создать событие</button>
    </form>

@endsection