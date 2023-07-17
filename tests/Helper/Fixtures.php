<?php

declare(strict_types=1);

namespace Tests\Helper;

use const DIRECTORY_SEPARATOR;

final class Fixtures
{
    private const FIXTURES_DIRECTORY = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Fixtures';

    public static function duplicateImageIn(string $sourceDirectory): void
    {
        $imagePath = self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'image.jpg';
        copy($imagePath, $sourceDirectory . DIRECTORY_SEPARATOR . 'image.jpg');
    }
}
