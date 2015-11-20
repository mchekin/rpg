<!DOCTYPE html>
<html>
    <head>
        @section("head")
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @show
    </head>
    <body>

        <div class="container">
            @include('partials.navbar')

            @include('partials.errors')

            @yield("body")
        </div>

        @section("footer")
            <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        @show
    </body>
</html>
