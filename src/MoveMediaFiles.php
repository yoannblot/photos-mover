<?php

declare(strict_types=1);

namespace App;

final class MoveMediaFiles
{
    private const IMAGE_EXTENSIONS = ['jpg', 'gif', 'png', 'jpeg'];

    private Finder $finder;
    private ImageReader $reader;
    private Mover $mover;

    public function __construct(Finder $finder, ImageReader $reader, Mover $mover)
    {
        $this->finder = $finder;
        $this->reader = $reader;
        $this->mover = $mover;
    }

    public function move(string $sourceDirectory, string $destinationDirectory): void
    {
        error_log("Start moving files from '$sourceDirectory' to $destinationDirectory'");
        foreach ($this->finder->find($sourceDirectory, self::IMAGE_EXTENSIONS) as $image) {
            $newFilePath = $this->reader->getNewPath($destinationDirectory, $image, 'Y/m/d');
            error_log("Will move '{$image->getPath()}' to $newFilePath'");
            $this->mover->move($image, $newFilePath);
        }
    }
}
