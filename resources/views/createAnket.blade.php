@extends('layouts.blog', ['title' => 'Создание анкеты'])
@section('content')


    <form action="{{route('storeGirl')}}" method="post" enctype="multipart/form-data">
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
                <br>
                <input type="tel" class="form-control" id="phone" name="phone" pattern="^\(\d{3}\)\d{3}-\d{2}-\d{2}$"
                       value="{{$phone}}" required disabled></input>
            </div>
        </div>

        Видимость телефона:
        <br>
        @foreach($phone_setting as $item)
            <input type="radio" id="phone_settings"
                   name="phone_settings" value="{{$item->id}}" checked>
            <label for="phone_settings">{{$item->name}}</label>
            <br>
        @endforeach

        <br>
        <b> Пол:</b> <br>
        <input type="radio" id="contactChoice1"
               name="sex" value="famele" checked>
        <label for="contactChoice1">Женский</label>

        <input type="radio" id="contactChoice2"
               name="sex" value="male">
        <label for="contactChoice2">Мужской</label>


        <br>
        <label for="age">Возраст:
            <input type="number" name="age" min="18" value="18" onkeypress="return isNumber(event)" checked>
        </label><br>
        @if($errors->has('age'))
            <font color="red"><p>  {{$errors->first('age')}}</p></font>
        @endif


        <label for="height">Рост:
            <input type="number" name="height" min="100" value="160" onkeypress="return isNumber(event)">
        </label><br>
        <label for="weight">Вес:
            <input type="number" name="weight" min="45" step="1" value="50"
                   pattern="[^@]+@[^@]+\.[0-9]{2,3}" onkeypress="return isNumber(event)">
        </label><br>

        <b>Внешность:</b> <br>
        @foreach($apperance as $target)
            <input type="radio" value="{{$target->id}}" name="aperance" id="aperance">
            {{$target->name}}
        @endforeach
        <br>

        <p><b>Отношения:</b></p>
        @foreach($realtions as $item)
            <input type="radio" value="{{$item->id}}" name="realtion" id="relation">
            {{$item->name}}
        @endforeach


        <p><b> С кем хотите познакомиться:</b></p>
        <input type="radio" id="contactmet"
               name="met" value="famele">
        c женщиной
        <br>
        <input type="radio" id="contactmet2"
               name="met" value="male" checked>
        с мужчиной
        <br>
        <br>
        в возрасте от <input type="number" name="from" id="from" min="18" value="18"
                             onkeypress="return isNumber(event)">
        @if($errors->has('from'))
            <font color="red"><p>  {{$errors->first('from')}}</p></font>
        @endif
        до
        <input type="number" id="to" name="to" min="18" value="18" onkeypress="return isNumber(event)">


        @if($errors->has('to'))
            <font color="red"><p>  {{$errors->first('to')}}</p></font>
        @endif

        <p><b>Цель знакомства:</b></p>
        @foreach($tagrets as $target)
            <input class="form-check-input" type="checkbox" value="{{$target->id}}" name="target[]">
            {{$target->name}}
            <br>
        @endforeach

        <b>Интересы:</b> <br>
        @foreach($interests as $interest)
            <input class="form-check-input" type="checkbox" value="{{$interest->id}}" name="interest[]">
            {{$interest->name}}
            <br>
        @endforeach

        <b>Дети:</b>
        @foreach($childrens as $item)
            <br>
            <input type="radio" value="{{$item->id}}" name="childrens" id="childrens">
            {{$item->name}}
        @endforeach

        <p><b>Отношение к курению:</b></p>
        @foreach($smoking as $item)
            <input type="radio" value="{{$item->id}}" name="smoking" id="smoking">
            {{$item->name}}
        @endforeach

        <div id="country">
            <label>Город</label>
            <input name="cityname" id="cityname" oninput="findCity();" type="text"/>
        </div>


        <label>Выбирите из списка:
            <select id="city" class="city" style="width: 200px" name="city">
                <option value="-">-</option>
            </select>
        </label>
        <br>

        <script>
            /*  function findCity() {
                  var inputcity = document.getElementById('cityname').value;
                  console.log(inputcity);
                  var x = document.getElementById("city");
                  var option = document.createElement("option");
                  axios.get('/findcity/' + inputcity, {
                      params: {}
                  })
                      .then((response) => {
                          var data = response.data;
                          for (var i = 0; i <= data.length; i++) {
                          }
                      });
              }*/
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

        <label>Выберите заглавную фотографию</label>

        <input type="file" id="file" accept="image/*" name="file" value="{{ old('file')}}" required>
        @if($errors->has('file'))
            <font color="red"><p>  {{$errors->first('file')}}</p></font>
        @endif
        <br>


        <br>
        <div class="form-group">
            <label for="exampleInputFile">Текст анкеты:</label><br>
            <textarea name="description" required> </textarea>
        </div>
        @if($errors->has('description'))
            <font color="red"><p class="errors">{{$errors->first('description')}}</p></font>
        @endif

        <div class="form-group">
            <label for="exampleInputFile">Приватный текст, который видно только тем, кому вы откроете доступ:</label>
            <br>
            <textarea name="private" required> </textarea>
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

        <label>Выберите фотографии для галереи(можно больше одной)</label>
        <input required type="file" class="form-control" name="images[]" accept="image/*" placeholder="Фотографии"
               multiple>
        <br>

        <label>Выберите приватные фотографии для галереи(можно больше одной). Их смогут вилетьтолько те, кому вы
            откроете доступ.</label>
        <input required type="file" class="form-control" name="privateimages[]" accept="image/*"
               placeholder="Фотографии"
               multiple>
        <br>

        <button type="submit" class="btn btn-default">Создать анкету</button>
    </form>

    <script>
        $('#state').bind('input', function () {
            $(this).next().stop(true, true).fadeIn(0).html('[input event fired!]: ' + $(this).val()).fadeOut(2000);
        });


    </script>

@endsection