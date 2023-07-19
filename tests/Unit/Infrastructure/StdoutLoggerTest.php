<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure;

use App\Infrastructure\StdoutLogger;
use PHPUnit\Framework\TestCase;

final class StdoutLoggerTest extends TestCase
{
    private StdoutLogger $sut;

    protected function setUp(): void
    {
        $this->sut = new StdoutLogger();
    }

    public function testItLogsAMessageToStdout(): void
    {
        // Arrange & Act
        $this->sut->log('error', 'this message');

        // Assert
        $this->expectOutputString('[error] this message' . PHP_EOL);
    }
}
