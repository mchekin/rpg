@extends("base")

@section("head")
    <title>{{ $character->name }} battles</title>
    @parent
@stop

@section("body")

    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <h2>{{ $character->name }}'s battles</h2>
            <ul class="list-group">
                @forelse ($battles as $battle)
                    <li class="list-group-item">
                        <a href="{{ route('battle.show', compact('battle')) }}">
                            @component('components.short_character_description', ['character' => $battle->getAttacker()])
                            @endcomponent
                            attacked
                            @component('components.short_character_description', ['character' => $battle->getDefender()])
                            @endcomponent
                        </a>
                    </li>
                @empty
                    @include('battle.partials.no-battles')
                @endforelse
                {{ $battles->links() }}
            </ul>
        </div>
    </div>

@stop