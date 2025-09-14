<?php
namespace Mbojanks\ContextualPermissions;

use Illuminate\Support\ServiceProvider;
use Mbojanks\ContextualPermissions\Console\CheckRoleInContextCommand;
use Mbojanks\ContextualPermissions\Console\ListRolesInContextCommand;
use Mbojanks\ContextualPermissions\Console\AssignRoleInContextCommand;
use Mbojanks\ContextualPermissions\Services\ContextualPermissionService;

class ContextualPermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('contextual-permission', function () {
            return new ContextualPermissionService();
        });
    }
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'contextual-permissions');

        if ($this->app->runningInConsole()) {
            $this->commands([
                AssignRoleInContextCommand::class,
                CheckRoleInContextCommand::class,
                ListRolesInContextCommand::class,
            ]);
        }
    }
}
