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
     */
    public function handle(HealthChecker $healthChecker): int
    {
        $result = $healthChecker->run();

        if ($result->hasFailed()) {
            foreach ($result->getErrors() as $error) {
                $this->error($error);
            }
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
