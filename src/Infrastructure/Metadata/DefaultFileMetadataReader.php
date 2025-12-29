<?php

declare(strict_types=1);

namespace App\Infrastructure\Metadata;

use App\Domain\Metadata\FileReader;
use App\Domain\Type\File;
use App\Domain\Type\FileMetadata;
use DateTimeImmutable;
use InvalidArgumentException;

final class DefaultFileMetadataReader implements FileReader
{
    public function extractMetadata(File $file): FileMetadata
    {
        $timestamp = filemtime($file->getPath());
        $date      = DateTimeImmutable::createFromFormat('U', (string) $timestamp);
        if ($date === false)
        {
            throw new InvalidArgumentException(sprintf("Unable to extract metadata from file: '%s'", $file->getPath()));
        }

        return new FileMetadata($date);
    }

    public function supports(File $file): bool
    {
        if ($file->isImage())
        {
            return true;
        }

        return $file->isVideo();
    }
}
