<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Contracts;

interface Probe
{
    /**
     * @return bool
     */
    public function isHealthy(): bool;
}
