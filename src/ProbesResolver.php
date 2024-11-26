<?php

declare(strict_types=1);

namespace Larakek\HealthCheck;

use Exception;
use Larakek\HealthCheck\Contracts\Probe;
use Larakek\HealthCheck\Probes\EnvVariablesProbe;

class ProbesResolver
{
    /**
     * @throws Exception
     */
    public function resolve(string $class, array $params): Probe
    {
        $method = sprintf('resolve%s', class_basename($class));
        if (method_exists($this, $method)) {
            return $this->$method($params);
        }

        throw new Exception(sprintf('Unsupported health-check class %s', $class));
    }

    private function resolveEnvVariablesProbe(array $params): EnvVariablesProbe
    {
        $data = [];
        $messages = [];
        foreach ($params as $key => $value) {
            $data[$key] = env($key);
            $messages[$key] = $key;
        }

        return new EnvVariablesProbe($data, $params, $messages);
    }
}
