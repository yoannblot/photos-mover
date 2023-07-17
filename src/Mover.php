<?php

declare(strict_types=1);

namespace App;

use App\Type\File;
use RuntimeException;

final class Mover
{
    public function move(File $source, string $destinationPath): void
    {
        $this->createDirectoryIfNecessary($destinationPath);

        if (rename($source->getPath(), $destinationPath)) {
            error_log("Move '{$source->getPath()}' to '$destinationPath'");
        } else {
            error_log("Unable to move '{$source->getPath()}' to '$destinationPath'");
        }
    }

    private function createDirectoryIfNecessary(string $destination): void
    {
        $destinationDirectory = dirname($destination);
        if (is_dir($destinationDirectory)) {
            return;
        }

        if (!mkdir($destinationDirectory, 0705, true) && !is_dir($destinationDirectory)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $destinationDirectory));
        }
    }
}
