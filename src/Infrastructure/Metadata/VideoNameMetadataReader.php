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
        return $file->isVideo() && str_starts_with($file->getFileName(), 'VID');
    }

    public function extractMetadata(File $file): FileMetadata
    {
        preg_match('/VID[_]?([0-9]{14})/', $file->getFileName(), $matches);

        if (!array_key_exists(1, $matches)) {
            throw new \LogicException("Unable to extract metadata from file name '{$file->getFileName()}'");
        }

        return new FileMetadata(\DateTimeImmutable::createFromFormat('YmdHis', $matches[1]));
    }
}
