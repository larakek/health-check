<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Factories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\ConnectionResolverInterface;
use Larakek\HealthCheck\Probes\DatabaseConnectionProbe;

class DatabaseConnectionProbeFactory
{
    /**
     * @param  array<string,string>  $params
     *
     * @throws BindingResolutionException
     */
    public function __invoke(array $params): DatabaseConnectionProbe
    {
        return new DatabaseConnectionProbe(
            connectionName: $params['connection_name'],
            connectionResolver: app()->make(ConnectionResolverInterface::class),
        );
    }
}
