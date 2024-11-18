<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Probes;

use Larakek\HealthCheck\Contracts\Probe;

class FailureProbe implements Probe
{
    public function getName(): string
    {
        return 'failure probe';
    }

    public function isHealthy(): bool
    {
        throw new \Exception('kek');
    }
}
