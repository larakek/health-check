<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Probes;

use Illuminate\Support\Facades\Validator;
use Larakek\HealthCheck\Contracts\Probe;

class EnvVariablesProbe implements Probe
{
    /**
     * @var array
     */
    private array $data;

    /**
     * @var array
     */
    private array $rules;

    /**
     * @var array
     */
    private array $messages;

    /**
     * @param array $data
     * @param array $rules
     */
    public function __construct(array $data, array $rules, array $messages)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->messages = $messages;
    }

    public function getName(): string
    {
        return class_basename($this);
    }

    public function isHealthy(): bool
    {
        Validator::validate($this->data, $this->rules, $this->messages, [
            'BAR' => '__BAR__',
        ]);

        return true;
    }
}
