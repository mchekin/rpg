@extends("base")

@section("head")
    <title>{{ $character->getName() }} (Level: {{ $character->getLevelNumber() }})</title>
    @parent
@stop

@section("body")
    <div class="row">

        <!-- Left Side -->
        <div class="col-md-6">

            <h2 class="text-center">
                {{ $character->getName() }}
            </h2>

            <?php
            /** @var \App\Character $character */
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
                <div class="mx-5 my-3">
                    <form role="form" method="POST"
                          action="{{ URL::route('character.profile-picture.store', compact('character')) }}"
                          enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="form-control" required>
                            </div>
                            <div class="mx-2 input-group-append">
                                <button type="submit" class="btn btn-success">Upload <span class="fas fa-upload"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                @if($character->hasProfilePicture())
                    <div class="text-center">
                        <?php $profilePicture = $character->getProfilePicture() ?>
                        <form role="form" method="POST"
                              action="{{ URL::route('character.profile-picture.destroy', compact('character', 'profilePicture')) }}">
                            {{ method_field('DELETE') }}
                            {!! csrf_field() !!}
                            <div class="mx-2">
                                <button type="submit" class="btn btn-danger btn-sm">Delete Profile Picture <span
                                            class="fas fa-save"></span></button>
                            </div>
                        </form>
                    </div>
                @endif

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

            <div class="text-center my-5">
                <a class="btn btn-primary" href="{{ route('location.show', ['location' => $character->location]) }}">
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