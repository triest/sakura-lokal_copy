<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Близкие знакомства</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- иконка -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
</head>
<body>
<script language="JavaScript" type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>

<div class="flex-center position-ref full-height">
    <input type="text" class="form-control" id="datetimepicker5">

    <script type="text/javascript">
        $(document).ready(function () {
            $(function () {
                $('#datetimepicker5').datetimepicker(
                    {locale: 'ru'}
                );
            });
        });
    </script>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
</body>
</html>