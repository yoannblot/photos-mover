<?php

use App\Application\MoveMediaFiles;
use App\Domain\FileReader;
use App\Domain\Finder;
use App\Domain\Metadata\FileMetadataReader;
use App\Domain\Metadata\ImageReader;
use App\Domain\Mover;
use App\Domain\Type\Directory;
use App\Infrastructure\StdoutLogger;

if ($argc < 3) {
    throw new InvalidArgumentException(
        'You have to provide at least two arguments : source directory and destination directory'
    );
}

[, $sourceDirectory, $destinationDirectory] = $argv;

$logger = new StdoutLogger();
$moveMediaFiles = new MoveMediaFiles(
    new Finder(),
    new FileReader(new FileMetadataReader(new ImageReader())),
    new Mover($logger),
    $logger
);
$moveMediaFiles->move(new Directory($sourceDirectory), new Directory($destinationDirectory));
