<?php

declare(strict_types=1);

namespace Tests\Helper;

use App\Domain\Type\Directory as DirectoryType;
use App\Domain\Type\File;

final class Fixtures
{
    private const FIXTURES_DIRECTORY = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Fixtures';

    public static function duplicateImageIn(DirectoryType $destination): void
    {
        copy(self::getImageFile()->getPath(), $destination->getPath() . DIRECTORY_SEPARATOR . 'image.jpg');
    }

    public static function getImageFile(): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'image.jpg');
    }
}
