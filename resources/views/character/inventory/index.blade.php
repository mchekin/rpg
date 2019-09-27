@extends("base")

@section("head")
    <title>{{ $character->getName() }} (Level: {{ $character->getLevelNumber() }})</title>
    @parent
@stop

@section("body")
    <div class="row">

        <!-- Left Side -->
        <div class="col-md-6">

            @include('character.partials.equipment', compact('character'))

            @include('character.partials.inventory', compact('character'))

        </div>


        <!-- Right Side -->
        <div class="col-md-6">

            @include('character.partials.general', compact('character', 'level'))

            @include('character.partials.attributes', compact('character'))

            @include('character.partials.statistics', compact('character'))

        </div>
    </div>

@stop

@section("footer")
    @parent

    <script src="{{ asset('js/character-update.js') }}"></script>
@stop