@extends("base")

@section("head")
    <title>{{ config('app.name') }}</title>

    @parent

@stop

@section("body")
    <div class="row mx-1 justify-content-center">
        <div class="col-lg-6">

            <img class="img-fluid mt-2" src="{{ asset('images/village.png') }}">

            <p class="text-center title">{{ config('app.name') }}</p>

            <div class="btn-group d-flex" role="group">
                <a href="{{ URL::route('register') }}" class="btn btn-success mx-1">Register</a>
                <a href="{{ URL::route('login') }}" class="btn btn-primary mx-1">Login</a>
            </div>

        </div>
    </div>
@stop
