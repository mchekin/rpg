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
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <img class="img-fluid" src="{{ asset('images/'.$location->image) }}">
                </div>
            </div>

            @include('location.partials.navigator', compact('location'))

        </div>

        <div class="col-lg-6">
            <h2>Characters at this location:</h2>
            <hr>
            <ul class="list-group">
                @foreach($location->characters as $character)
                    <?php
                    /** @var \App\Contracts\Models\CharacterInterface $character * */
                    $class = 'list-group-item-warning';

                    if (!$character->isNPC()) {
                        $class = $character->isYou() ? 'active' : '';
                    }

                    ?>
                    <li class="list-group-item {{ $class }}">

                        @if($character->isNPC())
                            <span class="dot dot-npc">
                            </span>
                        @elseif($character->isOnline())
                            <span class="dot dot-online">
                            </span>
                        @else
                            <span class="dot dot-offline">
                            </span>
                        @endif

                        @if($character->gender == 'male')
                            <span class="badge badge-pill badge-lightskyblue">
                                <span class="fa fa-mars"></span>
                            </span>
                        @else
                            <span class="badge badge-pill badge-lightpink">
                                <span class="fa fa-venus"></span>
                            </span>
                        @endif

                        <a href="{{ route('character.show', ['character' => $character]) }}">
                            @component('components.short_character_description', compact('character'))
                            @endcomponent
                        </a>

                        @if(!$character->isYou())
                            <span class="float-right">

                                @if(!$character->isNPC())
                                    <a href="{{ route('character.message.index', ['character' => $character]) }}"
                                       class="badge badge-success">
                                        message <span class="fa fa-comment"></span>
                                    </a>
                                @endif

                                <a href="{{ route('character.attack', ['character' => $character]) }}"
                                   class="badge badge-danger">
                                    attack <span class="fas fa-bolt"></span>
                                </a>
                            </span>
                        @endif

                    </li>
                @endforeach
            </ul>
        </div>
    </div>

@stop