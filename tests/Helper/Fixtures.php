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

    public static function duplicateVideoIn(DirectoryType $destination): void
    {
        copy(
            self::getVideoFileWithDateTimeInName()->getPath(),
            $destination->getPath() . DIRECTORY_SEPARATOR . self::getVideoFileWithDateTimeInName()->getFileName()
        );
    }

    public static function getImageFile(): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'image.jpg');
    }

    public static function getVideoFile(): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'video.mp4');
    }

    public static function getVideoFileWithDateTimeInName(): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'VID20230731221612.mp4');
    }

    public static function getTextFile(): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'text.txt');
    }
}
