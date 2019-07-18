@extends('layouts.blog', ['title' => 'Список анкет'])

@section('content')
    Ваш город {{$city->name}}

    <form action="{{route('agreeCity')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="city_name" id="city_name" value="{{$city->name}}">
        <input type="hidden" name="city_id" id="city_id" value="{{$city->id_city}}">
        <button type="submit" class="btn btn-default">Да</button>
    </form>

    Если нет, начните вводить название, а за тем выбирите из списка.
    <label>Город</label>
    <form action="{{route('newCity')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input name="cityname" id="cityname" oninput="findCity();" type="text"/>
        <label>Выбирите из списка:
            <select id="city" class="city" style="width: 200px" name="city">
                <option value="-">-</option>
            </select>
        </label>
        <button type="submit" class="btn btn-default">Да</button>
    </form>
    <br>

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

@endsection