<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use App\Domain\Finder;
use App\Domain\Type\Directory;
use FilesystemIterator;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

final class FinderTest extends TestCase
{
    private Finder $sut;

    private Directory $directory;

    public function test_it_finds_a_video(): void
    {
        // Arrange
        $this->createFile('test.mp4');

        // Act
        $files = $this->sut->find($this->directory);

        // Assert
        $this->assertCount(1, $files);
        $file = $files[0];
        $this->assertSame('test.mp4', $file->getFileName());
        $this->assertTrue($file->isVideo());
    }

    public function test_it_finds_an_image(): void
    {
        // Arrange
        $this->createFile('test.jpg');

        // Act
        $files = $this->sut->find($this->directory);

        // Assert
        $this->assertCount(1, $files);
        $file = $files[0];
        $this->assertSame('test.jpg', $file->getFileName());
        $this->assertTrue($file->isImage());
    }

    public function test_it_finds_files_only_in_root_directory(): void
    {
        // Arrange
        $this->createFile('test.jpg');
        $this->createFile('test.mp4');
        mkdir($this->directory->getPath() . DIRECTORY_SEPARATOR . 'sub');
        $this->createFile('sub' . DIRECTORY_SEPARATOR . 'test2.mp4');

        // Act
        $files = $this->sut->find($this->directory);

        // Assert
        $this->assertCount(2, $files);
    }

    protected function setUp(): void
    {
        $this->sut = new Finder();
        $directoryPath = __DIR__ . DIRECTORY_SEPARATOR . 'tmp';
        mkdir($directoryPath);
        $this->directory = new Directory($directoryPath);
    }

    protected function tearDown(): void
    {
        $di = new RecursiveDirectoryIterator($this->directory->getPath(), FilesystemIterator::SKIP_DOTS);
        $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($ri as $file)
        {
            /** @var SplFileInfo $file */
            $filePath = $file->getRealPath();
            if ($filePath === false)
            {
                continue;
            }

            $file->isDir() ? rmdir($filePath) : unlink($filePath);
        }

        rmdir($this->directory->getPath());
    }

    private function createFile(string $fileName): void
    {
        $sourcePath = $this->directory->getPath() . $fileName;
        file_put_contents($sourcePath, 'test');
    }
}
