<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Probes;

use Illuminate\Contracts\Cache\Repository;
use Larakek\HealthCheck\Contracts\Probe;

class CacheConnectionProbe implements Probe
{
    private const CACHE_KEY = 'cache_connection_probe';

    public function __construct(private readonly Repository $cache) {}

    public function getName(): string
    {
        return class_basename($this);
    }

    public function isHealthy(): bool
    {
        $this->cache->has(self::CACHE_KEY);

        return true;
    }
}
