<?php

declare(strict_types=1);

namespace Tests\Integration\Application;

use App\Application\MoveMediaFiles;
use Tests\Helper\Directory as DirectoryHelper;
use Tests\Helper\Fixtures;
use Tests\Integration\IntegrationTestCase;

final class MoveMediaFilesTest extends IntegrationTestCase
{
    private MoveMediaFiles $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = $this->app->get(MoveMediaFiles::class);
    }

    /** @test */
    public function it_moves_an_image_based_on_its_metadata(): void
    {
        // Arrange
        $sourceDirectory = DirectoryHelper::create('Fixtures-' . __FUNCTION__);
        $destinationDirectory = DirectoryHelper::create('Output-' . __FUNCTION__);
        Fixtures::duplicateImageIn($sourceDirectory);

        // Act
        $this->sut->move($sourceDirectory, $destinationDirectory);

        // Assert
        $today = new \DateTimeImmutable();
        $expectedImagePath = $destinationDirectory->getPath() . $today->format('Y')
            . DIRECTORY_SEPARATOR . $today->format('m')
            . DIRECTORY_SEPARATOR . $today->format('d')
            . DIRECTORY_SEPARATOR . 'image.jpg';
        $this->assertFileExists($expectedImagePath);

        unlink($expectedImagePath);
        DirectoryHelper::remove($destinationDirectory);
        DirectoryHelper::remove($sourceDirectory);
    }

    /** @test */
    public function it_moves_a_video_based_on_its_metadata(): void
    {
        // Arrange
        $sourceDirectory = DirectoryHelper::create('Fixtures-' . __FUNCTION__);
        $destinationDirectory = DirectoryHelper::create('Output-' . __FUNCTION__);
        Fixtures::duplicateVideoIn($sourceDirectory);

        // Act
        $this->sut->move($sourceDirectory, $destinationDirectory);

        // Assert
        $expectedVideoPath = $destinationDirectory->getPath() . '2023'
            . DIRECTORY_SEPARATOR . '07'
            . DIRECTORY_SEPARATOR . '31'
            . DIRECTORY_SEPARATOR . 'VID20230731221612.mp4';
        $this->assertFileExists($expectedVideoPath);

        unlink($expectedVideoPath);
        DirectoryHelper::remove($destinationDirectory);
        DirectoryHelper::remove($sourceDirectory);
    }
}
