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
            <form role="form" method="POST" action="{{ URL::route('character.update', $character) }}">
                {!! csrf_field() !!}


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
                        <td><progress max="{{ $character->level->nextLevel()->xp_threshold }}" value="{{ $character->xp }}"></progress></td>
                    </tr>
                </table>

                <?php
                    $incrementingCaption = ($character->isYou() && $character->available_attribute_points)
                            ? "<td class=\"circle\">+{$character->available_attribute_points}</td>"
                            : "";
                ?>

                <table class="table table-responsive table-attributes">
                    <caption>Attributes</caption>
                    <tr>
                        <th>Strength</th>
                        <td>{{ $character->strength }}</td>
                        {!! $incrementingCaption !!}
                    </tr>
                    <tr>
                        <th>Agility</th>
                        <td>{{ $character->agility }}</td>
                        {!! $incrementingCaption !!}
                    </tr>
                    <tr>
                        <th>Constitution</th>
                        <td>{{ $character->constitution }}</td>
                        {!! $incrementingCaption !!}
                    </tr>
                    <tr>
                        <th>Intelligence</th>
                        <td>{{ $character->intelligence }}</td>
                        {!! $incrementingCaption !!}
                    </tr>
                    <tr>
                        <th>Charisma</th>
                        <td>{{ $character->charisma }}</td>
                        {!! $incrementingCaption !!}
                    </tr>

                    @if($character->isYou() && $character->available_attribute_points)
                        <tfoot>
                            <th>Available points</th>
                            <td class="circle">{{ $character->available_attribute_points }}</td>
                        </tfoot>
                    @endif

                </table>

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

            </form>

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