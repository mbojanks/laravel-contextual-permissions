<?php
namespace Mbojanks\ContextualPermissions\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UninstallContextualPermissionsCommand extends Command
{
    protected $signature = 'contextual-permissions:uninstall
                            {--force : Skip confirmation prompt}
                            {--drop-columns : Drop context-related columns from model_has_roles}';

    protected $description = 'Interactively removes all contextual roles and (optionally) drops context-related columns from the model_has_roles table.';

    public function handle(): void
    {
        if (! $this->option('force')) {
            if (! $this->confirm(__('contextual-permissions::messages.confirm_uninstall'))) {
                $this->info(__('contextual-permissions::messages.cancelled'));
                return;
            }
        }

        $table = config('permission.table_names.model_has_roles');

        $deleted = DB::table($table)
            ->whereNotNull('context_type')
            ->whereNotNull('context_id')
            ->delete();

        $this->info(__('contextual-permissions::messages.deleted_roles', [
            'count' => $deleted,
            'table' => $table,
        ]));

        if ($this->option('drop-columns')) {
            Schema::table($table, function ($table) {
                $table->dropColumn(['context_type', 'context_id']);
            });

            $this->info(__('contextual-permissions::messages.columns_dropped'));
        }
    }
}
