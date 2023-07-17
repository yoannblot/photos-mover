<?php

declare(strict_types=1);

namespace App;

final class Finder
{
    /**
     * @return string[]
     */
    public function find(string $directory, array $imageExtensions): array
    {
        if (!is_dir($directory)) {
            error_log("Given directory '$directory' is not a directory.");

            return [];
        }

        $pattern = $directory . DIRECTORY_SEPARATOR . '*';

        $extensions = [];
        foreach ($imageExtensions as $extension) {
            $extensions[] = strtolower($extension);
            $extensions[] = strtoupper($extension);
        }

        return array_filter(
            array_map(static function (string $file) use ($extensions) {
                $extension = basename($file);
                $extension = substr($extension, strrpos($extension, '.') + 1);
                if (in_array($extension, $extensions, true)) {
                    return $file;
                }

                return null;
            }, glob($pattern, GLOB_NOSORT)),
        );
    }
}
