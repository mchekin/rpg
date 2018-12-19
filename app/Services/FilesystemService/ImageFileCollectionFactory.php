<?php

namespace App\Services\FilesystemService;


class ImageFileCollectionFactory
{
    public function create(string $folderPath): ImageFileCollection
    {
        return new ImageFileCollection($folderPath);
    }
}