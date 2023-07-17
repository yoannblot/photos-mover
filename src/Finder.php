<?php

declare(strict_types=1);

namespace App;

use App\Type\Directory;
use App\Type\File;

final class Finder
{
    /**
     * @return File[]
     */
    public function find(Directory $directory, array $extensions): array
    {
        return array_filter(
            array_map(static function (string $path) use ($extensions): ?File {
                $file = new File($path);
                if (!in_array($file->getExtension(), $extensions, true)) {
                    return null;
                }

                return $file;
            }, glob($directory->getPath() . DIRECTORY_SEPARATOR . '*', GLOB_NOSORT)),
        );
    }
}
