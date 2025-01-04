<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Factories;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Larakek\HealthCheck\Probes\PathsAreWritableProbe;

class PathsAreWritableProbeFactory
{
    public function __construct(
        private Filesystem  $filesystem,
        private Application $application,
    ) {}


    /**
     * @param array<array<string>> $params
     * @return PathsAreWritableProbe
     */
    public function __invoke(array $params): PathsAreWritableProbe
    {
        return new PathsAreWritableProbe(
            filesystem: $this->filesystem,
            application: $this->application,
            paths: $params['paths'],
        );
    }
}
