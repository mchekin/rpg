@extends("base")

@section("head")
    <title>Create Character</title>
    @parent
@stop

@section("body")

    <form role="form" class="col-md-4 col-md-offset-4" method="POST" action="{{ URL::route('character.store') }}">
        {!! csrf_field() !!}

        <h2>Please create your game character</h2>

        <div class="form-group">
            <div>
                <label for="name" class="sr-only">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name" required="" autofocus="">
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-primary btn-block">Create</button>
        </div>
    </form>

@stop