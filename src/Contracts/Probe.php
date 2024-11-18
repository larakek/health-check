<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Contracts;

use Throwable;

interface Probe
{
    /**
     * Get probe name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Run probe.
     *
     * @return bool
     * @throws Throwable
     */
    public function isHealthy(): bool;
}
