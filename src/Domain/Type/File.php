<?php

declare(strict_types=1);

namespace App\Domain\Type;

final class File
{
    private const IMAGE_EXTENSIONS = ['jpg', 'gif', 'png', 'jpeg'];

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

    public function getPath(): string
    {
        return $this->path;
    }

    public function isImage(): bool
    {
        return in_array($this->getExtension(), self::IMAGE_EXTENSIONS, true);
    }

    private function getExtension(): string
    {
        return strtolower(substr($this->path, strrpos($this->path, '.') + 1));
    }
}
