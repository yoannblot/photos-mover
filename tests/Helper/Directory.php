<?php

declare(strict_types=1);

namespace Tests\Helper;

use App\Domain\Type\Directory as DirectoryType;

final class Directory
{
    public static function create(string $directoryName): DirectoryType
    {
        $directoryPath = __DIR__ . DIRECTORY_SEPARATOR . $directoryName;

        if (!is_dir($directoryPath))
        {
            mkdir($directoryPath, 0o705, true);
        }

        return new DirectoryType($directoryPath);
    }

    public static function remove(DirectoryType $directoryType): void
    {
        $files = glob($directoryType->getPath() . '*', GLOB_MARK);
        if ($files === false)
        {
            return;
        }

        foreach ($files as $file)
        {
            if (is_dir($file))
            {
                self::remove(new DirectoryType($file));
            } else
            {
                unlink($file);
            }
        }

        rmdir($directoryType->getPath());
    }
}
