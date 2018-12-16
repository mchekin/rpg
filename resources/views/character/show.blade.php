@extends("base")

@section("head")
    <title>{{ $character->name }} (Level: {{ $character->level->id }})</title>
    @parent
@stop

@section("body")
    <div class="row">

        <!-- Left Side -->
        <div class="col-md-6">

            <h2 class="text-center">
                {{ $character->name }}
            </h2>

            <?php
                /** @var \App\Contracts\Models\CharacterInterface $character */
                $hpPercent = ($character->getHitPoints() / $character->getTotalHitPoints()) * 100
            ?>

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

            <img class="w-50 mx-auto d-block" src="{{ asset($character->getProfilePictureFull()) }}">

            @if($character->isYou())
            <div>
                <form class="mx-5 my-3" role="form" method="POST" action="{{ URL::route('image.store') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="mx-2 input-group-append">
                            <button type="submit" class="btn btn-success">Upload New</button>
                        </div>
                    </div>
                </form>
            </div>
            @endif

            <div class="text-center my-5">
                <a class="btn btn-primary" href="{{ route('location.show', ['location' => $character->location]) }}">
                    To {{ $character->getLocationName() }}
                    <span class="fa fa-history"></span>
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
                    <td>{{ $character->getLevelNumber() }}</td>
                </tr>
                <tr>
                    <th scope="row">XP</th>
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
                    <th scope="row">Battles Won</th>
                    <td>{{ $character->battles_won }}</td>
                </tr>
                <tr>
                    <th scope="row">Battles Lost</th>
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