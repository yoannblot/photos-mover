<?php

declare(strict_types=1);

namespace App\Domain\Type;

use InvalidArgumentException;

final readonly class File
{
    private const array IMAGE_EXTENSIONS = ['jpg', 'gif', 'png', 'jpeg'];

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
        return in_array($this->getExtension(), self::IMAGE_EXTENSIONS, true);
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
