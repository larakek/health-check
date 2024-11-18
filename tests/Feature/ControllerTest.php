<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests\Feature;

use Exception;
use Larakek\HealthCheck\Checker;
use Larakek\HealthCheck\Contracts\HealthChecker;
use Larakek\HealthCheck\Contracts\Probe;
use Mockery\MockInterface;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ControllerTest extends TestCase
{
    use WithWorkbench;

    public function test_success_probe(): void
    {
        $checker = new Checker();
        $this->app[HealthChecker::class] = $checker;
        $checker->register($this->makeSuccessProbe());

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
        $checker = new Checker();
        $this->app[HealthChecker::class] = $checker;
        $checker->register($this->makeFailureProbe('ShouldFailureProbe', 'foo'));

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

    /**
     * @return MockInterface|Probe
     */
    private function makeSuccessProbe(): MockInterface
    {
        $mock = $this->mock(Probe::class);
        $mock->expects('getName')->never();
        $mock->expects('isHealthy')->once()->andReturnTrue();

        return $mock;
    }

    /**
     * @return MockInterface|Probe
     */
    private function makeFailureProbe(string $name, string $errorMessage): MockInterface
    {
        $mock = $this->mock(Probe::class);
        $mock->expects('getName')->once()->andReturn($name);
        $mock->expects('isHealthy')->once()->andThrow(new Exception($errorMessage));

        return $mock;
    }
}
