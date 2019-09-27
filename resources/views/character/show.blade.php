@extends("base")

@section("head")
    <title>{{ $character->getName() }} (Level: {{ $character->getLevelNumber() }})</title>
    @parent
@stop

@section("body")
    <div class="row">

        <div class="col-md-12">
            <h2 class="text-center">
                {{ $character->getName() }}
            </h2>
        </div>

        <!-- Left Side -->
        <div class="col-md-6">

            @include('character.partials.character-display', compact('character'))

            @include('character.partials.equipment', compact('character'))

            <div class="text-center mt-3">
                @if($character->isYou())
                    <a class="btn btn-sm btn-primary" href="{{ route('character.inventory.index', compact('character')) }}">
                        Manage Inventory
                        <span class="fas fa-table"></span>
                    </a>
                @else
                    <div class="w-100 my-3 px-5 text-center" role="group" aria-label="Character Actions">
                        @if(!$character->isNPC())
                            <a href="{{ route('character.message.index', ['character' => $character]) }}"
                               class="btn btn-sm btn-success">
                                message <span class="fa fa-comment"></span>
                            </a>
                        @endif

                        <a href="{{ route('character.attack', ['character' => $character]) }}"
                           class="btn btn-sm btn-danger">
                            attack <span class="fas fa-bolt"></span>
                        </a>
                    </div>
                @endif
            </div>

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