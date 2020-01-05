@if($item && $item->isEquipped())
    <button type="submit" class="btn btn-link-thin"
            formaction="{{ route('inventory.item.un-equip', ['item' => $item->getId()]) }}">
        <img src="{{ asset($item->getImageFilePath()) }}">
    </button>
@endif
