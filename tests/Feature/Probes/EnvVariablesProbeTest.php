<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests\Feature\Probes;

use Illuminate\Validation\ValidationException;
use Larakek\HealthCheck\Probes\EnvVariablesProbe;
use Larakek\HealthCheck\Tests\TestCase;
use Throwable;

class EnvVariablesProbeTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testSuccessProbe(): void
    {
        $probe = new EnvVariablesProbe(
            data: [],
            rules: [],
            messages: [],
            attributes: [],
        );

        self::assertTrue($probe->isHealthy());
    }

    /**
     * @throws Throwable
     */
    public function testThrowsException(): void
    {
        $probe = new EnvVariablesProbe(
            data: [],
            rules: ['FOO' => 'required', 'BAR' => 'required'],
            messages: [],
            attributes: ['FOO' => 'FOO'],
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The FOO field is required. (and 1 more error)');
        $probe->isHealthy();
    }
}
