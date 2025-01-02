<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests\Feature\Probes;

use Exception;
use Illuminate\Contracts\Cache\Repository;
use Larakek\HealthCheck\Probes\CacheConnectionProbe;
use Larakek\HealthCheck\Tests\TestCase;
use Throwable;

class CacheConnectionProbeTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testSuccessProbe(): void
    {
        $probe = new CacheConnectionProbe($this->app->make(Repository::class));

        self::assertTrue($probe->isHealthy());
    }

    /**
     * @throws Throwable
     */
    public function testFailedProbe(): void
    {
        $mock = $this->mock(Repository::class);
        $mock
            ->expects('has')
            ->once()
            ->andThrows($exception = new Exception('Something went wrong'));

        $probe = new CacheConnectionProbe($mock);

        $this->expectExceptionObject($exception);

        $probe->isHealthy();
    }
}
