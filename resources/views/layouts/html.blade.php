<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
<head>
    @include('layouts.header')
</head>
<body>
@include('layouts.leftMenu')

@include('layouts.content')

@include('layouts.footer')
</body>
</html>
