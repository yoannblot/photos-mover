<?php

declare(strict_types=1);

namespace App\Metadata;

use App\Type\File;
use App\Type\FileMetadata;
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
