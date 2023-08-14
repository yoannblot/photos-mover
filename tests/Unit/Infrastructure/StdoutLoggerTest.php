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

    /** @test */
    public function it_logs_a_message_to_stdout(): void
    {
        // Arrange & Act
        $this->sut->log('error', 'this message');

        // Assert
        $this->expectOutputString('[error] this message' . PHP_EOL);
    }
}
