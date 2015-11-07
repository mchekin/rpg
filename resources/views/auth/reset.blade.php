@extends("base")

@section("head")
    <title>Reset password</title>
    @parent
@stop

@section("body")
    <form role="form" class="form-centered" method="POST" action="/password/reset">
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">

        <h2>Please reset your password</h2>
        <div>
            <label for="email" class="sr-only">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email address" required="" autofocus="">
        </div>

        <div>
            <label for="password" class="sr-only">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="">
        </div>

        <div>
            <label for="password_confirmation" class="sr-only">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required="">
        </div>

        <div>
            <button type="submit" class="btn btn-primary btn-block">
                Reset Password
            </button>
        </div>
    </form>
@stop