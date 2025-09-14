<?php
namespace Bojan\ContextualPermissions\Facades;

use Illuminate\Support\Facades\Facade;

class ContextualPermission extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'contextual-permission';
    }
}
