<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Type\File;
use Psr\Log\LoggerInterface;
use RuntimeException;

final readonly class Mover
{
    public function __construct(
        private LoggerInterface $logger,
    ) {}

    public function move(File $file, string $destinationPath): void
    {
        $this->createDirectoryIfNecessary($destinationPath);

        if (rename($file->getPath(), $destinationPath))
        {
            $this->logger->debug(sprintf("Move '%s' to '%s'", $file->getPath(), $destinationPath));
        } else
        {
            $this->logger->error(sprintf("Unable to move '%s' to '%s'", $file->getPath(), $destinationPath));
        }
    }

    private function createDirectoryIfNecessary(string $destination): void
    {
        $destinationDirectory = dirname($destination);
        if (is_dir($destinationDirectory))
        {
            return;
        }

        if (!mkdir($destinationDirectory, 0o705, true) && !is_dir($destinationDirectory))
        {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $destinationDirectory));
        }
    }
}
