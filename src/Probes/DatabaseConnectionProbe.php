<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Probes;

use Illuminate\Database\ConnectionResolverInterface;
use Larakek\HealthCheck\Contracts\Probe;

class DatabaseConnectionProbe implements Probe
{
    public function __construct(
        private readonly string $connectionName,
        private readonly ConnectionResolverInterface $connectionResolver,
    ) {}

    public function getName(): string
    {
        return sprintf('%s (connection %s)', class_basename($this), $this->connectionName);
    }

    public function isHealthy(): bool
    {
        $this->connectionResolver
            ->connection($this->connectionName)
            ->select('select true');

        return true;
    }
}
