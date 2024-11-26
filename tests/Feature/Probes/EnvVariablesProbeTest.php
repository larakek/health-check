<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Tests\Feature\Probes;

use Illuminate\Validation\ValidationException;
use Larakek\HealthCheck\Probes\EnvVariablesProbe;
use Larakek\HealthCheck\ProbesResolver;
use Larakek\HealthCheck\Tests\AbstractTestCase;
use Throwable;

class EnvVariablesProbeTest extends AbstractTestCase
{
    /**
     * @throws Throwable
     */
    public function testThrowsException(): void
    {
        $probe = $this->app->make(ProbesResolver::class)->resolve(
            EnvVariablesProbe::class,
            ['FOO' => 'required', 'BAR' => 'required']
        );


        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('FOO (and 1 more error)');
        $probe->isHealthy();
    }
}
