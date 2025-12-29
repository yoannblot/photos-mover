<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Metadata\FileMetadataReader;
use App\Domain\Type\Directory;
use App\Domain\Type\File;

final readonly class PathGenerator
{
    public function __construct(
        private FileMetadataReader $fileMetadataReader,
    ) {}

    public function generate(Directory $outputDirectory, File $file): string
    {
        $fileMetadata = $this->fileMetadataReader->extractMetadata($file);
        $newDirectory = $outputDirectory->getPath() . $fileMetadata->getDate()->format('Y/m/d') . DIRECTORY_SEPARATOR;

        return $newDirectory . strtolower($file->getDirectory());
    }
}
