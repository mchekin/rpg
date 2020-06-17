<!DOCTYPE html>
<html lang="en">
<head>
    @section('head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google" content="notranslate">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>
        {{--<meta http-equiv="refresh" content="30">--}}
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet"
              href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
              integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
              crossorigin="anonymous">
    @show
</head>
<body>

<div class="container" id="app">
    @include('partials.navbar')

    @include('partials.errors')

    @include('partials.status')

    @yield('body')
</div>

@section('footer')
    <script src="{{ asset('js/app.js') }}"></script>
@show
</body>
</html>
