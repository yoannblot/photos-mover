<?php

declare(strict_types=1);

namespace Unit\Domain\Type;

use App\Domain\Type\Directory;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class DirectoryTest extends TestCase
{
    #[Test]
    public function it_throws_an_invalid_argument_exception_when_directory_does_not_exist(): void
    {
        // Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Given directory 'fake-path' is not a directory.");

        // Arrange & Act
        new Directory('fake-path');
    }
}
