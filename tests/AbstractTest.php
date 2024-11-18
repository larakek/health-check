<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests;

use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;

abstract class AbstractTest extends TestCase
{
    use WithWorkbench;
}
