<?php
if ($argc < 3) {
    throw new \InvalidArgumentException('You have to provide at least two arguments : source directory and destination directory');
}

$directory = $argv[1];
$outputDirectory = $argv[2];
$imageExtension = 'jpg';
$format = 'Y/m/d';

require __DIR__ . '/src/Finder.php';
require __DIR__ . '/src/ImageReader.php';
require __DIR__ . '/src/Mover.php';

$finder = new Finder();
$reader = new ImageReader();
$mover = new Mover();

error_log("Start moving files from '$directory' to $outputDirectory'");
foreach ($finder->find($directory, $imageExtension) as $image) {
    $newFilePath = $reader->getNewPath($outputDirectory, $image, $format);
    error_log("Will move '$image' to $newFilePath'");
    $mover->move($image, $newFilePath);
}
