<?php

declare(strict_types=1);

namespace App\Type;

use DateTimeImmutable;

final class FileMetadata
{
    private DateTimeImmutable $date;

    public function __construct(DateTimeImmutable $date)
    {
        $this->date = $date;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
