<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests\Feature\Probes;

use Illuminate\Validation\ValidationException;
use Larakek\HealthCheck\Probes\EnvVariablesProbe;
use Larakek\HealthCheck\Tests\AbstractTestCase;
use Throwable;

class EnvVariablesProbeTest extends AbstractTestCase
{
    /**
     * @throws Throwable
     */
    public function testSuccessProbe(): void
    {
        $probe = new EnvVariablesProbe(
            name: 'example success probe',
            data: [],
            rules: [],
            messages: [],
        );

        self::assertTrue($probe->isHealthy());
    }

    /**
     * @throws Throwable
     */
    public function testThrowsException(): void
    {
        $probe = new EnvVariablesProbe(
            name: 'example failure probe',
            data: [],
            rules: ['FOO' => 'required', 'BAR' => 'required'],
            messages: ['FOO' => 'FOO'],
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('FOO (and 1 more error)');
        $probe->isHealthy();
    }
}
