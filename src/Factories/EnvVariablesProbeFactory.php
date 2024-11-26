<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Factories;

use Larakek\HealthCheck\Probes\EnvVariablesProbe;

class EnvVariablesProbeFactory
{
    public function __invoke(string $name, array $params): EnvVariablesProbe
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
