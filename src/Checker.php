<?php

declare(strict_types=1);

namespace Larakek\HealthCheck;

use Larakek\HealthCheck\Contracts\HealthChecker;
use Larakek\HealthCheck\Contracts\Probe;
use Throwable;

class Checker implements HealthChecker
{
    /** @var array<Probe> */
    private array $probes = [];

    public function register(Probe $probe): void
    {
        $this->probes[] = $probe;
    }

    public function run(): ErrorBag
    {
        $resultBag = new ErrorBag();

        foreach ($this->probes as $probe) {
            try {
                $probe->isHealthy();
            } catch (Throwable $e) {
                $resultBag->addError(probeName: $probe->getName(), e: $e);
            }
        }

        return $resultBag;
    }
}
