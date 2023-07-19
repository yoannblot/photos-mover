<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Metadata;

use App\Domain\Metadata\ImageReader;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Helper\Fixtures;

final class ImageReaderTest extends TestCase
{
    private ImageReader $sut;

    protected function setUp(): void
    {
        $this->sut = new ImageReader();
    }

    #[Test]
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
