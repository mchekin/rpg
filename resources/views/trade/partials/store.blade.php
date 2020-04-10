@php
    /** @var \App\Character $character */
    /** @var \App\Item $item */
    $items = $character->store->items;
@endphp

<h5 class="text-center">
    {{ $character->getName() }}'s Store
</h5>

<form role="form" method="POST">
    {!! csrf_field() !!}
    <div class="my-3 row mx-1 table-dark align-items-center">
        @foreach(range(0, App\Modules\Trade\Domain\Store::NUMBER_OF_SLOTS) as $slotNumber)
            @php
                $item = $items->where('pivot.inventory_slot_number', $slotNumber)->first();
            @endphp

            <div class="inventory-item">
                @if($item)
                    <button type="submit" class="btn btn-link-thin"
                            formaction="{{ route('store.item.move-to-inventory', compact('item')) }}">
                        <img src="{{ asset($item->image_file_path) }}">
                    </button>
                @endif
            </div>

        @endforeach
    </div>
</form>
