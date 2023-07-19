<?php

declare(strict_types=1);

namespace App\Domain\Metadata;

use App\Domain\Type\File;
use App\Domain\Type\FileMetadata;
use App\Infrastructure\Metadata\ExifMetadataReader;

final class FileMetadataReader
{
    /**
     * @var ExifMetadataReader[]
     */
    private iterable $fileReaders;

    /**
     * @param ExifMetadataReader[] $fileReaders
     */
    public function __construct(iterable $fileReaders)
    {
        $this->fileReaders = $fileReaders;
    }

    public function extractMetadata(File $file): FileMetadata
    {
        foreach ($this->fileReaders as $fileReader) {
            if ($fileReader->supports($file)) {
                return $fileReader->extractMetadata($file);
            }
        }

        throw new \InvalidArgumentException('Unsupported file type');
    }
}
