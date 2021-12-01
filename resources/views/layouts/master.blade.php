<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content={{ csrf_token() }}>
    <title>@if(isset($title)) {{$title}} :: @else Growave Market @endif</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="manifest" href="/mix-manifest.json">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    @stack('styles')
</head>
<body class="container-fluid">
    <header>
        @yield('header')
    </header>

    <div class="body">
        @yield('content')
    </div>

    <footer>
    </footer>

<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
