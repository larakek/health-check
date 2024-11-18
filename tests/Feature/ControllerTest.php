<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests\Feature;

use Exception;
use Larakek\HealthCheck\Contracts\HealthChecker;
use Larakek\HealthCheck\Contracts\Probe;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ControllerTest extends TestCase
{
    use WithWorkbench;

    public function test_success_probe(): void
    {
        $checker = $this->app->get(HealthChecker::class);

        $mock = $this->mock(Probe::class);
        $mock->expects('getName')
            ->never();
        $mock->expects('isHealthy')
            ->once()
            ->andReturn();
        $checker->register($mock);

        $this
            ->get(route('healthcheck'))
            ->assertOk()
            ->assertJsonStructure(['message'])
            ->assertJson([
                'message' => 'ok',
            ]);
    }

    public function test_one_failed_probe(): void
    {
        /** @var HealthChecker $checker */
        $checker = $this->app->get(HealthChecker::class);

        $mock = $this->mock(Probe::class);
        $mock->expects('getName')
            ->once()
            ->andReturn('ShouldFailureProbe');
        $mock->expects('isHealthy')
            ->once()
            ->andThrow(new Exception('foo'));
        $checker->register($mock);

        $this
            ->get(route('healthcheck'))
            ->assertStatus(Response::HTTP_I_AM_A_TEAPOT)
            ->assertJsonStructure([
                'message',
                'errors',
            ])
            ->assertJson([
                'message' => 'ne ok',
                'errors' => [
                    'Failed ShouldFailureProbe with message "foo"',
                ],
            ]);
    }
}
