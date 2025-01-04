<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests\Feature\Probes;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Larakek\HealthCheck\Probes\PathsAreWritableProbe;
use Larakek\HealthCheck\Tests\TestCase;
use Mockery\MockInterface;
use Throwable;

class PathsAreWritableProbeTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testSuccessProbe(): void
    {
        $probe = new PathsAreWritableProbe(
            $this->app->make(Filesystem::class),
            $this->app,
            ['paths' => []],
        );

        self::assertNotEmpty($probe->getName());
        self::assertTrue($probe->isHealthy());
    }

    /**
     * @throws Throwable
     */
    public function testFailedProbe(): void
    {
        $filesystemMock = $this->mock(Filesystem::class, function (MockInterface $mock) {
            $mock
                ->expects('isWritable')
                ->once()
                ->andReturnFalse();
        });

        $applicationMock = $this->mock(Application::class, function (MockInterface $mock) {
            $mock
                ->expects('basePath')
                ->once()
                ->andReturn('/tmp');
        });

        $probe = new PathsAreWritableProbe($filesystemMock, $applicationMock, ['/tmp']);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Path /tmp is not writable');

        $probe->isHealthy();
    }
}
