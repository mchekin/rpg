@if($item && $item->isEquipped())
    <button type="submit" class="btn btn-link-thin"
            formaction="{{ route('inventory.item.un-equip', compact('item')) }}">
        <img src="{{ asset($item->image_file_path) }}">
    </button>
@endif