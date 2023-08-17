<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Metadata;

use App\Domain\Metadata\FileMetadataReader;
use App\Infrastructure\Metadata\ExifMetadataReader;
use PHPUnit\Framework\TestCase;
use Tests\Helper\Directory as DirectoryHelper;
use Tests\Helper\Fixtures;

final class FileMetadataReaderTest extends TestCase
{
    private FileMetadataReader $sut;

    protected function setUp(): void
    {
        $this->sut = new FileMetadataReader([new ExifMetadataReader()]);
    }

    /** @test */
    public function it_throws_an_invalid_argument_exception_when_file_is_not_supported(): void
    {
        // Arrange
        $file = Fixtures::getTextFile();

        // Assert
        $this->expectException(\InvalidArgumentException::class);

        // Act
        $this->sut->extractMetadata($file);
    }

    /** @test */
    public function it_extracts_metadata_from_exif_for_an_image(): void
    {
        // Arrange
        $sourceDirectory = DirectoryHelper::create('Fixtures-' . __FUNCTION__);
        $file = Fixtures::createImageFile($sourceDirectory);

        // Act
        $metadata = $this->sut->extractMetadata($file);

        // Assert
        $now = new \DateTimeImmutable();
        $this->assertSame($now->format('Y-m-d'), $metadata->getDate()->format('Y-m-d'));
        unlink($file->getPath());
        DirectoryHelper::remove($sourceDirectory);
    }
}
