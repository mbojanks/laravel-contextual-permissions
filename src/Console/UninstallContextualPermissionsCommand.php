<?php
namespace Bojan\ContextualPermissions\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UninstallContextualPermissionsCommand extends Command
{
    protected $signature = 'contextual-permissions:uninstall
                            {--force : Прескочи потврду и одмах обриши}';

    protected $description = 'Interactively removes all contextual roles from model_has_roles table';

    public function handle(): void
    {
        if (! $this->option('force')) {
            if (! $this->confirm('Да ли заиста желите да обришете све контекстуалне улоге?')) {
                $this->info('Операција отказана.');
                return;
            }
        }

        $table = config('permission.table_names.model_has_roles');

        $deleted = DB::table($table)
            ->whereNotNull('context_type')
            ->whereNotNull('context_id')
            ->delete();

        $this->info("Успешно обрисано {$deleted} контекстуалних улога из табеле '{$table}'.");
    }
}
