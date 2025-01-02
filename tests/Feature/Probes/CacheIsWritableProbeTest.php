<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests\Feature\Probes;

use Illuminate\Contracts\Cache\Repository;
use Larakek\HealthCheck\Probes\CacheIsWritableProbe;
use Larakek\HealthCheck\Tests\TestCase;
use Throwable;

class CacheIsWritableProbeTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testSuccessProbe(): void
    {
        $probe = new CacheIsWritableProbe($this->app->make(Repository::class), 'foo');

        self::assertTrue($probe->isHealthy());
    }

    /**
     * @throws Throwable
     */
    public function testFailedProbe(): void
    {
        $mock = $this->mock(Repository::class);
        $mock
            ->expects('put')
            ->once()
            ->andReturnTrue();
        $mock
            ->expects('get')
            ->once()
            ->andReturn('some str');
        $mock
            ->expects('delete')
            ->once()
            ->andReturnTrue();

        $probe = new CacheIsWritableProbe($mock, 'bar');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('CacheIsWritableProbe received incorrect value');

        $probe->isHealthy();
    }

    /**
     * @throws Throwable
     */
    public function testFailedWriteProbe(): void
    {
        $mock = $this->mock(Repository::class);
        $mock
            ->expects('put')
            ->once()
            ->andThrows($exception = new \Exception('Cannot write'));

        $probe = new CacheIsWritableProbe($mock, 'bar');

        $this->expectExceptionObject($exception);

        $probe->isHealthy();
    }
}
