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
                                @if($turn->damage)
                                    <li class="list-group-item {{ $index % 2 ? 'text-danger' : 'text-success'}}">
                                        {{ $turn->executor->name }} did {{ $turn->damage }} damage
                                        to {{ $turn->target->name }}
                                    </li>
                                @else
                                    <li class="list-group-item">
                                        {{ $turn->executor->name }} was unable to hit {{ $turn->target->name }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

@stop