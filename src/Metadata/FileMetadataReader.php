<?php

declare(strict_types=1);

namespace App\Metadata;

use App\Type\File;
use App\Type\FileMetadata;

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
