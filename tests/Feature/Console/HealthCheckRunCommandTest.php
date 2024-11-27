<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests\Feature\Console;

use Exception;
use Larakek\HealthCheck\Contracts\HealthChecker;
use Larakek\HealthCheck\ErrorBag;
use Larakek\HealthCheck\Tests\TestCase;
use Mockery\MockInterface;

class HealthCheckRunCommandTest extends TestCase
{
    public function testSuccessProbe(): void
    {
        $this->mock(HealthChecker::class, function (MockInterface $mock) {
            $mock
                ->expects('run')
                ->once()
                ->andReturn(new ErrorBag());
        });

        $this->artisan('health-check:run')
            ->doesntExpectOutputToContain('Failed')
            ->assertSuccessful();
    }

    public function testOneFailedProbe(): void
    {
        $this->mock(HealthChecker::class, function (MockInterface $mock) {
            $errorBag = new ErrorBag();
            $errorBag->pushException('foo', new Exception('bar'));

            $mock
                ->expects('run')
                ->once()
                ->andReturn($errorBag);
        });

        $this->artisan('health-check:run')
            ->assertFailed()
            ->expectsOutput('Failed foo with message "bar"');
    }

    public function testTwoFailedProbes(): void
    {
        $this->mock(HealthChecker::class, function (MockInterface $mock) {
            $errorBag = new ErrorBag();
            $errorBag->pushException('foo', new Exception('bar'));
            $errorBag->pushException('bar', new Exception('baz'));

            $mock
                ->expects('run')
                ->once()
                ->andReturn($errorBag);
        });

        $this->artisan('health-check:run')
            ->assertFailed()
            ->expectsOutput('Failed foo with message "bar"')
            ->expectsOutput('Failed bar with message "baz"');
    }
}
