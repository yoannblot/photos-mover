# CLAUDE.md

**photos-mover** is a PHP 8.4 CLI application that organizes photos and videos by creation date (YYYY/MM/DD structure) using metadata extraction.

## Development Setup

All tasks use Make commands:

```bash
make up                 # Build Docker image
make install            # Install dependencies
make format             # Auto-format code (Mago lint + Rector + Mago format)
make quality            # Run code quality analysis
make test-unit          # Run unit tests
make test-integration   # Run integration tests
make shell              # Interactive bash in container
make clean              # Remove all containers/images/vendor
```

Typical workflow:
```bash
make up && make install    # Initial setup
make format && make test-unit   # After making changes
```

## Running Tests

```bash
# All tests or by suite
make test-unit
make test-integration

# Specific test file via Docker
docker run --rm -v "$PWD:/app" --entrypoint ./vendor/bin/phpunit photos-mover tests/Unit/Domain/Type/FileTest.php

# Specific test method
docker run --rm -v "$PWD:/app" --entrypoint ./vendor/bin/phpunit photos-mover tests/Unit/Domain/Type/FileTest.php -m test_it_returns_true_when_file_is_an_image
```

## Project Structure

```
src/
├── Application/     # Use cases (MoveMediaFiles orchestrates the workflow)
├── Domain/          # Core logic (Finder, PathGenerator, Mover, Metadata readers)
└── Infrastructure/  # Adapters (EXIF reader, filename parser, stdout logger)

tests/
├── Unit/            # Isolated class tests, mirror src/ structure
└── Integration/     # End-to-end workflows with real file operations
```

## Code Style

Code style is automated via `make format` (runs Mago lint, Rector, Mago format). Key conventions enforced:
- `declare(strict_types=1)` on all files
- `App\` namespace for source, `Tests\` for tests
- PSR-4 autoloading
- Constructor injection, `final readonly` for immutability
- Test methods: `test_it_<describes_behavior>` with Arrange/Act/Assert pattern

No need to manually check style—let the linter handle it.
