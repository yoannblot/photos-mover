<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Psr\Log\AbstractLogger;

final class StdoutLogger extends AbstractLogger
{
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        printf("[%s] %s" . PHP_EOL, $level, $message);
    }
}
