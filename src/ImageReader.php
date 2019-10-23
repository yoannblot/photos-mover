<?php

final class ImageReader {

    /**
     * @param string $path
     * @param string $format
     *
     * @return string
     */
    private function getDirectory (string $path, string $format): string {
        $exifData = exif_read_data($path);
        $timestamp = $exifData['FileDateTime'];

        return date($format, $timestamp) . DIRECTORY_SEPARATOR;
    }

    /**
     * @param string $outputDirectory
     * @param string $path
     * @param string $format
     *
     * @return string
     */
    public function getNewPath (string $outputDirectory, string $path, string $format): string {
        if (false === strpos($outputDirectory, DIRECTORY_SEPARATOR, -1)) {
            $outputDirectory .= DIRECTORY_SEPARATOR;
        }
        $newDirectory = $outputDirectory . $this->getDirectory($path, $format);

        $newFilePath = $newDirectory . strtolower(basename($path));
        $count = 2;
        while (is_file($newFilePath)) {
            $newFilePath = substr($newFilePath, 0, strrpos($newFilePath, '.')) . "-$count.$format";
        }

        return $newFilePath;
    }
}