<?php

final class Finder {

    /**
     * @param string $directory
     * @param string $imageExtension
     *
     * @return array
     */
    public function find (string $directory, string $imageExtension): array {
        if (!is_dir($directory)) {
            return [];
        }

        return glob("$directory/*.$imageExtension", GLOB_NOSORT);
    }
}