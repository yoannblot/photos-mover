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
        $metadata = $this->imageReader->extractMetadata($file);
        $newDirectory = $outputDirectory->getPath() . $metadata->getDate()->format('Y/m/d') . DIRECTORY_SEPARATOR;

        return $newDirectory . strtolower($file->getDirectory());
    }
}
