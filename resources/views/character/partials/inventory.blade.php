<?php
$inventorySlots = range(0, App\Modules\Character\Domain\ValueObjects\Inventory::NUMBER_OF_SLOTS);
/** @var \Illuminate\Support\Collection $items */
/** @var \App\Character $character */
$items = $character->items;
?>
<div class="my-3 row table-dark align-items-center">
    @foreach($inventorySlots as $slotNumber)
        <div class="inventory-item">
            @if($item = $items->where('inventory_slot_number', $slotNumber)->first())
                <img src="{{ asset($item->image_file_path) }}">
            @endif
        </div>
    @endforeach
</div>