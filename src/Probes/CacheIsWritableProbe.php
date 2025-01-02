<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Probes;

use Exception;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Str;
use Larakek\HealthCheck\Contracts\Probe;

class CacheIsWritableProbe implements Probe
{
    public function __construct(private readonly Repository $cache, private string $cacheKey) {}

    public function getName(): string
    {
        return class_basename($this);
    }

    public function isHealthy(): bool
    {
        $expectedValue = Str::random(8);
        $cacheKey = sprintf('%s_%s', $this->cacheKey, now()->timestamp);
        $this->cache->put($cacheKey, $expectedValue, now()->addSeconds(10));
        $actualValue = $this->cache->get($cacheKey);
        $this->cache->delete($cacheKey);

        if ($expectedValue !== $actualValue) {
            throw new Exception(sprintf('%s received incorrect value', $this->getName()));
        }

        return true;
    }
}
