<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Contracts;

use Larakek\HealthCheck\ErrorBag;

interface HealthChecker
{
    /**
     * Push the simple probe into the end of queue
     *
     * @param Probe $probe
     * @return void
     */
    public function register(Probe $probe): void;

    /**
     * Run all probes
     */
    public function run(): ErrorBag;
}
