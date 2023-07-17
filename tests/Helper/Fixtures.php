<?php

declare(strict_types=1);

namespace Tests\Helper;

use App\Type\Directory as DirectoryType;

final class Fixtures
{
    private const FIXTURES_DIRECTORY = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Fixtures';

    public static function duplicateImageIn(DirectoryType $destination): void
    {
        $imagePath = self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'image.jpg';
        copy($imagePath, $destination->getPath() . DIRECTORY_SEPARATOR . 'image.jpg');
    }
}
