<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests\Feature\Http;

use Exception;
use Larakek\HealthCheck\Contracts\HealthChecker;
use Larakek\HealthCheck\ErrorBag;
use Larakek\HealthCheck\Tests\AbstractTest;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response;

class ControllerTest extends AbstractTest
{
    public function test_success_probe(): void
    {
        $this->mock(HealthChecker::class, function (MockInterface $mock) {
            $mock
                ->expects('run')
                ->once()
                ->andReturn(new ErrorBag());
        });

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
        $this->mock(HealthChecker::class, function (MockInterface $mock) {
            $errorBag = new ErrorBag();
            $errorBag->pushException('foo', new Exception('bar'));

            $mock
                ->expects('run')
                ->once()
                ->andReturn($errorBag);
        });

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
                    'Failed foo with message "bar"',
                ],
            ]);
    }


}
