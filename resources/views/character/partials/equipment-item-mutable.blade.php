@if($item && $item->isEquipped())
    <form role="form" method="POST" action="{{ route('inventory.item.un-equip', compact('item')) }}">
        {!! csrf_field() !!}
        <button type="submit" class="btn btn-link-thin">
            <img src="{{ asset($item->image_file_path) }}">
        </button>
    </form>
@endif