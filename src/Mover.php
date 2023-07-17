<?php

declare(strict_types=1);

namespace App;

use App\Type\File;

final class Mover
{
    public function move(File $source, string $destination): void
    {
        $destinationDirectory = dirname($destination);
        if (!is_dir($destinationDirectory)) {
            mkdir($destinationDirectory, 0705, true);
        }
        if (rename($source->getPath(), $destination)) {
            error_log("Move '{$source->getPath()}' to '$destination'");
        } else {
            error_log("Unable to move '{$source->getPath()}' to '$destination'");
        }
    }
}
