@extends("base")

@section("head")
    <title>{{ $character->name }} battles</title>
    @parent
@stop

@section("body")

    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h2 class="text-center">{{ $character->name }}'s battles</h2>
            <ul class="list-group">
                @forelse ($battles as $battle)
                    <li class="list-group-item text-center">
                        <a class="d-block w-100 h-100" href="{{ route('battle.show', compact('battle')) }}">
                            <div class="row">
                                <div class="col-md-2">
                                    <small>{{ $battle->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="col-md-8">
                                    @component('components.short_character_description', ['character' => $battle->getAttacker()])
                                    @endcomponent
                                    <span class="fas fa-long-arrow-alt-right text-danger"></span>
                                    @component('components.short_character_description', ['character' => $battle->getDefender()])
                                    @endcomponent
                                </div>
                                <div class="col-md-2">
                                    @if($battle->isTheVictor($character))
                                        <span class="fas fa-check text-success"> victory</span>
                                    @else
                                        <span class="fas fa-times text-danger"> loss</span>
                                    @endif
                                </div>
                            </div>
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