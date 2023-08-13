<?php

declare(strict_types=1);

namespace App;

use App\Application\MoveMediaFiles;
use App\Domain\Finder;
use App\Domain\Metadata\FileMetadataReader;
use App\Domain\Mover;
use App\Domain\PathGenerator;
use App\Infrastructure\Metadata\ExifMetadataReader;
use App\Infrastructure\StdoutLogger;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class Kernel
{
    private ContainerBuilder $container;

    public function __construct()
    {
        $this->container = new ContainerBuilder();

        $this->container->register(LoggerInterface::class, StdoutLogger::class);
        $this->container
            ->register(FileMetadataReader::class, FileMetadataReader::class)
            ->addArgument([new ExifMetadataReader()]);
        $this->container->register(Finder::class, Finder::class);
        $this->container->register(PathGenerator::class, PathGenerator::class)
            ->addArgument($this->container->get(FileMetadataReader::class));
        $this->container->register(Mover::class, Mover::class)
            ->addArgument($this->container->get(LoggerInterface::class));
        $this->container->register(MoveMediaFiles::class, MoveMediaFiles::class)
            ->addArgument($this->container->get(Finder::class))
            ->addArgument($this->container->get(PathGenerator::class))
            ->addArgument($this->container->get(Mover::class))
            ->addArgument($this->container->get(LoggerInterface::class));
    }

    public function get(string $id): ?object
    {
        return $this->container->get($id);
    }
}
