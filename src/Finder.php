<?php

final class Finder {

    /**
     * @param string $directory
     * @param string $imageExtension
     *
     * @return array
     */
    public function find ($directory, $imageExtension) {
        if (!is_dir($directory)) {
            error_log("Given directory '$directory' is not a directory.");

            return [];
        }

        $pattern = $directory . DIRECTORY_SEPARATOR . '*';

        $extensions = [
            strtolower($imageExtension),
            strtoupper($imageExtension)
        ];

        return array_filter(array_map(function ($file) use ($extensions) {
            $extension = basename($file);
            $extension = substr($extension, strrpos($extension, '.') + 1);
            if (in_array($extension, $extensions)) {
                return $file;
            }

            return null;
        }, glob($pattern, GLOB_NOSORT)));
    }
}