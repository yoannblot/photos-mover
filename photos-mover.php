<?php

$directory = 'C:\Users\Yoann\Pictures\Camera Roll';
$outputDirectory = 'D:/images/';
$imageExtension = 'jpg';
$format = 'Y/m/d';

require __DIR__ . '/src/Finder.php';
require __DIR__ . '/src/ImageReader.php';
require __DIR__ . '/src/Mover.php';

$finder = new Finder();
$reader = new ImageReader();
$mover = new Mover();
foreach ($finder->find($directory, $imageExtension) as $image) {
    $newFilePath = $reader->getNewPath($outputDirectory, $image, $format);
    $mover->move($image, $newFilePath);
}
