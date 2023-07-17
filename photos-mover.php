<?php

use App\Finder;
use App\ImageReader;
use App\MoveMediaFiles;
use App\Mover;
use App\Type\Directory;

if ($argc < 3) {
    throw new \InvalidArgumentException(
        'You have to provide at least two arguments : source directory and destination directory'
    );
}

[, $sourceDirectory, $destinationDirectory] = $argv;

$moveMediaFiles = new MoveMediaFiles(new Finder(), new ImageReader(), new Mover());
$moveMediaFiles->move(new Directory($sourceDirectory), new Directory($destinationDirectory));
