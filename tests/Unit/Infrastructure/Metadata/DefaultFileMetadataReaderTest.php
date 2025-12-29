<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Metadata;

use App\Domain\Type\File;
use App\Infrastructure\Metadata\DefaultFileMetadataReader;
use DateTimeImmutable;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Helper\Directory as DirectoryHelper;
use Tests\Helper\Fixtures;

final class DefaultFileMetadataReaderTest extends TestCase
{
    /**
     * @return Iterator<string, array<File>>
     */
    public static function fileDataProvider(): Iterator
    {
        yield 'jpg' => [Fixtures::getJpgImageFile()];
        yield 'png' => [Fixtures::getPngImageFile()];
        yield 'mp4' => [Fixtures::getVideoFile()];
    }

    private DefaultFileMetadataReader $sut;

    public function test_it_extracts_datetime(): void
    {
        // Arrange
        $sourceDirectory = DirectoryHelper::create('Fixtures-' . __FUNCTION__);
        $file            = Fixtures::createPngImageFile($sourceDirectory);

        // Act
        $metadata = $this->sut->extractMetadata($file);

        // Assert
        $now = new DateTimeImmutable();
        $this->assertSame($now->format('Y-m-d'), $metadata->getDate()->format('Y-m-d'));
        unlink($file->getPath());
        DirectoryHelper::remove($sourceDirectory);
    }

    #[DataProvider('fileDataProvider')]
    public function test_it_supports_everything(File $file): void
    {
        // Act
        $isSupported = $this->sut->supports($file);

        // Assert
        $this->assertTrue($isSupported);
    }

    protected function setUp(): void
    {
        $this->sut = new DefaultFileMetadataReader();
    }
}
