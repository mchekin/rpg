@extends("base")

@section("head")
    <title>Login</title>
    @parent
@stop

@section("body")

    <form role="form" class="col-md-4 col-md-offset-4" method="POST" action="/auth/login">
        {!! csrf_field() !!}

        <h2>Please log in</h2>
        <div class="form-group">
            <div>
                <label for="email" class="sr-only">Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email address" required="" autofocus="">
            </div>
        </div>

        <div class="form-group">
            <div>
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="">
            </div>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div>

        <div>
            <a href="{{ URL::to('password/email') }}">I forgot my password?</a>
        </div>

        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-primary btn-block">Log In</button>
            </div>
        </div>
    </form>

@stop