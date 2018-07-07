@extends("base")

@section("head")
    <title>{{ $location->name }}</title>
    @parent
@stop

@section("body")

    <div class="row">
        <div class="col-lg-6">
            <h2>{{ $location->name }}</h2>
            <hr>
            <p>{{ $location->description }}</p>
            <img class="img-fluid col-lg-8 offset-md-2" src="{{ asset('images/'.$location->image) }}">

            <div class="row">
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
        <div class="col-lg-6">
            <h2>Characters at this location:</h2>
            <hr>
            <ul class="list-group">
                <?php $icon = ''; ?>
                @foreach($location->characters as $character)
                    <?php
                    /** @var \App\Character $character * */
                    $class = 'list-group-item-warning';
                    $description = '(NPC)';

                    if (!$character->isNPC()) {
                        $description = $character->isYou() ? '(you)' : '';
                        $class = $character->isYou() ? 'active' : '';
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

                        @if(!$character->isYou())
                            <span class="pull-right">
                            @if(!$character->isNPC())
                                    <a href="{{ route('character.message.index', ['character' => $character]) }}"
                                       class="badge label-success">
                                <span class="fa fa-comment"></span>
                            </a>
                                @endif
                                <a href="{{ route('character.attack', ['character' => $character]) }}"
                                   class="badge label-danger">
                                <span class="fa fa-flash"></span>
                            </a>
                        </span>
                        @endif

                    </li>
                @endforeach
            </ul>
        </div>
    </div>

@stop