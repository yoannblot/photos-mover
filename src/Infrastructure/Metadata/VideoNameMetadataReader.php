<?php

declare(strict_types=1);

namespace App\Infrastructure\Metadata;

use App\Domain\Metadata\FileReader;
use App\Domain\Type\File;
use App\Domain\Type\FileMetadata;
use DateTimeImmutable;
use LogicException;

final class VideoNameMetadataReader implements FileReader
{
    public function extractMetadata(File $file): FileMetadata
    {
        $matches = [];
        preg_match('/[VIDWP][_-]?(\d{8})[_-]?/', $file->getFileName(), $matches);

        if (count($matches) < 1)
        {
            throw new LogicException(sprintf("Unable to extract metadata from file name '%s'", $file->getFileName()));
        }

        $date = DateTimeImmutable::createFromFormat('Ymd', $matches[1]);
        if ($date === false)
        {
            throw new LogicException(sprintf("Unable to extract metadata from file name '%s'", $file->getFileName()));
        }

        return new FileMetadata($date);
    }

    public function supports(File $file): bool
    {
        return (
            $file->isVideo()
            && (str_starts_with($file->getFileName(), 'VID') || str_starts_with($file->getFileName(), 'WP'))
        );
    }
}
