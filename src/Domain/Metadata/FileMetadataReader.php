<?php

declare(strict_types=1);

namespace App\Domain\Metadata;

use App\Domain\Type\File;
use App\Domain\Type\FileMetadata;

final class FileMetadataReader
{
    private ImageReader $imageReader;

    public function __construct(ImageReader $imageReader)
    {
        $this->imageReader = $imageReader;
    }

    public function extractMetadata(File $file): FileMetadata
    {
        if ($file->isImage()) {
            return $this->imageReader->extractMetadata($file);
        }

        throw new \InvalidArgumentException('Unsupported file type');
    }
}
