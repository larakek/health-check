<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Http\Controllers;

use Larakek\HealthCheck\Contracts\HealthChecker;
use Larakek\HealthCheck\Http\Resources\HealthCheckerResource;

class HealthcheckController
{
    public function __invoke(HealthChecker $healthChecker): HealthCheckerResource
    {
        $result = $healthChecker->run();

        return HealthCheckerResource::make($result);
    }
}
