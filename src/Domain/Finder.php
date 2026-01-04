<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Type\Directory;
use App\Domain\Type\File;
use Generator;

final class Finder
{
    /**
     * @return Generator<File>
     */
    public function find(Directory $directory): Generator
    {
        $all = glob($directory->getPath() . '*', GLOB_NOSORT);
        if ($all === false)
        {
            return;
        }

        foreach ($all as $path)
        {
            $file = new File($path);
            if ($file->isImage() || $file->isVideo())
            {
                yield $file;
            }
        }
    }
}
