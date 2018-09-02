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

        $pattern = $directory . DIRECTORY_SEPARATOR . '*.' . $imageExtension;

        return glob($pattern, GLOB_NOSORT);
    }
}