<?php

declare(strict_types=1);

namespace App;

final class Mover
{
    public function move(string $source, string $destination): void
    {
        $destinationDirectory = dirname($destination);
        if (!is_dir($destinationDirectory)) {
            mkdir($destinationDirectory, true, 0705);
        }
        if (rename($source, $destination)) {
            error_log("Move '$source' to '$destination'");
        } else {
            error_log("Unable to move '$source' to '$destination'");
        }
    }
}
