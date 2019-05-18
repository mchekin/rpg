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

            <dt>{{ _t('XP') }}</dt>
            <dd>{{ $character->xp }}</dd>

            <dt>{{ _t('Level') }}</dt>
            <dd>{{ $character->level }}</dd>

            <dt>{{ _t('Reputation') }}</dt>
            <dd>{{ $character->reputation }}</dd>

            <dt>{{ _t('Gold') }}</dt>
            <dd>{{ $character->money }}</dd>

            <dt>{{ _t('Location') }}</dt>
            <dd>{{ $character->location->name }}</dd>

        </dl>
        <hr>
        <dl class="dl-horizontal">

            <dt>{{ _t('Strength') }}</dt>
            <dd>{{ $character->strength }}</dd>

            <dt>{{ _t('Agility') }}</dt>
            <dd>{{ $character->agility }}</dd>

            <dt>{{ _t('Constitution') }}</dt>
            <dd>{{ $character->constitution }}</dd>

            <dt>{{ _t('Intelligence') }}</dt>
            <dd>{{ $character->intelligence }}</dd>

            <dt>{{ _t('Charisma') }}</dt>
            <dd>{{ $character->charisma }}</dd>
        </dl>
        <hr>
    </div>
@stop