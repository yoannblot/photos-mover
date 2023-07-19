<?php

declare(strict_types=1);

namespace App\Domain\Metadata;

use App\Domain\Type\File;
use App\Domain\Type\FileMetadata;

interface FileReader
{
    public function supports(File $file): bool;

    public function extractMetadata(File $file): FileMetadata;
}
