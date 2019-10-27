@if($item && $item->isEquipped())
    <img src="{{ asset($item->image_file_path) }}">
@endif