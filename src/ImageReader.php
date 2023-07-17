<?php

declare(strict_types=1);

namespace App;

use App\Type\Directory;
use App\Type\File;

final class ImageReader
{
    public function getNewPath(Directory $outputDirectory, File $file, string $format): string
    {
        $newDirectory = $outputDirectory->getPath() . $this->getDirectory($file->getPath(), $format);

        $newFilePath = $newDirectory . strtolower($file->getDirectory());
        while (is_file($newFilePath)) {
            $newFilePath = substr($newFilePath, 0, strrpos($newFilePath, '.')) . "-2.$format";
        }

        return $newFilePath;
    }

    private function getDirectory(string $path, string $format): string
    {
        $exifData = exif_read_data($path);
        $timestamp = $exifData['FileDateTime'];

        return date($format, $timestamp) . DIRECTORY_SEPARATOR;
    }
}
