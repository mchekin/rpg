@extends("base")

@section("head")
    <title>{{ $character->getName() }} (Level: {{ $character->getLevelNumber() }})</title>
    @parent
@stop

@section("body")
    <div class="row">



    <?php
    /** @var \App\Character $character */
    /** @var \App\Modules\Level\Domain\Entities\Level $level */
    $hpPercent = ($character->getHitPoints() / $character->getTotalHitPoints()) * 100;
    $levelProgress = $level->getProgress($character->xp);
    ?>

        <!-- Left Side -->
        <div class="col-md-6">

            <h2 class="text-center">
                {{ $character->getName() }}
            </h2>

            <div class="progress mx-5 my-3">
                <div class="progress-bar bg-danger"
                     role="progressbar"
                     style="width: {{ $hpPercent }}%"
                     aria-valuenow="{{ $hpPercent }}"
                     aria-valuemin="0"
                     aria-valuemax="100">
                    {{ $character->getHitPoints() }} / {{ $character->getTotalHitPoints() }}
                </div>
            </div>

            @include('character.partials.character-display', compact('character'))

            <h3 class="mt-5 text-center"> Equipment </h3>
            <div class="my-3 row table-dark align-items-center">
                <div class="col-md-3 equipment-item">
                    Head gear
                </div>
                <div class="col-md-3 equipment-item">
                    Armor
                </div>
                <div class="col-md-3 equipment-item">
                    Main hand
                </div>
                <div class="col-md-3 equipment-item">
                    Off hand
                </div>
            </div>

            <div class="text-center my-5">
                <a class="btn btn-primary" href="{{ route('location.show', ['location' => $character->getLocationId()]) }}">
                    To {{ $character->getLocationName() }}
                    <span class="fas fa-walking"></span>
                </a>
            </div>

        </div>


        <!-- Right Side -->
        <div class="col-md-6">

            <table class="table">
                <caption class="caption-top">General</caption>
                <tr>
                    <th scope="row">Race</th>
                    <td>{{ $character->getRaceName() }}</td>
                </tr>
                <tr>
                    <th scope="row">Gender</th>
                    <td>{{ $character->gender }}</td>
                </tr>
                <tr>
                    <th scope="row">Level</th>
                    <td>{{ $level->getId() }}</td>
                </tr>
                <tr>
                    <th scope="row">XP</th>
                    <td>
                        <div class="progress">
                            <div class="progress-bar"
                                 role="progressbar"
                                 style="width: {{ $levelProgress }}%"
                                 aria-valuenow="{{ $levelProgress }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                                {{ $character->xp }} / {{ $level->getNextXpThreshold() }}
                            </div>
                        </div>
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

                    <table class="table">
                        <caption class="caption-top">Attributes</caption>
                        <tr>
                            <th scope="row">Strength</th>
                            <td>{{ $character->strength }}</td>
                            @component('components.increment_attribute_button', compact('hasFreePoints'))
                                {{ 'strength' }}
                            @endcomponent
                        </tr>
                        <tr>
                            <th scope="row">Agility</th>
                            <td>{{ $character->agility }}</td>
                            @component('components.increment_attribute_button', compact('hasFreePoints'))
                                {{ 'agility' }}
                            @endcomponent
                        </tr>
                        <tr>
                            <th scope="row">Constitution</th>
                            <td>{{ $character->constitution }}</td>
                            @component('components.increment_attribute_button', compact('hasFreePoints'))
                                {{ 'constitution' }}
                            @endcomponent
                        </tr>
                        <tr>
                            <th scope="row">Intelligence</th>
                            <td>{{ $character->intelligence }}</td>
                            @component('components.increment_attribute_button', compact('hasFreePoints'))
                                {{ 'intelligence' }}
                            @endcomponent
                        </tr>
                        <tr>
                            <th scope="row">Charisma</th>
                            <td>{{ $character->charisma }}</td>
                            @component('components.increment_attribute_button', compact('hasFreePoints'))
                                {{ 'charisma' }}
                            @endcomponent
                        </tr>

                        @if($hasFreePoints)
                            <tfoot>
                            <tr>
                                <th scope="row">Available points</th>
                                <td class="circle">{{ $character->available_attribute_points }}</td>
                            </tr>
                            </tfoot>
                        @endif

                    </table>

                    @if($hasFreePoints)
                </form>
            @endif

            <table class="table">
                <caption class="caption-top">Statistics</caption>
                <tr>
                    <th scope="row">Reputation</th>
                    <td>{{ $character->reputation }}</td>
                </tr>
                <tr>
                    <th scope="row">Money</th>
                    <td>{{ $character->money }}</td>
                </tr>
                <tr>
                    <th scope="row">
                        <a href="{{ URL::route('character.battle.index', compact('character')) }}">
                            Battles Won
                        </a>
                    </th>
                    <td>{{ $character->battles_won }}</td>
                </tr>
                <tr>
                    <th scope="row">
                        <a href="{{ URL::route('character.battle.index', compact('character')) }}">
                            Battles Lost
                        </a></th>
                    <td>{{ $character->battles_lost }}</td>
                </tr>
            </table>

        </div>
    </div>

@stop

@section("footer")
    @parent

    <script src="{{ asset('js/character-update.js') }}"></script>
@stop