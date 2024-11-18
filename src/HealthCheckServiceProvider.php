<?php

declare(strict_types=1);

namespace Larakek\HealthCheck;

use Illuminate\Support\ServiceProvider;
use Larakek\HealthCheck\Contracts\HealthChecker;
use Larakek\HealthCheck\Probes\FailureProbe;

class HealthCheckServiceProvider extends ServiceProvider
{
    /**
     * @var array|string[]
     */
    public array $bindings = [
        HealthChecker::class => Checker::class,
    ];

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        /** @var HealthChecker $checker */
        $checker = $this->app->make(HealthChecker::class);
        $checker->register(new FailureProbe());
    }
}
