<?php

use Larakek\HealthCheck\Probes\EnvVariablesProbe;

return [
    'settings' => [
        'register_healthcheck_route' => true,
    ],

    'probes' => [
        [
            'name' => 'test env variables probe',
            'enabled' => true,
            'class' => EnvVariablesProbe::class,
            'params' => [
                'FOO' => ['required', 'string'],
                'BAR' => 'required|bool',
                'BAZ' => 'required',
            ],
        ]
    ],
];
