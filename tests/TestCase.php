<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests;

use Larakek\HealthCheck\HealthCheckServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as OrchestraTestbenchTestCase;

abstract class TestCase extends OrchestraTestbenchTestCase
{
    use WithWorkbench;

    /**
     * Load package service provider.
     */
    protected function getPackageProviders($app): array
    {
        return [
            HealthCheckServiceProvider::class,
        ];
    }
}
