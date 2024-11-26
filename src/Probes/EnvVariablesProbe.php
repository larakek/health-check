<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Probes;

use Illuminate\Support\Facades\Validator;
use Larakek\HealthCheck\Contracts\Probe;

class EnvVariablesProbe implements Probe
{
    private string $name;

    /**
     * @var array<string,mixed>
     */
    private array $data;

    /**
     * @var array<string,mixed>
     */
    private array $rules;

    /**
     * @var array<string,string>
     */
    private array $messages;

    /**
     * @param  array<string,mixed>  $data
     * @param  array<string,mixed>  $rules
     * @param  array<string,string>  $messages
     */
    public function __construct(string $name, array $data, array $rules, array $messages)
    {
        $this->name = $name;
        $this->data = $data;
        $this->rules = $rules;
        $this->messages = $messages;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isHealthy(): bool
    {
        Validator::validate(
            data: $this->data,
            rules: $this->rules,
            messages: $this->messages,
        );

        return true;
    }
}
