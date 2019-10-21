@php
    /** @var \App\Character $character */
    /** @var \App\Item $item */
@endphp

<div class="mt-5 row table-dark align-items-center">
    <div class="col-3 equipment-item">
        @php
            $item = $character->getHeadGearItem()
        @endphp
        Head gear
        @include('character.partials.equipment-item-mutable', compact('item'))
    </div>
    <div class="col-3 equipment-item">
        @php
            $item = $character->getBodyArmorItem()
        @endphp
        Body armor
        @include('character.partials.equipment-item-mutable', compact('item'))
    </div>
    <div class="col-3 equipment-item">
        @php
            $item = $character->getMainHandItem()
        @endphp
        Main hand
        @include('character.partials.equipment-item-mutable', compact('item'))
    </div>
    <div class="col-3 equipment-item">
        @php
            $item = $character->getOffHandItem()
        @endphp
        Off hand
        @include('character.partials.equipment-item-mutable', compact('item'))
    </div>
</div>