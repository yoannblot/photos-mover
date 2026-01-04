# photos-mover

A PHP CLI application that automatically organizes your photos and videos by moving them into date-based directories. Files are organized by their creation date in `YYYY/MM/DD` format.

## Features

- **Automatic Organization**: Moves photos and videos into directories organized by creation date
- **Metadata Extraction**: Uses EXIF data, filename patterns, and file timestamps to determine creation date
- **Multiple Format Support**: Supports images (JPG, JPEG, GIF, PNG) and videos (MP4, MOV, 3GP, AVI)
- **Batch Processing**: Optional limit to process only N files per run
- **Docker Support**: Run in Docker for consistent environments

## Requirements

- **PHP 8.4** or higher
- Composer
- Docker (optional, for containerized execution)

## Installation

```bash
# Clone the repository
git clone <repository-url>
cd photos-mover

# Build Docker image
make up

# Install dependencies
make install
```

## Usage

### Basic Usage

Move files from a source directory to a destination organized by date:

```bash
php photos-mover.php /path/to/photos /path/to/organized
```

## Supported File Types

**Images**: JPG, JPEG, GIF, PNG
**Videos**: MP4, MOV, 3GP

## How It Works

1. **Discover Files**: Scans the source directory for supported image and video files
2. **Extract Metadata**: Determines the creation date using:
   - EXIF data (for images with EXIF metadata)
   - Filename pattern `YYYY-MM-DD_*` (for videos)
   - File creation/modification timestamps (fallback)
3. **Generate Paths**: Creates destination paths in `destination/YYYY/MM/DD/filename` format
4. **Move Files**: Moves files to their destination, creating directories as needed

## Development

### Running Tests

```bash
# Run unit tests
make test-unit

# Run integration tests
make test-integration
```

### Code Quality

```bash
# Auto format and refactor code
make format

# Run code quality analysis
make quality
```

### Shell Access

Access an interactive shell in the container:
```bash
make shell
```

### Cleanup

Remove all containers, images, and vendor files:
```bash
make clean
```

## Architecture

The application follows clean architecture principles:

- **Application Layer**: Orchestrates the file-moving workflow
- **Domain Layer**: Core business logic (Finder, PathGenerator, Mover, MetadataReaders)
- **Infrastructure Layer**: External integrations (Logger, Metadata readers)
