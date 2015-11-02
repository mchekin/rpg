@extends("base")

@section("head")
    <title>Send password reset link</title>
    @parent
@stop

@section("body")

    <form method="POST" action="/password/email">
        {!! csrf_field() !!}

        @if (count($errors) > 0)
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

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