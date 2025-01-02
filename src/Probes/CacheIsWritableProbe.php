<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Probes;

use Exception;
use Illuminate\Contracts\Cache\Repository;
use Larakek\HealthCheck\Contracts\Probe;

class CacheIsWritableProbe implements Probe
{
    private const CACHE_KEY = 'cache_is_writable_probe';

    public function __construct(private readonly Repository $cache) {}

    public function getName(): string
    {
        return class_basename($this);
    }

    public function isHealthy(): bool
    {
        $this->cache->delete(self::CACHE_KEY);
        $this->cache->put(self::CACHE_KEY, $timestamp = now()->timestamp);

        if ($timestamp !== $this->cache->get(self::CACHE_KEY)) {
            throw new Exception(sprintf('%s returned incorrect value', $this->getName()));
        }

        return true;
    }
}
