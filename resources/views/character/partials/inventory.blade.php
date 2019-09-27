<?php
       $inventorySlots = array_fill(0, App\Modules\Character\Domain\ValueObjects\Inventory::NUMBER_OF_SLOTS,0);
       /** @var \Illuminate\Support\Collection $items */
       /** @var \App\Character $character */
       $items = $character->items;
?>
<h3 class="mt-5 text-center"> Inventory </h3>
<div class="my-3 row table-dark align-items-center">

    @foreach($inventorySlots as $slotNumber)
        <div class="col-2 inventory-item">
        @if($items->where('inventory_slot_number', $slotNumber)->first())
                <img style = "display: none;" src="{{ asset($items->where('inventory_slot_number', $slotNumber)->first()->image_file_path) }}">
        @endif
        </div>
    @endforeach

</div>