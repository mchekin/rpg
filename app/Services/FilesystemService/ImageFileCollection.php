<?php

namespace App\Services\FilesystemService;

use Illuminate\Support\Collection;
use Intervention\Image\Image;

class ImageFileCollection extends Collection
{
    /**
     * @var string
     */
    private $folderPath;

    public function __construct(string $folderPath, $items = [])
    {
        parent::__construct($items);

        $this->folderPath = $folderPath;
    }

    public function add($key, Image $image): self
    {
        $this->offsetSet($key, $image);

        return $this;
    }

    public function getFullSizePath(): string
    {
        /** @var Image $image */
        $image = $this->get('full');

        $path = $image ? $this->folderPath . $image->basename : '';

        return $path;
    }

    public function getSmallSizePath(): string
    {
        /** @var Image $image */
        $image = $this->get('small');

        $path = $image ? $this->folderPath . $image->basename : '';

        return $path;
    }

    public function getIconSizePath(): string
    {
        /** @var Image $image */
        $image = $this->get('icon');

        $path = $image ? $this->folderPath . $image->basename : '';

        return $path;
    }
}