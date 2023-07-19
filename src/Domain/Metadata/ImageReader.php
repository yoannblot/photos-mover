<?php

declare(strict_types=1);

namespace App\Domain\Metadata;

use App\Domain\Type\File;
use App\Domain\Type\FileMetadata;
use DateTimeImmutable;

final class ImageReader
{
    public function extractMetadata(File $file): FileMetadata
    {
        $exifData = exif_read_data($file->getPath());
        $timestamp = $exifData['FileDateTime'];

        return new FileMetadata(DateTimeImmutable::createFromFormat('U', (string) $timestamp));
    }
}
