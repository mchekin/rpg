<?php

namespace App\Services\FilesystemService;

use Illuminate\Support\Collection;
use Intervention\Image\Image;

class ImageFiles extends Collection
{
    /**
     * @var string
     */
    private $folder;

    public function __construct(string $folder, $items = [])
    {
        parent::__construct($items);

        $this->folder = $folder;
    }

    public function addImageFile($key, Image $image): self
    {
        $this->offsetSet($key, $image);

        return $this;
    }

    public function getFullSizePath(): string
    {
        /** @var Image $image */
        $image = $this->get('full');

        $path = $image ? $this->folder . $image->basename : '';

        return $path;
    }

    public function getSmallSizePath(): string
    {
        /** @var Image $image */
        $image = $this->get('small');

        $path = $image ? $this->folder . $image->basename : '';

        return $path;
    }

    public function getIconSizePath(): string
    {
        /** @var Image $image */
        $image = $this->get('icon');

        $path = $image ? $this->folder . $image->basename : '';

        return $path;
    }
}