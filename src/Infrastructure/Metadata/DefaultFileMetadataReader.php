<?php

declare(strict_types=1);

namespace App\Infrastructure\Metadata;

use App\Domain\Metadata\FileReader;
use App\Domain\Type\File;
use App\Domain\Type\FileMetadata;
use DateTimeImmutable;

final class DefaultFileMetadataReader implements FileReader
{
    public function supports(File $file): bool
    {
        return $file->isImage() || $file->isVideo();
    }

    public function extractMetadata(File $file): FileMetadata
    {
        $timestamp = filemtime($file->getPath());

        return new FileMetadata(DateTimeImmutable::createFromFormat('U', (string) $timestamp));
    }
}
