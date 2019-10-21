@php
    /** @var \App\Character $character */
    /** @var \App\Item $item */
    $items = $character->items;
@endphp

<div class="my-3 row table-dark align-items-center">
    @foreach(range(0, App\Modules\Character\Domain\ValueObjects\Inventory::NUMBER_OF_SLOTS) as $slotNumber)
        @php
            $item = $items->where('inventory_slot_number', $slotNumber)->first();
            $isHighlighted = isset($item) && $item->isEquipped() ? "equipped" : "";
        @endphp

        <div class="inventory-item {{ $isHighlighted }}">
            @if($item)
                @if($item->isEquipped())
                    <form class="w-100 h-100" role="form" method="POST"
                          action="{{ route('inventory.item.un-equip', compact('item')) }}">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-link-thin">
                            <img src="{{ asset($item->image_file_path) }}">
                        </button>
                    </form>
                @else
                    <form class="w-100 h-100" role="form" method="POST"
                          action="{{ route('inventory.item.equip', compact('item')) }}">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-link-thin">
                            <img src="{{ asset($item->image_file_path) }}">
                        </button>
                    </form>
                @endif
            @endif
        </div>

    @endforeach
</div>