<?php

declare(strict_types=1);

namespace Tests\Helper;

use App\Domain\Type\Directory as DirectoryType;
use App\Domain\Type\File;
use App\Domain\Type\ImageExtension;
use App\Domain\Type\VideoExtension;

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

    public static function duplicateVideoIn(DirectoryType $directoryType, VideoExtension $videoExtension): void
    {
        $sourceFile = self::getVideoFile($videoExtension)->getPath();
        copy(
            $sourceFile,
            $directoryType->getPath() . DIRECTORY_SEPARATOR . self::getVideoFile($videoExtension)->getFileName(),
        );
    }

    public static function getGenericVideoFile(): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'video.mp4');
    }

    public static function getImageFile(ImageExtension $imageExtension): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'image.' . $imageExtension->value);
    }

    public static function getTextFile(): File
    {
        return new File(self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR . 'text.txt');
    }

    public static function getVideoFile(VideoExtension $videoExtension): File
    {
        $directory = self::FIXTURES_DIRECTORY . DIRECTORY_SEPARATOR;

        return match ($videoExtension)
        {
            VideoExtension::MP4 => new File($directory . 'VID20230731221612.mp4'),
            VideoExtension::THREE_GP => new File($directory . 'VID_20230731_221612.3gp'),
            VideoExtension::MOV => new File($directory . 'VID_20230731_091847.mov'),
        };
    }
}
