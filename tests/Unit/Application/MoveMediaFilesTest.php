<?php

declare(strict_types=1);

namespace Tests\Unit\Application;

use App\Application\MoveMediaFiles;
use App\Domain\Finder;
use App\Domain\Metadata\FileMetadataReader;
use App\Domain\Mover;
use App\Domain\PathGenerator;
use App\Infrastructure\Metadata\ExifMetadataReader;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Tests\Helper\Directory as DirectoryHelper;
use Tests\Helper\Fixtures;

final class MoveMediaFilesTest extends TestCase
{
    private MoveMediaFiles $sut;

    protected function setUp(): void
    {
        $logger = new NullLogger();
        $this->sut = new MoveMediaFiles(
            new Finder(),
            new PathGenerator(
                new FileMetadataReader([
                    new ExifMetadataReader(),
                ])
            ),
            new Mover($logger),
            $logger,
        );
    }

    #[Test]
    public function it_moves_an_image_based_on_its_metadata(): void
    {
        // Arrange
        $sourceDirectory = DirectoryHelper::create('Fixtures-' . __FUNCTION__);
        $destinationDirectory = DirectoryHelper::create('Output-' . __FUNCTION__);
        Fixtures::duplicateImageIn($sourceDirectory);

        // Act
        $this->sut->move($sourceDirectory, $destinationDirectory);

        // Assert
        $today = new \DateTimeImmutable();
        $expectedImagePath = $destinationDirectory->getPath() . $today->format('Y')
            . DIRECTORY_SEPARATOR . $today->format('m')
            . DIRECTORY_SEPARATOR . $today->format('d')
            . DIRECTORY_SEPARATOR . 'image.jpg';
        $this->assertFileExists($expectedImagePath);

        unlink($expectedImagePath);
        DirectoryHelper::remove($destinationDirectory);
        DirectoryHelper::remove($sourceDirectory);
    }
}
