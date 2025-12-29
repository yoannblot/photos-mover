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
        $all = glob($directory->getPath() . '*', GLOB_NOSORT);
        if ($all === false)
        {
            return [];
        }

        $result = [];
        foreach ($all as $path)
        {
            $file = new File($path);
            if ($file->isImage() || $file->isVideo())
            {
                $result[] = $file;
            }
        }

        return $result;
    }
}
