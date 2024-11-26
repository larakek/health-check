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
        $factories = config('health-check.factories');
        foreach (config('health-check.probes') as $config) {
            $this->app->bind($config['class'], function () use ($factories, $config) {
                if (isset($factories[$config['class']])) {
                    return $this->app->call(
                        callback: $factories[$config['class']],
                        parameters: [
                            'name' => $config['name'],
                            'params' => $config['params'] ?? []]);
                } else {
                    return new $config['class'];
                }
            });

            if ($config['enabled']) {
                $checker->register($this->app->make($config['class']));
            }
        }
    }

    /**
     * Register the package config.
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/health-check.php', 'health-check');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/health-check.php' => config_path('health-check.php'),
            ], 'health-check');
        }
    }

    /**
     * Register the package routes.
     */
    protected function registerRoutes(): void
    {
        if (config('health-check.settings.register_healthcheck_route')) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }
    }

    /**
     * Register the package commands.
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
