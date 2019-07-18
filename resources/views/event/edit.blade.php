@extends('layouts.blog', ['title' => 'Создать событие'])
@section('content')

    <form action="{{route('storeEvent')}}" method="post" enctype="multipart/form-data">
        <br>
        <div class="form-group">
            <label for="title">Имя:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Название события"
                   value="{{$event->name}}"
                   required>
        </div>
        <div class="form-group">
            <label for="exampleInputFile">Описание события:</label><br>
            <textarea name="description" required>{{$event->description}} </textarea>
        </div>
        @if($errors->has('description'))
            <font color="red"><p class="errors">{{$errors->first('description')}}</p></font>
        @endif
        <div class="form-group">
            <label for="title">Место:</label>
            <input type="text" class="form-control" id="place" name="place" placeholder="место события"
                   value="{{$event->place}}"
                   required>
        </div>


        <div class="form-group">
            <div class="dates row">
                <label class="col-md-2 control-label">Дата начала:</label>
                <div class="col-3">
                    <input type="text" class="col form-control form-control-sm" name="begin"
                           id="begin" placeholder="YYYY-MM-DD" autocomplete="off" width="100" value="{{$event->begin}}"
                           required>
                </div>
            </div>
            @if($errors->has('arrival'))
                <font color="red"><p>  {{$errors->first('arrival')}}</p></font>
            @endif
        </div>
        <h3>Time</h3>
        <input id="timepicker" class="timepicker" name="datetime" type="text" required>

        <label class="mt-5">Time picker</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="material-icons">event</i></span>
            </div>
            <input class="form-control" id="timepicker" type="text" placeholder="Choose time">
        </div>
        <label class="mt-5">Date picker</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="material-icons">event</i></span>
            </div>
            <input class="form-control" id="datepicker" type="text" placeholder="Choose a date">
        </div>

        <script>
            $('#timepicker').bootstrapMaterialDatePicker({
                format: 'HH:mm',
                shortTime: false,
                date: false,
                time: true,
                monthPicker: false,
                year: false,
                switchOnClick: true
            });
        </script>

        <script>
            $(function() {
                $("#datepicker1").datepicker();
            });

            $(function() {
                $('#timepicker').timepicker();
            });
        </script>
        <div class="form-group">
            <div class="dates row">
                <label class="col-md-2 control-label">Дата окончания:</label>
                <div class="col-3">
                    <input type="text" class="col form-control form-control-sm" name="end"
                           id="end" placeholder="YYYY-MM-DD" autocomplete="off" width="100" value="{{$event->end}}"
                           required>
                </div>
            </div>
            @if($errors->has('departure'))
                <font color="red"><p>  {{$errors->first('departure')}}</p></font>
            @endif
        </div>


        <label for="max">Максимальное число участников (если нет ограничения, оставьте пустым):
            <input type="number" name="max" id="min" min="1" value="{{$event->max_people}}" checked>
        </label><br>

        <label for="min">Минимальное число участников (если нет ограничения, оставьте пустым):
            <input type="number" name="min" id="min" min="1" value="{{$event->min_people}}" checked>
        </label><br>


        Фотографии события
        <input type="file" id="images" accept="image/*" name="file" value="{{ old('file')}}">
        @if($errors->has('file'))
            <font color="red"><p>  {{$errors->first('file')}}</p></font>
        @endif
        <select>
            @foreach($statys as $item)
                <option value="{{$item->id}}">  {{$item->status_name}}</option>
            @endforeach
        </select>
        <input type="submit">
    </form>

    <script type="text/javascript">
        var defaults = {
            calendarWeeks: true,
            showClear: true,
            showClose: true,
            allowInputToggle: true,
            useCurrent: false,
            ignoreReadonly: true,
            minDate: new Date(),
            toolbarPlacement: 'top',
            locale: 'nl',
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-angle-up',
                down: 'fa fa-angle-down',
                previous: 'fa fa-angle-left',
                next: 'fa fa-angle-right',
                today: 'fa fa-dot-circle-o',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            }
        };

        $(function() {
            var optionsTime = $.extend({}, defaults, {format:'HH:mm'});

            $('.timepicker').datetimepicker(optionsTime);
        });
    </script>

@endsection