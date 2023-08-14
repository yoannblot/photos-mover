<?php

declare(strict_types=1);

namespace App\Infrastructure\Metadata;

use App\Domain\Metadata\FileReader;
use App\Domain\Type\File;
use App\Domain\Type\FileMetadata;

final class VideoNameMetadataReader implements FileReader
{
    public function supports(File $file): bool
    {
        return $file->isVideo()
            && (str_starts_with($file->getFileName(), 'VID')
                || str_starts_with($file->getFileName(), 'WP'));
    }

    public function extractMetadata(File $file): FileMetadata
    {
        preg_match('/[VIDWP][_-]?([0-9]{8})[_-]?/', $file->getFileName(), $matches);

        if (count($matches) < 1) {
            throw new \LogicException("Unable to extract metadata from file name '{$file->getFileName()}'");
        }

        return new FileMetadata(\DateTimeImmutable::createFromFormat('Ymd', $matches[1]));
    }
}
