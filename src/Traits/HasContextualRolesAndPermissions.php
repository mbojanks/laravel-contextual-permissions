<?php
namespace Bojan\ContextualPermissions\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

trait HasContextualRolesAndPermissions
{
    public function assignRoleInContext(string $roleName, Model $context): void
    {
        $role = Role::firstOrCreate(['name' => $roleName]);

        DB::table(config('permission.table_names.model_has_roles'))->insert([
            'role_id' => $role->id,
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'context_type' => get_class($context),
            'context_id' => $context->id,
        ]);
    }

    public function hasRoleInContext(string $roleName, Model $context): bool
    {
        $role = Role::where('name', $roleName)->first();
        if (! $role) return false;

        return DB::table(config('permission.table_names.model_has_roles'))
            ->where([
                'role_id' => $role->id,
                'model_type' => get_class($this),
                'model_id' => $this->id,
                'context_type' => get_class($context),
                'context_id' => $context->id,
            ])->exists();
    }

    public function getPermissionsViaRolesInContext(Model $context)
    {
        $roleIds = DB::table(config('permission.table_names.model_has_roles'))
            ->where('model_type', get_class($this))
            ->where('model_id', $this->id)
            ->where('context_type', get_class($context))
            ->where('context_id', $context->id)
            ->pluck('role_id');

        return Permission::whereHas('roles', function ($query) use ($roleIds) {
            $query->whereIn('id', $roleIds);
        })->get();
    }

    public function getAllPermissionsInContext(Model $context)
    {
        return $this->getPermissionsViaRolesInContext($context);
    }
}
