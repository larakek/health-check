<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Probes;

use Illuminate\Support\Facades\Validator;
use Larakek\HealthCheck\Contracts\Probe;

class EnvVariablesProbe implements Probe
{
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
     * @var array<string,string>
     */
    private array $attributes;

    /**
     * @param  array<string,mixed>  $data
     * @param  array<string,mixed>  $rules
     * @param  array<string,string>  $messages
     * @param  array<string,string>  $attributes
     */
    public function __construct(array $data, array $rules, array $messages, array $attributes)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->messages = $messages;
        $this->attributes = $attributes;
    }

    public function getName(): string
    {
        return class_basename($this);
    }

    public function isHealthy(): bool
    {
        Validator::validate(
            data: $this->data,
            rules: $this->rules,
            messages: $this->messages,
            attributes: $this->attributes,
        );

        return true;
    }
}
