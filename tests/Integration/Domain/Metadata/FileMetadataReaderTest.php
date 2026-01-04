<?php

declare(strict_types=1);

namespace Tests\Integration\Domain\Metadata;

use App\Domain\Metadata\FileMetadataReader;
use App\Domain\Type\ImageExtension;
use DateTimeImmutable;
use InvalidArgumentException;
use Override;
use Tests\Helper\Directory as DirectoryHelper;
use Tests\Helper\Fixtures;
use Tests\Integration\IntegrationTestCase;

final class FileMetadataReaderTest extends IntegrationTestCase
{
    private FileMetadataReader $sut;

    public function test_it_extracts_metadata_from_exif_for_an_image(): void
    {
        // Arrange
        $sourceDirectory = DirectoryHelper::create('Fixtures-' . __FUNCTION__);
        $file            = Fixtures::createImageFile($sourceDirectory, ImageExtension::JPG);

        // Act
        $metadata = $this->sut->extractMetadata($file);

        // Assert
        $now = new DateTimeImmutable();
        $this->assertSame($now->format('Y-m-d'), $metadata->getDate()->format('Y-m-d'));
        unlink($file->getPath());
        DirectoryHelper::remove($sourceDirectory);
    }

    public function test_it_throws_an_invalid_argument_exception_when_file_is_not_supported(): void
    {
        $file = Fixtures::getTextFile();

        $this->expectException(InvalidArgumentException::class);

        $this->sut->extractMetadata($file);
    }

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = $this->app->get(FileMetadataReader::class);
    }
}
