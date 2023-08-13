<?php

declare(strict_types=1);

namespace Tests\Integration\Domain\Metadata;

use App\Domain\Metadata\FileMetadataReader;
use PHPUnit\Framework\Attributes\Test;
use Tests\Helper\Fixtures;
use Tests\Integration\IntegrationTestCase;

final class FileMetadataReaderTest extends IntegrationTestCase
{
    private FileMetadataReader $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = $this->app->get(FileMetadataReader::class);
    }

    #[Test]
    public function it_throws_an_invalid_argument_exception_when_file_is_not_supported(): void
    {
        // Arrange
        $file = Fixtures::getTextFile();

        // Assert
        $this->expectException(\InvalidArgumentException::class);

        // Act
        $this->sut->extractMetadata($file);
    }

    #[Test]
    public function it_extracts_metadata_from_exif_for_an_image(): void
    {
        // Arrange
        $file = Fixtures::getImageFile();

        // Act
        $metadata = $this->sut->extractMetadata($file);

        // Assert
        $this->assertSame('2023-06-12 16:24:17', $metadata->getDate()->format('Y-m-d H:i:s'));
    }
}
