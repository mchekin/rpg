@extends("base")

@section("head")
    <title>{{ $location->name }}</title>
    @parent
@stop

@section("body")

    <div class="col-md-6">
        <h2>{{ $location->name }}</h2>
        <hr>
        <p>{{ $location->description }}</p>
        <img class="img-responsive col-md-8 col-md-offset-2" src="{{ asset('images/'.$location->image) }}">

        <div class="col-md-12">
            <ul class="list-inline">
                @if(!is_null($adjacent = $location->adjacent('north')))
                    <li>
                        <a href="{{ route('character.move', ['character' => Auth::user()->character, 'location' => $adjacent]) }}">
                            {{ $adjacent->name }}
                            <span class="glyphicon glyphicon-arrow-up"></span>
                        </a>
                    </li>
                @endif
                @if(!is_null($adjacent = $location->adjacent('east')))
                    <li>
                        <a href="{{ route('character.move', ['character' => Auth::user()->character, 'location' => $adjacent]) }}">
                            {{ $adjacent->name }}
                            <span class="glyphicon glyphicon-arrow-right"></span>
                        </a>
                    </li>
                @endif
                @if(!is_null($adjacent = $location->adjacent('south')))
                    <li>
                        <a href="{{ route('character.move', ['character' => Auth::user()->character, 'location' => $adjacent]) }}">
                            {{ $adjacent->name }}
                            <span class="glyphicon glyphicon-arrow-down"></span>
                        </a>
                    </li>
                @endif
                @if(!is_null($adjacent = $location->adjacent('west')))
                    <li>
                        <a href="{{ route('character.move', ['character' => Auth::user()->character, 'location' => $adjacent]) }}">
                            {{ $adjacent->name }}
                            <span class="glyphicon glyphicon-arrow-left"></span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="col-md-6">
        <h2>Characters at this location:</h2>
        <hr>
        <div class="list-group">
            @foreach($location->characters as $character)
                <a href="#" class="list-group-item">
                    {{ $character->name }} ({{ $character->race->name }} {{ $character->gender }}){{ is_null($character->user) ? '(NPC)' : '' }}
                </a>
            @endforeach
        </div>
    </div>

@stop