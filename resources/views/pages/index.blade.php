@extends("base")

@section("head")
    <title>{{ env('APP_NAME') }}</title>

    @parent

@stop

@section("body")
    <div class="content col-md-8 col-md-offset-2">
        <img class="img-responsive col-md-8 col-md-offset-2" src="{{ asset('images/village.png') }}">
        <div class="row">
            <div class="title col-md-8 col-md-offset-2">{{ env('APP_NAME') }}</div>
        </div>
        <div class="btn-group btn-group-justified">
            <a href="{{ URL::to('register') }}"  class="btn btn-success">Register</a>
            <a href="{{ URL::to('login') }}"  class="btn btn-primary">Login</a>
        </div>
    </div>
@stop