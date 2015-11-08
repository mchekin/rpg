@extends("base")

@section("head")
    <title>Send password reset link</title>
    @parent
@stop

@section("body")

    @include('partials.status')

    <form role="form" class="form-centered" method="POST" action="/password/email">
        {!! csrf_field() !!}

        <h2>Please enter your email address</h2>

        <div class="form-group">
            <div>
                <label for="email" class="sr-only">Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email address" required="" autofocus="">
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-primary btn-block">
                Send Password Reset Link
            </button>
        </div>
    </form>
@stop