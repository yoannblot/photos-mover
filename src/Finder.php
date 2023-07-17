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
    public function find(Directory $directory, array $imageExtensions): array
    {
        $extensions = [];
        foreach ($imageExtensions as $extension) {
            $extensions[] = strtolower($extension);
            $extensions[] = strtoupper($extension);
        }

        return array_filter(
            array_map(static function (string $file) use ($extensions): ?File {
                $extension = basename($file);
                $extension = substr($extension, strrpos($extension, '.') + 1);
                if (in_array($extension, $extensions, true)) {
                    return new File($file);
                }

                return null;
            }, glob($directory->getPath() . DIRECTORY_SEPARATOR . '*', GLOB_NOSORT)),
        );
    }
}
