<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Contracts;

use Throwable;

interface Probe
{
    /**
     * Get probe name.
     */
    public function getName(): string;

    /**
     * Run probe.
     *
     * @throws Throwable
     */
    public function isHealthy(): bool;
}
