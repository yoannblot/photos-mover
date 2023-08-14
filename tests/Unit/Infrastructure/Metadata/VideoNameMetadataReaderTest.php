<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Metadata;

use App\Domain\Type\File;
use App\Infrastructure\Metadata\VideoNameMetadataReader;
use PHPUnit\Framework\TestCase;
use Tests\Helper\Fixtures;

final  class VideoNameMetadataReaderTest extends TestCase
{
    public static function validVideoFilesProvider(): array
    {
        return [
            'VID' => ['VID20230731221612.mp4'],
            'VID and underscores' => ['VID_20230731_221612.mp4'],
            'VID and dash' => ['VID-20230731-WA0001.mp4'],
            'WP and underscores' => ['WP_20230731_22_16_12_Pro.mp4'],
        ];
    }

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
    public function it_does_not_support_a_video_not_starting_with_VID_nor_WP(): void
    {
        // Arrange
        $file = Fixtures::getVideoFile();

        // Act
        $isSupported = $this->sut->supports($file);

        // Assert
        $this->assertFalse($isSupported);
    }

    /**
     * @test
     * @dataProvider validVideoFilesProvider
     */
    public function it_supports_a_valid_video(string $fileName): void
    {
        // Arrange
        touch($fileName);
        $file = new File($fileName);

        // Act
        $isSupported = $this->sut->supports($file);

        // Assert
        $this->assertTrue($isSupported);
        unlink($fileName);
    }

    /**
     * @test
     * @dataProvider validVideoFilesProvider
     */
    public function it_extracts_datetime_from_filename(string $fileName): void
    {
        // Arrange
        touch($fileName);
        $file = new File($fileName);

        // Act
        $metadata = $this->sut->extractMetadata($file);

        // Assert
        $this->assertSame('2023-07-31', $metadata->getDate()->format('Y-m-d'));
        unlink($fileName);
    }
}
