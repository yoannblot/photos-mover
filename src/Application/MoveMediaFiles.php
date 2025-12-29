<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Finder;
use App\Domain\Mover;
use App\Domain\PathGenerator;
use App\Domain\Type\Directory;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

final readonly class MoveMediaFiles
{
    public function __construct(
        private Finder $finder,
        private PathGenerator $pathGenerator,
        private Mover $mover,
        private LoggerInterface $logger,
    ) {}

    public function move(Directory $source, Directory $destination): void
    {
        $this->logger->info(sprintf(
            "Start moving files from '%s' to '%s'",
            $source->getPath(),
            $destination->getPath(),
        ));
        foreach ($this->finder->find($source) as $file)
        {
            $this->logger->debug(sprintf("Check for '%s'", $file->getPath()));
            try {
                $newFilePath = $this->pathGenerator->generate($destination, $file);
                $this->logger->info(sprintf("Will move '%s' to %s'", $file->getPath(), $newFilePath));
                $this->mover->move($file, $newFilePath);
            } catch (InvalidArgumentException) {
                $this->logger->warning(sprintf("Unable to move file: '%s'", $file->getPath()));
            }
        }
    }
}
