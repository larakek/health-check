<?php

declare(strict_types=1);

namespace Larakek\HealthCheck;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Larakek\HealthCheck\Console\HealthCheckRunCommand;
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

    /**
     * Bootstrap any package services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        /** @var HealthChecker $checker */
        $checker = $this->app->make(HealthChecker::class);
        $checker->register(new FailureProbe());
        // TODO remove code above

        $this->registerRoutes();
        $this->registerCommands();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    /**
     * Register the package commands.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                HealthCheckRunCommand::class,
            ]);
        }
    }
}
