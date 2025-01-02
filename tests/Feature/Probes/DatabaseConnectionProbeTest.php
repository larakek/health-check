<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests\Feature\Probes;

use Illuminate\Database\ConnectionResolverInterface;
use Larakek\HealthCheck\Probes\DatabaseConnectionProbe;
use Larakek\HealthCheck\Tests\TestCase;
use Throwable;

class DatabaseConnectionProbeTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testSuccessProbe(): void
    {
        $probe = new DatabaseConnectionProbe(config('database.default'), $this->app->make(ConnectionResolverInterface::class));

        self::assertTrue($probe->isHealthy());
    }

    /**
     * @throws Throwable
     */
    public function testFailedProbe(): void
    {
        $probe = new DatabaseConnectionProbe('unknown', $this->app->make(ConnectionResolverInterface::class));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Database connection [unknown] not configured.');

        $probe->isHealthy();
    }
}
