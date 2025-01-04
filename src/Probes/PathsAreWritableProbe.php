<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Probes;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Larakek\HealthCheck\Contracts\Probe;

class PathsAreWritableProbe implements Probe
{
    /**
     * @param Filesystem $filesystem
     * @param Application $application
     * @param array<string> $paths
     */
    public function __construct(
        private Filesystem  $filesystem,
        private Application $application,
        private array       $paths,
    ) {}

    public function getName(): string
    {
        return class_basename($this);
    }

    public function isHealthy(): bool
    {
        foreach ($this->paths as $path) {
            if (!$this->filesystem->isWritable($this->application->basePath($path))) {
                throw new Exception(sprintf('Path %s is not writable', $path));
            }
        }

        return true;
    }
}
