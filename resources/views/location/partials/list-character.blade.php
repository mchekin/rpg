<?php
/** @var \App\Models\Character $character * */
$class = 'list-group-item-warning';

if (!$character->isNPC()) {
    $class = $character->isYou() ? 'active' : '';
}

?>

<li class="list-group-item {{ $class }}">

    @if($character->isNPC())
        <span class="dot dot-npc">
        </span>
    @elseif($character->isOnline())
        <span class="dot dot-online">
        </span>
    @else
        <span class="dot dot-offline">
        </span>
    @endif

    @if($character->gender === 'male')
        <span class="badge badge-pill badge-lightskyblue">
            <span class="fa fa-mars"></span>
        </span>
    @else
        <span class="badge badge-pill badge-lightpink">
            <span class="fa fa-venus"></span>
        </span>
    @endif

    <a href="{{ route('character.show', ['character' => $character]) }}">
        @component('components.short_character_description', compact('character'))
        @endcomponent
    </a>

    @if(!$character->isYou())
        <span class="float-right">
            @if(!$character->isNPC())
                <a href="{{ route('character.message.index', ['character' => $character]) }}"
                   class="btn btn-xxs btn-success">
                    message <span class="fa fa-comment"></span>
                </a>
            @endif

            @if($character->isMerchant())
                <a href="{{ route('character.store.index', ['character' => $character]) }}"
                   class="btn btn-xxs btn-info">
                    trade <span class="fas fa-money-bill"></span>
                </a>
            @endif

            <button formaction="{{ route('character.attack', ['character' => $character]) }}"
                    class="btn btn-xxs btn-danger">
                attack <span class="fas fa-bolt"></span>
            </button>

        </span>
    @endif

</li>
