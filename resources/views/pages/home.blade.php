@extends("base")

@section("head")
    <title>RPG</title>

    @parent

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
    </style>
@stop

@section("body")
    <div class="container">
        <div class="content">
            <img src="{{ asset('images/village.png') }}" height="600" width="600">
            <div class="title">Role Playing Game</div>
            <a href="{{ URL::to('auth/login') }}"  class="btn btn-success">Login</a>
            <a href="{{ URL::to('auth/register') }}"  class="btn btn-success">Register</a>
        </div>
    </div>
@stop