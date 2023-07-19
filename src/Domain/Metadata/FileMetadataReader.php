<?php

declare(strict_types=1);

namespace App\Domain\Metadata;

use App\Domain\Type\File;
use App\Domain\Type\FileMetadata;
use App\Infrastructure\Metadata\ExifMetadataReader;

final class FileMetadataReader
{
    private FileReader $imageReader;

    public function __construct(ExifMetadataReader $imageReader)
    {
        $this->imageReader = $imageReader;
    }

    public function extractMetadata(File $file): FileMetadata
    {
        if ($this->imageReader->supports($file)) {
            return $this->imageReader->extractMetadata($file);
        }

        throw new \InvalidArgumentException('Unsupported file type');
    }
}
