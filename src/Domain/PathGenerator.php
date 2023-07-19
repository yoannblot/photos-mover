<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Metadata\FileMetadataReader;
use App\Domain\Type\Directory;
use App\Domain\Type\File;

final class PathGenerator
{
    private FileMetadataReader $fileMetadataReader;

    public function __construct(FileMetadataReader $fileMetadataReader)
    {
        $this->fileMetadataReader = $fileMetadataReader;
    }

    public function generate(Directory $outputDirectory, File $file): string
    {
        $metadata = $this->fileMetadataReader->extractMetadata($file);
        $newDirectory = $outputDirectory->getPath() . $metadata->getDate()->format('Y/m/d') . DIRECTORY_SEPARATOR;

        return $newDirectory . strtolower($file->getDirectory());
    }
}
