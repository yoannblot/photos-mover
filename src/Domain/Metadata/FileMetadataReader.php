<?php

declare(strict_types=1);

namespace App\Domain\Metadata;

use App\Domain\Type\File;
use App\Domain\Type\FileMetadata;
use App\Infrastructure\Metadata\ExifMetadataReader;
use InvalidArgumentException;

final readonly class FileMetadataReader
{
    /**
     * @param ExifMetadataReader[] $fileReaders
     */
    public function __construct(
        private iterable $fileReaders,
    ) {}

    public function extractMetadata(File $file): FileMetadata
    {
        foreach ($this->fileReaders as $fileReader)
        {
            if (!$fileReader->supports($file))
            {
                continue;
            }

            return $fileReader->extractMetadata($file);
        }

        throw new InvalidArgumentException('Unsupported file type');
    }
}
