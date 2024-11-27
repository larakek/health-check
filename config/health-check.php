<?php

use Larakek\HealthCheck\Factories\DatabaseConnectionProbeFactory;
use Larakek\HealthCheck\Factories\EnvVariablesProbeFactory;
use Larakek\HealthCheck\Probes\DatabaseConnectionProbe;
use Larakek\HealthCheck\Probes\EnvVariablesProbe;

return [
    'settings' => [
        'register_healthcheck_route' => true,
    ],

    'probes' => [
        [
            'enabled' => true,
            'class' => EnvVariablesProbe::class,
            'params' => [
                'APP_KEY' => ['required', 'string'],
            ],
        ],
        [
            'enabled' => true,
            'class' => DatabaseConnectionProbe::class,
            'params' => [
                'connection_name' => env('DB_CONNECTION', 'mysql'),
            ],
        ],
    ],

    'factories' => [
        DatabaseConnectionProbe::class => DatabaseConnectionProbeFactory::class,
        EnvVariablesProbe::class => EnvVariablesProbeFactory::class,
    ],
];
