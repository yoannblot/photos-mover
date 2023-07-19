<?php

declare(strict_types=1);

namespace App;

use App\Type\Directory;
use Psr\Log\LoggerInterface;

final class MoveMediaFiles
{
    private Finder $finder;
    private FileReader $reader;
    private Mover $mover;
    private LoggerInterface $logger;

    public function __construct(Finder $finder, FileReader $reader, Mover $mover, LoggerInterface $logger)
    {
        $this->finder = $finder;
        $this->reader = $reader;
        $this->mover = $mover;
        $this->logger = $logger;
    }

    public function move(Directory $source, Directory $destination): void
    {
        $this->logger->info("Start moving files from '{$source->getPath()}' to {$destination->getPath()}'");
        foreach ($this->finder->find($source) as $file) {
            $newFilePath = $this->reader->getNewPath($destination, $file);
            $this->logger->info("Will move '{$file->getPath()}' to $newFilePath'");
            $this->mover->move($file, $newFilePath);
        }
    }
}
