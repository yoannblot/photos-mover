<?php

use App\FileReader;
use App\Finder;
use App\Infrastructure\StdoutLogger;
use App\Metadata\FileMetadataReader;
use App\Metadata\ImageReader;
use App\MoveMediaFiles;
use App\Mover;
use App\Type\Directory;

if ($argc < 3) {
    throw new InvalidArgumentException(
        'You have to provide at least two arguments : source directory and destination directory'
    );
}

[, $sourceDirectory, $destinationDirectory] = $argv;

$moveMediaFiles = new MoveMediaFiles(
    new Finder(),
    new FileReader(new FileMetadataReader(new ImageReader())),
    new Mover(),
    new StdoutLogger()
);
$moveMediaFiles->move(new Directory($sourceDirectory), new Directory($destinationDirectory));
