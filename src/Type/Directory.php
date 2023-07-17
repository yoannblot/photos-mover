<?php

declare(strict_types=1);

namespace App\Type;

final class Directory
{
    private string $path;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(string $path)
    {
        if (!is_dir($path)) {
            throw new \InvalidArgumentException("Given directory '$path' is not a directory.");
        }

        if (false === strpos($path, DIRECTORY_SEPARATOR, -1)) {
            $path .= DIRECTORY_SEPARATOR;
        }

        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
