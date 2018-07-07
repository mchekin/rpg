@extends("base")

@section("head")
    <title>{{ $battle->location->name }}</title>
    @parent
@stop

@section("body")

    <div class="col-lg-6">
        <h2>Participants</h2>
        <hr>

        <ul class="list-group">
            <li class="list-group-item">
                {{$battle->attacker->name}} (Attacker)
            </li>
            <li class="list-group-item">
                {{$battle->defender->name}} (Defender)
            </li>
            <li class="list-group-item">
                The winner is: {{$battle->victor->name}}
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
                    <h3>Round {{$index}}</h3>
                    <ul class="list-group">
                        @foreach($round->turns as $turn)
                            <li class="list-group-item">
                            @if($turn->damage)
                                {{ $turn->executor->name }} did {{ $turn->damage }} damage to {{ $turn->target->name }}
                            @else
                                {{ $turn->executor->name }} was unable to hit {{ $turn->target->name }}
                            @endif
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>

@stop