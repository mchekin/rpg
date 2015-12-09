@extends("base")

@section("head")
    <title>RPG</title>

    @parent

@stop

@section("body")
    <div class="content col-md-8 col-md-offset-2">
        <h2>Here is your character:</h2>
        <hr>
        <dl class="dl-horizontal">

            <dt>Name</dt>
            <dd>{{ $character->name }}</dd>

            <dt>Gender</dt>
            <dd>{{ $character->gender }}</dd>

            <dt>XP</dt>
            <dd>{{ $character->xp }}</dd>

            <dt>Level</dt>
            <dd>{{ $character->level }}</dd>

            <dt>Gold</dt>
            <dd>{{ $character->money }}</dd>

            <dt>Race</dt>
            <dd>{{ $character->race->name }}</dd>

            <dt>Location</dt>
            <dd>{{ $character->location->name }}</dd>

        </dl>
        <hr>
        <dl class="dl-horizontal">

            <dt>Strength</dt>
            <dd>{{ $character->strength }}</dd>

            <dt>Agility</dt>
            <dd>{{ $character->agility }}</dd>

            <dt>Constitution</dt>
            <dd>{{ $character->constitution }}</dd>

            <dt>Intelligence</dt>
            <dd>{{ $character->intelligence }}</dd>

            <dt>Charisma</dt>
            <dd>{{ $character->charisma }}</dd>
        </dl>
        <hr>
    </div>
@stop