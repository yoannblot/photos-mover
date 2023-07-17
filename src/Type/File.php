<?php

declare(strict_types=1);

namespace App\Type;

final class File
{
    private string $path;

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

    public function getPath(): string
    {
        return $this->path;
    }
}
