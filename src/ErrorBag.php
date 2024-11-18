<?php

declare(strict_types=1);

namespace Larakek\HealthCheck;

class ErrorBag
{
    /** @var string[] */
    private array $errors = [];

    public function addError(string $probeName, \Throwable $e): void
    {
        $this->errors[] = sprintf('Failed %s with message "%s"', $probeName, $e->getMessage());
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasFailed(): bool
    {
        return count($this->errors) > 0;
    }
}
