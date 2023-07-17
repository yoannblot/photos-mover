<?php

declare(strict_types=1);

namespace Tests\Helper;

use InvalidArgumentException;

final class Directory
{
    public static function create(string $directoryName): string
    {
        $directoryPath = __DIR__ . DIRECTORY_SEPARATOR . $directoryName;

        mkdir($directoryPath, 0777, true);

        return $directoryPath;
    }

    public static function remove(string $dirPath): void
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }

        if (!str_ends_with($dirPath, '/')) {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::remove($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}
