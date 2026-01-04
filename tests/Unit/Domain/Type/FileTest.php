<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Type;

use App\Domain\Type\File;
use App\Domain\Type\ImageExtension;
use App\Domain\Type\VideoExtension;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Tests\Helper\Fixtures;

final class FileTest extends TestCase
{
    public function test_it_retrieves_directory_name(): void
    {
        // Arrange
        $file = new File(Fixtures::getTextFile()->getPath());

        // Act
        $directoryName = $file->getDirectory();

        // Assert
        $this->assertSame('text.txt', $directoryName);
    }

    public function test_it_returns_false_when_file_is_not_a_video(): void
    {
        // Arrange
        $file = Fixtures::getImageFile(ImageExtension::JPG);

        // Act
        $isVideo = $file->isVideo();

        // Assert
        $this->assertFalse($isVideo);
    }

    public function test_it_returns_false_when_file_is_not_an_image(): void
    {
        // Arrange
        $file = new File(Fixtures::getGenericVideoFile()->getPath());

        // Act
        $isImage = $file->isImage();

        // Assert
        $this->assertFalse($isImage);
    }

    #[TestWith([VideoExtension::MP4])]
    #[TestWith([VideoExtension::THREE_GP])]
    #[TestWith([VideoExtension::MOV])]
    public function test_it_returns_true_when_file_is_a_video(VideoExtension $videoExtension): void
    {
        // Arrange
        $file = new File(Fixtures::getVideoFile($videoExtension)->getPath());

        // Act
        $isVideo = $file->isVideo();

        // Assert
        $this->assertTrue($isVideo);
    }

    #[TestWith([ImageExtension::JPG])]
    #[TestWith([ImageExtension::PNG])]
    #[TestWith([ImageExtension::HEIC])]
    public function test_it_returns_true_when_file_is_an_image(ImageExtension $imageExtension): void
    {
        // Arrange
        $file = Fixtures::getImageFile($imageExtension);

        // Act
        $isImage = $file->isImage();

        // Assert
        $this->assertTrue($isImage);
    }

    public function test_it_throws_an_invalid_argument_exception_when_file_does_not_exist(): void
    {
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File 'fake-path' does not exist.");

        // Act
        new File('fake-path');
    }
}
