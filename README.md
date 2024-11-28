# Health Check
<a href="https://github.com/larakek/health-check/actions"><img src="https://github.com/larakek/health-check/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/larakek/health-check"><img src="https://img.shields.io/packagist/v/larakek/health-check" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/larakek/health-check"><img src="https://img.shields.io/packagist/l/larakek/health-check" alt="License"></a>

## Introduction

Health Check is a package for the Laravel application that allows you to understand if your application is unhealthy. 
The package can handle http probes and command probes.

## Installation

Require this package with composer.
```
composer require larakek/health-check
```
Laravel uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

### Laravel without auto-discovery:
If you don't use auto-discovery, add the ServiceProvider to the providers list. For Laravel 11 or newer, add the ServiceProvider in bootstrap/providers.php. For Laravel 10 or older, add the ServiceProvider in config/app.php.
```
Larakek\HealthCheck\HealthCheckServiceProvider
```

### Copy the package config to your local config with the publish command:
```
php artisan vendor:publish --provider="Larakek\HealthCheck\HealthCheckServiceProvider"
```

## Configuration

## Usage
