# Architecture

This document provides a detailed overview of the application architecture for developers who need to understand the system design and how components interact.

## Overview

The application follows clean architecture principles with strict separation of concerns across three layers:

```
Application Layer    → Use cases and orchestration
Domain Layer         → Core business logic (framework-independent)
Infrastructure Layer → Implementation details and external integrations
```

## Layers

### Application Layer (`src/Application/`)

**MoveMediaFiles.php**
- Main use case class that orchestrates the file-moving workflow
- Coordinates: Finder → PathGenerator → Mover
- Handles per-file error handling gracefully (logs warning but continues with next file)
- Logs all operations via PSR-3 LoggerInterface

```php
foreach ($this->finder->find($source) as $file) {
    try {
        $newFilePath = $this->pathGenerator->generate($destination, $file);
        $this->mover->move($file, $newFilePath);
    } catch (InvalidArgumentException) {
        // Log and continue with next file
    }
}
```

### Domain Layer (`src/Domain/`)

**Core business logic, independent of frameworks and external details.**

- **Finder**: Discovers media files in a directory
  - Filters by supported extensions (image/video enums)
  - Returns Generator of File objects

- **PathGenerator**: Determines target path for a file
  - Uses FileMetadataReader to extract creation date
  - Generates paths: `destination/YYYY/MM/DD/filename`
  - Throws InvalidArgumentException if metadata can't be extracted

- **Mover**: Handles actual file operations
  - Creates destination directories as needed
  - Moves file and logs outcome

- **Metadata/FileMetadataReader**: Strategy pattern chain
  - Tries each registered metadata reader until one succeeds
  - Throws InvalidArgumentException if no reader supports the file type
  - Readers implement FileReader interface with `supports()` and `extractMetadata()`

- **Type/** value objects:
  - `File`: Immutable file representation with validation
  - `Directory`: Immutable directory path representation
  - `FileMetadata`: Immutable metadata (currently just DateTimeImmutable)
  - `ImageExtension` enum: jpg, jpeg, png, gif, heic
  - `VideoExtension` enum: mp4, 3gp, mov

### Infrastructure Layer (`src/Infrastructure/`)

**Implementation details and external integrations.**

- **Metadata Readers** (pluggable via strategy pattern):
  - `ExifMetadataReader`: Reads EXIF FileDateTime from JPEG images
    - Only supports JPEG files (checked via exif_imagetype)
    - Most reliable for photos from cameras/phones

  - `VideoNameMetadataReader`: Parses video filenames
    - Expected format: `YYYY-MM-DD_*`
    - Useful for videos manually named with date
    - Falls back to filectime() if parsing fails

  - `DefaultFileMetadataReader`: Fallback reader
    - Uses PHP's filectime() (file creation time)
    - Works for any file type
    - Least reliable but always available

  - Reader chain in Kernel: ExifMetadataReader → VideoNameMetadataReader → DefaultFileMetadataReader

- **StdoutLogger**: PSR-3 compatible logger
  - Outputs directly to stdout
  - No dependency on logging framework

## Dependency Injection

The `Kernel.php` uses Symfony's DependencyInjection container:

```
metadata readers (chain)
    ↓
FileMetadataReader
    ↓
PathGenerator ← Mover
              ↓
          MoveMediaFiles ← Finder
                        ← LoggerInterface
```

Key wiring:
- Metadata readers registered as array passed to FileMetadataReader
- PathGenerator and Mover registered as services
- MoveMediaFiles depends on all the above plus LoggerInterface

## Design Patterns

1. **Strategy Pattern**: Metadata readers implement FileReader interface. FileMetadataReader tries each reader until one succeeds.

2. **Chain of Responsibility**: Multiple metadata reader strategies are chained in a specific order (most reliable first).

3. **Dependency Injection**: All dependencies injected via constructor, configured in Kernel.php container.

4. **Value Objects**: File, Directory, FileMetadata, and enums are immutable with validation. They represent domain concepts rather than persistence entities.

5. **Adapter Pattern**: Metadata readers adapt different sources (EXIF, filenames, filesystem metadata) to a common interface.

## Error Handling

- `InvalidArgumentException` is thrown by domain classes when:
  - File doesn't exist
  - No metadata reader supports the file
  - Metadata extraction fails

- Application layer (MoveMediaFiles) catches per-file errors and logs warnings, allowing the process to continue with other files.

- Integration layer tests verify that files are only moved if metadata can be successfully extracted.

## File Type Support

Supported formats defined as enums for type safety:

- **ImageExtension**: jpg, jpeg, png, gif, heic
- **VideoExtension**: mp4, 3gp, mov

Both enums implement validation in File class:
```php
public function isImage(): bool {
    return ImageExtension::tryFrom($this->getExtension()) !== null;
}
```

## Testing Architecture

- **Unit tests**: Test individual classes in isolation, mirror src/ structure
- **Integration tests**: Test class interactions and real file operations with temp directories
- Tests use Fixtures helper for test data, follow AAA (Arrange/Act/Assert) pattern
- PHPUnit 12.5 with Attributes for test configuration