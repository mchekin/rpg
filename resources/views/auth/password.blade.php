@extends("base")

@section("head")
    <title>Send password reset link</title>
    @parent
@stop

@section("body")

    <form method="POST" action="/password/email">
        {!! csrf_field() !!}

        @include('partials.errors')

        <div>
            Email
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            <button type="submit" class="btn btn-primary">
                Send Password Reset Link
            </button>
        </div>
    </form>
@stop