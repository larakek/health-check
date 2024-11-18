<?php

declare(strict_types=1);

namespace Larakek\HealthCheck;

use Illuminate\Support\ServiceProvider;
use Larakek\HealthCheck\Contracts\HealthChecker;

class HealthCheckServiceProvider extends ServiceProvider
{
    /**
     * @var array|string[]
     */
    public array $singletons = [
        HealthChecker::class => Checker::class,
    ];

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
