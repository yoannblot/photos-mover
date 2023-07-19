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
        return array_filter(
            array_map(static function (string $path): ?File {
                $file = new File($path);
                if (!$file->isImage()) {
                    return null;
                }

                return $file;
            }, glob($directory->getPath() . DIRECTORY_SEPARATOR . '*', GLOB_NOSORT)),
        );
    }
}
