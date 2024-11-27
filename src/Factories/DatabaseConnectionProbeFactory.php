<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Factories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\DatabaseManager;
use Larakek\HealthCheck\Probes\DatabaseConnectionProbe;

class DatabaseConnectionProbeFactory
{
    /**
     * @param array<string,string> $params
     * @throws BindingResolutionException
     */
    public function __invoke(array $params): DatabaseConnectionProbe
    {
        return new DatabaseConnectionProbe(
            connection: $params['connection_name'],
            databaseManager: app()->make(DatabaseManager::class),
        );
    }
}
