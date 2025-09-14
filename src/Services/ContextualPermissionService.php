<?php
namespace Mbojanks\ContextualPermissions\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class ContextualPermissionService
{
    public function assignRole(User $user, string $roleName, Model $context): string
    {
        $role = Role::firstOrCreate(['name' => $roleName]);

        DB::table(config('permission.table_names.model_has_roles'))->insert([
            'role_id' => $role->id,
            'model_type' => get_class($user),
            'model_id' => $user->id,
            'context_type' => get_class($context),
            'context_id' => $context->id,
        ]);

        return __('contextual-permissions::messages.role_assigned', [
            'role' => $roleName,
            'user' => $user->id,
            'context' => class_basename($context),
            'id' => $context->id,
        ]);
    }

    public function hasRole(User $user, string $roleName, Model $context): bool
    {
        $role = Role::where('name', $roleName)->first();
        if (! $role) return false;

        return DB::table(config('permission.table_names.model_has_roles'))
            ->where([
                'role_id' => $role->id,
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'context_type' => get_class($context),
                'context_id' => $context->id,
            ])->exists();
    }

    public function getPermissions(User $user, Model $context)
    {
        $roleIds = DB::table(config('permission.table_names.model_has_roles'))
            ->where('model_type', get_class($user))
            ->where('model_id', $user->id)
            ->where('context_type', get_class($context))
            ->where('context_id', $context->id)
            ->pluck('role_id');

        return Permission::whereHas('roles', function ($query) use ($roleIds) {
            $query->whereIn('id', $roleIds);
        })->get();
    }
}
