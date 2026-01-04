---
paths: tests/**/*.php
---

# Testing Conventions

Guidelines for writing tests in this project.

## Test Organization

- Tests mirror the source structure: `src/Domain/Foo.php` → `tests/Unit/Domain/FooTest.php`
- Unit tests in `tests/Unit/` - isolated class tests
- Integration tests in `tests/Integration/` - class interactions and real file operations

## Test Structure

Follow the **Arrange/Act/Assert (AAA) pattern**:

```php
public function test_it_validates_file_paths(): void
{
    // Arrange
    $file = Fixtures::getImageFile(ImageExtension::JPG);

    // Act
    $result = $file->isImage();

    // Assert
    $this->assertTrue($result);
}
```

## Test Method Naming

All test methods follow this pattern:

```
test_it_<describes_what_the_code_does>
```

Examples:
- `test_it_returns_true_when_file_is_an_image`
- `test_it_throws_invalid_argument_exception_when_file_does_not_exist`
- `test_it_extracts_metadata_from_jpeg_files`

## PHPUnit Attributes

Use PHP 8.4 Attributes for test configuration instead of docblocks:

### Parametrized Tests

```php
#[TestWith([ImageExtension::JPG])]
#[TestWith([ImageExtension::PNG])]
#[TestWith([ImageExtension::GIF])]
public function test_it_returns_true_when_file_is_an_image(ImageExtension $imageExtension): void
{
    $file = Fixtures::getImageFile($imageExtension);
    $this->assertTrue($file->isImage());
}
```

### Expected Exceptions

```php
public function test_it_throws_invalid_argument_exception_when_file_does_not_exist(): void
{
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("File 'fake-path' does not exist.");

    new File('fake-path');
}
```

## Test Fixtures

Use the `Tests\Helper\Fixtures` helper to create test data:

```php
use Tests\Helper\Fixtures;

$imageFile = Fixtures::getImageFile(ImageExtension::JPG);
$videoFile = Fixtures::getVideoFile(VideoExtension::MP4);
$textFile = Fixtures::getTextFile();
```

Fixtures create actual files in temp directories for testing.

## Comments in Tests

Only add comments where the logic isn't self-evident:

```php
// Good - logic is clear from method names
$file = Fixtures::getImageFile(ImageExtension::JPG);
$this->assertTrue($file->isImage());

// Avoid - comment just restates the code
// Create an image file
$file = Fixtures::getImageFile(ImageExtension::JPG);
```

## Assertions

Use descriptive assertions:

```php
// Good - clear what's being tested
$this->assertTrue($file->isImage());
$this->assertFalse($file->isVideo());
$this->assertSame('expected_value', $actual);
$this->assertNotNull($metadata->createdAt());

// Avoid
$this->assertTrue($x);  // What is $x?
$this->assertEquals($a, $b);  // Use assertSame for type-safe comparisons
```

## Running Tests

```bash
# All tests
make test-unit
make test-integration

# Specific test file
docker run --rm -v "$PWD:/app" --entrypoint ./vendor/bin/phpunit photos-mover tests/Unit/Domain/Type/FileTest.php

# Specific test method
docker run --rm -v "$PWD:/app" --entrypoint ./vendor/bin/phpunit photos-mover tests/Unit/Domain/Type/FileTest.php -m test_it_returns_true_when_file_is_an_image

# With verbose output
docker run --rm -v "$PWD:/app" --entrypoint ./vendor/bin/phpunit photos-mover tests/Unit/Domain/Type/FileTest.php --verbose
```

## Test File Structure

```php
<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Type;

use App\Domain\Type\File;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Tests\Helper\Fixtures;

final class FileTest extends TestCase
{
    public function test_it_returns_true_when_file_is_an_image(): void
    {
        // Arrange
        $file = Fixtures::getImageFile(ImageExtension::JPG);

        // Act
        $isImage = $file->isImage();

        // Assert
        $this->assertTrue($isImage);
    }
}
```

## Avoid Mocking

Do not use mock libraries or PHPUnit mocks. Instead:
- Use real objects and test fixtures (Fixtures helper)
- For external dependencies that can't be easily instantiated (file system, EXIF), use integration tests with real files
- Keep tests close to the actual behavior by avoiding mocks

This ensures tests reflect real-world usage and prevent false positives from overly-mocked tests.

## Integration Tests

- Use actual file operations with temp directories
- Test real class interactions
- Verify end-to-end workflows

Example integration test:
```php
public function test_it_moves_files_to_dated_directories(): void
{
    // Create source and destination directories
    $sourceDir = new Directory($this->tempDir . '/source');
    $destDir = new Directory($this->tempDir . '/dest');

    // Place test file in source
    // Execute the workflow
    // Verify files were moved to correct YYYY/MM/DD structure
}
```
