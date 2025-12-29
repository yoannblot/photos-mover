<?php

declare(strict_types=1);

namespace App\Domain\Type;

use InvalidArgumentException;

final readonly class Directory
{
    private string $path;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $path)
    {
        if (!is_dir($path))
        {
            throw new InvalidArgumentException(sprintf("Given directory '%s' is not a directory.", $path));
        }

        if (!str_contains(substr($path, -1), DIRECTORY_SEPARATOR))
        {
            $path .= DIRECTORY_SEPARATOR;
        }

        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
