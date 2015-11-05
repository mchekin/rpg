@extends("base")

@section("head")
    <title>RPG</title>

    @parent

@stop

@section("body")
    <div class="content">
        <img src="{{ asset('images/village.png') }}" height="600" width="600">
        <div class="title">Role Playing Game</div>
        <a href="{{ URL::to('auth/login') }}"  class="btn btn-success">Login</a>
        <a href="{{ URL::to('auth/register') }}"  class="btn btn-success">Sign Up</a>
    </div>
@stop