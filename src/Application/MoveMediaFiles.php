<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Finder;
use App\Domain\Mover;
use App\Domain\PathGenerator;
use App\Domain\Type\Directory;
use Psr\Log\LoggerInterface;

final class MoveMediaFiles
{
    private Finder $finder;
    private PathGenerator $pathGenerator;
    private Mover $mover;
    private LoggerInterface $logger;

    public function __construct(Finder $finder, PathGenerator $pathGenerator, Mover $mover, LoggerInterface $logger)
    {
        $this->finder = $finder;
        $this->pathGenerator = $pathGenerator;
        $this->mover = $mover;
        $this->logger = $logger;
    }

    public function move(Directory $source, Directory $destination): void
    {
        $this->logger->info("Start moving files from '{$source->getPath()}' to '{$destination->getPath()}'");
        foreach ($this->finder->find($source) as $file) {
            $this->logger->debug("Check for '{$file->getPath()}'");
            try {
                $newFilePath = $this->pathGenerator->generate($destination, $file);
                $this->logger->info("Will move '{$file->getPath()}' to $newFilePath'");
                $this->mover->move($file, $newFilePath);
            } catch (\InvalidArgumentException $e) {
                $this->logger->warning("Unable to move file: '{$file->getPath()}'");
            }
        }
    }
}
