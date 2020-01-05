<form role="form" method="POST" class="w-100">
    {!! csrf_field() !!}
    <div class="text-center mt-3">
        @if($character->isYou(Auth::id()))
            <a class="btn btn-sm btn-primary" href="{{ route('inventory.index') }}">
                Manage Inventory
                <span class="fas fa-table"></span>
            </a>
        @else
            <div class="w-100 my-3 px-5 text-center" role="group" aria-label="Character Actions">
                @if(!$character->isNPC())
                    <a href="{{ route('character.message.index', ['character' => $character]) }}"
                       class="btn btn-sm btn-success">
                        message <span class="fa fa-comment"></span>
                    </a>
                @endif

                <button formaction="{{ route('character.attack', ['character' => $character]) }}"
                        class="btn btn-sm btn-danger">
                    attack <span class="fas fa-bolt"></span>
                </button>
            </div>
        @endif
    </div>
</form>
