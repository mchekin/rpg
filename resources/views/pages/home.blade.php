@extends("base")

@section("head")
    <title>RPG</title>

    @parent

@stop

@section("body")
    <div class="content col-md-8 col-md-offset-2">
        <h2>Here is your character:</h2>
        <dl>
            <dt>Name</dt>
            <dd>{{ $character->name }}</dd>

            <dt>Race</dt>
            <dd>{{ $character->race->name }}</dd>

            <dt>Location</dt>
            <dd>{{ $character->location->name }}</dd>
        </dl>
    </div>
@stop