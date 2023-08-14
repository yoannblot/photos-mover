<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Metadata;

use App\Infrastructure\Metadata\VideoNameMetadataReader;
use PHPUnit\Framework\TestCase;
use Tests\Helper\Fixtures;

final  class VideoNameMetadataReaderTest extends TestCase
{
    private VideoNameMetadataReader $sut;

    protected function setUp(): void
    {
        $this->sut = new VideoNameMetadataReader();
    }

    /** @test */
    public function it_does_not_support_an_image_file(): void
    {
        // Arrange
        $file = Fixtures::getImageFile();

        // Act
        $isSupported = $this->sut->supports($file);

        // Assert
        $this->assertFalse($isSupported);
    }

    /** @test */
    public function it_does_not_support_a_video_not_starting_with_VID(): void
    {
        // Arrange
        $file = Fixtures::getVideoFile();

        // Act
        $isSupported = $this->sut->supports($file);

        // Assert
        $this->assertFalse($isSupported);
    }

    /** @test */
    public function it_supports_a_video_starting_with_VID(): void
    {
        // Arrange
        $file = Fixtures::getVideoFileWithDateTimeInName();

        // Act
        $isSupported = $this->sut->supports($file);

        // Assert
        $this->assertTrue($isSupported);
    }

    /** @test */
    public function it_extracts_datetime_from_filename(): void
    {
        // Arrange
        $file = Fixtures::getVideoFileWithDateTimeInName();

        // Act
        $metadata = $this->sut->extractMetadata($file);

        // Assert
        $this->assertSame('2023-07-31 22:16:12', $metadata->getDate()->format('Y-m-d H:i:s'));
    }
}
