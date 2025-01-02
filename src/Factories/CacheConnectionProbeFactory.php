<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Factories;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Larakek\HealthCheck\Probes\CacheConnectionProbe;

class CacheConnectionProbeFactory
{
    /**
     * @param array<string,string> $params
     *
     * @throws BindingResolutionException
     */
    public function __invoke(array $params): CacheConnectionProbe
    {
        return new CacheConnectionProbe(
            cache: app()->make(Repository::class),
        );
    }
}
