@php
    /** @var \App\Character $character */
    /** @var \App\Item $item */
    $items = $character->store->items;
@endphp

<form role="form" method="POST">
    {!! csrf_field() !!}
    <div class="my-3 row table-dark align-items-center">
        @foreach(range(0, App\Modules\Equipment\Domain\Inventory::NUMBER_OF_SLOTS) as $slotNumber)
            @php
                $item = $items->where('pivot.inventory_slot_number', $slotNumber)->first();
            @endphp

            <div class="inventory-item">
                @if($item)
                    <img src="{{ asset($item->image_file_path) }}">
                @endif
            </div>

        @endforeach
    </div>
</form>
