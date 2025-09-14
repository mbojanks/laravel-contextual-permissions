<?php
namespace Mbojanks\ContextualPermissions\Console;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ListRolesInContextCommand extends Command
{
    protected $signature = 'permission:list-context-roles
                            {user_id}
                            {context_type}
                            {context_id}';

    protected $description = 'Lists all roles of a user in a given context';

    public function handle(): void
    {
        $user = User::find($this->argument('user_id'));
        if (! $user) {
            $this->error('Корисник није пронађен.');
            return;
        }

        $roles = DB::table(config('permission.table_names.model_has_roles'))
            ->where('model_type', get_class($user))
            ->where('model_id', $user->id)
            ->where('context_type', $this->argument('context_type'))
            ->where('context_id', $this->argument('context_id'))
            ->pluck('role_id');

        if ($roles->isEmpty()) {
            $this->warn('Корисник нема улоге у контексту.');
            return;
        }

        $roleNames = Role::whereIn('id', $roles)->pluck('name');
        $this->info("Улоге корисника у контексту:");
        foreach ($roleNames as $name) {
            $this->line("- {$name}");
        }
    }
}
