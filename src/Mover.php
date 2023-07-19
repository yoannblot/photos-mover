<?php

declare(strict_types=1);

namespace App;

use App\Type\File;
use Psr\Log\LoggerInterface;
use RuntimeException;

final class Mover
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function move(File $source, string $destinationPath): void
    {
        $this->createDirectoryIfNecessary($destinationPath);

        if (rename($source->getPath(), $destinationPath)) {
            $this->logger->debug("Move '{$source->getPath()}' to '$destinationPath'");
        } else {
            $this->logger->error("Unable to move '{$source->getPath()}' to '$destinationPath'");
        }
    }

    private function createDirectoryIfNecessary(string $destination): void
    {
        $destinationDirectory = dirname($destination);
        if (is_dir($destinationDirectory)) {
            return;
        }

        if (!mkdir($destinationDirectory, 0705, true) && !is_dir($destinationDirectory)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $destinationDirectory));
        }
    }
}
