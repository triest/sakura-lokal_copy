@extends('layouts.blog', ['title' => 'Список анкет'])

@section('content')
    @if ($agent->isMobile())

        Show mobile stuff...
    @else
        Not mobile;
    @endif

@endsection