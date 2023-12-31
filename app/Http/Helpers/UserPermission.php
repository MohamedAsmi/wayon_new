<?php
namespace App\Http\Helpers;

use App\Models\PermissionOwnerRole;
use View;
use Session;
use App\Models\Permissions;
use App\Models\RoleAdmin;
use App\Models\PermissionRole;

class UserPermission
{

    public static function has_permission($user_id, $permissions = '')
    {
        $permissions = explode('|', $permissions);
        $user_permissions = Permissions::getAll()->whereIn('name', $permissions);
        $permission_id = [];
        $i = 0;
        foreach ($user_permissions as $value) {
            $permission_id[$i++] = $value->id;
        }
        $role = RoleAdmin::getAll()->where('admin_id', $user_id)->first();

        if (count($permission_id) && isset($role->role_id)) {
            $has_permit = PermissionRole::where('role_id', $role->role_id)->whereIn('permission_id', $permission_id);
            return $has_permit->count();
        } else {
            return 0;
        }
    }

    public static function has_owner_permission($user_id, $permissions = '')
    {
        $permissions = explode('|', $permissions);
        $user_permissions = Permissions::getAll()->whereIn('name', $permissions);
        $permission_id = [];
        $i = 0;
        foreach ($user_permissions as $value) {
            $permission_id[$i++] = $value->id;
        }
        $role = RoleAdmin::getAll()->where('admin_id', $user_id)->first();

        if (count($permission_id) && isset($role->role_id)) {
            $has_permit = PermissionOwnerRole::where('role_id', $role->role_id)->whereIn('permission_id', $permission_id);
            return $has_permit->count();
        } else {
            return 0;
        }
    }
    
}
