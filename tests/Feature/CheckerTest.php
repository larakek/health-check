<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests\Feature;

use Exception;
use Larakek\HealthCheck\Checker;
use Larakek\HealthCheck\Contracts\Probe;
use Larakek\HealthCheck\Tests\TestCase;
use Mockery\MockInterface;

class CheckerTest extends TestCase
{
    public function testSuccessProbe(): void
    {
        $checker = new Checker();
        $checker->register($this->mock(Probe::class, function (MockInterface $mock) {
            $mock
                ->expects('isHealthy')
                ->once()
                ->andReturnTrue();
        }));
        $errorBag = $checker->run();

        self::assertFalse($errorBag->hasFailed());
    }

    public function testFailedProbe(): void
    {
        $checker = new Checker();
        $checker->register($this->mock(Probe::class, function (MockInterface $mock) {
            $mock
                ->expects('isHealthy')
                ->once()
                ->andThrows(new Exception('Something went wrong'));
            $mock
                ->expects('getName')
                ->once()
                ->andReturn('FailedProbe');
        }));
        $errorBag = $checker->run();

        self::assertTrue($errorBag->hasFailed());
    }
}
