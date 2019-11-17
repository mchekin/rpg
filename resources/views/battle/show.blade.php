@extends("base")

@section("head")
    <title>{{ $battle->location->name }}</title>
    @parent
@stop

@section("body")

    <div class="row">

        <div class="col-lg-6">
            <h2>Participants</h2>
            <hr>

            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{ route('character.show', ['character' => $battle->getAttacker()]) }}">
                    {{$battle->attacker->name}} (Attacker)
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('character.show', ['character' => $battle->getDefender()]) }}">
                    {{$battle->defender->name}} (Defender)
                    </a>
                </li>
                <li class="list-group-item">
                    The winner is: {{$battle->victor->name}}
                </li>
                <li class="list-group-item">
                    The winner XP gained: {{$battle->victor_xp_gained}}
                </li>
            </ul>
            <hr>

            <a href="{{ route('index') }}">
                Back
                <span class="fa fa-history"></span>
            </a>
        </div>

        <div class="col-lg-6">
            <h2>Battle log:</h2>
            <hr>
            <ul class="list-group">
                @foreach($battle->rounds as $index => $round)
                    <li class="list-group-item">
                        <h3>Round {{$index + 1}}</h3>
                        <ul class="list-group">
                            @foreach($round->turns as $index => $turn)
                                @switch($turn->result_type)
                                    @case('miss')
                                        <li class="list-group-item">
                                            {{ $turn->executor->name }} was unable to hit {{ $turn->target->name }}.
                                        </li>
                                        @break

                                    @case('hit')
                                        <li class="list-group-item {{ $index % 2 ? 'text-danger' : 'text-success'}}">
                                            {{ $turn->executor->name }} did <b>{{ $turn->damageDone }}</b> damage
                                            to {{ $turn->target->name }}.
                                            @if($turn->damageAbsorbed)
                                                <br>
                                                <span class="text-warning">
                                                    <b>{{ $turn->damageAbsorbed }}</b> was damage absorbed by
                                                    {{ $turn->target->name }}'s armor.
                                                </span>
                                            @endif
                                        </li>
                                        @break

                                    @case('critical_hit')
                                        <li class="list-group-item {{ $index % 2 ? 'text-danger' : 'text-success'}}">
                                            {{ $turn->executor->name }} did <b>{{ $turn->damageDone }}</b> critical damage
                                            to {{ $turn->target->name }}.
                                        </li>
                                        @break

                                    @default
                                        Something went wrong ...
                                @endswitch
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

@stop