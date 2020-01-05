@if($item && $item->isEquipped())
    <img src="{{ asset($item->getImageFilePath()) }}">
@endif
