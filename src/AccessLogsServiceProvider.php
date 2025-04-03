<?php

namespace Maize\AccessLogs;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Maize\AccessLogs\Commands\AccessLogsCommand;

class AccessLogsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-access-logs')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_access_logs_table')
            ->hasCommand(AccessLogsCommand::class);
    }
}
