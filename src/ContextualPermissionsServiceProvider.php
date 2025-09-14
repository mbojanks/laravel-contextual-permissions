<?php
namespace Mbojanks\ContextualPermissions;

use Illuminate\Support\ServiceProvider;
use Mbojanks\ContextualPermissions\Console\CheckRoleInContextCommand;
use Mbojanks\ContextualPermissions\Console\ListRolesInContextCommand;
use Mbojanks\ContextualPermissions\Console\AssignRoleInContextCommand;

class ContextualPermissionsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                AssignRoleInContextCommand::class,
                CheckRoleInContextCommand::class,
                ListRolesInContextCommand::class,
            ]);
        }
    }
}
