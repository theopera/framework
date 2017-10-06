<?php
/**
 * The Opera Framework
 * AccessControlListProviderInterface.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 21-9-16
 * @version 1.0
 */

namespace Opera\Component\Authorization;


interface AccessControlListProviderInterface
{

    public function hasRolePermission(string $role, string $permission) : bool;
}