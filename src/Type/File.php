<?php

declare(strict_types=1);

namespace App\Type;

final class File
{
    private string $path;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException("File '$path' does not exist.");
        }

        $this->path = $path;
    }

    public function getDirectory(): string
    {
        return basename($this->path);
    }

    public function getExtension(): string
    {
        return strtolower(substr($this->path, strrpos($this->path, '.') + 1));
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
