<?php

use Larakek\HealthCheck\Factories\EnvVariablesProbeFactory;
use Larakek\HealthCheck\Probes\EnvVariablesProbe;
use Larakek\HealthCheck\Probes\FailureProbe;

return [
    'settings' => [
        'register_healthcheck_route' => true,
    ],

    'probes' => [
        [
            'enabled' => true,
            'class' => EnvVariablesProbe::class,
            'params' => [
                'FOO' => ['required', 'string'],
                'BAR' => 'required|bool',
                'BAZ' => 'required',
            ],
        ],
        [
            'enabled' => true,
            'class' => FailureProbe::class,
        ],
    ],

    'factories' => [
        EnvVariablesProbe::class => EnvVariablesProbeFactory::class,
    ],
];
