@extends("base")

@section("head")
    <title>{{ env('APP_NAME') }}</title>

    @parent

@stop

@section("body")
    <div class="col-lg-6">
        <h2>{{ $character->name }} ({{ $character->race->name }} {{ $character->gender }}) </h2>
        <hr>
        <dl class="dl-horizontal">

            <dt>XP</dt>
            <dd>{{ $character->xp }}</dd>

            <dt>Level</dt>
            <dd>{{ $character->level }}</dd>

            <dt>Reputation</dt>
            <dd>{{ $character->reputation }}</dd>

            <dt>Gold</dt>
            <dd>{{ $character->money }}</dd>

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