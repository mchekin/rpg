@php
    use App\Modules\Equipment\Domain\ValueObjects\ItemType;
    /** @var \App\Character $character */
    /** @var \App\Item $item */
@endphp

<div class="mt-5 row table-dark align-items-center">
    <div class="col-3 equipment-item">
        Head gear
    </div>
    <div class="col-3 equipment-item">
        Armor
    </div>
    <div class="col-3 equipment-item">
        @php
            $item = $character->getMainHandItem()
        @endphp
        Main hand
        @if($item && $item->isEquipped())
            <img src="{{ asset($item->image_file_path) }}">
        @endif
    </div>
    <div class="col-3 equipment-item">
        Off hand
    </div>
</div>