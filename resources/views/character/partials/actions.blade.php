<form role="form" method="POST" class="mx-1">
    {!! csrf_field() !!}
    <div class="text-center mt-3">
        @if($character->isYou())
            <a class="btn btn-sm btn-primary" href="{{ route('inventory.index') }}">
                Inventory
                <span class="fas fa-shopping-bag"></span>
            </a>
            <a class="btn btn-sm btn-primary" href="{{ route('store.index') }}">
                Store
                <span class="fas fa-shopping-bag"></span>
            </a>
        @else
            <div class="mx-1 my-3 px-5 text-center" role="group" aria-label="Character Actions">
                @if($character->isPlayerCharacter())
                    <a href="{{ route('character.message.index', ['character' => $character]) }}"
                       class="btn btn-sm btn-success">
                        message <span class="fa fa-comment"></span>
                    </a>
                @endif

                <button formaction="{{ route('character.attack', ['character' => $character]) }}"
                        class="btn btn-sm btn-danger">
                    attack <span class="fas fa-bolt"></span>
                </button>

                <a href="{{ route('character.store.index', ['character' => $character]) }}"
                   class="btn btn-sm btn-info">
                    trade <span class="fas fa-money-bill"></span>
                </a>
            </div>
        @endif
    </div>
</form>
