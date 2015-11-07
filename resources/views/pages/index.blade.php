@extends("base")

@section("head")
    <title>RPG</title>

    @parent

@stop

@section("body")
    <div class="content content-centered">
        <img src="{{ asset('images/village.png') }}" height="600" width="600">
        <div class="title">Role Playing Game</div>
        <div class="btn-group btn-group-justified">
            <a href="{{ URL::to('auth/register') }}"  class="btn btn-success">Register</a>
            <a href="{{ URL::to('auth/login') }}"  class="btn btn-primary">Login</a>
        </div>
    </div>
@stop