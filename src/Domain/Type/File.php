<?php

declare(strict_types=1);

namespace App\Domain\Type;

use InvalidArgumentException;

final readonly class File
{
    private string $path;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $path)
    {
        if (!file_exists($path))
        {
            throw new InvalidArgumentException(sprintf("File '%s' does not exist.", $path));
        }

        $this->path = $path;
    }

    public function getDirectory(): string
    {
        return basename($this->path);
    }

    public function getFileName(): string
    {
        return basename($this->path);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function isImage(): bool
    {
        return ImageExtension::tryFrom($this->getExtension()) !== null;
    }

    public function isVideo(): bool
    {
        return $this->getExtension() === 'mp4';
    }

    private function getExtension(): string
    {
        $dotPosition = strrpos($this->path, '.');
        if ($dotPosition === false)
        {
            return '';
        }

        return strtolower(substr($this->path, $dotPosition + 1));
    }
}
