<?php

declare(strict_types=1);

namespace App;

use App\Type\Directory;

final class MoveMediaFiles
{
    private Finder $finder;
    private FileReader $reader;
    private Mover $mover;

    public function __construct(Finder $finder, FileReader $reader, Mover $mover)
    {
        $this->finder = $finder;
        $this->reader = $reader;
        $this->mover = $mover;
    }

    public function move(Directory $source, Directory $destination): void
    {
        error_log("Start moving files from '{$source->getPath()}' to {$destination->getPath()}'");
        foreach ($this->finder->find($source) as $file) {
            $newFilePath = $this->reader->getNewPath($destination, $file);
            error_log("Will move '{$file->getPath()}' to $newFilePath'");
            $this->mover->move($file, $newFilePath);
        }
    }
}
