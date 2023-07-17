<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Mover;
use App\Type\File;
use PHPUnit\Framework\TestCase;

final class MoverTest extends TestCase
{
    private Mover $sut;

    protected function setUp(): void
    {
        $this->sut = new Mover();
    }

    /**
     * @test
     */
    public function it_creates_the_destination_directory_if_it_does_not_exist(): void
    {
        // Arrange
        $sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'source-file.txt';
        $destinationPath = __DIR__ . DIRECTORY_SEPARATOR . 'destination' . DIRECTORY_SEPARATOR . 'file.txt';
        file_put_contents($sourcePath, 'test');

        // Act
        $this->sut->move(new File($sourcePath), $destinationPath);

        // Assert
        $this->assertDirectoryExists(dirname($destinationPath));
        unlink($destinationPath);
        rmdir(dirname($destinationPath));
    }

    /**
     * @test
     */
    public function it_moves_a_file_into_a_directory(): void
    {
        // Arrange
        $sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'source-file.txt';
        $destinationPath = __DIR__ . DIRECTORY_SEPARATOR . 'destination-file.txt';
        file_put_contents($sourcePath, 'test');

        // Act
        $this->sut->move(new File($sourcePath), $destinationPath);

        // Assert
        $this->assertFileExists($destinationPath);
        $this->assertFileDoesNotExist($sourcePath);
        unlink($destinationPath);
    }
}
