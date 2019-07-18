@extends('layouts.blog', ['title' => 'Создание анкеты'])
@section('content')

    <style>
        textarea {
            resize: none;
        }
    </style>

    <form action="{{route('girlsEdit')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <br>
        <div class="form-group">
            <label for="title">Имя:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Имя" value="{{$username}}"
                   readonly required>
        </div>

        @if($errors->has('name'))
            <font color="red"><p>  {{$errors->first('name')}}</p></font>
        @endif


        <div class="control-group2" ng-class="{true: 'error'}[submitted && form.pas.$invalid]">
            <div class="form-group">
                <label for="phone">Ваш телефон:</label>
                <!--   <input type="tel" class="form-control" id="phone" name="phone" pattern="^\(\d{3}\)\d{3}-\d{2}-\d{2}$" required></input>-->

            </div>
        </div>
        <b> Пол:</b> <br>
        <input type="radio" id="contactChoice1"
               name="sex" value="famele" checked>
        Женский
        <input type="radio" id="contactChoice2"
               name="sex" value="male">
        Мужской

        <br>
        <label for="age">Возраст:
            <input type="number" name="age" min="18" value="18" onkeypress="return isNumber(event)" checked>
        </label><br>
        @if($errors->has('age'))
            <font color="red"><p>  {{$errors->first('age')}}</p></font>
        @endif

        <label for="age">Рост:
            <input type="number" name="height" min="100" value="160" onkeypress="return isNumber(event)">
        </label><br>
        <label for="age">Вес:
            <input type="number" name="weight" min="45" step="1" value="50"
                   pattern="[^@]+@[^@]+\.[0-9]{2,3}" onkeypress="return isNumber(event)">
        </label><br>

        <b>Внешность:</b> <br>
        @foreach($aperance as $target)
            @if($girl->apperance_id==$target->id)
                <input type="radio" value="{{$target->id}}" name="aperance" id="aperance" checked>
            @else
                <input type="radio" value="{{$target->id}}" name="aperance" id="aperance">
            @endif
            {{$target->name}}
        @endforeach
        <br>

        <p><b>Отношения:</b></p>
        @foreach($realtions as $item)
            @if($girl->relation_id==$item->id)
                <input type="radio" value="{{$item->id}}" name="realtion" id="relation" checked>
                {{$item->name}}
            @else
                <input type="radio" value="{{$item->id}}" name="realtion" id="relation">
            @endif
        @endforeach


        <b> С кем хотите познакомиться:</b> <br>
        <input type="radio" id="contactmet"
               name="met" value="famele">
        c женщиной
        <br>
        <input type="radio" id="contactmet2"
               name="met" value="male" checked>
        с мужчиной
        <br>
        в возрасте от <input type="number" name="from" id="from" min="18" value="{{$girl->from_age}}"
                             onkeypress="return isNumber(event)">
        @if($errors->has('from'))
            <font color="red"><p>  {{$errors->first('from')}}</p></font>
        @endif
        до
        <input type="number" id="to" name="to" min="18" value="{{$girl->to_age}}"
               onkeypress="return isNumber(event)">
        <br>
        <label>Цель знакомства:</label>
        @foreach($allTarget as $tag)
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="tags[]" value="{{$tag}}"
                       @if(in_array($tag,$anketTarget)) checked="1" @endif >
                {{$tag}}
            </div>
        @endforeach
        <br>
        <label>Интересы:</label>
        @foreach($allInterests as $tag)
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="interests[]" value="{{$tag}}"
                       @if(in_array($tag,$anketInterests)) checked="1" @endif >
                {{$tag}}
            </div>
        @endforeach

        <label>Настройки видимости телефона:</label> <br>
        @foreach($phone_settings as $item)
            @if($select_phone_settings->id==$item->id)
                <input type="radio" id="phone_settings"
                       name="phone_settings" value="{{$item->id}}" checked>
            @else
                <input type="radio" id="phone_settings"
                       name="phone_settings" value="{{$item->id}}">
            @endif
            {{$item->name}}
            <br>
        @endforeach

        <div id="country">
            <label>Город</label>
            @if($city!=null)
                <input type="text" name="state" id="state" class="form-control" value="{{$city->name}}">
            @else
                <input name="cityname" id="cityname" oninput="findCity();" type="text"/>
            @endif
        </div>

        <label>Город:
            <select id="city" class="city" style="width: 200px" name="city">
                <option value="-">-</option>
            </select>
        </label>


        <!--  <div id="selectCityApp">
              <selectcity></selectcity>
          </div>
          -->

        <br>
        <div class="form-group">
            <label for="exampleInputFile">Текст анкеты:</label><br>
            <textarea class="form-control" rows="10" name="description"
                      required>{{$girl->description}} </textarea>
        </div>
        @if($errors->has('description'))
            <font color="red"><p class="errors">{{$errors->first('description')}}</p></font>
        @endif

        <div class="form-group">
            <label for="exampleInputFile">Приватный текст, который видно только тем, кому вы откроете
                доступ:</label>
            <br>
            <textarea class="form-control" rows="10" name="private" required>{{$girl->private}} </textarea>
        </div>
        @if($errors->has('private'))
            <font color="red"><p class="errors">{{$errors->first('private')}}</p></font>
        @endif

        <input type="hidden" value="{{csrf_token()}}" name="_token">

        <script type="text/javascript">
            $(document).ready(function () {
                $("ul.dropdown-menu input[type=checkbox]").each(function () {
                    $(this).change(function () {
                        var line = "";
                        $("ul.dropdown-menu input[type=checkbox]").each(function () {
                            if ($(this).is(":checked")) {
                                line += $("+ span", this).text() + ";";
                            }
                        });
                        $("input.form-control").val(line);
                    });
                });
            });
        </script>

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
                            $('#city').append('<option value="' + data[0][i].id + '">' + data[0][i].name + '</option>');
                        }
                    });
            }

        </script>


        <br>
        <script type="text/javascript">
            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }

            function isNumber2(evt) {
                evt = (evt) ? evt : window.event;
                return false;
            }
        </script>

        <script>
            $('#state').on('input', function (e) {
                var state_id = e.target.value;
                $.get(
                    "/findcity/" + state_id,
                    function (data, status) {
                        $('#city').empty();
                        $.each(data[0], function (index, subcatObj) {

                            $('#city').append('<option value="' + subcatObj.id_city + '">' + subcatObj.name + '</option>');
                        })
                    }
                )
            });
        </script>
        <button type="submit" class="btn btn-default">Сохранить изминения</button>
        <a class="btn btn-primary" href="{{route('myAnket')}}" role="link"
           onclick=" relocate_home()">Отменить</a>
    </form>
@endsection