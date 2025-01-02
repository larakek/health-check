<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Factories;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Larakek\HealthCheck\Probes\CacheIsWritableProbe;

class CacheIsWritableProbeFactory
{
    /**
     * @param array<string,string> $params
     *
     * @throws BindingResolutionException
     */
    public function __invoke(array $params): CacheIsWritableProbe
    {
        return new CacheIsWritableProbe(
            cache: app()->make(Repository::class),
        );
    }
}
