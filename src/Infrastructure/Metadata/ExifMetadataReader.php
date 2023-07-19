<?php

declare(strict_types=1);

namespace App\Infrastructure\Metadata;

use App\Domain\Metadata\FileReader;
use App\Domain\Type\File;
use App\Domain\Type\FileMetadata;
use DateTimeImmutable;

final class ExifMetadataReader implements FileReader
{
    public function supports(File $file): bool
    {
        return $file->isImage();
    }

    public function extractMetadata(File $file): FileMetadata
    {
        $exifData = exif_read_data($file->getPath());
        $timestamp = $exifData['FileDateTime'];

        return new FileMetadata(DateTimeImmutable::createFromFormat('U', (string) $timestamp));
    }
}
