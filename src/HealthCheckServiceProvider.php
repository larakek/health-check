<?php

declare(strict_types=1);

namespace Larakek\HealthCheck;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Larakek\HealthCheck\Console\HealthCheckRunCommand;
use Larakek\HealthCheck\Contracts\HealthChecker;

class HealthCheckServiceProvider extends ServiceProvider
{
    /**
     * @var array|string[]
     */
    public array $singletons = [
        HealthChecker::class => Checker::class,
    ];

    /**
     * Bootstrap any package services.
     *
     * @return void
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerRoutes();
        $this->registerCommands();

        /** @var HealthChecker $checker */
        $checker = $this->app->make(HealthChecker::class);
        /** @var ProbesResolver $resolver */
        $resolver = $this->app->make(ProbesResolver::class);
        foreach (config('health-check.probes') as $config) {
            if ($config['enabled']) {
                $checker->register($resolver->resolve($config['class'], $config['params']));
            }
        }
    }

    /**
     * Register the package config.
     *
     * @return void
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/health-check.php', 'health-check');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/health-check.php' => config_path('health-check.php'),
            ], 'health-check');
        }
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        if (config('health-check.settings.register_healthcheck_route')) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }
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
