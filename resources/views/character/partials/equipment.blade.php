@php
    /** @var \App\Models\Character $character */
    /** @var \App\Models\Item $item */
@endphp

<div class="mt-5 row mx-1 table-dark align-items-center mx-1">
    <div class="col-3 equipment-item">
        @php
            $item = $character->getHeadGearItem()
        @endphp
        Head gear
        @include('character.partials.equipment-item', compact('item'))
    </div>
    <div class="col-3 equipment-item">
        @php
            $item = $character->getBodyArmorItem()
        @endphp
        Body armor
        @include('character.partials.equipment-item', compact('item'))
    </div>
    <div class="col-3 equipment-item">
        @php
            $item = $character->getMainHandItem()
        @endphp
        Main hand
        @include('character.partials.equipment-item', compact('item'))
    </div>
    <div class="col-3 equipment-item">
        @php
            $item = $character->getOffHandItem()
        @endphp
        Off hand
        @include('character.partials.equipment-item', compact('item'))
    </div>
</div>
