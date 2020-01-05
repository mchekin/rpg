@php
    /** @var \App\Modules\Character\Domain\Entities\Character $character */
    /** @var \App\Modules\Character\Domain\ValueObjects\Inventory $inventory */
    $inventory = $character->getInventory();
@endphp

<form role="form" method="POST">
    {!! csrf_field() !!}
    <div class="my-3 row table-dark align-items-center">
        @foreach(range(0, App\Modules\Character\Domain\ValueObjects\Inventory::NUMBER_OF_SLOTS) as $slotNumber)
            @php
                $item = $inventory->getItemForSlot($slotNumber);
                $isHighlighted = isset($item) && $item->isEquipped() ? "equipped" : "";
            @endphp

            <div class="inventory-item {{ $isHighlighted }}">
                @if($item)
                    @if($item->isEquipped())
                        <button type="submit" class="btn btn-link-thin"
                                formaction="{{ route('inventory.item.un-equip', ['item' => $item->getId()]) }}">
                            <img src="{{ asset($item->getImageFilePath()) }}">
                        </button>
                    @else
                        <button type="submit" class="btn btn-link-thin"
                                formaction="{{ route('inventory.item.equip', ['item' => $item->getId()]) }}">
                            <img src="{{ asset($item->getImageFilePath()) }}">
                        </button>
                    @endif
                @endif
            </div>

        @endforeach
    </div>
</form>
