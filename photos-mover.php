<?php

use App\Finder;
use App\ImageReader;
use App\Mover;

if ($argc < 3) {
    throw new \InvalidArgumentException(
        'You have to provide at least two arguments : source directory and destination directory'
    );
}

$directory = $argv[1];
$outputDirectory = $argv[2];
$imageExtensions = ['jpg', 'gif', 'png', 'jpeg'];
$format = 'Y/m/d';

$finder = new Finder();
$reader = new ImageReader();
$mover = new Mover();

error_log("Start moving files from '$directory' to $outputDirectory'");
foreach ($finder->find($directory, $imageExtensions) as $image) {
    $newFilePath = $reader->getNewPath($outputDirectory, $image, $format);
    error_log("Will move '$image' to $newFilePath'");
    $mover->move($image, $newFilePath);
}
