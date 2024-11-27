<?php

use Illuminate\Support\Facades\Route;
use Larakek\HealthCheck\Http\Controllers\HealthcheckController;

Route::get('/healthcheck', HealthcheckController::class)
    ->name('healthcheck');
