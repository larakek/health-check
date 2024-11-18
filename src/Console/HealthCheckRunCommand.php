<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Console;

use Illuminate\Console\Command;
use Larakek\HealthCheck\Contracts\HealthChecker;

class HealthCheckRunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'health-check:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all health-check probes';

    /**
     * Execute the console command.
     *
     * @param HealthChecker $healthChecker
     * @return int
     */
    public function handle(HealthChecker $healthChecker): int
    {
        $result = $healthChecker->run();

        return $result->hasFailed()
            ? self::FAILURE
            : self::SUCCESS;
    }
}
