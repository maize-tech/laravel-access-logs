<?php

namespace Maize\AccessLogs;

use Maize\AccessLogs\Commands\AccessLogsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AccessLogsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-access-logs')
            ->hasConfigFile()
            ->hasMigration('create_laravel_access_logs_table')
            ->hasCommand(AccessLogsCommand::class);
    }
}
