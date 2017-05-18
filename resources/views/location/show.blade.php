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
            <ul class="list-unstyled">
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
        <ul class="list-group">
            <?php $icon = ''; ?>
            @foreach($location->characters as $character)
                <?php
                    $class = 'list-group-item-warning';
                    $description = '(NPC)';
                    if (!$character->isNPC() ) {
                        $description = ($character->user->id == Auth::user()->id) ? '(you)' : '';
                        $class = ($character->user->id == Auth::user()->id) ? 'active' : '';
                    }
                ?>
                <li href="#" class="list-group-item {{ $class }}">
                    @if($character->gender == 'male')
                        <span class="fa fa-mars"></span>
                    @else
                        <span class="fa fa-venus"></span>
                    @endif

                    <a href="{{ route('character.show', ['character' => $character]) }}">
                        @component('components.short_character_description', compact('character'))
                            {{ $description }}
                        @endcomponent
                    </a>

                    <a href="{{ route('character.attack', ['character' => $character]) }}" class="pull-right">
                        <span class="fa fa-flash"></span> attack
                    </a>

                </li>
            @endforeach
        </ul>
    </div>

@stop