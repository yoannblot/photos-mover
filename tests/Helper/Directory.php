<?php

declare(strict_types=1);

namespace Tests\Helper;

use App\Type\Directory as DirectoryType;

final class Directory
{
    public static function create(string $directoryName): DirectoryType
    {
        $directoryPath = __DIR__ . DIRECTORY_SEPARATOR . $directoryName;

        mkdir($directoryPath, 0777, true);

        return new DirectoryType($directoryPath);
    }

    public static function remove(DirectoryType $directory): void
    {
        foreach (glob($directory->getPath() . '*', GLOB_MARK) as $path) {
            if (is_dir($path)) {
                self::remove(new DirectoryType($path));
            } else {
                unlink($path);
            }
        }
        rmdir($directory->getPath());
    }
}
