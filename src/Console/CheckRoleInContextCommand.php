<?php
namespace Mbojanks\ContextualPermissions\Console;

use Illuminate\Console\Command;
use App\Models\User;

class CheckRoleInContextCommand extends Command
{
    protected $signature = 'permission:check-context-role
                            {user_id}
                            {role}
                            {context_type}
                            {context_id}';

    protected $description = 'Check if a user has a role in a given context';

    public function handle(): void
    {
        $user = User::find($this->argument('user_id'));
        if (! $user) {
            $this->error('Корисник није пронађен.');
            return;
        }

        $contextModel = app($this->argument('context_type'))->find($this->argument('context_id'));
        if (! $contextModel) {
            $this->error('Контекст није пронађен.');
            return;
        }

        if ($user->hasRoleInContext($this->argument('role'), $contextModel)) {
            $this->info('Корисник ИМА улогу у контексту.');
        } else {
            $this->warn('Корисник НЕМА улогу у контексту.');
        }
    }
}
