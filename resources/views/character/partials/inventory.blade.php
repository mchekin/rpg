@php
    /** @var \App\Character $character */
    /** @var \App\Item $item */
    $items = $character->inventory->items;
@endphp

<form role="form" method="POST">
    {!! csrf_field() !!}
    <div class="my-3 row table-dark align-items-center">
        @foreach(range(0, App\Modules\Equipment\Domain\Inventory::NUMBER_OF_SLOTS) as $slotNumber)
            @php
                $item = $items->where('pivot.inventory_slot_number', $slotNumber)->first();
                $isHighlighted = isset($item) && $item->isEquipped() ? 'equipped' : '';
            @endphp

            <div class="inventory-item {{ $isHighlighted }}">
                @if($item)
                    @if($item->isEquipped())
                        <button type="submit" class="btn btn-link-thin"
                                formaction="{{ route('inventory.item.un-equip', compact('item')) }}">
                            <img src="{{ asset($item->image_file_path) }}">
                        </button>
                    @else
                        <button type="submit" class="btn btn-link-thin"
                                formaction="{{ route('inventory.item.equip', compact('item')) }}">
                            <img src="{{ asset($item->image_file_path) }}">
                        </button>
                    @endif
                @endif
            </div>

        @endforeach
    </div>
</form>
