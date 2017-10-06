<?php
/**
 * The Opera Framework
 * ArrayAccessControlListProvider.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 21-9-16
 * @version 1.0
 */

namespace Opera\Component\Authorization;


class ArrayAccessControlListProvider implements AccessControlListProviderInterface
{

    /**
     * @var string[][]
     */
    protected $permissions = [];

    /**
     * ArrayAccessControlListProvider constructor.
     *
     * @param string[][] $permissions
     */
    public function __construct(array $permissions)
    {
        $this->permissions = $permissions;
    }


    public function hasRolePermission(string $role, string $permission) : bool
    {
        if ($this->hasRole($role) && $this->hasPermission($role, $permission)) {
            return $this->permissions[$role][$permission];
        }

        return false;
    }

    protected function hasRole(string $role) : bool
    {
        return isset($this->permissions[$role]);
    }

    protected function hasPermission(string $role, string $permission) : bool
    {
        return isset($this->permissions[$role][$permission]);
    }
}