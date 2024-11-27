<?php

declare(strict_types=1);

namespace Larakek\HealthCheck;

use Throwable;

class ErrorBag
{
    /** @var string[] */
    private array $errors = [];

    public function pushException(string $probeName, Throwable $exception): void
    {
        $this->errors[] = sprintf('Failed %s with message "%s"', $probeName, $exception->getMessage());
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
