<?php

declare(strict_types=1);

namespace App;

use App\Metadata\ImageReader;
use App\Type\Directory;
use App\Type\File;

final class FileReader
{
    private ImageReader $imageReader;

    public function __construct(ImageReader $imageReader)
    {
        $this->imageReader = $imageReader;
    }

    public function getNewPath(Directory $outputDirectory, File $file): string
    {
        $format = 'Y/m/d';
        $newDirectory = $outputDirectory->getPath() . $this->getDirectory($file, $format);

        $newFilePath = $newDirectory . strtolower($file->getDirectory());
        while (is_file($newFilePath)) {
            $newFilePath = substr($newFilePath, 0, strrpos($newFilePath, '.')) . "-2.$format";
        }

        return $newFilePath;
    }

    private function getDirectory(File $file, string $format): string
    {
        $metadata = $this->imageReader->extractMetadata($file);

        return date($format, $metadata->getDate()->getTimestamp()) . DIRECTORY_SEPARATOR;
    }
}
