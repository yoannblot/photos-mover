<?php

use App\Application\MoveMediaFiles;
use App\Domain\Type\Directory;
use App\Kernel;

if ($argc < 3) {
    throw new InvalidArgumentException(
        'You have to provide at least two arguments : source directory and destination directory'
    );
}

[, $sourceDirectory, $destinationDirectory] = $argv;

$app = new Kernel();
$moveMediaFiles = $app->get(MoveMediaFiles::class);

$moveMediaFiles->move(new Directory($sourceDirectory), new Directory($destinationDirectory));
