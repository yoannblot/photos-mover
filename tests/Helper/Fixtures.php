<?php

declare(strict_types=1);

namespace Tests\Helper;

use App\Domain\Type\Directory as DirectoryType;
use App\Domain\Type\File;

final class Fixtures
{
    private const string FIXTURES_DIRECTORY = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Fixtures';

    public static function createJpgImageFile(DirectoryType $directoryType): File
    {
        $imagePath = $directoryType->getPath() . DIRECTORY_SEPARATOR . 'image.jpg';
        copy(self::getJpgImageFile()->getPath(), $imagePath);

        return new File($imagePath);
    }

    public static function createPngImageFile(DirectoryType $directoryType): File
    {
        $imagePath = $directoryType->getPath() . DIRECTORY_SEPARATOR . 'image.png';
        copy(self::getPngImageFile()->getPath(), $imagePath);

        return new File($imagePath);
    }

    public static function duplicateJpgImageIn(DirectoryType $directoryType): void
    {
        copy(self::getJpgImageFile()->getPath(), $directoryType->getPath() . DIRECTORY_SEPARATOR . 'image.jpg');
    }

    public static function duplicatePngImageIn(DirectoryType $directoryType): void
    {
        copy(self::getPngImageFile()->getPath(), $directoryType->getPath() . DIRECTORY_SEPARATOR . 'image.png');
    }

    public static function duplicateVideoIn(DirectoryType $directoryType): void
    {
        copy(
            self::getVideoFileWithDateTimeInName()->getPath(),
            $directoryType->getPath() . DIRECTORY_SEPARATOR . self::getVideoFileWithDateTimeInName()->getFileName(),
        );
    }

    public static function getJpgImageFile(): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'image.jpg');
    }

    public static function getPngImageFile(): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'image.png');
    }

    public static function getTextFile(): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'text.txt');
    }

    public static function getVideoFile(): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'video.mp4');
    }

    public static function getVideoFileWithDateTimeInName(): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'VID20230731221612.mp4');
    }
}
