<?php

declare(strict_types=1);

namespace Tests\Helper;

use App\Domain\Type\Directory as DirectoryType;
use App\Domain\Type\File;
use App\Domain\Type\ImageExtension;

final class Fixtures
{
    private const string FIXTURES_DIRECTORY = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Fixtures';

    public static function createImageFile(DirectoryType $directoryType, ImageExtension $imageExtension): File
    {
        $sourceFile = self::getImageFile($imageExtension)->getPath();
        $imagePath  = $directoryType->getPath() . DIRECTORY_SEPARATOR . ('image.' . $imageExtension->value);
        copy($sourceFile, $imagePath);

        return new File($imagePath);
    }

    public static function duplicateImageIn(DirectoryType $directoryType, ImageExtension $imageExtension): void
    {
        $sourceFile = self::getImageFile($imageExtension)->getPath();
        copy($sourceFile, $directoryType->getPath() . DIRECTORY_SEPARATOR . ('image.' . $imageExtension->value));
    }

    public static function duplicateVideoIn(DirectoryType $directoryType): void
    {
        copy(
            self::getVideoFileWithDateTimeInName()->getPath(),
            $directoryType->getPath() . DIRECTORY_SEPARATOR . self::getVideoFileWithDateTimeInName()->getFileName(),
        );
    }

    public static function getImageFile(ImageExtension $imageExtension): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'image.' . $imageExtension->value);
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
