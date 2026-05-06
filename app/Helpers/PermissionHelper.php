<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class PermissionHelper
{
    /**
     * Check if a user has permission to access a specific feature
     *
     * @param string $feature
     * @param string|null $userRole
     * @return bool
     */
    public static function hasPermission($feature, $userRole = null)
    {
        if (!$userRole) {
            $userRole = session('user.role');
        }

        if (!$userRole) {
            return false;
        }

        // Get permissions from cache
        $permissions = Cache::get("admin.settings.permissions.{$userRole}", []);
        
        // Default permissions for safety
        if (empty($permissions)) {
            return self::getDefaultPermission($userRole, $feature);
        }

        return isset($permissions[$feature]) && $permissions[$feature] == true;
    }

    /**
     * Get default permission for a role and feature
     *
     * @param string $role
     * @param string $feature
     * @return bool
     */
    private static function getDefaultPermission($role, $feature)
    {
        $defaults = [
            'admin' => [
                'dashboard' => true,
                'users' => true,
                'groups' => true,
                'projects' => true,
                'analytics' => true,
                'reports' => true,
                'messages' => true,
                'settings' => true,
            ],
            'supervisor' => [
                'dashboard' => true,
                'users' => false,
                'groups' => true,
                'projects' => true,
                'analytics' => true,
                'reports' => true,
                'messages' => true,
                'settings' => false,
            ],
            'student' => [
                'dashboard' => true,
                'users' => false,
                'groups' => true,
                'projects' => true,
                'analytics' => false,
                'reports' => false,
                'messages' => true,
                'settings' => false,
            ],
        ];

        return isset($defaults[$role][$feature]) ? $defaults[$role][$feature] : false;
    }

    /**
     * Get all permissions for a role
     *
     * @param string $role
     * @return array
     */
    public static function getRolePermissions($role)
    {
        $cached = Cache::get("admin.settings.permissions.{$role}", []);
        
        if (!empty($cached)) {
            return $cached;
        }

        return self::getDefaultPermissions($role);
    }

    /**
     * Get default permissions for a role
     *
     * @param string $role
     * @return array
     */
    private static function getDefaultPermissions($role)
    {
        $defaults = [
            'admin' => [
                'dashboard' => true,
                'users' => true,
                'groups' => true,
                'projects' => true,
                'analytics' => true,
                'reports' => true,
                'messages' => true,
                'settings' => true,
            ],
            'supervisor' => [
                'dashboard' => true,
                'users' => false,
                'groups' => true,
                'projects' => true,
                'analytics' => true,
                'reports' => true,
                'messages' => true,
                'settings' => false,
            ],
            'student' => [
                'dashboard' => true,
                'users' => false,
                'groups' => true,
                'projects' => true,
                'analytics' => false,
                'reports' => false,
                'messages' => true,
                'settings' => false,
            ],
        ];

        return isset($defaults[$role]) ? $defaults[$role] : [];
    }

    /**
     * Save permissions for a role
     *
     * @param string $role
     * @param array $permissions
     * @return void
     */
    public static function saveRolePermissions($role, $permissions)
    {
        Cache::put("admin.settings.permissions.{$role}", $permissions, 86400); // Cache for 24 hours
    }
}
