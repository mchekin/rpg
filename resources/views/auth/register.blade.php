@extends("base")

@section("head")
    <title>Register</title>
    @parent
@stop

@section("body")

    <form role="form" class="form-centered" method="POST" action="/auth/register">
        {!! csrf_field() !!}

        <h2>Please register</h2>

        <div class="form-group">
            <div>
                <label for="name" class="sr-only">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name" required="" autofocus="">
            </div>
        </div>

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

        <div class="form-group">
            <div>
                <label for="password_confirmation" class="sr-only">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required="">
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
    </form>

@stop