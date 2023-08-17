<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Metadata;

use App\Infrastructure\Metadata\ExifMetadataReader;
use PHPUnit\Framework\TestCase;
use Tests\Helper\Directory as DirectoryHelper;
use Tests\Helper\Fixtures;

final class ExifMetadataReaderTest extends TestCase
{
    private ExifMetadataReader $sut;

    protected function setUp(): void
    {
        $this->sut = new ExifMetadataReader();
    }

    /** @test */
    public function it_does_not_support_a_video_file(): void
    {
        // Arrange
        $file = Fixtures::getVideoFile();

        // Act
        $isSupported = $this->sut->supports($file);

        // Assert
        $this->assertFalse($isSupported);
    }

    /** @test */
    public function it_supports_an_image(): void
    {
        // Arrange
        $file = Fixtures::getImageFile();

        // Act
        $isSupported = $this->sut->supports($file);

        // Assert
        $this->assertTrue($isSupported);
    }

    /** @test */
    public function it_extracts_datetime(): void
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
