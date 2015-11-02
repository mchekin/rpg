@extends("base")

@section("head")
    <title>Login</title>
    @parent
@stop

@section("body")

    <form method="POST" action="/auth/login">
    {!! csrf_field() !!}

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Password
        <input type="password" name="password" id="password">
    </div>

    <div>
        <input type="checkbox" name="remember"> Remember Me
    </div>

    <div>
        <a href="{{ URL::to('password/email') }}">I forgot my password?</a>
    </div>

    <div>
        <button type="submit">Login</button>
    </div>
</form>

@stop