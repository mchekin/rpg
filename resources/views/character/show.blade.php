@extends("base")

@section("head")
    <title>{{ $character->name }} (Level: {{ $character->level->id }})</title>
    @parent
@stop

@section("body")
    <div class="row">

        <!-- Left Side -->
        <div class="col-lg-6">

            <h2>{{ $character->name }} ({{ $character->hit_points }} / {{ $character->total_hit_points }})</h2>

            <img class="img-race" src="{{ asset('images/' . $character->getImage()) }}">
        </div>


        <!-- Right Side -->
        <div class="col-lg-6">
            <table class="table table-responsive">
                <caption>General</caption>
                <tr>
                    <th>Race</th>
                    <td>{{ $character->getRaceName() }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ $character->gender }}</td>
                </tr>
                <tr>
                    <th>Level</th>
                    <td>{{ $character->getLevelNumber() }}</td>
                </tr>
                <tr>
                    <th>XP</th>
                    <td>
                        <progress value="{{ $character->xp }}" max="{{ $character->getNextLevelXp() }}"></progress>
                    </td>
                </tr>
            </table>

            <?php
            $hasFreePoints = ($character->isYou() && $character->available_attribute_points);
            ?>

            @if($hasFreePoints)
                <form role="form" method="POST" action="{{ URL::route('character.update', $character) }}"
                      id="increment_attribute">
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
                            <tr>
                                <th>Available points</th>
                                <td class="circle">{{ $character->available_attribute_points }}</td>
                            </tr>
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
                Back to {{ $character->getLocationName() }}
                <span class="fa fa-history"></span>
            </a>
        </div>
    </div>

@stop

@section("footer")
    @parent

    <script src="{{ asset('js/character-update.js') }}"></script>
@stop