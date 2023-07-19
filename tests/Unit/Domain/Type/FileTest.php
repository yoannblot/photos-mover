<?php

declare(strict_types=1);

namespace Unit\Domain\Type;

use App\Domain\Type\File;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Helper\Fixtures;

final class FileTest extends TestCase
{
    #[Test]
    public function it_throws_an_invalid_argument_exception_when_file_does_not_exist(): void
    {
        // Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("File 'fake-path' does not exist.");

        // Arrange & Act
        new File('fake-path');
    }

    #[Test]
    public function it_retrieves_directory_name(): void
    {
        // Arrange
        $file = new File(Fixtures::getTextFile()->getPath());

        // Act
        $directoryName = $file->getDirectory();

        // Assert
        $this->assertSame('text.txt', $directoryName);
    }

    #[Test]
    public function it_returns_true_when_file_is_an_image(): void
    {
        // Arrange
        $file = new File(Fixtures::getImageFile()->getPath());

        // Act
        $isImage = $file->isImage();

        // Assert
        $this->assertTrue($isImage);
    }

    #[Test]
    public function it_returns_false_when_file_is_not_an_image(): void
    {
        // Arrange
        $file = new File(Fixtures::getVideoFile()->getPath());

        // Act
        $isImage = $file->isImage();

        // Assert
        $this->assertFalse($isImage);
    }
}
