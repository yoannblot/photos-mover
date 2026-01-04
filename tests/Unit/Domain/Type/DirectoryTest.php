<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Type;

use App\Domain\Type\Directory;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class DirectoryTest extends TestCase
{
    public function test_it_throws_an_invalid_argument_exception_when_directory_does_not_exist(): void
    {
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Given directory 'fake-path' is not a directory.");

        // Arrange & Act
        new Directory('fake-path');
    }
}
