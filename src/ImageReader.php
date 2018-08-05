<?php

final class ImageReader {

    /**
     * @param string $path
     * @param string $format
     *
     * @return string
     */
    public function getDirectory (string $path, string $format): string {
        $exifData = exif_read_data($path);
        $timestamp = $exifData['FileDateTime'];

        return date($format, $timestamp) . DIRECTORY_SEPARATOR;
    }
}