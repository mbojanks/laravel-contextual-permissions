<?php
namespace Mbojanks\ContextualPermissions\Console;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRoleInContextCommand extends Command
{
    protected $signature = 'permission:assign-context-role
                            {user_id : User ID}
                            {role : Role name}
                            {context_type : Full context model namespace (e.g., App\Models\Project)}
                            {context_id : ID of the context model}';

    protected $description = 'Assigns a role to a user within a specific context';

    public function handle(): void
    {
        $user = User::find($this->argument('user_id'));
        if (! $user) {
            $this->error('Корисник није пронађен.');
            return;
        }

        $roleName = $this->argument('role');
        $contextType = $this->argument('context_type');
        $contextId = $this->argument('context_id');

        $contextModel = app($contextType)->find($contextId);
        if (! $contextModel) {
            $this->error('Контекст није пронађен.');
            return;
        }

        $user->assignRoleInContext($roleName, $contextModel);

        $this->info("Улога '{$roleName}' успешно додељена кориснику #{$user->id} у контексту {$contextType} #{$contextId}.");
    }
}
