@extends("base")

@section("head")
    <title>Register</title>
    @parent
@stop

@section("body")

    <form method="POST" action="/auth/register">
        {!! csrf_field() !!}

        @include('partials.errors')

        <div>
            Name
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div>
            Email
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            Password
            <input type="password" name="password">
        </div>

        <div>
            Confirm Password
            <input type="password" name="password_confirmation">
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Register</button>
        </div>
    </form>

@stop