<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Type\Directory;
use App\Domain\Type\File;

final class Finder
{
    /**
     * @return File[]
     */
    public function find(Directory $directory): array
    {
        return array_values(
            array_filter(
                array_map(static function (string $path): ?File {
                    $file = new File($path);
                    if (!$file->isImage() && !$file->isVideo()) {
                        return null;
                    }

                    return $file;
                }, glob($directory->getPath() . '*', GLOB_NOSORT)),
            )
        );
    }
}
