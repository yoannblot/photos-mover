<?php

declare(strict_types=1);

namespace App;

use App\Application\MoveMediaFiles;
use App\Domain\Finder;
use App\Domain\Metadata\FileMetadataReader;
use App\Domain\Mover;
use App\Domain\PathGenerator;
use App\Infrastructure\Metadata\DefaultFileMetadataReader;
use App\Infrastructure\Metadata\ExifMetadataReader;
use App\Infrastructure\Metadata\VideoNameMetadataReader;
use App\Infrastructure\StdoutLogger;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final readonly class Kernel
{
    private ContainerBuilder $containerBuilder;

    public function __construct()
    {
        $this->containerBuilder = new ContainerBuilder();

        $this->containerBuilder->register(LoggerInterface::class, StdoutLogger::class);
        $this->containerBuilder
            ->register(FileMetadataReader::class, FileMetadataReader::class)
            ->addArgument([new ExifMetadataReader(), new VideoNameMetadataReader(), new DefaultFileMetadataReader()]);
        $this->containerBuilder->register(Finder::class, Finder::class);
        $this->containerBuilder
            ->register(PathGenerator::class, PathGenerator::class)
            ->addArgument($this->containerBuilder->get(FileMetadataReader::class));
        $this->containerBuilder
            ->register(Mover::class, Mover::class)
            ->addArgument($this->containerBuilder->get(LoggerInterface::class));
        $this->containerBuilder
            ->register(MoveMediaFiles::class, MoveMediaFiles::class)
            ->addArgument($this->containerBuilder->get(Finder::class))
            ->addArgument($this->containerBuilder->get(PathGenerator::class))
            ->addArgument($this->containerBuilder->get(Mover::class))
            ->addArgument($this->containerBuilder->get(LoggerInterface::class));
    }

    /**
     * @template T of object
     * @param class-string<T> $id
     *
     * @return T
     * @throws RuntimeException
     */
    public function get(string $id): mixed
    {
        /** @var T|null $service */
        $service = $this->containerBuilder->get($id);
        if ($service === null)
        {
            throw new RuntimeException(sprintf('Service not found %s', $id));
        }

        return $service;
    }
}
