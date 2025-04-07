<?php

namespace Maize\AccessLogs;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AccessLogsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-access-logs')
            ->hasConfigFile()
            ->hasMigration('create_access_logs_table')
            ->hasInstallCommand(
                fn (InstallCommand $command) => $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('maize-tech/laravel-access-logs')
            );
    }
}
