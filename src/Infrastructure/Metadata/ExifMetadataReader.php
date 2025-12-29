<?php

declare(strict_types=1);

namespace App\Infrastructure\Metadata;

use App\Domain\Metadata\FileReader;
use App\Domain\Type\File;
use App\Domain\Type\FileMetadata;
use DateTimeImmutable;
use InvalidArgumentException;

final class ExifMetadataReader implements FileReader
{
    public function extractMetadata(File $file): FileMetadata
    {
        $exifData = \exif_read_data($file->getPath());
        if (
            $exifData === false
            || !array_key_exists('FileDateTime', $exifData)
            || !is_numeric($exifData['FileDateTime'])
        )
        {
            throw new InvalidArgumentException(sprintf("Unable to extract metadata from file: '%s'", $file->getPath()));
        }

        $date = DateTimeImmutable::createFromFormat('U', (string) $exifData['FileDateTime']);
        if ($date === false)
        {
            throw new InvalidArgumentException(sprintf("Unable to extract metadata from file: '%s'", $file->getPath()));
        }

        return new FileMetadata($date);
    }

    public function supports(File $file): bool
    {
        return $file->isImage() && exif_imagetype($file->getPath()) === IMAGETYPE_JPEG;
    }
}
