<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Metadata;

use App\Domain\Type\File;
use App\Infrastructure\Metadata\DefaultFileMetadataReader;
use PHPUnit\Framework\TestCase;
use Tests\Helper\Directory as DirectoryHelper;
use Tests\Helper\Fixtures;

final class DefaultFileMetadataReaderTest extends TestCase
{
    public static function fileDataProvider(): array
    {
        return [
            'jpg' => [Fixtures::getJpgImageFile()],
            'png' => [Fixtures::getPngImageFile()],
            'mp4' => [Fixtures::getVideoFile()],
        ];
    }

    private DefaultFileMetadataReader $sut;

    protected function setUp(): void
    {
        $this->sut = new DefaultFileMetadataReader();
    }

    /**
     * @test
     * @dataProvider fileDataProvider
     */
    public function it_supports_everything(File $file): void
    {
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
        $file = Fixtures::createPngImageFile($sourceDirectory);

        // Act
        $metadata = $this->sut->extractMetadata($file);

        // Assert
        $now = new \DateTimeImmutable();
        $this->assertSame($now->format('Y-m-d'), $metadata->getDate()->format('Y-m-d'));
        unlink($file->getPath());
        DirectoryHelper::remove($sourceDirectory);
    }
}
