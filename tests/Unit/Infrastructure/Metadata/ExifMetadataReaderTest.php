<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Metadata;

use App\Infrastructure\Metadata\ExifMetadataReader;
use PHPUnit\Framework\TestCase;
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
        $file = Fixtures::getImageFile();

        // Act
        $metadata = $this->sut->extractMetadata($file);

        // Assert
        $this->assertSame('2023-06-12 16:24:17', $metadata->getDate()->format('Y-m-d H:i:s'));
    }
}
