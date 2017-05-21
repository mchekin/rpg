@extends("base")

@section("head")
    <title>{{ $character->name }} (Level: {{ $character->level->id }})</title>
    @parent
@stop

@section("body")
    <div class="row">

        <!-- Left Side -->
        <div class="col-md-4 col-md-offset-1 col-sm-6 hidden-xs">

            <h2>{{ $character->name }} ({{ $character->hit_points }} / {{ $character->total_hit_points }})</h2>

            <img class="img-race" src="{{ asset('images/' . $character->race->male_image) }}">
        </div>


        <!-- Right Side -->
        <div class="col-md-4 col-md-offset-1 col-sm-6">

                <table class="table table-responsive">
                    <caption>General</caption>
                    <tr>
                        <th>Race</th>
                        <td>{{ $character->race->name }}</td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>{{ $character->level->id }}</td>
                    </tr>
                    <tr>
                        <th>XP</th>
                        <td><progress max="{{ $character->level->next_level_xp_threshold }}" value="{{ $character->xp }}"></progress></td>
                    </tr>
                </table>

            <?php
                $hasFreePoints = ($character->isYou() && $character->available_attribute_points);
            ?>

            @if($hasFreePoints)
            <form role="form" method="POST" action="{{ URL::route('character.update', $character) }}" id="increment_attribute">
                {{ method_field('PUT') }}
                {!! csrf_field() !!}

                <input type="hidden" id="attribute_input" name="attribute" value="strength">
            @endif

                <table class="table table-responsive table-attributes">
                    <caption>Attributes</caption>
                    <tr>
                        <th>Strength</th>
                        <td>{{ $character->strength }}</td>
                        @component('components.increment_attribute_button', compact('hasFreePoints'))
                            {{ 'strength' }}
                        @endcomponent
                    </tr>
                    <tr>
                        <th>Agility</th>
                        <td>{{ $character->agility }}</td>
                        @component('components.increment_attribute_button', compact('hasFreePoints'))
                            {{ 'agility' }}
                        @endcomponent
                    </tr>
                    <tr>
                        <th>Constitution</th>
                        <td>{{ $character->constitution }}</td>
                        @component('components.increment_attribute_button', compact('hasFreePoints'))
                            {{ 'constitution' }}
                        @endcomponent
                    </tr>
                    <tr>
                        <th>Intelligence</th>
                        <td>{{ $character->intelligence }}</td>
                        @component('components.increment_attribute_button', compact('hasFreePoints'))
                            {{ 'intelligence' }}
                        @endcomponent
                    </tr>
                    <tr>
                        <th>Charisma</th>
                        <td>{{ $character->charisma }}</td>
                        @component('components.increment_attribute_button', compact('hasFreePoints'))
                            {{ 'charisma' }}
                        @endcomponent
                    </tr>

                    @if($hasFreePoints)
                        <tfoot>
                            <th>Available points</th>
                            <td class="circle">{{ $character->available_attribute_points }}</td>
                        </tfoot>
                    @endif

                </table>

            @if($hasFreePoints)
                </form>
            @endif

                <table class="table table-responsive">
                    <caption>Statistics</caption>
                    <tr>
                        <th>Reputation</th>
                        <td>{{ $character->reputation }}</td>
                    </tr>
                    <tr>
                        <th>Money</th>
                        <td>{{ $character->money }}</td>
                    </tr>
                    <tr>
                        <th>Battles Won</th>
                        <td>{{ $character->battles_won }}</td>
                    </tr>
                    <tr>
                        <th>Battles Lost</th>
                        <td>{{ $character->battles_lost }}</td>
                    </tr>
                </table>

            <a href="{{ route('location.show', ['location' => $character->location]) }}">
                Back to {{ $character->location->name }}
                <span class="fa fa-history"></span>
            </a>
        </div>
    </div>

@stop

@section("footer")
    @parent

    <script src="{{ asset('js/character-update.js') }}"></script>
@stop