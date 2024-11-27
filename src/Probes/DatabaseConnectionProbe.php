<?php

declare(strict_types=1);

namespace Larakek\HealthCheck\Probes;

use Illuminate\Database\DatabaseManager;
use Larakek\HealthCheck\Contracts\Probe;

class DatabaseConnectionProbe implements Probe
{
    private string $connection;

    private DatabaseManager $databaseManager;

    /**
     * @param string $connection
     * @param DatabaseManager $databaseManager
     */
    public function __construct(string $connection, DatabaseManager $databaseManager)
    {
        $this->connection = $connection;
        $this->databaseManager = $databaseManager;
    }

    public function getName(): string
    {
        return sprintf('%s (connection %s)', class_basename($this), $this->connection);
    }

    public function isHealthy(): bool
    {
        $this->databaseManager
            ->connection($this->connection)
            ->select('true');

        return true;
    }
}
