@extends("base")

@section("head")
    <title>{{ env('APP_NAME') }}</title>

    @parent

@stop

@section("body")
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <img class="img-fluid mt-2" src="{{ asset('images/village.png') }}">

            <p class="text-center title">{{ env('APP_NAME') }}</p>

            <div class="btn-group d-flex" role="group">
                <a href="{{ URL::to('register') }}" class="btn btn-success w-100">{{ _t('Register') }}</a>
                <a href="{{ URL::to('login') }}" class="btn btn-primary w-100">{{ _t('Login') }}</a>
            </div>

        </div>
    </div>
@stop