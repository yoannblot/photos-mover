<?php

declare(strict_types=1);

namespace App;

use App\Metadata\FileMetadataReader;
use App\Type\Directory;
use App\Type\File;

final class FileReader
{
    private FileMetadataReader $fileMetadataReader;

    public function __construct(FileMetadataReader $fileMetadataReader)
    {
        $this->fileMetadataReader = $fileMetadataReader;
    }

    public function getNewPath(Directory $outputDirectory, File $file): string
    {
        $metadata = $this->fileMetadataReader->extractMetadata($file);
        $newDirectory = $outputDirectory->getPath() . $metadata->getDate()->format('Y/m/d') . DIRECTORY_SEPARATOR;

        return $newDirectory . strtolower($file->getDirectory());
    }
}
