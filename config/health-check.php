<?php

use Larakek\HealthCheck\Factories\CacheConnectionProbeFactory;
use Larakek\HealthCheck\Factories\CacheIsWritableProbeFactory;
use Larakek\HealthCheck\Factories\DatabaseConnectionProbeFactory;
use Larakek\HealthCheck\Factories\EnvVariablesProbeFactory;
use Larakek\HealthCheck\Probes\CacheConnectionProbe;
use Larakek\HealthCheck\Probes\CacheIsWritableProbe;
use Larakek\HealthCheck\Probes\DatabaseConnectionProbe;
use Larakek\HealthCheck\Probes\EnvVariablesProbe;

return [
    'settings' => [
        'register_healthcheck_route' => true,
        'route_path' => '/healthcheck',
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
        [
            'enabled' => true,
            'class' => CacheConnectionProbe::class,
        ],
        [
            'enabled' => true,
            'class' => CacheIsWritableProbe::class,
            'params' => [
                'cache_key' => 'unique_cache_key_name_for_application_instance',
            ],
        ],
    ],

    'factories' => [
        CacheConnectionProbe::class => CacheConnectionProbeFactory::class,
        CacheIsWritableProbe::class => CacheIsWritableProbeFactory::class,
        DatabaseConnectionProbe::class => DatabaseConnectionProbeFactory::class,
        EnvVariablesProbe::class => EnvVariablesProbeFactory::class,
    ],
];
