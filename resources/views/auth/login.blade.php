@extends("base")

@section("head")
    <title>Login</title>
    @parent
@stop

@section("body")

    <form role="form" class="form-centered" method="POST" action="/auth/login">
        {!! csrf_field() !!}

        <h2>Please log in</h2>
        <div>
            <label for="email" class="sr-only">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email address" required="" autofocus="">
        </div>

        <div>
            <label for="password" class="sr-only">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="">
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div>

        <div>
            <a href="{{ URL::to('password/email') }}">I forgot my password?</a>
        </div>

        <div>
            <button type="submit" class="btn btn-primary btn-block">Log In</button>
        </div>
    </form>

@stop