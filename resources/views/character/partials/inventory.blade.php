@php
/** @var \App\Character $character */
            /** @var \App\Item $item */
$items = $character->items;
@endphp

<div class="my-3 row table-dark align-items-center">
    @foreach(range(0, App\Modules\Character\Domain\ValueObjects\Inventory::NUMBER_OF_SLOTS) as $slotNumber)
        @php
            $item = $items->where('inventory_slot_number', $slotNumber)->first();
            $isHighlighted = isset($item) && $item->isEquipped() ? "border-info" : "";
        @endphp

        <div class="inventory-item {{ $isHighlighted }}">
            @if($item)
                <img src="{{ asset($item->image_file_path) }}">
            @endif
        </div>

    @endforeach
</div>