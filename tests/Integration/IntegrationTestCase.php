<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Kernel;
use PHPUnit\Framework\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    protected Kernel $app;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app = new Kernel();
    }
}
