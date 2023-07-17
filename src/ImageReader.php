<?php

declare(strict_types=1);

namespace App;

use App\Type\File;

final class ImageReader
{
    public function getNewPath(string $outputDirectory, File $file, string $format): string
    {
        if (false === strpos($outputDirectory, DIRECTORY_SEPARATOR, -1)) {
            $outputDirectory .= DIRECTORY_SEPARATOR;
        }
        $newDirectory = $outputDirectory . $this->getDirectory($file->getPath(), $format);

        $newFilePath = $newDirectory . strtolower($file->getDirectory());
        $count = 2;
        while (is_file($newFilePath)) {
            $newFilePath = substr($newFilePath, 0, strrpos($newFilePath, '.')) . "-$count.$format";
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
