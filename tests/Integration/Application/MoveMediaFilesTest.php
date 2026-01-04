<?php

declare(strict_types=1);

namespace Tests\Integration\Application;

use App\Application\MoveMediaFiles;
use App\Domain\Type\ImageExtension;
use App\Domain\Type\VideoExtension;
use DateTimeImmutable;
use Override;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\Helper\Directory as DirectoryHelper;
use Tests\Helper\Fixtures;
use Tests\Integration\IntegrationTestCase;

final class MoveMediaFilesTest extends IntegrationTestCase
{
    private MoveMediaFiles $sut;

    #[TestWith([VideoExtension::MP4, 'vid20230731221612.mp4'])]
    #[TestWith([VideoExtension::THREE_GP, 'vid_20230731_221612.3gp'])]
    public function test_it_moves_a_video_based_on_its_metadata(VideoExtension $videoExtension, string $fileName): void
    {
        // Arrange
        $sourceDirectory      = DirectoryHelper::create('Fixtures-video-' . $videoExtension->value);
        $destinationDirectory = DirectoryHelper::create('Output-video-' . $videoExtension->value);
        Fixtures::duplicateVideoIn($sourceDirectory, $videoExtension);

        // Act
        $this->sut->move($sourceDirectory, $destinationDirectory);

        // Assert
        $expectedVideoPath = $destinationDirectory->getPath() . '2023' . DIRECTORY_SEPARATOR;
        $expectedVideoPath .= '07' . DIRECTORY_SEPARATOR;
        $expectedVideoPath .= '31' . DIRECTORY_SEPARATOR;
        $expectedVideoPath .= $fileName;
        $this->assertFileExists($expectedVideoPath);

        unlink($expectedVideoPath);
        DirectoryHelper::remove($destinationDirectory);
        DirectoryHelper::remove($sourceDirectory);
    }

    #[TestWith([ImageExtension::HEIC])]
    #[TestWith([ImageExtension::JPG])]
    #[TestWith([ImageExtension::PNG])]
    public function test_it_moves_an_image_based_on_its_metadata(ImageExtension $imageExtension): void
    {
        // Arrange
        $sourceDirectory      = DirectoryHelper::create('Fixtures-image-' . $imageExtension->value);
        $destinationDirectory = DirectoryHelper::create('Output-image-' . $imageExtension->value);
        Fixtures::duplicateImageIn($sourceDirectory, $imageExtension);

        // Act
        $this->sut->move($sourceDirectory, $destinationDirectory);

        // Assert
        $today             = new DateTimeImmutable();
        $expectedImagePath = $destinationDirectory->getPath() . $today->format('Y') . DIRECTORY_SEPARATOR;
        $expectedImagePath .= $today->format('m') . DIRECTORY_SEPARATOR . $today->format('d') . DIRECTORY_SEPARATOR;
        $expectedImagePath .= 'image.' . $imageExtension->value;
        $this->assertFileExists($expectedImagePath);

        unlink($expectedImagePath);
        DirectoryHelper::remove($destinationDirectory);
        DirectoryHelper::remove($sourceDirectory);
    }

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = $this->app->get(MoveMediaFiles::class);
    }
}
