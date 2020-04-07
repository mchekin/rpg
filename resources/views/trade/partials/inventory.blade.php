@php
    /** @var \App\Character $character */
    /** @var \App\Item $item */
    $items = $character->inventory->items;
@endphp

<h5 class="text-center">
    {{ $character->getName() }}'s Inventory
</h5>

<form role="form" method="POST">
    {!! csrf_field() !!}
    <div class="my-3 row mx-1 table-dark align-items-center">
        @foreach(range(0, App\Modules\Equipment\Domain\Inventory::NUMBER_OF_SLOTS) as $slotNumber)
            @php
                $item = $items->where('pivot.inventory_slot_number', $slotNumber)->first();
                $isHighlighted = isset($item) && $item->isEquipped() ? 'equipped' : '';
            @endphp

            <div class="inventory-item {{ $isHighlighted }}">
                @if($item)
                    <button type="submit" class="btn btn-link-thin"
                            formaction="{{ route('inventory.item.move-to-store', compact('item')) }}">
                        <img src="{{ asset($item->image_file_path) }}">
                    </button>
                @endif
            </div>

        @endforeach
    </div>
</form>
