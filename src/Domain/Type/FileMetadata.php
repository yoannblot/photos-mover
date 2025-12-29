<?php

declare(strict_types=1);

namespace App\Domain\Type;

use DateTimeImmutable;

final readonly class FileMetadata
{
    public function __construct(
        private DateTimeImmutable $date,
    ) {}

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
